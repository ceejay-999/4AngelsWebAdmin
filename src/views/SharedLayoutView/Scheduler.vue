<script>
import {formatDateString,axios,validateForm,elementLoad, lStore} from '../../functions';

export default({
    props:{
        facilityId: Number
    },
    data(){
        return{
            requestsModal:{
                shown: false,
                mode:3
            },
            currentCalendar:{
                y:0,
                m:0,
                d:0
            },
            selectedDay:{
                y:0,
                m:0,
                d:0
            },
            viewMode:'Month View',
            calendarBox:[],
            updateSchedId:'',
            queSched:{
                id:'',
                shift_date: '',
                shift_date_end: '',
                shift_start:'',
                shift_end:'',
                repeatDays:[],
                description:'',
                branch_id:this.facilityId,
                designation:'',
                assignedEmps:[],
                color:''
            },
            daysOfWeek:['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
            deletedSchedIds:[],
            designations:[],
            searchDesignations:'',
            colors:['#4054b2','#d30915','#1b9ce2','#3bb57a','#f2522c'],
            showSetSchedModal:false,
            allowDrag: true,
            schedules:{},
            selectedBranch:20,
            copyMode:false,
            employees:{},
            invalidInput:[],
            alertMsg:'',
            editDisabled:false,
            isSaving:false,
            expanded:[],
            employeeFilter:{
                search:'',
                byRole:[-1]
            },
            urlParams:null
        }
    },
    mounted(){
        let date = new Date();
        this.currentCalendar.y = date.getFullYear();
        this.currentCalendar.m = date.getMonth();
        this.currentCalendar.d = date.getDate();
        this.urlParams = new URLSearchParams(window.location.search);
        if(this.urlParams.get('date') != null) this.jumpToDate(this.urlParams.get('date'))

        this.initScheduler();

        this.buildCalendar();


        

    },
    watch:{
        currentCalendar:{
            handler(change){
                let date = new Date(change.y,change.m,change.d)
                document.getElementById('gotoDate').value = date.toLocaleDateString('zh-Hans-CN',{year:'numeric',month:'2-digit',day:'2-digit'}).replaceAll('/','-');
            },
            deep:true
        }
    },
    computed:{
        filteredDesignations(){
            let filtered = this.designations.filter(el=>{
                return el.role_name.toLowerCase().includes(this.searchDesignations.toLowerCase()) && !this.queSched.designation.includes(el.id);
            });
            return filtered;
        },
        filteredEmployees(){
            let filtered = {};
            for(let e in this.employees){
                let el = this.employees[e];
                let name1 = (el.employee_firstname+' '+el.employee_lastname).toLowerCase().includes(this.employeeFilter.search);
                let name2 = (el.employee_lastname+' '+el.employee_firstname).toLowerCase().includes(this.employeeFilter.search);
                if(((name1 || name2) || this.employeeFilter.search == '') && 
                (this.employeeFilter.byRole.includes(el.assigndesignation_roleid) || this.employeeFilter.byRole[0] == -1)){
                    filtered[e] = this.employees[e];
                }
            }
            return filtered;
        }
    },
    methods:{
        formatDateString,
        clickGoToDate(){
            document.getElementById('gotoDate').dispatchEvent(new Event('click'))
        },
        async getRelativeFoldHeight(index){
            elementLoad('#'+index).then(el=>{
                elementLoad('#'+index+ ' .dayScheds').then(()=>{
                    let children = document.querySelectorAll('#'+index+ ' .dayScheds');
                    if(children.length < 2) {el.style.maxHeight = "max-height";return;}
                    let height = children[0].offsetHeight + children[1].offsetHeight + 10;
                    document.getElementById(index).style.maxHeight = height+"px";
                })
            })
            
        },
        toggleExpand(el){
            if(!this.expanded.includes(el)) this.expanded.push(el);
            else this.expanded.splice(this.expanded.indexOf(el),1);
        },
        prepareEdit(ds){
            if(new Date(ds.shift_date+' '+ds.shift_start).getTime() <= new Date().getTime()) this.editDisabled = true;
            if(this.facilityId != ds.branch_id) this.editDisabled = true;
            this.showSetSchedModal = true;
            this.updateSchedId = ds.id;
            
            this.queSched=this.stringifyAndParse(ds);
            this.searchDesignations = this.findPropInObjArray(this.designations,'role_id',this.queSched.designation).role_name;
        },
        initScheduler(){
            axios.encrypted('Designation?_batch=true')
            .then(res=>{
                res.data = axios.decryptToJSON(res.data);
                if(!res.data) return;
                this.designations = res.data.result;
            });

            axios.post(`UserDesignations?
            assigndesignation_facilityid=${this.facilityId}
            &_batch=true
            &_joins=employee,role
            &_on=
            employee.employee_id=assigndesignation.assigndesignation_employeeid,
            role.role_id=assigndesignation.assigndesignation_roleid`)
            .then(res=>{
                // res.data = axios.decryptToJSON(res.data);
                // if(!res.data) return;
                res.data.result.forEach(el=>{
                    this.employees[el.employee_id] = el;
                });
            });

            const processAssignedEmps = arr =>{
                let newArr = [];
                arr.forEach(el=>{
                    newArr.push({
                        id:el.assigndesignation_employeeid,
                        status:el.assignschedules_status,
                        ...el
                    })
                })
                return newArr;
            };

            axios.encrypted(`Schedule/joint?_batch=true`).then(res=>{
                res.data = axios.decryptToJSON(res.data);
                if(!res.data) return;
                res.data.result.forEach(el=>{
                    this.schedules[el.schedules_id] = {
                        id:el.schedules_id,
                        shift_date:el.schedules_dates,
                        shift_date_end:el.schedules_dates,
                        shift_start:el.schedules_timestart,
                        shift_end:el.schedules_timeend,
                        repeatDays:[],
                        description:el.schedules_description,
                        branch_id:el.schedules_facilityid,
                        branch_name:el.facility_name,
                        designation:el.schedules_roleid,
                        assignedEmps:processAssignedEmps(el.assignedEmps),
                        color:el.role_color
                    };
                });

                if(this.urlParams.get('schedule') != null) {
                    let scheduleSelected = this.schedules[this.urlParams.get('schedule')];
                    if(scheduleSelected != null){
                        this.jumpToDate(scheduleSelected.shift_date);
                        this.prepareEdit(scheduleSelected);
                    }
                    
                }
                    
                this.buildCalendar();
            });
        },
        toggleRequestView(e){

        },
        stringifyAndParse(obj){
            return JSON.parse(JSON.stringify(obj));
        },
        dragSched(e,ds){
            if(this.facilityId != ds.branch_id) {
                alert('You can only move schedules from the branch you selected.')
                return;
            }
            try{
                e.dataTransfer.setData('schedData',JSON.stringify(ds));

                // if(new Date(ds.shift_date+' '+ds.shift_start).getTime() <= new Date().getTime()){
                    // e.preventDefault();
                // }
            }catch(err){return;}
        },
        fetchEmps(){
        },
        isScheduleDone(ds){
            let date = new Date(ds.shift_date+' '+ds.shift_start).getTime();
            let ndate = new Date().getTime();
            return date <= ndate;
        },
        dropSched(e){
            if(e.dataTransfer.getData('schedData') == '' || e.target.dataset.datestring == null) return;
            let sched = JSON.parse(e.dataTransfer.getData('schedData'));

            if(this.copyMode) {
                this.copySched(e);
                return;
            }

            let date = new Date(e.target.dataset.datestring+' '+sched.shift_start).getTime();
            let ndate = new Date().getTime();

            if(date <= ndate){
                alert('You cannot drag a schedule to a datetime that is already finished!');
                return;
            }

            
            
            sched.shift_date_end = sched.shift_date = formatDateString(e.target.dataset.datestring).replaceAll(' ','');
            if(sched.crudStatus != 0) sched.crudStatus = 1;
            this.schedules[sched.id] = JSON.parse(JSON.stringify(sched));


            // if(this.schedules[this.queSched.id].excludeDates.indexOf()) this.schedules[this.queSched.id].excludeDates.push(origin);
            // console.log(this.schedules[this.queSched.id]);
            this.resetQueSched();
            this.buildCalendar();
        },
        copySched(e){
             if(e.dataTransfer.getData('schedData') == '' || e.target.dataset.datestring == null) return;
            let sched = JSON.parse(e.dataTransfer.getData('schedData'));
            if(sched.shift_date == e.target.dataset.datestring) {
                alert('Please choose a different date!');
                return;
            }
            this.queSched = JSON.parse(JSON.stringify(sched));
            this.queSched.shift_date_end = this.queSched.shift_date = formatDateString(e.target.dataset.datestring).replaceAll(' ','');
            this.setSchedule();
            this.resetQueSched();
            this.buildCalendar();
        },
        dropSchedToEmp(e,empId){
            if(e.dataTransfer.getData('schedData') == '') return;
            let sched = JSON.parse(e.dataTransfer.getData('schedData'));
            if(this.schedules[sched.id].designation != this.employees[empId].role_id) {
                alert('You must only drop schedules with appropriate roles for this employee!');
                return;
            }

            if(this.schedules[sched.id].assignedEmps == null){
                this.schedules[sched.id].assignedEmps = [];
            }

        
            if(this.schedules[sched.id].crudStatus != 0) this.schedules[sched.id].crudStatus = 1;
            
            if(this.schedules[sched.id].assignedEmps.includes(empId)) return;
            this.schedules[sched.id].assignedEmps.push({id:empId,status:0});
        },
        objFromArr(arr,id){
            return this[arr].find(el=>el.id == id);
        },
        stringify(obj){
            return JSON.stringify(obj)
        },
        selectDay(num){
            if(this.queSched.repeatDays.includes(num))
                this.queSched.repeatDays.splice(this.queSched.repeatDays.indexOf(num),1);
            else
                this.queSched.repeatDays.push(num);
        },
        resetQueSched(){
            this.updateSchedId = '';
            this.editDisabled = false;
            this.queSched={
                id:'',
                shift_date: this.currentCalendar.y+'-'+(this.currentCalendar.m+1)+'-'+this.currentCalendar.d,
                shift_date_end: '',
                shift_start:'',
                shift_end:'',
                repeatDays:[],
                description:'',
                branch_id:this.facilityId,
                designation:'',
                assignedEmps:[],
                color:''
            };

            this.searchDesignations = '';
        },
        findPropInObjArray(array,property,value){
            let match = false;
            array.forEach(el=>{
                if(el[property] == value) match = el;
            })
            return match;
        },
        checkConflicts(ds,empid,conflictId){
            let hasConflict = false;

            setTimeout(()=>{
                for(let s in this.schedules){
                    let el = this.schedules[s];
                    let startA = new Date(ds.shift_date+' '+ds.shift_start);
                    let startB = new Date(el.shift_date+' '+el.shift_start);
                    let endA = new Date(ds.shift_date+' '+ds.shift_end);
                    let endB = new Date(el.shift_date+' '+el.shift_end);
                    let assignedEmps = [];


                    if((startA <= startB && endA > startB) || (startA >= startB && endB > startA))
                        if(ds.id != el.id)
                            if(el.assignedEmps != null)
                                assignedEmps = el.assignedEmps.filter(el2=>el2.id==empid);

                    
                    if(assignedEmps.length > 0){
                        document.getElementById(conflictId).style.display = "inline-block";
                        document.getElementById("conflict_"+el.id+'_'+empid).style.display = "inline-block";
                    }
                }

                
            },100)
        },
        setSchedule(){
            let q = this.queSched;
            let currentDateTime = new Date().getTime();
            let startDateTime = new Date(q.shift_date+' '+q.shift_start).getTime();
            this.invalidInput = [];

            let validate = validateForm(q,{
                shift_date: "required",
                shift_date_end: "required",
                shift_start: "required",
                shift_end: "required",
                designation:"required",
                callback:(v,k)=>{
                    this.invalidInput.push(k);
                }
            });
            
            if(!validate.allValid) return;
            

            
            if(this.updateSchedId == ''){
                
                let startDate = new Date(q.shift_date).getTime();
                
                let endDate = new Date(q.shift_date_end).getTime();
                let dayDiff = Math.round((endDate - startDate) / (1000 * 60 * 60 * 24));
                
                

                if(startDateTime <= currentDateTime){
                    alert("You cannot add a schedule that has started already!");
                    return;
                }

                for(let i = 0,j=0;i<=dayDiff;i++){
                    let includedDate = new Date(q.shift_date);
                    includedDate.setDate(includedDate.getDate() + i);
                    
                    if(q.repeatDays.length > 0 && q.repeatDays.includes(includedDate.getDay()) || q.repeatDays.length == 0 || i == 0){
                        let newSched = JSON.parse(JSON.stringify(q));
                        // replace 1008 with lStore.get('user_id') once connected
                        newSched.id = (lStore.get('users_id')).toString(32)+'-'+new Date().getTime().toString(32)+'-'+j;
                        let opts = {year:'numeric',month:'2-digit',day: "2-digit"};
                        newSched.shift_date = includedDate.toLocaleDateString('zh-Hans-CN',opts).replaceAll('/','-');
                        newSched.shift_date_end = includedDate.toLocaleDateString('zh-Hans-CN',opts).replaceAll('/','-');
                        newSched.crudStatus = 0;
                        this.schedules[newSched.id] = JSON.parse(JSON.stringify(newSched));
                        
                        j++;
                    }
                        
                }
                
            }else{
                if(startDateTime <= currentDateTime){
                    alert("You cannot modify a schedule's time to a datetime that has already started!");
                    return;
                }

                let emps = this.queSched.assignedEmps;
                if(emps != null){
                    if(emps.length > 0){
                         for(let i = 0; i < emps.length; i++){
                            if(this.queSched.designation != this.employees[emps[i].id].role_id){
                                alert('Please remove the employees you assigned which did not have the role you specified!');
                                return;
                            }
                        }

                        if(emps.length > this.queSched.max_employees){
                            alert('Please remove some employees from this schedule before you reduce the maximum number of employees!');
                            return;
                        }
                    }
                }

                if(this.queSched.crudStatus != 0) this.queSched.crudStatus = 1;

                this.schedules[this.queSched.id] = JSON.parse(JSON.stringify(this.queSched));
            }

            
            this.buildCalendar();
            this.showSetSchedModal = false;
            this.resetQueSched();
        },  
        
        buildCalendar(){
            let cc = this.currentCalendar;
            let date = new Date(cc.y,cc.m,cc.d);

            if(this.viewMode == 'Month View'){
                let numDays = new Date(date.getFullYear(),date.getMonth()+1,0).getDate();
                let startOffset = new Date(date.getFullYear(),date.getMonth(),1).getDay();
                let endOffset = 7 - new Date(date.getFullYear(),date.getMonth()+1,1).getDay();
                if(endOffset == 7) endOffset = 0;
                
                
                this.calendarBox = new Array();
                for(let i=0,j=1;i<numDays+startOffset+endOffset;i++){
                    if(i>=startOffset&&j<=numDays){
                        let dateString = formatDateString(new Date(cc.y+'-'+(cc.m+1)+'-'+j).toLocaleDateString('zh-Hans-CN')).replaceAll(' ','');
                        this.calendarBox.push({
                            dateNum: j,
                            dateString:dateString,
                            dayScheds:this.getDayScheds(dateString),
                            onclick: ()=> {
                                this.currentCalendar.d = ((j-1)<10) ? '0'+(j-1) : j - 1;
                            },
                            today: new Date().toLocaleDateString == new Date(cc.y,cc.m,j)
                        });
                        j++;
                    }else{
                        this.calendarBox.push({
                            onclick: ()=>{}
                        });
                    }
                }
                return;
            }
            let startOffset = date.getDay() - 0
            let endOffset = 7 - date.getDay();
            let inclusiveDates = [];
            for(let i=startOffset;i>=0;i--){
                let newDate = new Date(cc.y,cc.m,cc.d);
                newDate.setDate(newDate.getDate() - i);
                inclusiveDates.push(formatDateString(String(newDate.getFullYear())+'-'+String(newDate.getMonth()+1)+'-'+String(newDate.getDate())).replaceAll(' ',''));
            }

            for(let i=1;i<endOffset;i++){
                let newDate = new Date(cc.y,cc.m,cc.d);
                newDate.setDate(newDate.getDate() + i);
                inclusiveDates.push(formatDateString(String(newDate.getFullYear())+'-'+String(newDate.getMonth()+1)+'-'+String(newDate.getDate())).replaceAll(' ',''));
            }

            this.calendarBox = new Array();
            inclusiveDates.forEach(el=>{
                this.calendarBox.push({
                    dateNum: parseInt(el.split('-')[el.split('-').length - 1]),
                    dateString:el,
                    dayScheds:this.getDayScheds(el),
                    onclick: ()=> {
                        this.currentCalendar.y = parseInt(el.split('-')[0]);
                        this.currentCalendar.m = parseInt(el.split('-')[1]) - 1;
                        this.currentCalendar.d = parseInt(el.split('-')[2]);
                    },
                    today: parseInt(date.getDate() == el.split('-')[el.split('-').length - 1])
                });
            })
        
            this.calendarBox;
            
            
        },
        jumpToDate(e){
            this.expanded = [];
            let date = typeof e == 'object' ? new Date(e.target.value) : new Date(e);
            this.currentCalendar.y = date.getFullYear();
            this.currentCalendar.m = date.getMonth();
            this.currentCalendar.d = date.getDate();
            this.buildCalendar();
            document.getElementById('gotoDate').value = date.toLocaleDateString('zh-Hans-CN',{year:'numeric',month:'2-digit',day:'2-digit'}).replaceAll('/','-');
        },
        next(mos){
            this.expanded = [];
            let cc = this.currentCalendar;
            let date = new Date(cc.y,cc.m,cc.d);
            date.setMonth(date.getMonth()+mos);
            this.currentCalendar.y = date.getFullYear();
            this.currentCalendar.m = date.getMonth();
            this.currentCalendar.d = date.getDate();
            this.buildCalendar();
        },
        nextDay(days){
            this.expanded = [];
            let cc = this.currentCalendar;
            let date = new Date(cc.y,cc.m,cc.d);
            date.setDate(date.getDate()+days);
            this.currentCalendar.y = date.getFullYear();
            this.currentCalendar.m = date.getMonth();
            this.currentCalendar.d = date.getDate();
            this.buildCalendar();
        },
        echo(txt){
            return console.log(txt);
        },
        getDayScheds(dateString){
            let hitScheds = [];
            for(let s in this.schedules){
                if(dateString == this.schedules[s].shift_date)
                    hitScheds.push(this.schedules[s]);
            }
            if(hitScheds.length == 0) return [];
            return hitScheds.sort((a,b)=>{
                let timeA = new Date(a.shift_date+' '+a.shift_start).getTime();
                let timeB = new Date(b.shift_date+' '+b.shift_start).getTime();
                return timeA - timeB;
            });
        },
        deleteSchedule(id){
            delete this.schedules[id];
            this.showSetSchedModal = false;
            this.deletedSchedIds.push(id);
            this.buildCalendar();
        },
        filteredDayScheds(scheds,empId){
            return scheds.filter(el=>{
                
                if(el.assignedEmps != null){
                    let e = el.assignedEmps.filter(el=>el.id==empId);
                    return e.length > 0;
                }
            });
        },
        removeSchedFromEmp(schedId,empId){
            let index = this.schedules[schedId].assignedEmps.indexOf(this.schedules[schedId].assignedEmps.find(el=>el.id == empId));
            this.schedules[schedId].assignedEmps.splice(index,1);
            if(this.schedules[schedId].crudStatus != 0) this.schedules[schedId].crudStatus = 1;
        },
        saveChanges(){
            let created = [];
            let updated = [];
            if(this.isSaving) return;
            this.isSaving = true;

            let string = this.currentCalendar.y +'-'+ (this.currentCalendar.m+1) +'-'+ this.currentCalendar.d;
            string = formatDateString(string).replaceAll(' ','');
            
            const getAssignDesignationID = (arr,schedid)=>{
                let assigned = [];
                arr.forEach(el=>{
                    const status = el.status;
                    const id = el.id;
                    delete el.assigndesignation_employeeid;
                    delete el.status;
                    delete el.id;
                    delete el.assignschedules_id;
                    assigned.push({
                        assignschedules_assigndesignationid:this.employees[id].assigndesignation_id,
                        assignschedules_scheduleid:schedid,
                        assignschedules_status:status,
                        ...el
                    });
                });
                return assigned;
            };

            for(let s in this.schedules){
                if(this.schedules[s].crudStatus == null) continue;
                let newData = JSON.parse(JSON.stringify({
                    schedule:{
                        schedules_dates:this.schedules[s].shift_date,
                        schedules_description:this.schedules[s].description,
                        schedules_facilityid:this.schedules[s].branch_id,
                        schedules_id:this.schedules[s].id,
                        schedules_roleid:this.schedules[s].designation,
                        schedules_timestart:this.schedules[s].shift_start,
                        schedules_timeend:this.schedules[s].shift_end,
                    }
                }));
                if(this.schedules[s].assignedEmps.length > 0){
                    newData.assignedEmps = getAssignDesignationID(this.schedules[s].assignedEmps,this.schedules[s].id);
                }

                if(this.schedules[s].crudStatus == 0) created.push(newData);
                else updated.push(newData);
            }
            let completeStatusCreated = [created.length,0];
            let completeStatusUpdated = [updated.length,0];
            let completeStatusCreated2 = {};
            let completeStatusUpdated2 = {};
            let deletedIndexes = 0;


            created.forEach(el=>{;
                if(el.assignedEmps != null && el.assignedEmps.length != 0) completeStatusCreated2[el.schedule.schedules_id] = [el.assignedEmps.length,0]
                axios.encrypted('Schedule/create',null,el.schedule).then(()=>{
                    if(el.assignedEmps == null || el.assignedEmps.length == 0) {completeStatusCreated[1]++;return;}
                    
                    el.assignedEmps.forEach(el2=>{
                        axios.post('Assign/create',null,el2).then(res=>{
                            if(res.data.success) completeStatusCreated2[el.schedule.schedules_id][1]++
                            if(completeStatusCreated2[el.schedule.schedules_id][0] == completeStatusCreated2[el.schedule.schedules_id][1]) completeStatusCreated[1]++
                        });
                    })
                 });
            });
            
            updated.forEach(el=>{
                if(el.assignedEmps != null && el.assignedEmps.length != 0) completeStatusUpdated2[el.schedule.schedules_id] = [el.assignedEmps.length,0]
                axios.encrypted('Assign/delete?scheduleid='+el.schedule.schedules_id,null).then(res=>{
                    axios.encrypted('Schedule/update?id='+el.schedule.schedules_id,null,el.schedule).then(()=>{
                        if(el.assignedEmps == null || el.assignedEmps.length == 0) {completeStatusUpdated[1]++;return;}
                        el.assignedEmps.forEach(el2=>{
                            axios.post('Assign/create',null,el2).then(res=>{
                                if(res.data.success) completeStatusUpdated2[el.schedule.schedules_id][1]++
                                if(completeStatusUpdated2[el.schedule.schedules_id][0] == completeStatusUpdated2[el.schedule.schedules_id][1]) completeStatusUpdated[1]++
                            });
                        })
                    });
                });
            });


            this.deletedSchedIds.forEach(el=>{
                axios.encrypted('Assign/delete?scheduleid='+el).then(()=>{
                    axios.encrypted('Schedule/delete?id='+el).then(()=>{
                        deletedIndexes++;
                    });
                });
            });

            let axiosChecker = setInterval(()=>{
                let conditions = [false,false,false];

                if(completeStatusCreated.length == 0) conditions[0] = true;
                else if(completeStatusCreated[0] == completeStatusCreated[1]) conditions[0] = true;

                if(completeStatusUpdated.length == 0) conditions[1] = true;
                else if(completeStatusUpdated[0] == completeStatusUpdated[1]) conditions[1] = true;

                if(deletedIndexes == this.deletedSchedIds.length) conditions[2] = true;
                if(conditions[0] && conditions[1] && conditions[2]) window.location.replace('/adminapp/jobschedule?date='+string);

            },500);
        }
    }
})
</script>

<template>
<div class="scheduler_parent">
    <div class="requestsModal" v-if="requestsModal.shown">
    <div class="requestsModalBox">
        <div class="requestsModalHeader">
            <h3>Schedule Requests</h3>
            <button @click="requestsModal.shown = false">Close</button>
        </div>
        <div class="requestsModalBody">
            <div class="requestsCtrl">
                <button :class="{active:requestsModal.mode == 3}" @click="requestsModal.mode =3">Schedule Applications</button>
                <button :class="{active:requestsModal.mode == 4}" @click="requestsModal.mode = 4">Reschedule Requests</button>
                <button :class="{active:requestsModal.mode == 2}" @click="requestsModal.mode = 2">Reassign Requests</button>
            </div>

            <div class="requestsList">
                <div class="requestsItem">
                    <h3>Schedule One <small>January 2 (2:00am-5:00am) &bull; Employee Employee</small><button  @click="toggleRequestView">&#9660;</button></h3>
                    <div class="requestsItemGrid">
                        <div><small>Date</small>January 2, 2023</div>
                        <div><small>From</small>2:00am</div>
                        <div><small>To</small>5:00am</div>
                        <div><small>Employee ID</small>12345678</div>
                        <div class="right"><small>Employee Name</small>Employee Employee</div>
                        <div><small>Employee Role</small>LPN</div>
                        <div class="right"><small>Branch</small>4ANGELS HEALTH CENTER</div>
                        <div class="requestsItemFooter full">
                            <button>Accept</button>
                            <button>Decline</button>
                        </div>
                    </div>
                </div>

                <div class="requestsItem">
                    <h3>Schedule Two <small>January 2 (2:00am-5:00am) &bull; Employee Employee</small><button  @click="toggleRequestView">&#9660;</button></h3>
                    <div class="requestsItemGrid">
                        <div><small>Date</small>January 2, 2023</div>
                        <div><small>From</small>2:00am</div>
                        <div><small>To</small>5:00am</div>
                        <div><small>Resched Date</small>January 3, 2023</div>
                        <div><small>Resched From</small>5:00am</div>
                        <div><small>Resched To</small>7:00am</div>
                        <div><small>Employee ID</small>12345678</div>
                        <div class="right"><small>Employee Name</small>Employee Employee</div>
                        <div><small>Employee Role</small>LPN</div>
                        <div class="right"><small>Branch</small>4ANGELS HEALTH CENTER</div>
                        <div class="full"><small>Reason</small>10 years na single, karun ra naay blind date</div>
                        <div class="requestsItemFooter full">
                            <button>Accept</button>
                            <button>Decline</button>
                        </div>
                </div>
                   
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="setScheduleModal" v-if="showSetSchedModal">
    <div class="setScheduleModalBox">
        <div class="setScheduleModalHeader">
            <h3>{{(updateSchedId == '') ? 'Add' : (editDisabled) ? 'View' : 'Edit'}} Schedule <small v-if="updateSchedId != ''">ID: {{updateSchedId}}</small></h3>
            <button @click="showSetSchedModal = false;resetQueSched();">Close</button>
        </div>
        <div class="setScheduleModalInputs">
            <label >{{(updateSchedId == '') ? 'From' : 'Date'}}</label>
            <input type="date" v-model="queSched.shift_date" readonly :class="{full: (updateSchedId != ''), emptyInput: invalidInput.includes('shift_date_end')}">
            <label v-if="updateSchedId == ''">To</label>
            <input :class="{emptyInput: invalidInput.includes('shift_date_end')}" type="date" v-model="queSched.shift_date_end" v-if="updateSchedId == ''">
            <label>Start Time</label>
            <input :readonly="editDisabled" :class="{emptyInput: invalidInput.includes('shift_start')}" type="time" v-model="queSched.shift_start" min="00:00" max="23:59">
            <label>End Time</label>
            <input :readonly="editDisabled" :class="{emptyInput: invalidInput.includes('shift_end')}" type="time" v-model="queSched.shift_end" min="00:00" max="23:59">
            
            <div class="dta_label" v-if="updateSchedId == ''">Days to Appear
                <div class="dta_btns">
                    <button :class="{active:queSched.repeatDays.includes(0)}" @click="selectDay(0)">S</button>
                    <button :class="{active:queSched.repeatDays.includes(1)}" @click="selectDay(1)">M</button>
                    <button :class="{active:queSched.repeatDays.includes(2)}" @click="selectDay(2)">T</button>
                    <button :class="{active:queSched.repeatDays.includes(3)}" @click="selectDay(3)">W</button>
                    <button :class="{active:queSched.repeatDays.includes(4)}" @click="selectDay(4)">T</button>
                    <button :class="{active:queSched.repeatDays.includes(5)}" @click="selectDay(5)">F</button>
                    <button :class="{active:queSched.repeatDays.includes(6)}" @click="selectDay(6)">S</button>
                </div>
            </div>

            <label>Roles</label>
            <div id="roles_select_con" class="full">
                <input :readonly="editDisabled" :class="{emptyInput: invalidInput.includes('designation')}" id="roles_select_input" v-model="searchDesignations" placeholder="Search in roles">
                <ul v-if="!editDisabled">
                    <li v-for="d,i in filteredDesignations" :key="i" @click="searchDesignations = d.role_name;queSched.designation=d.role_id;queSched.color=d.role_color">{{d.role_name}}</li>
                </ul>
            </div>
            <div class="roles_select_selected full" >
                <div class="roles_selected_item" v-for="qd,i in queSched.designations" :key="i">
                    {{objFromArr('designations',qd).role_name}}
                    <a href="javascript:;" @click="queSched.designations.splice(i,1)">&times;</a>
                </div>
            </div>
            <label>Description</label>
            <textarea :readonly="editDisabled" v-model="queSched.description" class="full"></textarea>
        </div>
        <div class="setScheduleModalFooter" v-if="!editDisabled">
            <button class="exitSetScheduleModal" @click="setSchedule">{{(updateSchedId == '') ? 'Add' : 'Edit'}} Schedule</button>
            <button class="deleteSchedule" v-if="updateSchedId != ''" @click="deleteSchedule(queSched.id)">Delete Schedule</button>
        </div>
        
    </div>
</div>
<div class="scheduler_ctrl">
    <!-- <button class="calendarCtrlBtns"  @click="requestsModal.shown = true">View Requests</button> -->
    <button class="calendarCtrlBtns" @click="next(-12)" v-if="viewMode == 'Month View'">Prev Year</button>
    <button class="calendarCtrlBtns" @click="next(-1)">Prev Month</button>
    <button class="calendarCtrlBtns" @click="nextDay(-7)" v-if="viewMode == 'Week View'">Prev Week</button>
    <button class="calendarCtrlBtns" @click="nextDay(7);" v-if="viewMode == 'Week View'">Next Week</button>
    <button class="calendarCtrlBtns" @click="next(1)">Next Month</button>
    <button class="calendarCtrlBtns" @click="next(12)" v-if="viewMode == 'Month View'">Next Year</button>
    <label for="gotoDate" class="calendarLabel" @click="clickGoToDate">
        {{new Date(currentCalendar.y,currentCalendar.m,currentCalendar.d).toLocaleString('default', { month: 'long',year:'numeric' })}}
        <small></small>
        <input type="date" id="gotoDate" @change="jumpToDate">
        <!-- style="opacity:0;width:0;height:0;display:block" -->
    </label>
    <button class="calendarCtrlBtns" @click="copyMode=!copyMode" :class="{red:copyMode,black:!copyMode}">{{copyMode ? 'Move' : 'Copy'}} Mode</button>
    <div id="viewmode_select_con" class="full">
            <input v-model="viewMode" readonly>
            <ul>
                <li @click="viewMode = 'Month View';buildCalendar();">Month View</li>
                <li @click="viewMode = 'Week View';buildCalendar();">Week View</li>
            </ul>
        </div>
    <button class="calendarCtrlBtns green" @click="saveChanges" :class="{saving:isSaving}">
        {{!isSaving ? 'Save Changes':''}}

        <i class="loading-dots" v-if="isSaving">
            <i class="loading-dots-inner"></i>
        </i>
    </button>
</div>


<div class="scheduler_view" :class="{week:viewMode == 'Week View'}">
    <div class="scheduler_item title">Sun</div>
    <div class="scheduler_item title">Mon</div>
    <div class="scheduler_item title">Tue</div>
    <div class="scheduler_item title">Wed</div>
    <div class="scheduler_item title">Thu</div>
    <div class="scheduler_item title">Fri</div>
    <div class="scheduler_item title">Sat</div>

    <div class="scheduler_item" :class="{blank: c.dateNum == null,active:c.dateNum==currentCalendar.d,today:c.today===true}" v-for="c,ind in calendarBox" :key="c" @click="e=>(c.onclick() != null) ? c.onclick() : false" :data-dateString="c.dateString" @dragenter.prevent @dragover.prevent @drop="dropSched">
        <span class="dateNum" v-if="c.dateNum != null">{{c.dateNum}}</span>
        <div class="scheduler_item_actions"  v-if="c.dateNum != null && c.dateNum==currentCalendar.d">
            <img class="icon" @click="showSetSchedModal = true;resetQueSched();queSched.shift_date_end = queSched.shift_date = formatDateString(currentCalendar.y+'-'+(currentCalendar.m+1)+'-'+currentCalendar.d).replaceAll(' ','');" title="Add Schedule" src="../../assets/add-icon.svg"/>
        </div>
        <div class="dayScheds_con" :id="'dayScheds_con_'+ind" :class="{expanded: expanded.includes('dayScheds_con_'+ind)}" :data-call="getRelativeFoldHeight('dayScheds_con_'+ind)">
            <div class="dayScheds" :class="{unclickable:isScheduleDone(ds),notCurrentBranch: facilityId != ds.branch_id}" draggable="true" v-for="ds,i in c.dayScheds" :key="i" :data-schedule="stringify(ds)" @click="prepareEdit(ds)" @dragstart="dragSched($event,ds)">
                <h4>{{findPropInObjArray(designations,'role_id',ds.designation).role_name}}
                    <!-- <span title="Conflicting schedules!" v-if="checkConflicts(c.dateString,ds)" class="conflict">!</span> -->
                </h4>
                <p>{{new Date(ds.shift_date+' '+ds.shift_start).toLocaleTimeString('en-US',{hour12:true,hour: '2-digit', minute: '2-digit'})}} to 
                    {{new Date(ds.shift_date+' '+ds.shift_end).toLocaleTimeString('en-US',{hour12:true,hour: '2-digit', minute: '2-digit'})}}
                </p>
                <strong class="notCurrentBranchIndicator" v-if="facilityId != ds.branch_id">Branch: {{ds.branch_name}}</strong>
                <div class="color" :style="'background:'+ds.color"></div>
            </div>
        </div> 
        
    {{c.text}}
    <div @click="toggleExpand('dayScheds_con_'+ind)" v-if="c.dayScheds != null && c.dayScheds.length > 2" class="icon expand_icon" :class="{expanded: expanded.includes('dayScheds_con_'+ind)}">
        <img src="../../assets/caret-down.svg"/> {{ !expanded.includes('dayScheds_con_'+ind) ? (c.dayScheds.length - 2) + ' more' : 'Collapse'}}
    </div>
    
    </div>
</div>

<div class="employee_view_cont" v-if="viewMode == 'Week View'">
    <div class="employee_view_header">
        <h4>Employees in this facility</h4>
        <div class="employee_view_header_right">
            <select id="designations_select" @change="e=>employeeFilter.byRole = [e.target.value]">
                <option :value=[-1]>All</option>
                <option v-for="d in designations" :value="d.role_id" :key="d.role_id">{{d.role_name}}</option>
            </select>
            <input v-model="employeeFilter.search" placeholder="Search Employee Name">

        </div>
    </div>
    
    <div class="employee_view">
        <div class="employee_item">
            <div class="employee_scheduler_item">
                Employee
            </div>
            <div class="employee_scheduler_item" v-for="c in calendarBox" :key="c">{{daysOfWeek[new Date(c.dateString).getDay()]}} - {{c.dateNum}}</div>
        </div>
        <div class="employee_item" v-for="e,i in filteredEmployees" :key="i">
            <div class="employee_scheduler_item">
                <h4>{{e.employee_firstname}} {{e.employee_lastname}} <small :style="{border: '2px solid '+e.role_color}">{{e.role_name}}</small></h4>
            </div>
            <div class="employee_scheduler_item" v-for="c,ind in calendarBox" :key="c" :data-employee="i" @dragenter.prevent @dragover.prevent @drop="dropSchedToEmp($event,e.employee_id)">
                <div class="dayScheds_con" :id="'dayScheds_con_emp_'+ind+'_'+e.employee_id" :class="{expanded: expanded.includes('dayScheds_con_emp_'+ind+'_'+e.employee_id)}" :data-call="getRelativeFoldHeight('dayScheds_con_emp_'+ind+'_'+e.employee_id)">
                    <div class="dayScheds" draggable="true" v-for="ds,i in filteredDayScheds(c.dayScheds,i)" :key="i" :data-schedule="stringify(ds)" @dragstart="dragSched($event,ds)" :class="{notCurrentBranch: facilityId != ds.branch_id}">
                        {{ds.status}}
                    <h4>{{findPropInObjArray(designations,'role_id',ds.designation).role_name}}
                        <span :id="'conflict_'+ds.id+'_'+e.assigndesignation_employeeid" title="Conflicting schedules!" :data-call="checkConflicts(ds,e.employee_id,'conflict_'+ds.id+'_'+e.assigndesignation_employeeid)" class="conflict">!</span>
                    </h4>
                    <p>{{new Date(ds.shift_date+' '+ds.shift_start).toLocaleTimeString('en-US',{hour12:true,hour: '2-digit', minute: '2-digit'})}} to 
                        {{new Date(ds.shift_date+' '+ds.shift_end).toLocaleTimeString('en-US',{hour12:true,hour: '2-digit', minute: '2-digit'})}}
                    </p>
                    
                    <a href="javascript:;" @click="prepareEdit(ds)">View / Edit</a>
                    <a class="remove" v-if="!isScheduleDone(ds) && facilityId == ds.branch_id" href="javascript:;" @click="removeSchedFromEmp(ds.id,e.employee_id)">Remove (x)</a>
                    <strong class="notCurrentBranchIndicator" v-if="facilityId != ds.branch_id">Branch: {{ds.branch_name}}</strong>
                    <div class="color" :style="'background:'+ds.color"></div>
                    </div>
                </div>
                <div @click="toggleExpand('dayScheds_con_emp_'+ind+'_'+e.employee_id)" v-if="filteredDayScheds(c.dayScheds,i).length != null && filteredDayScheds(c.dayScheds,i).length > 2" class="icon expand_icon" :class="{expanded: expanded.includes('dayScheds_con_emp_'+ind+'_'+e.employee_id)}">
                    <img src="../../assets/caret-down.svg"/> {{ !expanded.includes('dayScheds_con_emp_'+ind+'_'+e.employee_id) ? (filteredDayScheds(c.dayScheds,i).length - 2) + ' more' : 'Collapse'}}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</template>

<style scoped>
*{font-family: sans-serif;}
h3,p{margin: 0;}

.scheduleAlert{
    padding: 10px;
    background: #222;
    position: fixed;
    color:#fff;
    border-radius: 5px;
    bottom:-50px;
    right:20px;
    transition: 0.3s;
    opacity: 0;
}
.alertShow{
    bottom: 50px;
    opacity: 1;
}

.scheduler_view{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
    border:1px solid #ccc;
    border-bottom: none;
    
}

.scheduler_view.week{
    resize: vertical;
    overflow-y: auto;
    grid-template-rows: 30px 1fr;
    border-bottom: 1px solid #ccc;
}

.scheduler_view.week .scheduler_item{
    min-height: auto;
}

.scheduler_item{
    border-right:1px solid #ccc;
    border-bottom:1px solid #ccc;
    position: relative;
    padding-bottom: 40px;
    transition: 0.2s;
    min-height: 100px;
}

.scheduler_item:nth-child(7n){border-right:none}

.dateNum{
    padding: 5px;
    display: inline-block;
    border-radius: 50%;
    box-shadow: inset -1px -1px 4px #aaa;
    width: 35px;
    text-align: center;
    margin: 5px;
}

.scheduler_item:not(.blank):not(.title):hover{outline:1px solid #000}
.scheduler_item:not(.active):hover .dateNum{
    background: #000;
    color:#fff;
    box-shadow:none;
}

.scheduler_item.today{outline:1px solid #777}
.scheduler_item.today .dateNum{
    background: #777;
    color:#fff;
    box-shadow:none;
}

.scheduler_item:not(.blank):not(.title):active,.scheduler_item.active{outline:1px solid #2095db}
.scheduler_item:active .dateNum,.scheduler_item.active .dateNum{
    background: #2095db;
    color:#fff;
    box-shadow:none;
}
.scheduler_item.title{
    text-align: center;
    min-height: unset;
    padding: 5px;
    max-height: 30px;
}

.scheduler_item_actions{
    display: flex;
    position: absolute;
    bottom: 0;
    right: 0;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 20px 0 0 0;
    border-right: none;
    border-bottom: none;
    background: #fff;
    z-index: 1;
}



.scheduler_item .icon, .employee_scheduler_item .icon{
    width: 30px;
    display: block;
    opacity: 0.8;
    transition: 0.2s;
}

.scheduler_item .expand_icon.icon, .employee_scheduler_item .expand_icon.icon{
    width: max-content;
    margin: 20px auto -30px 10px;
    box-shadow: 0 0 2px #000;
    padding: 7px;
    border-radius: 5px;
    line-height: 100%;
}

.employee_scheduler_item .expand_icon.icon{
    margin: 20px auto 10px 10px;
}

.scheduler_item .expand_icon.icon img, .employee_scheduler_item .expand_icon.icon img{object-fit: contain;width: 10px;vertical-align:middle;margin-bottom: 3px;margin-right: 5px;transition: 0.2s;transform: scale(1);}

.scheduler_item .expand_icon.expanded img, .employee_scheduler_item .expand_icon.icon.expanded img{
    transform: scale(-1);
}

.scheduler_item .icon:hover{
    opacity: 0.6;
}

.scheduler_ctrl{
    padding:10px;
    border:1px solid #ccc;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 10px;
    flex-wrap: wrap;
}
.calendarCtrlBtns{
    background: #2095db;
    color:#fff;
    border:none;
    padding:10px;
    margin: 5px;
    border-radius: 10px;
    transition: 0.2s;
}

.calendarCtrlBtns.saving{
    opacity: 0.7;
}

.calendarCtrlBtns:hover{background: #1875ab;}
.calendarCtrlBtns:active{background: #135b85;}
.calendarCtrlBtns.green{background: #017c3a;min-width:130px}
.calendarCtrlBtns.green:hover{background: #00632e;}
.calendarCtrlBtns.green:active{background: #004d24;}
.calendarCtrlBtns.red{background: #b94d37;}
.calendarCtrlBtns.red:hover{background: #953c2a;}
.calendarCtrlBtns.red:active{background: #8c3828;}
.calendarCtrlBtns.black{background: #797979;}
.calendarCtrlBtns.black:hover{background: #5f5f5f;}
.calendarCtrlBtns.black:active{background: #444444;}

.calendarLabel{
    margin: 0 40px;
    font-size:25px;
    line-height: 20px;
    text-align: center;
}
.calendarLabel small{
    font-size: 16px;
    text-align: center;
    width: 100%;
    display: block;
    border-top: 1px solid #ccc;
    opacity: 0.7;
    margin-top: 7px;
    padding-top: 4px;
}
.dayScheds_con{
    overflow: hidden;
    transition: max-height 0.4s;
    max-height: max-content;
}


.dayScheds_con.expanded,.employee_scheduler_item .dayScheds_con.expanded{
    max-height: max-content !important;
}

.dayScheds{
    padding: 5px 5px 0;
    border: 1px solid #ccc;
    text-align: center;
    margin:5px 0;
}
.dayScheds h4,.dayScheds p{margin: 0;font-size:18px}
.dayScheds h4 span.conflict{background: #e67523;
width: 15px;
height: 15px;
display: inline-block;
border-radius: 50%;
text-align: center;
font-size: 12px;
line-height:15px;
display: none;}
.dayScheds p{font-size: 14px;}
.dayScheds .color{
    margin: 5px -5px 0 -5px;
    width: calc(100% + 10px);
    height: 10px;
}

.setScheduleModal{position: fixed;width: 100vw;height: 100vh;top:0;left:0;z-index: 99;background: rgb(0,0,0,0.5);}

.setScheduleModal{
    position: fixed;
    width: 100vw;
    height: 100vh;
    top: 0;
    left: 0;
    z-index: 99;
    background: rgb(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}
.setScheduleModalBox{
    background: #fff;
    max-width: 600px;
    border-radius: 20px;
}
.setScheduleModalHeader{
    padding: 20px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #2095db;
    border-bottom: 2px solid #19638e;
    border-radius: 20px 20px 0 0;
    color: #fff;
}
.setScheduleModalHeader h3 small{
    font-size: 15px;
    font-style: oblique;
    font-weight: 400;
    background: white;
    padding: 2px 5px;
    color: #2095db;
    border-radius: 20px;
    margin: 5px;
    vertical-align: text-top;
}

.setScheduleModalHeader button{
    background: #19638e;
    border: none;
    color: #fff;
    border-radius:5px;
    padding: 10px;
    transition: 0.4s;
}

.setScheduleModalHeader button:hover{
   background: #0f4564; 
}

.full{
    grid-column: 2/5;
}

.wide{
    grid-column: 1/5;
}



.setScheduleModalInputs{
    padding: 20px 20px;
    display: grid;
    align-items: center;
    gap: 10px;
    grid-template-columns: 2fr 3fr 2fr 3fr;
}

.setScheduleModalInputs input,.setScheduleModalInputs textarea{
    padding: 7px;
    background: #ddd;
    border:none;
    border-bottom: 1px solid #aaa;
    border-radius: 5px;
    outline:none;
}
.dta_label{
    grid-column: 1/5;
    display: flex;
    gap:20px;
    align-items: center;
}

.dta_btns{
    display:flex;
}
.dta_btns button{
      background: #bbb;
    color: #fff;
    border:none;
    border-bottom: 1px solid #777;
    display:flex;
    align-items: center;
    justify-content: center;
    margin: 0 5px;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    transition: 0.4s;
}

.dta_btns button.active{
    background: #2095db;
    border-bottom: 1px solid #19638e;
    
}
#branch_select_con{position: relative;}
#branch_select_input{width: calc(100% - 10px);}
#branch_select_con ul{
    display: none;
    position: absolute;
    top: 100%;
    list-style: none;
    padding: 0;
    width: 100%;
    margin: 0;
    box-shadow: 0 0 2px #000;
    z-index: 100;
}
#branch_select_con:focus-within ul,#branch_select_con ul:hover{ display: block;}
#branch_select_con ul li{
    padding: 7px;
    background: #fff;
}

#branch_select_con ul li:hover{
    padding: 7px;
    background: #2095db;
    color:#fff
}

#roles_select_con{position: relative;}
#roles_select_input{width: calc(100% - 10px);}
#roles_select_con ul{
    display: none;
    position: absolute;
    top: 100%;
    list-style: none;
    padding: 0;
    width: 100%;
    margin: 0;
    box-shadow: 0 0 2px #000;
    z-index: 100;
}
#roles_select_con:focus-within ul,#roles_select_con ul:hover{ display: block;}
#roles_select_con ul li{
    padding: 7px;
    background: #fff;
}

#roles_select_con ul li:hover{
    padding: 7px;
    background: #2095db;
    color:#fff
}
.roles_select_selected{
    display: flex;
    flex-wrap: wrap;
    gap:3px;
}
.roles_selected_item{
    display: inline-block;
    border: 1px solid #aaa;
    padding: 5px 7px;
    border-radius: 50px;
    margin: 0px;
}
.roles_selected_item a{
    background: #777;
    width: 20px;
    height: 20px;
    display: inline-block;
    text-align: center;
    color: #fff;
    text-decoration: none;
    border-radius: 50%;
    margin-left: 5px;
}
.roles_selected_item a:hover{background: #555;}

.colors{display: flex;flex-wrap: wrap;}
.colors button{
    color: #fff;
    border:none;
    display:flex;
    align-items: center;
    justify-content: center;
    margin: 0 5px;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    transition: 0.4s;
}

.colors button.active{
    border: 3px solid #000;
}
.setScheduleModalFooter{
    padding: 0 20px 20px;
    display: flex;
    justify-content: flex-end;
    gap:10px;
}
.setScheduleModalFooter button{
    border: none;
    padding: 10px;
    color: #fff;
    border-radius: 5px;
    transition: 0.4s;
    display: block;
}
.exitSetScheduleModal{background: #2095db}
.exitSetScheduleModal:hover{background: #19638e}

.deleteSchedule{background: #e95353;}
.deleteSchedule:hover{background: #bf2f2f;}

#branchmode_select_con{
    position: relative;
    width: 150px;
}
#branchmode_select_con input{
    border: 1px solid #aaa;
    background: #fff;
    width: 135px;
    display: block;
    padding: 7px;
    border-radius: 5px;
}

#branchmode_select_con ul{
    display:none;
    list-style: none;
    padding: 0;
    margin: 0;
    position: absolute;
    box-shadow: 0 0 2px #000;
    width: 100%;
    z-index: 1;
}
#branchmode_select_con input:focus-within{background: #eee;}

#branchmode_select_con input:focus-within + ul,#branchmode_select_con ul:hover{display:block;}

#branchmode_select_con ul li{
    padding: 7px;
    background: #fff;
    z-index: 1;
}

#viewmode_select_con ul li:hover{
    padding: 7px;
    background: #fff;
    z-index: 1;
}


#viewmode_select_con{
    position: relative;
    width: 150px;
}
#viewmode_select_con input{
    border: 1px solid #aaa;
    background: #fff;
    width: 135px;
    display: block;
    padding: 7px;
    border-radius: 5px;
}

#viewmode_select_con ul{
    display:none;
    list-style: none;
    padding: 0;
    margin: 0;
    position: absolute;
    box-shadow: 0 0 2px #000;
    width: 100%;
    z-index: 1;
}
#viewmode_select_con input:focus-within{background: #eee;}

#viewmode_select_con input:focus-within + ul,#viewmode_select_con ul:hover{display:block;}

#viewmode_select_con ul li{
    padding: 7px;
    background: #fff;
    z-index: 1;
}

#viewmode_select_con ul li:hover{
    padding: 7px;
    background: #fff;
    z-index: 1;
}
.maxEmpInput{margin-left: 20px;width: 50px;}

.employee_view_cont{
    margin:20px 0 0;
}

.employee_view_header{
    margin: 0 0 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.employee_view_header_right{
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

.employee_view_header_right input,select{
    border: 1px solid #aaa;
    background: #fff;
    display: block;
    padding: 9px;
    border-radius: 5px;
    margin-right: 10px;
    height: 40px;
}
.employee_view_header_right .calendarCtrlBtns{margin-left: -5px;}
.employee_view{
    border:1px solid #ccc;
    resize: vertical;
    overflow-y: auto;
}



.employee_item{
    display: grid;
    grid-template-columns: 150px 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
    border-bottom:1px solid #ccc;
}



.employee_item:last-child{border-bottom:none}

.employee_scheduler_item{
    border-right: 1px solid #ccc;
    min-height: 100px;
    padding:10px;
}

.employee_item:first-child .employee_scheduler_item{
    min-height: unset;
    text-align: center;
}

.employee_item:not(:first-child) .employee_scheduler_item:first-child{
    display: flex;
    align-items: flex-start ;
    font-weight: 600;
    line-height: 25px;
}

.employee_item:not(:first-child) .employee_scheduler_item:not(:first-child){
    padding: 0;
}

.employee_scheduler_item .dayScheds a{
    font-size: 12px;
    text-decoration: none;
    display: inline-block;
    margin: 5px 5px 0;
    background: #2095db;
    color:#fff;
    padding: 3px 5px;
    border-radius: 5px;
    transition: 0.2s;
}

.employee_scheduler_item .dayScheds a.remove{
    background:#ab2828;
}

.employee_scheduler_item .dayScheds a:hover{background: #205e82}
.employee_scheduler_item .dayScheds a.remove:hover{background: #812c2c}

.employee_scheduler_item h4{
    line-height: 100%;
    margin: 0;
    font-size: 17px;
    font-weight: 600;
}

.employee_scheduler_item .dayScheds p{
    font-size: 13px;
}

.employee_scheduler_item .dayScheds h4{
    font-size: 15px;
}

.employee_scheduler_item h4 small{
    padding: 3px 8px;
    margin: 7px 0 0 -10px;
    display: block;
    color: #000;
    font-size: 14px;
    width: max-content;
    border-radius: 0 20px 20px 0;
}   

.unclickable{opacity: 0.7;}


.requestsModal{
    position: fixed;
    width: 100vw;
    height: 100vh;
    top: 0;
    left: 0;
    z-index: 99;
    background: rgb(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 50px;
}
.requestsModalBox{
    background: #fff;
    width:100%;
    max-width: 600px;
    border-radius: 20px;
}
.requestsModalHeader{
    padding: 20px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #2095db;
    border-bottom: 2px solid #19638e;
    border-radius: 20px 20px 0 0;
    color: #fff;
}

.requestsModalHeader button{
    background: #19638e;
    border: none;
    color: #fff;
    border-radius:5px;
    padding: 10px;
    transition: 0.4s;
}
.requestsModalBody{padding: 20px;}
.requestsModalBody .requestsCtrl{margin-bottom: 20px;}
.requestsModalBody .requestsCtrl button{
    border: 1px solid #2095db;
    background: #fff;
    color: #2095db;
    margin: 3px;
    padding: 5px 7px;
    border-radius: 20px;
    transition: 0.4s;
}

.requestsModalBody .requestsCtrl button:hover,.requestsModalBody .requestsCtrl button.active{
    color: #fff;
    background: #2095db;
}

.requestsModalBody .requestsCtrl button:active{background: #19638e;}

.requestsItem{
    padding: 15px;
    background: #eee;
    border: 1px solid #dcdcdc;
    /* border-bottom: 2px solid #aaa; */
    border-radius: 10px;
    margin: 5px 0;
    font-size: 15px;
}

.requestsItemGrid{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap:5px;
    overflow: hidden;
    transition: 0.4s;
    height: 0;
}
.requestsItem.open .requestsItemGrid{
    margin-top:10px;
}

.requestsItemGrid .full{grid-column: 1/4;}
.requestsItemGrid .left{grid-column: 1/3;}
.requestsItemGrid .right{grid-column: 2/4;}

.requestsItemGrid > div{
    padding: 3px;
}

.requestsItemGrid small{
    display: block;
    font-size: 12px;
    color:#2095db;
    margin-bottom: 3px;
    font-weight: 700;
}

.requestsItem h3 small{
    color: #2095db;
    font-weight: 400;
    font-size: 14px;
    vertical-align: middle;
    display: inline-block;
    margin-left: 10px;
    transition: 0.4s;
    white-space: pre;
    overflow: hidden;
    text-overflow: ellipsis;
    opacity: 1;
}

.requestsItem.open h3 small{opacity: 0;}

.requestsItem h3 button{quotes: none;float:right;display: inline-block;transition: 0.4s;border:none}
.requestsItem h3 button:hover{background: transparent;}
.requestsItem.open h3 button{transform: scaleY(-1);}
.requestsItemFooter{padding: 10px 0 5px;}
.requestsItemFooter button{
    background: #017c3a;
    color: #fff;
    padding: 10px;
    border-radius: 10px;
    border: none;
    box-shadow: inset 0 -3px 3px rgb(0,0,0,0.3);
    margin: 3px;
    transition: 0.2s;
}


.requestsItemFooter button:active{
    box-shadow: inset 0 3px 3px rgb(0,0,0,0.3);
    filter: brightness(75%);
}

.requestsItemFooter button:last-child{
    background: #ab2828;
}

.emptyInput{box-shadow: 0 0 5px #f00;}

.scheduler_ctrl2{
    justify-content: center;
    width: 100%;
    display: flex;
}

.scheduler_ctrl2 > div{display: flex;align-items: center;}


.notCurrentBranch{
    border:1px solid #eee;
    color:#555;
}

.notCurrentBranch .color{
    height: 2px;
    filter: grayscale(100%);
}

#gotoDate{
    font-size: 17px;
    border-radius: 5px;
    border: none;
    outline: none;
}


.notCurrentBranchIndicator{
    font-size: 11px;
    background: #555;
    color: #fff;
    padding: 3px;
    display: block;
    margin: 10px 0;
}

.loading-dots{text-align:center;width:31px;display:inline-block}
.loading-dots-inner{width:7px;height:7px;background:#fff;display:inline-block;border-radius:50%;position:relative;animation-name:loadingDot1;animation-duration: 1s;animation-iteration-count:infinite;animation-delay:0.33s}
.loading-dots-inner::before{content:"";position:absolute;width:7px;height:7px;background:#fff;display:inline-block;border-radius:50%;left:-12px;animation-name:loadingDot1;animation-duration: 1s;animation-iteration-count:infinite;}
.loading-dots-inner::after{content:"";position:absolute;width:7px;height:7px;background:#fff;display:inline-block;border-radius:50%;right:-12px;animation-name:loadingDot1;animation-duration: 1s;animation-iteration-count:infinite;animation-delay:0.66s}

@keyframes loadingDot1{
  0%{opacity:1;scale:0}
  30%{scale:1;opacity:1}
  50%{opacity:1}
  100%{opacity:0;}
}


</style>

