<template>
    <div class="scheduler-calendar-parent">
        <ScheduleSetForm
            :modalCloseProp="modalClose"
            :schedule="queSchedule"
            @close="e=>{modalClose=e;resetQueSchedule()}"
            @onCreate="e=>createSchedule(e)"
            @onUpdate="e=>updateSchedule(e)"
            @onDelete="e=>deleteSchedule(e)"
        />
        <StyledAlert
            :header="styledAlert.header"
            :body="styledAlert.body"
            :buttons="styledAlert.buttons"
            :type="styledAlert.type"
            :duration="styledAlert.duration"
            :show="styledAlert.show"
            @dismiss="styledAlert.show=false"
        />


        <div class="scheduler-calendar-topcontrols">
            <div class="scheduler-calendar-controls">
                <button v-if="viewMode == 0" @click="nextMonths(-1)">&laquo;</button>
                <button v-if="viewMode == 1" @click="nextDays(-7)">&laquo;</button>
                <h4 class="title">{{ title }}</h4>
                <button v-if="viewMode == 1" @click="nextDays(7)">&raquo;</button>
                <button v-if="viewMode == 0" @click="nextMonths(1)">&raquo;</button>
               
            </div>
            <div><button class="viewselect" :class="{active:viewMode == 0}" @click="viewMode = 0;buildCalendar()">Month View</button>
                <button class="viewselect" :class="{active:viewMode == 1}" @click="viewMode = 1;buildCalendar()">Week View</button></div>
        </div>
        
        <div class="scheduler-calendar-days" :class="{calendarWeekView: viewMode == 1}">
            <div v-if="viewMode == 1" class="scheduler-calendar-item title openschedule">
                <strong>Open Schedules</strong>
                <p class="instrux">Click and hold schedule to drag, then release mouse to drop schedule to a date or assign it to an employee</p>
            </div>

            <div class="scheduler-calendar-item title">SUN</div>
            <div class="scheduler-calendar-item title">MON</div>
            <div class="scheduler-calendar-item title">TUE</div>
            <div class="scheduler-calendar-item title">WED</div>
            <div class="scheduler-calendar-item title">THU</div>
            <div class="scheduler-calendar-item title">FRI</div>
            <div class="scheduler-calendar-item title">SAT</div>

            

            <div class="scheduler-calendar-item" :class="{isNotCurrentMonth:!cb.isCurrentMonth && viewMode == 0,active: new Date(cb.date + ' 00:00:00').getTime() == new Date(qd.y,qd.m,qd.d).getTime()}" v-for="cb,i in calendarBoxes" :key="i" @click="cb.onclick(cb.date,$event)" @dragenter.prevent @dragover.prevent="$event.target.closest('.scheduler-calendar-item').classList.add('dragovered')" @dragleave.prevent="$event.target.closest('.scheduler-calendar-item').classList.remove('dragovered')" @drop="$event.target.closest('.scheduler-calendar-item').classList.remove('dragovered');dropSched(cb.date,$event)" @dblclick="">
                <p class="datenum"><span>{{cb.dateNum}}</span> <span class="calendar-date-tooltip" @click="addSchedule(cb.date)">Add Schedule</span></p>
                <div class="dayschedule-cont">
                    <div class="dayschedule" v-for="ds,i in cb.scheds" :key="i" :style="{'border-left': '5px solid '+designations[ds.designation].color}" draggable="true" @dragstart="dragSched(ds,$event)" @click="editSchedule(ds)">
                        <h5 ><span class="dayschedule-color" :style="{'background-color': designations[ds.designation].color}"></span>{{ designations[ds.designation].name }}</h5>
                        <p>{{ dateFormat('%h:%M%a',ds.shift_date + ' '+ds.shift_start) }} - 
                            {{ dateFormat('%h:%M%a',ds.shift_date + ' '+ds.shift_end) }}</p>
                        <p>Slots remaining: {{ ds.slots - ds.assignedEmps.length }}/{{ ds.slots }}</p>
                    </div>
                </div>
                
            </div>
        </div>


        <div class="scheduler-calendar-employees-controls" v-if="viewMode == 1">
            <div>
                <p>Facility</p>
                <CustomFieldVue
                type="select"
                name="scheduler-calendar-employees-branches"
                :values="[
                    {label:'All Facilities',value:0},
                    {label:'Keppel Hub',value:0},
                    {label:'Argao Hub',value:1},
                    {label:'Plaridel Hub',value:2},
                    {label:'Bogo Hub',value:3}
                ]"
                />
            </div>
            <div>
                <p>Designation</p>
                <CustomFieldVue
                type="select"
                name="scheduler-calendar-employees-designations"
                :values="[
                    {label: 'IT Support',value:0},
                    {label: 'RNA',value:1},
                    {label: 'CNA',value:2},
                    {label: 'LPA',value:3}
                ]"
                />
            </div>
            
        </div>

        <div class="scheduler-calendar-employees" v-if="viewMode == 1">
            <div class="scheduler-calendar-item title">Employee</div>
            <div class="scheduler-calendar-item title">SUN</div>
            <div class="scheduler-calendar-item title">MON</div>
            <div class="scheduler-calendar-item title">TUE</div>
            <div class="scheduler-calendar-item title">WED</div>
            <div class="scheduler-calendar-item title">THU</div>
            <div class="scheduler-calendar-item title">FRI</div>
            <div class="scheduler-calendar-item title">SAT</div>
        </div>


        <div v-if="!refreshEmployeeList">
            <div class="scheduler-calendar-employees" v-show="viewMode == 1" v-for="emp,i in employees" :key="i">
            <div class="scheduler-calendar-item title openschedule">
                <p>
                    <strong>{{ emp.employee_firstname }} {{ emp.employee_lastname }}</strong>
                    
                </p>
                <p><span class="dayschedule-color" :style="{'background-color': designations[emp.role_id].color}"></span>{{ designations[emp.role_id].name }} </p>
                    
            </div>

            <div class="scheduler-calendar-item" :class="{isNotCurrentMonth:!cb.isCurrentMonth && viewMode == 0,active: new Date(cb.date + ' 00:00:00').getTime() == new Date(qd.y,qd.m,qd.d).getTime()}" v-for="cb,i in calendarBoxes" :key="i" @dragenter.prevent @dragover.prevent="" @dragleave.prevent="" @drop="assignSchedule($event,emp.employee_id)">
                <p class="datenum" style="background:transparent;border: none;"><span>{{cb.dateNum}}</span></p>
                <div class="dayschedule-cont">
                    <div class="dayschedule" v-for="ds,i in fetchEmployeeSchedules(emp.employee_id,cb.date)" :key="i" :style="{'border-left': '5px solid '+designations[ds.designation].color}" draggable="true" @dragstart="dragSched(ds,$event)" >
                        <h5><span class="dayschedule-color" :style="{'background-color': designations[ds.designation].color}"></span>{{ designations[ds.designation].name }}</h5>
                        <p>{{ dateFormat('%h:%M%a',ds.shift_date + ' '+ds.shift_start) }} - 
                            {{ dateFormat('%h:%M%a',ds.shift_date + ' '+ds.shift_end) }}</p>
                        <a href="javascript:;" class="removeAssign" @click="removeEmployeeFromSchedule(ds.id,emp.employee_id)">Remove</a>
                    </div>
                </div>
                
            </div>
        </div>
        </div>

        


    </div>
</template>

<script>
import {dateFormat} from './scheduler.utils'
import CustomFieldVue from './CustomField.vue';
import ScheduleSetForm from './ScheduleSetForm.vue';
import StyledAlert from './StyledAlert.vue';

export default{
    components:{ScheduleSetForm,CustomFieldVue,StyledAlert},
    data(){
        return{
            cc:{y:0,m:0,d:0},
            qd:{y:0,m:0,d:0},
            calendarBoxes:[],
            title:'',
            modalClose:true,
            refreshEmployeeList:false,
            branches:{
                0: 'Keppel Hub',
                1: 'Argao Hub',
                2: 'Plaridel Hub',
                3: 'Bogo Hub'
            },
            styledAlert:{
                header:'Scheduler Error',
                body:'asdsad',
                buttons:[],
                type:'neutral',
                duration:2000,
                show:false
            },
            viewMode:1,
            queSchedule:{
                id:'',
                shift_date: '',
                shift_start:'',
                shift_end:'',
                description:'',
                branch_id:0, // note: replace with selected branch
                designation: 2,
                slots:0
            },
            designations:{
                0: {name: 'IT Support',color:'#6c9e79'},
                1: {name: 'RNA',color:'#d6e65e'},
                2: {name: 'CNA',color:'#d45d48'},
                3: {name: 'LPA',color:'#6821c4'}
            },
            employees:{
                0:{
                    employee_firstname: 'Kim',
                    employee_lastname: 'Baring',
                    employee_id: 0,
                    role_id:0,
                },
                1:{
                    employee_firstname: 'Ceejay',
                    employee_lastname: 'Abellanosa',
                    employee_id: 1,
                    role_id:1,
                }
            },
            schedules:{
                'vasdaasasd': {
                    id:'vasdaasasd',
                    shift_date: '2023-03-01',
                    shift_start:'05:00',
                    shift_end:'14:00',
                    description:'',
                    branch_id:0,
                    designation: 2,
                    assignedEmps:[
                        {employee_id:0}
                    ],
                    slots:2
                },
                'vasdaas': {
                    id:'vasdaas',
                    shift_date: '2023-03-02',
                    shift_date_end: '',
                    shift_start:'07:00',
                    shift_end:'13:00',
                    repeatDays:[],
                    description:'',
                    branch_id:0,
                    designation: 1,
                    assignedEmps:[],
                    slots:2
                }
            },
        }
    },
    mounted(){
        let date = new Date();
        this.cc.y = date.getFullYear();
        this.cc.m = date.getMonth();
        this.cc.d = date.getDate();
        this.qd.y = date.getFullYear();
        this.qd.m = date.getMonth();
        this.qd.d = date.getDate();
        this.buildCalendar();
    },
    watch:{

    },
    methods:{
        dateFormat,
        alert(header,body,type){
            this.styledAlert.header = header;
            this.styledAlert.body = body;
            this.styledAlert.type = type;
            this.styledAlert.show = true;
        },
        fetchEmployeeSchedules(userid,dateString){
            let daySchedules = this.fetchScheds(dateString);
            let hitSchedules = daySchedules.filter(el=>{
                el.assignedEmps.filter(el=>{
                    return el.employee_id == userid
                })
                return el.assignedEmps.filter(el=>el.employee_id == userid).length > 0
            });
            
            return hitSchedules;
        },
        assignSchedule(e,userid){
            let schedData = e.dataTransfer.getData('schedData')
            if(schedData == '') return;
            schedData = JSON.parse(schedData);
           
            if(this.schedules[schedData.id].assignedEmps.filter(el=>el.employee_id == userid).length > 0)
                return;

            if(schedData.assignedEmps.length >= schedData.slots){
                this.alert('Schedule full','All the slots in this schedule are taken','danger');
                return;
            }
                
            this.schedules[schedData.id].assignedEmps.push({employee_id:userid})
            this.buildCalendar();
        },
        removeEmployeeFromSchedule(scheduleid,userid){
            this.schedules[scheduleid].assignedEmps.splice(this.schedules[scheduleid].assignedEmps.findIndex(el=>el.employee_id==userid),1);
            this.buildCalendar();
        },
        createSchedule(e){
            let loopDate = new Date(e.shift_date);
            let endDate = new Date(e.shift_date_end);
            let iteration = 0;
            let midId = Date.now().toString(32);
            while(loopDate.getTime() <= endDate.getTime()){
                if(iteration == 0 || e.repeatDays.includes(loopDate.getDay())){
                    let newSched = {};
                    Object.keys(this.queSchedule).forEach(qs=>newSched[qs] = e[qs])

                    newSched.id = 
                    (1000).toString(32)+'-'+ //note: replace with user id of user adding the scheduke
                    midId+'-'+
                    iteration;
                    newSched.assignedEmps = [];

                    newSched.shift_date = dateFormat('%y-%m2-%D',loopDate.getTime());

                    this.schedules[newSched.id] = newSched;
                    iteration++;

                }

                loopDate.setDate(loopDate.getDate() + 1);
            }
            
            this.modalClose = true;
            this.buildCalendar();

        },
        updateSchedule(e){
            let newSched = {};
            Object.keys(this.queSchedule).forEach(qs=>newSched[qs] = e[qs])

            if(this.schedules[e.id].assignedEmps.length > e.slots){
                this.alert('Exceeding Number','The number of assigned employees exceeded the number of slots specified','danger');
                return;
            }
            
            for(let ns in newSched) this.schedules[e.id][ns] = newSched[ns];

            this.modalClose = true;
            this.buildCalendar();
        },
        deleteSchedule(e){
            delete this.schedules[e];
            this.modalClose = true;
            this.buildCalendar();
        },
        resetQueSchedule(){
            this.queSchedule = {
                id:'',
                shift_date: '',
                shift_start:'',
                shift_end:'',
                description:'',
                branch_id:0, // note: replace with selected branch
                designation: 2,
                slots:0
            }
        },
        addSchedule(date){
            this.queSchedule.shift_date = date;
            this.modalClose=false;
        },
        editSchedule(schedule){
            Object.keys(this.queSchedule).forEach(qd=>{
                this.queSchedule[qd] = schedule[qd];
            });

            this.modalClose=false;
        },
        fetchScheds(dateString){
            let hitScheds = [];
            for(let ds in this.schedules){
                let el = JSON.parse(JSON.stringify(this.schedules[ds]));
                if(el.shift_date != dateString) continue;
                hitScheds.push(el);
            }
            hitScheds.sort((a,b)=>{
                return new Date(dateString+' '+a.shift_start).getTime() - new Date(dateString+' '+b.shift_start).getTime()
            })
            return hitScheds;
        },
        dragSched(ds,e){
            try{e.dataTransfer.setData('schedData',JSON.stringify(ds));}catch(err){return;}
        },
        dropSched(date,e){
            if(e.dataTransfer.getData('schedData') == '') return;
            let ds = JSON.parse(e.dataTransfer.getData('schedData'));
            this.schedules[ds.id].shift_date = date;
            this.buildCalendar()
        },
        buildCalendar(){
            if(this.viewMode == 1){
                let weekOffset = new Date(this.qd.y,this.qd.m,this.qd.d).getDay();
                let startWeek = new Date(this.qd.y,this.qd.m,this.qd.d);
                startWeek.setDate(startWeek.getDate() - weekOffset);
                let endWeek = new Date(this.qd.y,this.qd.m,this.qd.d);
                endWeek.setDate(endWeek.getDate() + (6 - weekOffset));
                let startWeekString = startWeek.toLocaleDateString();
                let endWeekString = endWeek.toLocaleDateString();

                this.calendarBoxes = [];

                while(startWeek.getTime() <= endWeek.getTime()){
                    let dateString = dateFormat('%y-%m2-%D',startWeek.getTime());
                    let newDateBox = {
                        date: dateString,
                        dateNum: startWeek.getDate(),
                        isCurrentMonth: startWeek.getMonth() == this.cc.m,
                        scheds:this.fetchScheds(dateString),
                        onclick:(dateString,e)=>{
                            let date = new Date(dateString);
                            this.qd.y = date.getFullYear();
                            this.qd.m = date.getMonth();
                            this.qd.d = date.getDate();
                        }
                    }
                    this.calendarBoxes.push(newDateBox);
                    startWeek.setDate(startWeek.getDate() + 1);
                }
                
                this.title = dateFormat('%sm %d, %y',startWeekString) + ' - ' + dateFormat('%sm %d, %y',endWeekString) ;

                return;
            }

            
            let startMonth = new Date(this.cc.y,this.cc.m,1);
            let endMonth = new Date(this.cc.y,this.cc.m+1,0);
            let offsetStart = new Date(this.cc.y,this.cc.m,1).getDay();
            let offsetEnd = new Date(this.cc.y,this.cc.m+1,0).getDay();
            startMonth.setDate(startMonth.getDate() - offsetStart);
            endMonth.setDate(endMonth.getDate() + (6 - offsetEnd));
            this.calendarBoxes = [];

            while(startMonth.getTime() <= endMonth.getTime()){
                let dateString = dateFormat('%y-%m2-%D',startMonth.getTime());
                let newDateBox = {
                    date: dateString,
                    dateNum: startMonth.getDate(),
                    isCurrentMonth: startMonth.getMonth() == this.cc.m,
                    scheds:this.fetchScheds(dateString),
                    onclick:(dateString,e)=>{
                        let date = new Date(dateString);
                        this.qd.y = date.getFullYear();
                        this.qd.m = date.getMonth();
                        this.qd.d = date.getDate();
                    }
                }
                this.calendarBoxes.push(newDateBox);
                startMonth.setDate(startMonth.getDate() + 1);
            }

            this.title = dateFormat('%lm %y',new Date(this.cc.y,this.cc.m,this.cc.d).getTime());
        },
        nextMonths(num){
            let date = new Date(this.cc.y,this.cc.m,this.cc.d);
            date.setMonth(date.getMonth() + num);
            this.cc.y = date.getFullYear();
            this.cc.m = date.getMonth();
            this.cc.d = date.getDate();
            this.qd.y = date.getFullYear();
            this.qd.m = date.getMonth();
            this.qd.d = date.getDate();
            this.buildCalendar();
        },
        nextDays(num){
            let date = new Date(this.cc.y,this.cc.m,this.cc.d);
            date.setDate(date.getDate() + num);
            this.cc.y = date.getFullYear();
            this.cc.m = date.getMonth();
            this.cc.d = date.getDate();
            this.qd.y = date.getFullYear();
            this.qd.m = date.getMonth();
            this.qd.d = date.getDate();
            this.buildCalendar();
        }
    }
}
</script>

<style scoped>
.scheduler-calendar-controls{display: flex; align-items: center;padding: 10px;}
.scheduler-calendar-controls button{margin:0 5px}
.scheduler-calendar-controls .title{text-align: center;width: 100%;max-width: 400px;border:1px solid #333;height: 34px;line-height: 34px;border-radius: 5px;font-size: 17px;}

.scheduler-calendar-topcontrols{display: grid;grid-template-columns: 1fr 1fr;align-items: center;}
.scheduler-calendar-days{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
    border-top:1px solid #ddd;
    border-left:1px solid #ddd;
    gap:7px
}

.scheduler-calendar-days.calendarWeekView{
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
}

.scheduler-calendar-employees-controls{
    margin-top: 20px;
    padding:10px;
    border-bottom:1px solid #ddd;
    display: flex;
    gap:20px;
    align-items: center;
}

.scheduler-calendar-employees-controls > div{
    display:grid;
    grid-template-columns: 1fr 2fr;
    gap:5px;
    align-items: center;
}


.scheduler-calendar-employees{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
    grid-template-rows: 1fr;
    gap:7px;
}
.scheduler-calendar-item.title.openschedule{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 10px;
    grid-row: 1/3;
}
.scheduler-calendar-employees .scheduler-calendar-item.title.openschedule.openschedule{
    grid-row: 1/2;
}

.scheduler-calendar-item.title.openschedule p.instrux{font-size: 12px;}

button.viewselect{
    border:1px solid #434343;
    background: #fff;
    border-radius: 0;
    color:#434343;
    margin:0 2px
}
/* button.viewselect:first-of-type{border-left:1px solid #434343;} */
button.viewselect.active{background:#434343;color:#fff;}

button{all:unset;padding: 10px;background:#434343;color:#fff;border-radius: 5px;transition: 0.2s;font-size: 14px;line-height: 14px;}
button:hover{scale:1.05}
button:active{scale:0.95}
.scheduler-calendar-item{border-bottom:1px solid #ddd;transition:0.2s;border-radius: 0 0 5px 0;}
.scheduler-calendar-item.title{padding: 5px;text-align: center;}
.scheduler-calendar-item .datenum{margin:0;width: 30px;height:30px;text-align: center;line-height: 30px;border-right:1px solid #ddd;border-bottom:1px solid #ddd;margin-bottom: 10px;transition:0.2s;display: flex;align-items: center;overflow: hidden;}

.scheduler-calendar-item .datenum span:first-child{width: 30px;}
.calendar-date-tooltip{width:0;overflow: hidden;padding: 0px;white-space: nowrap;text-align: center;flex-grow: 1;background: #85cbf4;color: #222;transition:0.2s}

.calendar-date-tooltip:hover{background: #007dc6;color: #fff;}
.calendar-date-tooltip:active{background: #005a8e;color: #fff;}

.calendar-date-tooltip{}
.scheduler-calendar-item.active .calendar-date-tooltip{width:max-content;padding: 5px;}
.scheduler-calendar-item.active{background:rgba(186, 229, 255, 0.263);}
.scheduler-calendar-item.active .datenum{width: 100%;background: #ffffff;border-bottom:1px solid #1b98e3;}
.scheduler-calendar-item.active .datenum span:first-child{background: #1b98e3;color:#fff;}
.scheduler-calendar-item.isNotCurrentMonth:not(.active){background: #eee;}
.scheduler-calendar-item{border-right: 1px solid #ddd;}
.dayschedule-cont{min-height: 70px;padding: 3px;}
.dragovered .dayschedule-cont{box-shadow: inset 0 0 10px #aaa}
.dayschedule{background:#fff;text-align: center;padding: 5px;border:1px solid #ddd;border-radius:5px;margin:0 5px 5px 5px;transition:0.2s}

.dayschedule *{pointer-events: none;}
.dayschedule h3{}

.scheduler-calendar-days .dayschedule:hover{scale: 1.05;box-shadow: 0 0px 10px #aaa;}

.dayschedule-color{border:1px solid #ddd;display: inline-block;width:10px;height:10px;margin:0 5px;vertical-align: middle;border-radius: 50%;margin-bottom: 2px;}
.dayschedule p{font-size: 14px;}
.removeAssign{
    all: unset;
    font-size: 14px;
    margin: 5px 0;
    display: block;
    color: #593434;
}
</style>
