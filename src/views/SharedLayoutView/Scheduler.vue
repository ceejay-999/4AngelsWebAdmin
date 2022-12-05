<script>
import {dateFormat,formatDateString,axios} from '../../functions';
import {toRaw} from 'vue';

export default({
    data(){
        return{
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
                title:'',
                shift_date: '',
                shift_date_end: '',
                shift_start:'',
                shift_end:'',
                max_employees:1,
                repeatDays:[],
                excludeDates:[],
                description:'',
                branch_id:20,
                designations:[],
                assignedEmps:[],
                color:''
            },
            daysOfWeek:['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
            deletedSchedIds:[],

            branches:[],
            searchBranch:'Keppel Hub',
            designations:[],
            searchDesignations:'',
            colors:['#4054b2','#d30915','#1b9ce2','#3bb57a','#f2522c'],
            showSetSchedModal:false,
            allowDrag: true,
            schedules:{},
            selectedBranch:20,

            employees:{}
        }
    },
    mounted(){
        let date = new Date();
        this.currentCalendar.y = date.getFullYear();
        this.currentCalendar.m = date.getMonth();
        this.currentCalendar.d = date.getDate();

        axios.post('designation?_select=id,position&_batch=true&_batch=true').then(res=>{
            this.designations = res.data.result;
        });
        
        axios.post('branches?_select=id,name&_batch=true').then(res=>{
            this.branches = res.data.result;
        });

        this.fetchEmps();

        
        
        axios.post('common/schedules?branch_id='+this.queSched.branch_id).then(res=>{
            res.data.result.forEach(el=>{
                delete el.created_at;
                delete el.updated_at;
                let designations = [];
                let assignedEmps = [];
                if(el.designations != null) el.designations.forEach(el2=>designations.push(el2.id));
                if(el.assignedEmps != null) el.assignedEmps.forEach(el2=>assignedEmps.push(el2.id));
                el.designations = designations;
                el.assignedEmps = assignedEmps;
                this.schedules[el.id] = el;
            });

            this.resetQueSched();
            this.buildCalendar();
        })

        
    },
    computed:{
        filteredBranches(){
            let filtered = this.branches.filter(el=>{
                return el.name.toLowerCase().includes(this.searchBranch.toLowerCase());
            });
            return filtered;
        },
        filteredDesignations(){
            let filtered = this.designations.filter(el=>{
                return el.position.toLowerCase().includes(this.searchDesignations.toLowerCase()) && !this.queSched.designations.includes(el.id);
            });
            return filtered;
        }
    },
    methods:{
        dateFormat,
        formatDateString,
        stringifyAndParse(obj){
            return JSON.parse(JSON.stringify(obj));
        },
        dragSched(e,ds){
            try{
            e.dataTransfer.setData('schedData',JSON.stringify(ds));
            e.dataTransfer.setData('origin',formatDateString(e.target.parentElement.dataset.datestring).replaceAll(' ',''))
            }catch(err){return;}
        },
        fetchEmps(){
            axios.post(`userDesignations?
            _select=mobile_users.id,mobile_users.lastname,mobile_users.firstname,mobile_userdesignations.designation_id,mobile_designation.position
            &_joins=mobile_users,mobile_designation
            &_on=
            mobile_userdesignations.user_id=mobile_users.id,
            mobile_userdesignations.designation_id=mobile_designation.id
            &_batch=true
            &branch_id=`+this.queSched.branch_id).then(res=>{
                this.employees = {};
                res.data.result.forEach(el=>{
                    this.employees[el.id] = el;
                })
                
            });
        },
        dropSched(e){
            if(e.dataTransfer.getData('schedData') == '' || e.dataTransfer.getData('origin') == '' || e.target.dataset.datestring == null) return;
            let sched = JSON.parse(e.dataTransfer.getData('schedData'));
            let origin = e.dataTransfer.getData('origin');
            this.queSched = JSON.parse(JSON.stringify(sched));
            this.queSched.shift_date = formatDateString(e.target.dataset.datestring).replaceAll(' ','');
            if(this.queSched.crudStatus != 0) this.queSched.crudStatus = 1;
            this.schedules[this.queSched.id] = JSON.parse(JSON.stringify(this.queSched));


            // if(this.schedules[this.queSched.id].excludeDates.indexOf()) this.schedules[this.queSched.id].excludeDates.push(origin);
            // console.log(this.schedules[this.queSched.id]);
            this.resetQueSched();
            this.buildCalendar();
        },
        dropSchedToEmp(e,empId){
            if(e.dataTransfer.getData('schedData') == '') return;
            let sched = JSON.parse(e.dataTransfer.getData('schedData'));
            if(!this.schedules[sched.id].designations.includes(this.employees[empId].designation_id)) {
                alert('You must only drop schedules with appropriate roles for this employee!');
                return;
            }

            if(this.schedules[sched.id].assignedEmps.length >= this.schedules[sched.id].max_employees) {
                alert('Too many employees for this schedule!');
                return;
            }
        
            if(this.schedules[sched.id].crudStatus != 0) this.schedules[sched.id].crudStatus = 1;
            
            if(this.schedules[sched.id].assignedEmps.includes(empId)) return;
            this.schedules[sched.id].assignedEmps.push(empId);
        },
        selectDesignation(num){
            if(this.queSched.designations.includes(num))
                this.queSched.designations.splice(this.queSched.designations.indexOf(num),1);
            else
                this.queSched.designations.push(num);
            this.searchDesignations = '';
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
            this.queSched={
                id:'',
                title:'',
                shift_date: this.currentCalendar.y+'-'+(this.currentCalendar.m+1)+'-'+this.currentCalendar.d,
                shift_date_end: '',
                shift_start:'',
                shift_end:'',
                repeatDays:[],
                description:'',
                excludeDates:[],
                branch_id:this.queSched.branch_id,
                max_employees:1,
                designations:[],
                assignedEmps:[],
                color:''
            };
        },
        setSchedule(){
            let date = new Date();
            if(
                this.queSched.title == '' ||
                this.queSched.shift_date == '' ||
                this.queSched.shift_start =='' ||
                this.queSched.shift_end =='' ||
                this.queSched.branch_id == 0 ||
                this.queSched.searchBranch == 0 ||
                this.queSched.designations.length == 0 ||
                this.queSched.designations.max_employees <= 0 ||
                this.queSched.color == ''
            ) {
                alert('Required Fields are empty!');
                return;
            }
            if(new Date(this.queSched.shift_date).getTime() > new Date(this.queSched.shift_date_end).getTime()){
                alert('End date is sooner than the start date!');
                return;
            }

            let daydiffs = (new Date(this.queSched.shift_date_end) - new Date(this.queSched.shift_date)) / (1000 * 60 * 60 * 24);
            let inclusiveDates = [];

            
            let dateId1 = String(date.getUTCFullYear())+String(date.getUTCMonth())
            +String(date.getUTCDate())+String(date.getUTCHours())+String(date.getUTCMinutes())+String(date.getUTCSeconds());
            if(this.queSched.shift_start.match(/^[0-9]+:[0-9]+$/g) != null) this.queSched.shift_start = this.queSched.shift_start+':00';
            if(this.queSched.shift_end.match(/^[0-9]+:[0-9]+$/g) != null) this.queSched.shift_end = this.queSched.shift_end+':00';

            if(this.updateSchedId == ''){
                inclusiveDates.push([this.queSched.shift_date,dateId1])
                let month = this.currentCalendar.m;
                let day = parseInt(this.currentCalendar.d);
                
                for(let i=1;i<=daydiffs;i++){
                    let numDays = new Date(this.currentCalendar.y,this.currentCalendar.m+1,0).getDate();
                    day++;
                    
                    if(parseInt(day) > numDays) {
                        day =1;
                        month++;
                    }
                
                    let newDate = new Date(this.currentCalendar.y,month,day);
                    let dateId2 = (Math.floor(Math.random() * 1000) + 1000)+String(date.getUTCMonth())
                +String(date.getUTCDate())+String(date.getUTCHours())+String(date.getUTCMinutes())+String(date.getUTCSeconds());
                    let dateString = formatDateString(String(newDate.getFullYear())+'-'+(String(newDate.getMonth()+ 1) )
                +'-'+String(day)).replaceAll(' ','');
        
                    if(this.queSched.repeatDays.length > 0 && this.queSched.repeatDays.includes(newDate.getDay())){
                        inclusiveDates.push([dateString,dateId2]);
                    }else if(this.queSched.repeatDays.length == 0){
                        inclusiveDates.push([dateString,dateId2]);
                    }
                }
                inclusiveDates.forEach(el=>{
                    let sched = this.queSched;
                    sched.id = el[1];
                    sched.shift_date = el[0];
                    delete sched.repeatDays;
                    delete sched.shift_date_end;
                    delete sched.excludeDates;
                    sched.crudStatus = 0;
                    this.schedules[sched.id] = JSON.parse(JSON.stringify(sched));
                });
            }else{
                let emps = this.queSched.assignedEmps;

                for(let i = 0; i < emps.length; i++){
                    if(!this.queSched.designations.includes(this.employees[emps[i]].designation_id)){
                        alert('Please remove the employees you assigned which did not have the role(s) you specified!');
                        return;
                    }
                }

                if(emps.length > this.queSched.max_employees){
                    alert('Please remove some employees from this schedule before you reduce the maximum number of employees!');
                    return;
                }
        
                if(this.queSched.crudStatus != 0) this.queSched.crudStatus = 1;

                this.schedules[this.queSched.id] = JSON.parse(JSON.stringify(this.queSched));
            }
            
            this.resetQueSched();
            this.updateSchedId = '';
            this.selectedBranch = 20;
            this.showSetSchedModal = false;
            
            this.buildCalendar();
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
                        this.calendarBox.push({
                            dateNum: j,
                            dateString:cc.y+'-'+(cc.m+1)+'-'+j,
                            dayScheds:this.getDayScheds(cc.y+'-'+(cc.m+1)+'-'+j),
                            onclick: ()=> {
                                this.currentCalendar.d = ((j-1)<10) ? '0'+(j-1) : j - 1;
                            },
                            today: date.getDate() == j
                        });
                        j++;
                    }else{
                        this.calendarBox.push({});
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
            let date = new Date(e.target.value);
            this.currentCalendar.y = date.getFullYear();
            this.currentCalendar.m = date.getMonth();
            this.currentCalendar.d = date.getDate();
            this.buildCalendar();
        },
        next(mos){
            let cc = this.currentCalendar;
            let date = new Date(cc.y,cc.m,cc.d);
            date.setMonth(date.getMonth()+mos);
            this.currentCalendar.y = date.getFullYear();
            this.currentCalendar.m = date.getMonth();
            this.currentCalendar.d = date.getDate();
            this.buildCalendar();
        },
        nextDay(days){
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
            dateString = formatDateString(dateString).replaceAll(' ','');
            let hitScheds = [];
            for(let s in this.schedules){
                if(dateString == this.schedules[s].shift_date && this.schedules[s].branch_id==  this.selectedBranch)
                    hitScheds.push(this.schedules[s]);
            }

            return hitScheds;
        },
        deleteSchedule(id){
            delete this.schedules[id];
            this.showSetSchedModal = false;
            this.deletedSchedIds.push(id);
            this.buildCalendar();
        },
        filteredDayScheds(scheds,empId){
            return scheds.filter(el=>el.assignedEmps.includes(empId));
        },
        removeSchedFromEmp(schedId,empId){
            console.log(this.schedules[schedId].assignedEmps,String(empId));
            let index = this.schedules[schedId].assignedEmps.indexOf(String(empId));
            this.schedules[schedId].assignedEmps.splice(index,1);
        },
        saveChanges(){
            let created = [];
            let updated = [];
            
            for(let s in this.schedules){
                console.log(this.schedules[s]);
                if(this.schedules[s].crudStatus == null) continue;
                if(this.schedules[s].crudStatus == 0) created.push(JSON.parse(JSON.stringify(this.schedules[s])));
                else updated.push(JSON.parse(JSON.stringify(this.schedules[s])));
            }

            created.forEach(el=>{
                let assignedEmps = el.assignedEmps;
                let designations = el.designations;
                delete el.assignedEmps;
                delete el.designations;
                delete el.crudStatus;
                console.log(el);
                axios.post('schedule/create',null,el).then(()=>{
                    
                    assignedEmps.forEach(el2=>{
                        axios.post('assigned/create',null,{
                            user_id: el2,
                            schedule_id:el.id
                        }).then(res=>console.log(res));
                    });
                    designations.forEach(el2=>{
                        axios.post('scheduleDesignations/create',null,{
                            designation_id: el2,
                            schedule_id:el.id
                        }).then(res=>console.log(res));
                    });
                });
                
            });

            updated.forEach(el=>{
                let assignedEmps = el.assignedEmps;
                let designations = el.designations;
                delete el.assignedEmps;
                delete el.designations;
                delete el.crudStatus;
                console.log(el);
                axios.post('schedule/update?id='+el.id,null,el).then(res=>console.log(res));
                axios.post('assigned/delete?schedule_id='+el.id,null,el).then(()=>{
                    console.log(assignedEmps);
                    assignedEmps.forEach(el2=>{
                        
                        
                        axios.post('assigned/create',null,{
                            user_id: el2,
                            schedule_id:el.id
                        }).then(res=>console.log(res));
                    });
                });
                axios.post('scheduleDesignations/delete?schedule_id='+el.id,null,el).then(()=>{
                    designations.forEach(el2=>{
                        axios.post('scheduleDesignations/create',null,{
                            designation_id: el2,
                            schedule_id:el.id
                        }).then(res=>console.log(res));
                    });
                });
                
            });

            this.deletedSchedIds.forEach(el=>{
                axios.post('scheduleDesignations/delete?schedule_id='+el);
                axios.post('assigned/delete?schedule_id='+el);
                axios.post('schedule/delete?id='+el);
            });

            
        }
    }
})
</script>

<template>
<div class="setScheduleModal" v-if="showSetSchedModal">
    <div class="setScheduleModalBox">
        <div class="setScheduleModalHeader">
            <h3>{{(updateSchedId == '') ? 'Add' : 'Edit'}} Schedule <small v-if="updateSchedId != ''">ID: {{updateSchedId}}</small></h3>
            <button @click="showSetSchedModal = false;resetQueSched();">Close</button>
        </div>
        <div class="setScheduleModalInputs">
            <label>Title</label>
            <input placeholder="Title of the schedule" v-model="queSched.title">
            <label >{{(updateSchedId == '') ? 'From' : 'Date'}}</label>
            <input type="date" v-model="queSched.shift_date" readonly :class="{full: (updateSchedId != '')}">
            <label v-if="updateSchedId == ''">To</label>
            <input type="date" v-model="queSched.shift_date_end" v-if="updateSchedId == ''">
            <label>Start Time</label>
            <input type="time" v-model="queSched.shift_start" min="00:00" max="23:59">
            <label>End Time</label>
            <input type="time" v-model="queSched.shift_end" min="00:00" max="23:59">
            <div class="wide">Max Employees <input type="number" class="maxEmpInput" v-model="queSched.max_employees" min="1"></div>
            
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

            <label>Branch</label>
            <div id="branch_select_con" class="full">
                <input id="branch_select_input" v-model="searchBranch" placeholder="Search in branches">
                <ul>
                    <li v-for="b,i in filteredBranches" :key="i" @click="queSched.branch_id = b.id;searchBranch = b.name;this.selectedBranch = b.id;fetchEmps();">{{b.name}}</li>
                </ul>
            </div>
            <label>Roles</label>
            <div id="roles_select_con" class="full">
                <input id="roles_select_input" v-model="searchDesignations" placeholder="Search in roles">
                <ul>
                    <li v-for="d,i in filteredDesignations" :key="i" @click="searchDesignations = d.position;selectDesignation(d.id)">{{d.position}}</li>
                </ul>
            </div>
            <div class="roles_select_selected full" >
                <div class="roles_selected_item" v-for="qd,i in queSched.designations" :key="i">
                    {{objFromArr('designations',qd).position}}
                    <a href="javascript:;" @click="queSched.designations.splice(i,1)">&times;</a>
                </div>
            </div>
            <label>Description</label>
            <textarea v-model="queSched.description" class="full"></textarea>

            <label>Color</label>
            <div class="colors full">
                <button :class="{active: queSched.color == c}" v-for="c,i in colors" :key="i" @click="queSched.color = c" :style="'background:'+c"></button>
            </div>
        </div>
        <div class="setScheduleModalFooter">
            <button class="exitSetScheduleModal" @click="setSchedule">{{(updateSchedId == '') ? 'Add' : 'Edit'}} Schedule</button>
            <button class="deleteSchedule" v-if="updateSchedId != ''" @click="deleteSchedule(queSched.id)">Delete Schedule</button>
        </div>
        
    </div>
</div>
<div class="scheduler_ctrl">
    <div id="branchmode_select_con" class="full">
        <input v-model="searchBranch" placeholder="Branch" readonly>
        <ul>
            <li v-for="b,i in branches" :key="i" @click="selectedBranch = b.id;queSched.branch_id = b.id;searchBranch = b.name;this.fetchEmps();buildCalendar();">{{b.name}}</li>
        </ul>
    </div>
    
    <button class="calendarCtrlBtns" @click="next(-12)" v-if="viewMode == 'Month View'">Prev Year</button>
    <button class="calendarCtrlBtns" @click="next(-1)">Prev Month</button>
    <button class="calendarCtrlBtns" @click="nextDay(-7)" v-if="viewMode == 'Week View'">Prev Week</button>
    <label for="gotoDate" class="calendarLabel">
        {{new Date(currentCalendar.y,currentCalendar.m,currentCalendar.d).toLocaleString('default', { month: 'long',year:'numeric' })}}
        <small>Click to jump to date</small>
        <input type="date" id="gotoDate" @change="jumpToDate" style="opacity:0;width:0;height:0;display:block">
    </label>
    <button class="calendarCtrlBtns" @click="nextDay(7);" v-if="viewMode == 'Week View'">Next Week</button>
    <button class="calendarCtrlBtns" @click="next(1)">Next Month</button>
    <button class="calendarCtrlBtns" @click="next(12)" v-if="viewMode == 'Month View'">Next Year</button>
    <div id="viewmode_select_con" class="full">
        <input v-model="viewMode" readonly>
        <ul>
            <li @click="viewMode = 'Month View';buildCalendar();">Month View</li>
            <li @click="viewMode = 'Week View';buildCalendar();">Week View</li>
        </ul>
    </div>
    <button class="calendarCtrlBtns" @click="saveChanges">Save Changes</button>
</div>
<div class="scheduler_view">
    <div class="scheduler_item title">Sun</div>
    <div class="scheduler_item title">Mon</div>
    <div class="scheduler_item title">Tue</div>
    <div class="scheduler_item title">Wed</div>
    <div class="scheduler_item title">Thu</div>
    <div class="scheduler_item title">Fri</div>
    <div class="scheduler_item title">Sat</div>

    <div class="scheduler_item" :class="{blank: c.dateNum == null,active:c.dateNum==currentCalendar.d,today:c.today===true}" v-for="c in calendarBox" :key="c" @click="e=>(c.onclick() != null) ? c.onclick() : false" :data-dateString="c.dateString" @dragenter.prevent @dragover.prevent @drop="dropSched">
        <span class="dateNum" v-if="c.dateNum != null">{{c.dateNum}}</span>
        <div class="scheduler_item_actions"  v-if="c.dateNum != null && c.dateNum==currentCalendar.d">
            <img class="icon" @click="showSetSchedModal = true;resetQueSched();queSched.shift_date_end = queSched.shift_date = formatDateString(currentCalendar.y+'-'+(currentCalendar.m+1)+'-'+currentCalendar.d).replaceAll(' ','');" title="Add Schedule" src="../../assets/add-icon.svg"/>
        </div>       
        <div class="dayScheds" draggable="true" v-for="ds,i in c.dayScheds" :key="i" :data-schedule="stringify(ds)" @click="showSetSchedModal = true;updateSchedId = ds.id;queSched=stringifyAndParse(ds)" @dragstart="dragSched($event,ds)">
            <h4>{{ds.title}}</h4>
            <p>{{dateFormat('%h:%i%a',ds.shift_date+' '+ds.shift_start)}} to {{dateFormat('%h:%i%a',ds.shift_date+' '+ds.shift_end)}}</p>
            <div class="color" :style="'background:'+ds.color"></div>
        </div>
    {{c.text}}</div>
</div>
<div class="employee_view" v-if="viewMode == 'Week View'">
    <div class="employee_item">
        <div class="employee_scheduler_item">
            Employee
        </div>
        <div class="employee_scheduler_item" v-for="c in calendarBox" :key="c">{{daysOfWeek[new Date(c.dateString).getDay()]}} - {{c.dateNum}}</div>
    </div>
    <div class="employee_item" v-for="e,i in employees" :key="i">
        <div class="employee_scheduler_item">
            <h4>{{e.firstname}} {{e.lastname}} <small>{{e.position}}</small></h4>
        </div>
        <div class="employee_scheduler_item" v-for="c in calendarBox" :key="c" :data-employee="i" @dragenter.prevent @dragover.prevent @drop="dropSchedToEmp($event,e.id)">
            <div class="dayScheds" draggable="true" v-for="ds,i in filteredDayScheds(c.dayScheds,i)" :key="i" :data-schedule="stringify(ds)" @dragstart="dragSched($event,ds)">
            <h4>{{ds.title}}</h4>
            <p>{{dateFormat('%h:%i%a',ds.shift_date+' '+ds.shift_start)}} to {{dateFormat('%h:%i%a',ds.shift_date+' '+ds.shift_end)}}</p>
            <a href="javascript:;" @click="removeSchedFromEmp(ds.id,e.id)">Remove (x)</a>
            <div class="color" :style="'background:'+ds.color"></div>
        </div>
        </div>
    </div>
    
</div>
</template>

<style scoped>
*{font-family: sans-serif;}
h3,p{margin: 0;}

.scheduler_view{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
    border:1px solid #ccc;
    border-bottom: none;
}

.scheduler_item{
    border-right:1px solid #ccc;
    border-bottom:1px solid #ccc;
    min-height: 100px;
    position: relative;
    padding-bottom: 40px;
}

.scheduler_item:nth-child(7n){border-right:none}

.dateNum{
    padding: 5px;
    display: inline-block;
    border-radius: 0 0 50% 0;
    box-shadow: inset -1px -1px 4px #aaa;
    width: 30px;
    text-align: center;
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
}

.scheduler_item .icon{
    width: 30px;
    display: block;
    opacity: 0.6;
    transition: 0.4s;
}

.scheduler_item .icon:hover{
    opacity: 0.8;
}

.scheduler_ctrl{
    padding: 20px;
    border:1px solid #ccc;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 10px;
}
.calendarCtrlBtns{
    background: #2095db;
    color:#fff;
    border:none;
    padding:10px;
    margin: 5px;
    border-radius: 10px;
}
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

.dayScheds{
    padding: 5px 5px 0;
    border: 1px solid #ccc;
    text-align: center;
    margin:5px 0;
}
.dayScheds h4,.dayScheds p{margin: 0;}
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
.setScheduleModalInputs input:first-of-type{
    grid-column: 2/5;
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

.employee_view{
    margin-top:20px;
    border:1px solid #ccc;
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
    align-items: center;
    font-weight: 600;
    line-height: 25px;
}

.employee_item:not(:first-child) .employee_scheduler_item:not(:first-child){
    padding: 0;
}

.employee_scheduler_item .dayScheds a{
    font-size: 14px;
    text-decoration: none;
    margin: 10px 0;
    display: block;
    color: #777;
}

.employee_scheduler_item h4 small{
    color: #fff;
    background: #2095db;
    padding: 3px;
    border-radius: 20px;
    margin: 3px;
}


</style>

