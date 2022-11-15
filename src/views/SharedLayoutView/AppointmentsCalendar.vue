<template>
    <div class="breadcrumb-wrapper breadcrumb-contacts">
        <h2>Job Schedule</h2>
        <div class="option">
            <button class="btn btn-primary" @click="view = !view;timeViewPanel = !timeViewPanel;buildCalendar()">{{(view) ? 'Create' : 'Assign'}} Schedule </button> 
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header card-header-border-bottom d-flex justify-content-between card-design head">
            <h3>{{currentCalendar.monthString}} of {{currentCalendar.year}}</h3>
            <div class="option">
                <button class="btn btn-primary hide"  @click="view = !view;">{{(view) ? 'Employee' : 'Month'}} View</button> 
                <button class="btn btn-success" @click="saveChanges">{{(actions > 0) ? 'Save' : 'Saved'}}</button>
            </div>
        </div>
        <div class="card-body">
            <div class="calendarComp">
                <div id="calendar" >
                    <div v-if="view==0">
                        <div class="calendarCtrl">
                            <button class="mb-1 btn btn-info" @click="prevYear">&laquo;</button>
                            <button class="mb-1 btn btn-info" @click="prevMonth">&#10094;</button>
                            <button class="mb-1 btn btn-info" @click="nextMonth">&#10095;</button>
                            <button class="mb-1 btn btn-info" @click="nextYear">&raquo;</button>
                            <input class="form-control" type="date" v-model="queryDate.rcvrString">
                            <button class="mb-1 btn btn-info" @click="gotoDate">Go</button>
                        </div>
                        
                            
                    
                        <div class="calendarView">
                            <div class="calendarWeekHeads" v-for="c in currentCalendar.weekString" :key="c">{{c}}</div>
                            <div class="calendarDays"  :key="c" :id="c.dateId" :class="c.type" v-for="c in currentCalendar.viewArray" :data-dispkey="c.dateNum" @click="selectDay($event,c.dateNum)" @dragenter.prevent="dragEnter" @dragover.prevent @dragleave="dragLeave" @drop="drop" :data-datestring="c.dateString">
                                {{c.dateNum}}
                                <div class="dayMark" v-for="(d) in c.dayMark" :key="d" :draggable="d.refMarker == null" :data-daymark="stringify(d)" @dragstart="dragStart" :style="'background:'+d.color" @click="selectDayMark(d)" :class="{selectedMark: (d.index == this.newMarkDetails.index)}">
                                    <strong>{{d.time_start}} {{d.title}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="employeeWeekView" v-if="view==1">
                        
                        <h2><small>({{dateFormat('%lm %d, %y',computeDays(1)[2]+'00:00:00')}} to {{dateFormat('%lm %d, %y',computeDays(7)[2]+'00:00:00')}})</small></h2>
                        <div class="but">
                            <button class="mb-1 btn btn-info" @click="weekStartChange(7,'dec')">&laquo; -1 Week</button>
                            <button class="mb-1 btn btn-info" @click="weekStartChange(1,'dec')">&#10094; -1 Day</button>
                            <input class="form-control" type="date" v-model="queryDate.rcvrString">
                            <button class="mb-1 btn btn-info" @click="weekStartChange(1,'inc')">&#10095; +1 Day</button>
                            <button class="mb-1 btn btn-info" @click="weekStartChange(7,'inc')">&raquo; +1 Week</button>
                        </div>
                        <h3>Open Schedules</h3>
                        <div class="weekgrid1">
                            <div v-for="i in 7" :key="i" class="topBoxes2">{{weekViewLabel(computeDays(i)[2])}} <span>{{computeDays(i)[0]}}</span></div>
                                <div class="schedBox dateBox" v-for="i in 7" :key="i" :id="'date-'+computeDays(i)[1]" @dragenter.prevent="dragEnter" @dragover.prevent @dragleave="dragLeave" @drop="drop" :data-datestring="computeDays(i)[2]" @click="selectDate($event,'date-'+computeDays(i)[2])">
                                <div class="dayMark" v-for="(d) in dayMarks['date-'+computeDays(i)[1]]" :key="d" draggable="true" :data-daymark="stringify(d)" @dragstart="dragStart" :style="'background:'+d.color+';width:'+(topBoxes2 - 40)+'px'"
                                    @click="selectDayMark(d)" :class="{selectedMark: (d == this.selectedDayMark)}" v-show="isOpenSchedule(d)">
                                    <strong>{{d.time_start}} {{d.title}}</strong>
                                    <em>{{d.index}}</em>
                                    <p>From {{d.time_start}}</p>
                                    <p>To {{d.time_end}}</p>
                                    <p>Employees: {{objectKeys(d.employees).length}}/{{d.max_emp}}</p>

                                </div>
                            </div>
                        </div>
                        <div class="weekgrid1">
                            
                        </div>

                        <h3>Employee Schedules</h3>
                        <div class="weekgrid2">
                            <div><strong>Employee</strong></div>
                            <div v-for="i in 7" :key="i" class="topBoxes">{{weekViewLabel(computeDays(i)[2])}} <span>{{computeDays(i)[0]}}</span></div>
                        </div>
                        <div class="weekgrid2 employeegrid" v-for="emp in empScheds" :key="emp">
                            <div><strong>{{emp.name}}</strong></div>
                            <div class="schedBox empSchedBox" v-for="i in 7" :key="i" :data-day="'date-'+computeDays(i)[1]" :data-dateString="computeDays(i)[2].replaceAll(' ','')" :data-for="emp.id" @dragenter.prevent="dragEnter" @dragover.prevent @dragleave="dragLeave" @drop="dropSched">

                                <div class="dayMark" v-for="(d) in empSchedList('date-'+computeDays(i)[1],emp.id)" :key="d" :data-daymark="stringify(d)" :style="'background:'+d.color+';width:'+(this.topBoxes - 45)+'px'" @click="deleteThis(d.index,emp.id)">
                                    <strong>{{d.title}}</strong>
                                    <p>From {{d.time_start}}</p>
                                    <a href="javascript:;" @click="deleteThis(d.index,emp.id)">(x) Remove</a>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>

                <div class="modal" v-if="hasSelected" id="exampleModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle">
                    <div class="modal-dialog modal-lg" role="document">
		                <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{(selectedDayMark == null) ? 'Add':'Edit'}} Schedule</h5>
                                <button type="button" class="close" @click="newMarkDetails = {index:0};selectedDayMark=null;hasSelected = false;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- <div class="addMarker"> -->
                                    <div class="form-group">
                                        Date: <strong>{{queryDate.monthString}} {{queryDate.day}}, {{currentCalendar.year}}</strong> to <input class="form-control" id="end_date" type="date" v-model="newMarkDetails.end_date" />
                                    </div>
                                    <br />
                                    Time: From <input class="form-control" type="time" v-model="newMarkDetails.time_start"> to <input class="form-control" type="time"  v-model="newMarkDetails.time_end"><br/>
                                    Color: 
                                    <div class="color_selector_container">
                                    <ul class="color_selector_list">
                                        <li v-for="c in colors" :key="c" :style="'background:'+c+';border: 3px solid '+c" @click="newMarkDetails.color = c" :class="{selected:(newMarkDetails.color == c)}"></li>
                                    </ul></div>
                                    <input class="form-control" placeholder="Add Title" v-model="newMarkDetails.title">
                                    <textarea class="form-control" placeholder="Add Description" v-model="newMarkDetails.description"></textarea>

                                    <div class="branch_inputlist">
                                            <input class="form-control" placeholder="Branch" :value="branchName(newMarkDetails.branch)" readonly>
                                            <ul>
                                                <li @click="newMarkDetails.branch = ''"> - Select Branch - </li>
                                                <li v-for="b in branches" :key="b.id" :data-id="b.id" @click="newMarkDetails.branch = b.id">{{b.name}}</li>
                                            </ul>
                                        </div>
                                    <input class="form-control" type="number" placeholder="Max Employees" v-model="newMarkDetails.max_emp" @input="updateEmpSchedList">
                                    <div class="selected_emps">
                                        <div class="selected_emps_inputlist">
                                            <input class="form-control" placeholder="Assign Schedule to Employees" v-model="searchEmpBox">
                                            <ul id="selected_emps_datalist" v-if="searchEmpBox != ''">
                                                <li v-for="e in searchEmpResult" :key="e.id" :data-id="e.id" @click="selectEmpSched(e.id);searchEmpBox = ''">{{e.name}}</li>
                                            </ul>
                                        </div>
                                        
                                        <ul id="selected_emps_emplist">
                                            <li v-for="e,i in newMarkDetails.employees" :key="e" :data-id="e">{{e}}
                                                <a href="javascript:;" @click="delete deleteEmpSched(i)">&#10005;</a>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                <!-- </div> -->
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-info btn-pill" @click="newMarkDetails = {index:0};selectedDayMark=null;hasSelected = false;">Cancel</button>
                                <button class="btn btn-danger btn-pill" @click="deleteSched(this.newMarkDetails.index)" v-if="selectedDayMark!=null" >Delete Schedule</button>
                                <button class="btn btn-primary btn-pill" @click="addMarker">{{(selectedDayMark == null) ? 'Create':'Update'}} Schedule</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dayMarkPanel" v-if="timeViewPanel">
                        
                    <div>
                        <h3>Time View for {{queryDate.monthString}} {{queryDate.day}}, {{currentCalendar.year}}</h3>
                        <div class="timeView">
                            <div class="time" v-for="(index,i) in 24" :key="i" :id="'timemark-'+i">
                                <span>{{(i == 0) ? '12' :(i>12) ? (i-12):i}} {{(i==12) ? 'pm' : (i>12) ? 'pm' : 'am'}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                
                

            </div>
        </div>
    </div>
    
</template>

<script>
import {dateFormat, elementLoad, formatDateString, validateForm, axios} from '../../functions.js';

export default ({
    data(){
        return {
            view:0,
            currentCalendar:{
                year: undefined,
                month: undefined,
                monthString: undefined,
                date:undefined,
                weekString: ['Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                viewArray:[]
            },
            select:'',
            hasSelected:false,
            queryDate:{
                rcvrString:'',
                year: undefined,
                month: undefined,
                day: 1
            },
            weekStart:28,
            colors: ['#4054b2','#d30915','#1b9ce2','#3bb57a','#f2522c'],
            branches:[],

            dayMarks:{},
            empScheds:[
                {id:1,name: 'Kim'},
                {id:2,name: 'Ceejay'},
                {id:3,name: 'James'},
                {id:4,name: 'Marco'},
            ],
            actions:0,
            searchEmpBox:'',
            newMarkDetails:{employees:{}},
            deletedIndexes:[],
            topBoxes:0,       
            topBoxes2:0,     
            selectedDayMark:null,
            timeViewPanel: true
    
        }
    },
    methods:{
        console(e){
            console.log(e)
        },
        weekViewLabel(dateString){
            const d = new Date(dateString.replaceAll(' ',''));
            const days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
            return days[d.getDay()];
        },
        computeDays(i){
            
            let c = this.currentCalendar.date;
            let dateNum = new Date(c.year,c.month+1,0).getDate();
            let dateNum2 = new Date(c.year,c.month,0).getDate();
            if(((this.weekStart - 1) + i) > dateNum) {
                let newMonth = 0;
                let newYear = this.currentCalendar.year ;
                if(!((this.currentCalendar.month + 1) >= 12)) newMonth = this.currentCalendar.month + 1;
                if(!((this.currentCalendar.month + 1) >= 12)) newYear = this.currentCalendar.year + 1;
                c = new Date(newYear,newMonth + 1,((this.weekStart - 1)) + i - dateNum);
                
            }else if((this.weekStart - 1) + i < 1){
                let newMonth = this.currentCalendar.month - 1;
                let newYear = this.currentCalendar.year;
                if(!((this.currentCalendar.month - 1) < 0)) newMonth = 11;
                if(!((this.currentCalendar.month - 1) < 0)) newYear = this.currentCalendar.year - 1;
                c = new Date(newYear,newMonth,dateNum2 + (this.weekStart - 1) + i);
            }
            let days = ((this.weekStart + i) - 2) % (c.getDate());
            days++;
            let month = c.getMonth();
            let year = c.getFullYear();
            
            if((this.weekStart + i) - 1 > c.getDate()) month++;
            if(month >= 12) {month = 0;year++}
            let c2 = String(year)+String(month)+String(days);

            
            
            let dateString = formatDateString(String(year)+'-'+String(month+1)+'-'+String(days)).replaceAll(' ','');
            return [days,c2,formatDateString(dateString)]; 
            
        },
        buildCalendar(){

            if(document.querySelector(".selected") != null)
        			document.querySelector(".selected").classList.remove("selected");
            this.currentCalendar.viewArray = [];
            let c = this.currentCalendar;
            let d = new Date(c.year,c.month,1);
            let d2 = new Date(c.year,c.month + 1,0);
            let startDay = d.getDay();
            let maxloop = d2.getDate() + startDay + (7 - ((d2.getDate() + startDay)) % 7);
            if(((d2.getDate() + startDay)) % 7 == 0) maxloop = d2.getDate() + startDay;
            this.select='';
            this.currentCalendar.date = new Date(c.year,c.month + 1,0);
            	
            document.querySelectorAll('div[id^="time-"]').forEach(el=>{
                el.remove();
            });
            
            
            for(let i = 0,j=1; i < maxloop;i++){
                if(i >= startDay && i < d2.getDate() + startDay){
                    
                    
                    const d = new Date();
                    
                    let dnow = (String(d.getFullYear()) + String(d.getMonth()) + String(d.getDate()));
                    
                  if(
                    (String(c.year) + String(c.month) + String(j)) == dnow
                  ){
                    elementLoad('#date-'+dnow).then(el=>{
                       el.classList.add("today"); 
                    })
                    
                  	// document.getElementById(dnow).classList.add("today");
                  }
                    let dayMarks = [];
                  if(this.dayMarks['date-'+String(c.year) + String(c.month) + String(j)] != null){
                    dayMarks = this.dayMarks['date-'+String(c.year) + String(c.month) + String(j)] 
                  }

                  this.currentCalendar.viewArray.push({
                        dateId: 'date-'+String(c.year) + String(c.month) + String(j),
                        dateNum:j,
                        type: "dateBox",
                        dayMark:dayMarks,
                        dateString: `${String(c.year)}-${String(c.month+1)}-${String(j)}`
                    });
                    

                    j++;
                    
                }else this.currentCalendar.viewArray.push({
                    dateId: '',
                    dateNum: undefined,
                    type: "emptyBox"
                });
            }
            
            this.buildTimeView();
            
        },
        prevYear(){this.currentCalendar.year--;this.buildCalendar();},
        nextYear(){this.currentCalendar.year++;this.buildCalendar();},
        prevMonth(){
        	this.currentCalendar.month--;
            if(this.currentCalendar.month <= 0){
                this.currentCalendar.month = 11;
                this.currentCalendar.year--;
            }
          
            this.buildCalendar();
        },
        nextMonth(){
        	this.currentCalendar.month++;
            if(this.currentCalendar.month >= 12){
                this.currentCalendar.month = 0;
                this.currentCalendar.year++;
            }
            
            this.buildCalendar();
        },
        gotoDate(){
            this.currentCalendar.year = this.queryDate.year;
            this.currentCalendar.month = this.queryDate.month;

            this.buildCalendar();
            setTimeout(()=>{
                this.selectDay(this.queryDate.day);
            },100);
        },
        selectDay(e,dNum){
            this.hasSelected = true;          
            if(!e.target.classList.contains('dayMark')) {this.selectedDayMark = null;this.newMarkDetails = {index:0,employees:{}}}
        	if(document.querySelector(".selected") != null)
                document.querySelector(".selected").classList.remove("selected");
            this.queryDate.year = this.currentCalendar.year;
            this.queryDate.month = this.currentCalendar.month;
            this.queryDate.day = dNum;
            let dateId = 'date-'+this.queryDate.year+"" + this.queryDate.month + dNum;
            document.getElementById(dateId).classList.add("selected");
            this.select = dateId;
            const d = new Date(this.queryDate.year,this.queryDate.month,1);
            this.queryDate.monthString = d.toLocaleDateString('en-us',{
                    month: 'long'
            });
            this.buildTimeView();
        },
        selectDate(e,dateString){
            this.hasSelected = true;
            if(!e.target.classList.contains('dayMark')) {this.selectedDayMark = null;this.newMarkDetails = {index:0,employees:{}}}
        	if(document.querySelector(".selected") != null)
                document.querySelector(".selected").classList.remove("selected");
            let dateParse = new Date(dateString.match('[0-9]+-[0-9]+-[0-9]+')[0]);
            this.queryDate.year = dateParse.getFullYear();
            this.queryDate.month = dateParse.getMonth();
            this.queryDate.day = dateParse.getDate();
            let dateId = 'date-'+this.queryDate.year+"" + this.queryDate.month + dateParse.getDate();
            document.getElementById(dateId).classList.add("selected");
            this.select = dateId;
            const d = new Date(this.queryDate.year,this.queryDate.month,1);
            this.queryDate.monthString = d.toLocaleDateString('en-us',{
                    month: 'long'
            });
            this.buildTimeView();
        },
        addMarker(){
            if(this.selectedDayMark != null && this.selectedDayMark != '') {this.updateMarker(); return}
            let dateString = this.queryDate.year + '-' +
            (this.queryDate.month+1) + '-' +
            this.queryDate.day;

            let valid = validateForm(this.newMarkDetails,{
                title:"required",
                branch:"required",
                time_start:"required",
                time_end:"required",
                max_emp:{
                    isRequired: true,
                    greaterThan: 0
                },
                color:"required",
                callback(e){
                    if(e == 'max_emp') e = 'Max Employees';
                    if(e == 'time_start') e = 'Start Time';
                    if(e == 'time_end') e = 'End Time';
                    alert(e.charAt(0).toUpperCase() + e.substring(1) + ' field is empty!');
                }
            });
            
            if(!valid.allValid) return;

            if(this.newMarkDetails.end_date != null){
                let dateStart = new Date(formatDateString(dateString).replaceAll(' ',''));
                let dateEndDate = new Date(formatDateString(this.newMarkDetails.end_date).replaceAll(' ',''));
                
                if(dateStart > dateEndDate){            
                    alert('Start date should be earlier than the end date!');
                    return;
                }
            }
                
            let dateStart = new Date(formatDateString(dateString)+this.newMarkDetails.time_start);
            let dateEndDate = new Date(formatDateString(dateString)+this.newMarkDetails.time_end);
                
            if(dateStart > dateEndDate){            
                alert('Start time should be earlier than the end time!');
                return;
            }

            //end of validation

            this.newMarkDetails.dateId = 'date-'+this.queryDate.year+"" + this.queryDate.month + this.queryDate.day;
            this.newMarkDetails.start_date = dateString;
            if(this.newMarkDetails.end_date != null) this.newMarkDetails.end_date = formatDateString(this.newMarkDetails.end_date).replaceAll(' ','');
            else{
                let date = new Date(this.newMarkDetails.end_date);
                
                this.newMarkDetails.end_date = formatDateString(date.getFullYear() + '-' +
                (date.getMonth()+1) + '-' +
                date.getDate()).replaceAll(' ','');
            }
            
            this.newMarkDetails.dateString = formatDateString(dateString).replaceAll(' ','');
            if(this.dayMarks[this.newMarkDetails.dateId ] == null) this.dayMarks[this.newMarkDetails.dateId  ] = new Array();

            let conflicts = 0;
            let y = this.newMarkDetails;
            this.dayMarks[this.newMarkDetails.dateId].forEach(x=>{
                let a1 = new Date(formatDateString(dateString+' '+x.time_start)).getTime();
                let b1 = new Date(formatDateString(dateString+' '+x.time_end)).getTime();
                let a2 = new Date(formatDateString(dateString+' '+y.time_start)).getTime();
                let b2 = new Date(formatDateString(dateString+' '+y.time_end)).getTime();
                
                if(
                    ((a1 >= a2 && a1 < b2) || (a1 <= a2 && b1 > a2)) && (y.index != x.index)
                ){
                    for(let e1 in x.employees){
                        for(let e2 in y.employees){
                            if(e1 == e2) conflicts++;
                        }   
                    }
                    
                }

            });

            if(conflicts > 0){
                alert('Schedule Conflict!');
                this.hasSelected = false;

                return;
            }

            const d = new Date();
            let dateStringIndex = String(d.getUTCFullYear())+String(d.getUTCMonth())+String(d.getUTCDate())+
            String(d.getHours())+String(d.getMinutes())+String(d.getSeconds());
            this.newMarkDetails.index = dateStringIndex;
            this.newMarkDetails.created = true;
            this.actions++,
            this.dayMarks[this.newMarkDetails.dateId].push(JSON.parse(JSON.stringify(this.newMarkDetails)));
            this.dayMarks[this.newMarkDetails.dateId].sort((e,f)=>{
                let a = new Date(dateString+' '+e.time_start).getTime();
                let b = new Date(dateString+' '+f.time_start).getTime();
                return a - b;
            });
            this.buildCalendar();
            this.duplicateMarker(this.newMarkDetails);
            
            this.newMarkDetails = {index:0,employees:{}};
            this.hasSelected = false;
            
        },

        duplicateMarker(markDet,isUpdate=false){
            markDet = JSON.parse(JSON.stringify(markDet));
            
            let dateStart = new Date(markDet.start_date);
            dateStart.setDate(dateStart.getDate()+1);
            let dateEnd = new Date(markDet.end_date);
            let numDays = Math.round((dateEnd-dateStart)/(1000*60*60*24));
            let tempSched = {};

            for(let i = 1; i <= numDays + 1; i++){
                let sched = markDet;
                let date = new Date(sched.start_date);
                date.setDate(date.getDate()+i);
                let newDateId = 'date-'+String(date.getFullYear())+String(date.getMonth())+String(date.getDate());
                let newDateString = formatDateString(date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate());
                sched.dateId = newDateId;
                sched.dateString = newDateString;
                
                sched.refMarker = sched.index;

                if(this.dayMarks[newDateId] == null) this.dayMarks[newDateId] = new Array();

                let conflicts = 0;
                this.dayMarks[newDateId].forEach(x=>{
                    let a1 = new Date(formatDateString(newDateString+x.time_start)).getTime();
                    let b1 = new Date(formatDateString(newDateString+x.time_end)).getTime();
                    let a2 = new Date(formatDateString(newDateString+sched.time_start)).getTime();
                    let b2 = new Date(formatDateString(newDateString+sched.time_end)).getTime();
                    
                    if(
                        ((a1 >= a2 && a1 < b2) || (a1 <= a2 && b1 > a2))  && (sched.index != x.index)
                    ){
                        for(let e1 in x.employees){
                            
                            for(let e2 in sched.employees){
                                if(e1 == e2) conflicts++;
                            }   
                        }
                        
                    }

                });

                if(conflicts > 0){
                    alert('Schedule Conflict!');
                    if(!isUpdate) this.deleteSched(sched.index,true);
                    this.hasSelected = false;
                    return;
                }


                tempSched[newDateId] = sched;
            }

            for(let ts in tempSched){
                if(this.dayMarks[ts] == null) this.dayMarks[ts] = new Array();
                this.dayMarks[ts].push(JSON.parse(JSON.stringify(tempSched[ts])));
            }
            

            this.buildCalendar();


        },
        updateMarker(){
            let dateString = this.queryDate.year + '-' +
            (this.queryDate.month+1) + '-' +
            this.queryDate.day;

            let valid = validateForm(this.newMarkDetails,{
                title:"required",
                branch:"required",
                time_start:"required",
                time_end:"required",
                max_emp:{
                    isRequired: true,
                    greaterThan: 0
                },
                color:"required",
                callback(e){
                    if(e == 'max_emp') e = 'Max Employees';
                    if(e == 'time_start') e = 'Start Time';
                    if(e == 'time_end') e = 'End Time';
                    alert(e.charAt(0).toUpperCase() + e.substring(1) + ' field is empty!');
                }
            });
            
            if(!valid.allValid) return;

            if(this.newMarkDetails.end_date != null){
                let dateStart = new Date(formatDateString(dateString).replaceAll(' ',''));
                let dateEndDate = new Date(formatDateString(this.newMarkDetails.end_date).replaceAll(' ',''));
                
                if(dateStart > dateEndDate){            
                    alert('Start date should be earlier than the end date!');
                    return;
                }
            }
                
            let dateStart = new Date(formatDateString(dateString)+this.newMarkDetails.time_start);
            let dateEndDate = new Date(formatDateString(dateString)+this.newMarkDetails.time_end);
                
            if(dateStart > dateEndDate){            
                alert('Start time should be earlier than the end time!');
                return;
            }
            
            let mark = this.newMarkDetails;
            
            

            let conflicts = 0;
            let index = this.dayMarks[mark.dateId].indexOf(this.dayMarks[mark.dateId].find(el=> el.index == this.newMarkDetails.index));
            
            let y = this.newMarkDetails;
            let generatedKeys = [];
            let first = new Date(formatDateString(this.newMarkDetails.start_date).replaceAll(' ',''));
            let second = new Date(formatDateString(this.newMarkDetails.end_date).replaceAll(' ',''));
            let diff =  Math.round((second - first) / (1000 * 60 * 60 * 24));
            first = new Date(formatDateString(y.dateString).replaceAll(' ',''));
            second = new Date(formatDateString(y.dateString).replaceAll(' ',''));
            second.setDate(second.getDate()+diff);

            for(let i = 0; i <= diff; i++){
                let genKey = String(first.getFullYear()) + String(first.getMonth()) + String(first.getDate());
                generatedKeys.push(genKey);
                first.setDate(first.getDate()+1);
            }

            generatedKeys.forEach(nk=>{
                if(this.dayMarks['date-'+nk]==null) return;
                
                this.dayMarks['date-'+nk].forEach(x=>{
                    
                    let a1 = new Date(formatDateString(y.dateString+' '+x.time_start)).getTime();
                    let b1 = new Date(formatDateString(y.dateString+' '+x.time_end)).getTime();
                    let a2 = new Date(formatDateString(y.dateString+' '+y.time_start)).getTime();
                    let b2 = new Date(formatDateString(y.dateString+' '+y.time_end)).getTime();

                    let c1 = new Date(formatDateString(x.start_date).replaceAll(' ','')).getTime();
                    let c2 = new Date(formatDateString(y.dateString).replaceAll(' ','')).getTime();
                    let d1 = new Date(formatDateString(x.end_date).replaceAll(' ','')).getTime();
                    let d2 = second.getTime();
                    
                    
                    if(
                        ((a1 >= a2 && a1 < b2) || (a1 <= a2 && b1 > a2)) && (((c1 <= c2) && (d1 >= c2)) || ((c1 >= c2) && (c1 <= d2))) &&
                        (y.index != x.index)
                    ){
                        for(let e1 in x.employees){
                            for(let e2 in y.employees){
                                if(e1 == e2) conflicts++;
                            }   
                        }
                        
                    }

                });
            });

            if(conflicts > 0){
                alert('Schedule Conflict!');
                this.hasSelected = false;
                return;
            }
            
            
            this.newMarkDetails.updated = true;
            this.actions++;
            
            

            for(let dayMark in this.dayMarks){
                for(let i = this.dayMarks[dayMark].length - 1; i >= 0; i--  ){
                    if(this.dayMarks[dayMark][i].index === mark.index) { 
                        this.dayMarks[dayMark].splice(i,1);
                        
                    }
                }
            }
            

            this.duplicateMarker(this.newMarkDetails,true);
            delete this.newMarkDetails.refMarker;
            let newDate = new Date(formatDateString(mark.start_date).replaceAll(' ',''));
            let newDateId = 'date-'+String(newDate.getFullYear()) + String(newDate.getMonth()) + String(newDate.getDate());
            let newDateString = String(newDate.getFullYear())+"-"+ String(newDate.getMonth()+1)+"-"+ String(newDate.getDate());
            this.newMarkDetails.dateId = newDateId;
            this.newMarkDetails.dateString = newDateString;

            

            this.dayMarks[newDateId].push(JSON.parse(JSON.stringify(this.newMarkDetails)));


            this.buildCalendar();
            this.buildTimeView();
            this.newMarkDetails = {index:0,employees:{}};
            this.selectedDayMark = null;
            this.hasSelected = false;
            
        },
        buildTimeView(){
            document.querySelectorAll('div[id^="time-"]').forEach(el=>{
                el.remove();
            });
            if(this.select == '' || this.dayMarks[this.select] == null || this.dayMarks[this.select].length == 0) return;
            let colorIndexer = 0;
            this.dayMarks[this.select].forEach((el,i)=>{
                let newEl = document.createElement('div');
                newEl.id = 'time-'+el.dateString+'-'+i;
                
                let dateString = formatDateString(el.dateString+' '+el.time_start);
                let dateString2 = formatDateString(el.dateString+' '+el.time_end);
                let dateString3 = formatDateString(el.dateString +' 00:00:00');
                let diff = (new Date(dateString).getTime() - new Date(dateString3).getTime())/3600000;
                let diff2 = (new Date(dateString2).getTime() - new Date(dateString).getTime())/3600000;
                const left = 85 + (i * 20);

                
                let top = document.getElementById('timemark-'+Math.floor(diff)).offsetTop;
                let height = (top - document.getElementById('timemark-23').offsetTop) + 41;
                if(diff2 >= 0) height = (diff2*document.getElementById('timemark-'+Math.floor(new Date(dateString).getHours())).offsetHeight)-8;
                
                top+= document.getElementById('timemark-'+Math.floor(diff)).offsetHeight * (diff % 1);
                newEl.style = `width: calc(100% - ${left}px);position: absolute;top: ${top}px;background: ${el.color};left: ${left}px;padding: 4px;height: ${height}px;position: absolute;box-shadow: 0 0 5px #000;min-height:20px;overflow:hidden`;
                document.querySelector('.timeView').appendChild(newEl);
                newEl.innerHTML = `<strong class="dayMarkerTitle" style="color:#fff;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;margin: 0 0 5px;display: block;font-size: 14px;">${el.title}</strong>`+
                `<p class="dayMarkerP" style="color:#fff;font-size:12px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;margin: 0 !important">${el.time_start}</p>`+
                `<p class="dayMarkerP" style="color:#fff;font-size:12px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;margin: 0 !important;">${el.time_end}</p>`;
                if(colorIndexer >= 4) colorIndexer = 0;
                else colorIndexer++;
            });
        },
        dragStart(e){
            this.selectedDayMark = null;
            this.newMarkDetails = {index:0,employees:{}};
            if(e.target.parentElement.classList.contains('empSchedBox')) return;
            try{
                e.dataTransfer.setData('daymarkData',e.target.dataset.daymark);
                e.dataTransfer.setData('origin',e.target.parentElement.classList);
            }catch(err) {return;
            }
            
        },
        dragEnter(e){
            e.target.classList.add('dragEnter');
        },
        dragLeave(e){
            e.target.classList.remove('dragEnter');
        },
        drop(e){
            this.selectedDayMark = null;    
            let test = '';
            try{test = JSON.parse(e.dataTransfer.getData('daymarkData'));}
            catch(err){return;}
            let obj = JSON.parse(e.dataTransfer.getData('daymarkData'));
            let newKey = '';
            let newDate = '';
            if(e.target.classList.contains('dateBox')){
                newKey = e.target.id;
                newDate = e.target.dataset.datestring;
            }else{
                newKey = e.target.closest('.dateBox').id;
                newDate = e.target.closest('.dateBox').dataset.datestring;
            }
            
            
            if(this.dayMarks[newKey] == null) this.dayMarks[newKey] = new Array();
            let conflicts = 0;

            let generatedKeys = [];
            let first = new Date(formatDateString(obj.start_date).replaceAll(' ',''));
            let second = new Date(formatDateString(obj.end_date).replaceAll(' ',''));
            let diff =  Math.round((second - first) / (1000 * 60 * 60 * 24));
            first = new Date(formatDateString(newDate).replaceAll(' ',''));
            second = new Date(formatDateString(newDate).replaceAll(' ',''));
            second.setDate(second.getDate()+diff);

            for(let i = 0; i <= diff; i++){
                let genKey = String(first.getFullYear()) + String(first.getMonth()) + String(first.getDate());
                generatedKeys.push(genKey);
                first.setDate(first.getDate()+1);
            }
            generatedKeys.forEach(nk=>{
                if(this.dayMarks['date-'+nk]==null) return;
                
                this.dayMarks['date-'+nk].forEach(x=>{
                    
                    let a1 = new Date(formatDateString(newDate+' '+x.time_start)).getTime();
                    let b1 = new Date(formatDateString(newDate+' '+x.time_end)).getTime();
                    let a2 = new Date(formatDateString(newDate+' '+obj.time_start)).getTime();
                    let b2 = new Date(formatDateString(newDate+' '+obj.time_end)).getTime();

                    let c1 = new Date(formatDateString(x.start_date).replaceAll(' ','')).getTime();
                    let c2 = new Date(formatDateString(newDate).replaceAll(' ','')).getTime();
                    let d1 = new Date(formatDateString(x.end_date).replaceAll(' ','')).getTime();
                    let d2 = second.getTime();
                    
                    if(
                        ((a1 >= a2 && a1 < b2) || (a1 <= a2 && b1 > a2)) && (((c1 <= c2) && (d1 >= c2)) || ((c1 >= c2) && (c1 <= d2))) &&
                        (obj.index != x.index)
                    ){
                        for(let e1 in x.employees){
                            for(let e2 in obj.employees){
                                if(e1 == e2) conflicts++;
                            }   
                        }
                        
                    }

                });
            });
            
            
            

            if(conflicts > 0){
                alert('Schedule Conflict!');
                this.hasSelected = false;

                return;
            }

            if(conflicts > 0){
                alert('Schedule Conflict!');
                this.hasSelected = false;

                return;
            }
            this.dayMarks[obj.dateId].forEach((el,i)=>{ 
                if(el.index == obj.index) this.dayMarks[obj.dateId].splice(i,1);
            });

            obj.dateId = newKey;
            
            obj.dateString = formatDateString(newDate);
            
            let dateStart = new Date(obj.start_date);
            dateStart.setDate(dateStart.getDate()+1);
            let dateEnd = new Date(obj.end_date);
            let numDays = Math.round((dateEnd-dateStart)/(1000*60*60*24)) + 1;
            obj.start_date = formatDateString(newDate).replaceAll(' ','');
            let dateEndDate = new Date(obj.start_date);
            dateEndDate.setDate(dateEndDate.getDate()+numDays);
            obj.end_date = dateEndDate.getFullYear()+"-"+(dateEndDate.getMonth()+1)+"-"+dateEndDate.getDate();
            obj.end_date = formatDateString(obj.end_date).replaceAll(' ','');
            

            for(let dayMark in this.dayMarks){
                for(let i = this.dayMarks[dayMark].length - 1; i >= 0; i--  ){
                    if(this.dayMarks[dayMark][i].index === obj.index) this.dayMarks[dayMark].splice(i,1);
                }
            }

            obj.updated = true;
            this.actions++;

            this.duplicateMarker(obj);

            delete obj.refMarker;
            
            
            this.dayMarks[newKey].push(JSON.parse(JSON.stringify(obj)));
            this.dayMarks[newKey].sort((e,f)=>{
                let a = new Date(e.dateString+' '+e.time_start).getTime();
                let b = new Date(f.dateString+' '+f.time_start).getTime();
                return a - b;
            });

            this.buildCalendar();
        },
        isOpenSchedule(d){
            if(Object.keys(d.employees).length >= d.max_emp) return false;
            return true;
        },
        objectKeys(d){
            return Object.keys(d);
        },

        dropSched(e){
            this.selectedDayMark = null;
            this.newMarkDetails = {index:0,employees:{}};
            let test = '';
            try{test = JSON.parse(e.dataTransfer.getData('daymarkData'));}
            catch(err){return;}
            let obj = JSON.parse(e.dataTransfer.getData('daymarkData'));


            let generatedKeys = [];
            let conflicts = 0;
            let first = new Date(formatDateString(obj.start_date).replaceAll(' ',''));
            let second = new Date(formatDateString(obj.end_date).replaceAll(' ',''));
            let diff =  Math.round((second - first) / (1000 * 60 * 60 * 24));

            for(let i = 0; i <= diff; i++){
                let genKey = String(first.getFullYear()) + String(first.getMonth()) + String(first.getDate());
                generatedKeys.push(genKey);
                first.setDate(first.getDate()+1);
            }
            
            
            generatedKeys.forEach(nk=>{
                if(this.dayMarks['date-'+nk]==null) return;
                
                this.dayMarks['date-'+nk].forEach(x=>{
                    
                    let a1 = new Date(formatDateString(obj.dateString+' '+x.time_start)).getTime();
                    let b1 = new Date(formatDateString(obj.dateString+' '+x.time_end)).getTime();
                    let a2 = new Date(formatDateString(obj.dateString+' '+obj.time_start)).getTime();
                    let b2 = new Date(formatDateString(obj.dateString+' '+obj.time_end)).getTime();

                    let c1 = new Date(formatDateString(x.start_date).replaceAll(' ','')).getTime();
                    let c2 = new Date(formatDateString(obj.dateString).replaceAll(' ','')).getTime();
                    let d1 = new Date(formatDateString(x.end_date).replaceAll(' ','')).getTime();
                    let d2 = second.getTime();
                    
                    if(
                        ((a1 >= a2 && a1 < b2) || (a1 <= a2 && b1 > a2)) && (((c1 <= c2) && (d1 >= c2)) || ((c1 >= c2) && (c1 <= d2))) &&
                        (obj.index != x.index)
                    ){
                        for(let e1 in x.employees){
                                if(e1 == e.target.closest('.schedBox').dataset.for) conflicts++;
                        }
                        
                    }

                });
            });

            if(conflicts > 0){
                alert('Schedule Conflict!');
                this.hasSelected = false;

                return;
            }

            let index = this.dayMarks[obj.dateId].indexOf(this.dayMarks[obj.dateId].find(el => el.index == obj.index));
            if(Object.keys(this.dayMarks[obj.dateId][index].employees).length >= this.dayMarks[obj.dateId][index].max_emp){
                alert('Maximum Employees exceeded!');
                this.hasSelected = false;

                return;
            }
            
            let empid;
            if(e.target.classList.contains('schedBox')) empid = e.target.dataset.for;
            else empid = e.target.closest('.schedBox').dataset.for;
            let emp = this.empScheds.find(el => el.id == empid);

            for(let dayMark in this.dayMarks){
                for(let i = this.dayMarks[dayMark].length - 1; i >= 0; i--  ){
                    if(this.dayMarks[dayMark][i].index === obj.index) { 
                        this.dayMarks[dayMark][i].employees[empid] = emp.name;
                        this.dayMarks[dayMark][i].updated = true;
                        this.actions++;
                    }
                }
            }
            
            this.newMarkDetails = {index:0,employees:{}};
        },

        selectEmpSched(id){
            if(!parseInt(this.newMarkDetails.max_emp)) return;
            if(Object.keys(this.newMarkDetails.employees).length >= parseInt(this.newMarkDetails.max_emp)) return;
            
            let emp = this.empScheds.find(el => el.id == id);
            this.newMarkDetails.employees[emp.id] = emp.name;
            for(let e in this.newMarkDetails.employees) {if(e == '' || e == null) delete this.newMarkDetails.employees[e];}
        },
        updateEmpSchedList(){
            if(!(parseInt(this.newMarkDetails.max_emp) >= 0)) return;
            let list = JSON.parse(JSON.stringify(this.newMarkDetails.employees));
            for(let e in list){
                
                if((Object.keys(this.newMarkDetails.employees).length <= parseInt(this.newMarkDetails.max_emp))) break;
                else delete this.newMarkDetails.employees[e];
                
            }
        },
        deleteEmpSched(id){
            delete this.newMarkDetails.employees[id];
        }, 

        empSchedList(dateId,empId){
            let dayMark = this.dayMarks[dateId];
            if(dayMark == null){
                return [];
            }
            let schedules = [];
            dayMark.forEach(el=>{
                if(el.employees[empId] != null) schedules.push(el);
            });
            return schedules;   

        },
        selectDayMark(d){
            this.hasSelected = true;
            this.selectedDayMark = JSON.parse(JSON.stringify(d));
            let date = new Date(d.dateString);
            this.queryDate.year = date.getFullYear();
            this.queryDate.month = date.getMonth();
            this.queryDate.day = date.getDate();
            this.newMarkDetails = JSON.parse(JSON.stringify(d));

        },
        stringify(obj){
            return JSON.stringify(obj);
        },

        deleteSched(index,isReverted=false){
            for(let dayMark in this.dayMarks){
                for(let i = this.dayMarks[dayMark].length - 1; i >= 0; i--  ){
                    if(this.dayMarks[dayMark][i].index === index) { 
                        this.dayMarks[dayMark].splice(i,1);
                    }
                }
            }
            if(isReverted) this.deletedIndexes.push(index);
            this.newMarkDetails = {index:0};
            this.selectedDayMark=null;
            this.hasSelected = false;
            this.buildCalendar();
        },

        deleteThis(index,empId){
            for(let dayMark in this.dayMarks){
                for(let i = this.dayMarks[dayMark].length - 1; i >= 0; i--  ){
                    if(this.dayMarks[dayMark][i].index === index) {
                        this.dayMarks[dayMark][i].updated = true;
                        this.actions++;
                        delete this.dayMarks[dayMark][i].employees[empId];
                    }
                }
            }
        },

        dateFormat(string,dateString){
            return dateFormat(string,dateString+'00:00:00');
        },
        weekStartChange(amt,dir){
            let qd = this.queryDate;
            let dateNum = new Date(qd.year,qd.month+1,0).getDate();
            let dateNum2 = new Date(qd.year,qd.month,0).getDate();

            if(dir == 'inc') this.weekStart+=amt;
            else if(dir == 'dec') this.weekStart-=amt;
            if(this.weekStart > dateNum) {
                let newMonth = 0;
                let newYear = this.queryDate.year;
                if(!((this.queryDate.month + 1) >= 12)) newMonth = this.queryDate.month + 1;
                if(!((this.queryDate.month + 1) >= 12)) newYear = this.queryDate.year + 1;
                let newDate = new Date(newYear,newMonth + 1,this.weekStart - dateNum);
                this.queryDate.year = newDate.getFullYear();
                this.queryDate.month = newDate.getMonth();
                this.nextMonth();
                this.queryDate.day = newDate.getDate();
                this.weekStart = (this.weekStart - dateNum);
            }else if(this.weekStart < 1){
                let newMonth = this.queryDate.month - 1;
                let newYear = this.queryDate.year;
                if(!((this.queryDate.month - 1) < 0)) newMonth = 11;
                if(!((this.queryDate.month - 1) < 0)) newYear = this.queryDate.year - 1;
                
                let newDate = new Date(newYear,newMonth,dateNum2 + this.weekStart);
                
                this.queryDate.year = newDate.getFullYear();
                this.queryDate.month = newDate.getMonth();
                this.prevMonth();
                this.queryDate.day = newDate.getDate();
                this.weekStart = dateNum2 + this.weekStart;
            }
        },

        saveChanges(){
            let created = [];
            let updated = [];
            
            for(let dayMark in this.dayMarks){
                for(let i = this.dayMarks[dayMark].length - 1; i >= 0; i--  ){
                    if(this.dayMarks[dayMark][i].refMarker == null) {
                        if(this.dayMarks[dayMark][i].created == true && this.dayMarks[dayMark][i].updated == null )
                            created.push(this.dayMarks[dayMark][i]);
                        if(this.dayMarks[dayMark][i].updated == true && this.dayMarks[dayMark][i].created == null )
                            updated.push(this.dayMarks[dayMark][i]);
                    }
                }
            }

            
            let parsedCreated = [];
            let parsedUpdated = [];
            created.forEach(el=>{
                let obj = {
                    id: el.index,
                    title: el.title,
                    description: el.description,
                    max_employees: el.max_emp,
                    shift_start: el.time_start,
                    shift_end: el.time_end,
                    shift_date: el.start_date,
                    shift_date_end: el.end_date,
                    status: 0,
                    branch_id: el.branch,
                    assigns:[]
                };
                for(let e in el.employees){
                    let assigned = {};
                    assigned.user_id =  this.empScheds.find(el=>el.id == e).id;
                    assigned.schedule_id = el.index;
                    obj.assigns.push(assigned);
                }

                parsedCreated.push(obj);
            });

            updated.forEach(el=>{
                let obj = {
                    id: el.index,
                    title: el.title,
                    description: el.description,
                    max_employees: el.max_emp,
                    shift_start: el.time_start,
                    shift_end: el.time_end,
                    shift_date: el.start_date,
                    shift_date_end: el.end_date,
                    color: el.color,
                    status: 0,
                    branch_id: el.branch,
                    assigns:[]
                };
                
                for(let e in el.employees){
                    let assigned = {};
                    assigned.user_id =  this.empScheds.find(el=>el.id == e).id;
                    assigned.schedule_id = el.index;
                    obj.assigns.push(assigned);
                }
            

                parsedUpdated.push(obj);
            });

            parsedCreated.forEach(el=>{
                let assigns = el.assigns;
                delete el.assigns;
                axios.post('schedule/create',null,el).then(res=>console.log(res));
                axios.post('assigned/delete?schedule_id='+el.id,null,el).then(()=>{
                    assigns.forEach(el=>{
                        axios.post('assigned/create',null,el).then(res=>console.log(res));
                    })
                });
            });



            parsedUpdated.forEach(el=>{
                let assigns = el.assigns;
                delete el.assigns;
                axios.post('schedule/update?id='+el.id,null,el).then(res=>console.log(res));
                axios.post('assigned/delete?schedule_id='+el.id,null,el).then(()=>{
                    assigns.forEach(el=>{
                        axios.post('assigned/create',null,el).then(res=>console.log(res));
                    })
                });
                
            });

            this.actions = 0;
        },

        branchName(id){
            if(id == '') return;
            let finder = this.branches.find(el=>el.id == id);
            if(finder != null) return finder.name;
            return '';
        }
        
    },  
    watch:{
        'currentCalendar.month': function (){
                let c = this.currentCalendar;
                const d = new Date(c.year,c.month,1);
                this.currentCalendar.monthString = d.toLocaleDateString('en-us',{
                    month: 'long'
                });
        },
        'queryDate.rcvrString' : function(to){
            
            if(to == '' ) return;
            this.queryDate.year = parseInt(this.queryDate.rcvrString.split("-")[0]);
            this.queryDate.month = parseInt(this.queryDate.rcvrString.split("-")[1]) -1;
            this.queryDate.day = parseInt(this.queryDate.rcvrString.split("-")[2]);
            const d = new Date(this.queryDate.year,this.queryDate.month,1);
            this.queryDate.monthString = d.toLocaleDateString('en-us',{
                    month: 'long'
            });       
            this.currentCalendar.year = this.queryDate.year;
            this.currentCalendar.month = this.queryDate.month;
            this.weekStart = this.queryDate.day;
            this.buildCalendar();
            
        },
    },
    created(){
        const d = new Date();
        this.currentCalendar.year = d.getFullYear();
        this.currentCalendar.month = d.getMonth();
        this.currentCalendar.monthString = d.toLocaleDateString('en-us',{
            month: 'long'
        });
        

        this.queryDate.year = d.getFullYear();
        this.queryDate.month = d.getMonth();
        this.queryDate.day = d.getDate();
        this.queryDate.monthString = d.toLocaleDateString('en-us',{
            month: 'long'
        });
        this.weekStart = this.queryDate.day;
        
     
        this.buildCalendar();

    },
    mounted()
    {

        axios.post('branches?_batch=true',null,null).then(res=>{
            this.branches = res.data.result;
        });

        axios.post('users?_batch=true',null,null).then(res=>{
            let list = [];
            if(!res.data.success) return;
            res.data.result.forEach(el=>{
                el.name = el.firstname + ' '+ el.lastname;
                list.push(el);
            })
            this.empScheds = list;

            axios.post('schedule?_batch=true',null,null).then(res=>{
                this.dayMarks = {};
                if(!res.data.success) return;
                res.data.result.forEach(el=>{
                    let obj = {
                        index: el.id,
                        branch: el.branch_id,
                        color: el.color,
                        start_date: el.shift_date,
                        end_date: el.shift_date_end,
                        time_end: el.shift_end,
                        time_start: el.shift_start,
                        max_emp:el.max_employees,
                        title: el.title,
                        description: el.description,
                        employees:{}
                    };
                    obj.dateString = el.shift_date;
                    let newDate = new Date(el.shift_date.replaceAll(' ',''));
                    obj.dateId = 'date-'+String(newDate.getFullYear()) + String(newDate.getMonth()) + String(newDate.getDate());

                    if(this.dayMarks[obj.dateId] == null) this.dayMarks[obj.dateId] = new Array();
                    

                    axios.post('assigned?_batch=true,schedule_id='+obj.index,null,null).then(res2=>{
                        if(res2.data.result != null){
                            res2.data.result.forEach(el=>{
                                obj.employees[el.user_id] =  this.empScheds.find(el2=>el.user_id == el2.id).name;
                            });
                        }

                        this.dayMarks[obj.dateId].push(obj);
                        this.duplicateMarker(obj);
                    });
                })

                this.buildCalendar();
            });
        });




        // let obj = {
        //             id: el.index,
        //             title: el.title,
        //             max_employees: el.max_emp,
        //             shift_start: el.time_start,
        //             shift_end: el.time_end,
        //             shift_date: el.start_date,
        //             shift_date_end: el.end_date,
        //             status: 0,
        //             branch_id: el.branch
        //         };



        elementLoad('.topBoxes').then(el=>{
            this.topBoxes = el.offsetWidth;
            window.onresize = ()=>{
                this.topBoxes = el.offsetWidth;
            };
        });

        elementLoad('.topBoxes2').then(el=>{
            this.topBoxes2 = el.offsetWidth;
            window.onresize = ()=>{
                this.topBoxes2 = el.offsetWidth;
            };
        })


        },
    computed:{
        searchEmpResult(){
            return this.empScheds.filter(el=>(
                (this.searchEmpBox.toLowerCase().includes(el.name.toLowerCase()) || el.name.toLowerCase().includes(this.searchEmpBox.toLowerCase())) &&
                (this.newMarkDetails.employees[el.id] == null) &&
                this.searchEmpBox != ''
            ));
        }

        
    }


})
</script>



<style scoped>
@import '../../assets/scss/_card.scss';
@import '../../assets/scss/_breadcrumb.scss';
@import '../../assets/sleek.min.css';

.hide {visibility: hidden !important;}
.empSchedBox{min-height: 170px;}
.option{width: 15%;justify-content: space-evenly;display: flex;}
#calendar h2 {color: #1b223c;font-size: 1.99rem;font-weight: 500;}
#calendar h3{color: #1b223c;font-size: 1.63rem;font-weight: 500;}
.timeView{color: #1b223c;font-size: 1.10rem;font-weight: 500;}
.modal-header h2{color: #1b223c;font-size: 1.99rem;font-weight: 500;}
.modal-lg{width: 800px;}
.dayMarkPanel h3{color: #1b223c;font-size: 1.63rem;font-weight: 500;}
.but button{margin-left: 5px;}
.dateBox{min-height: 170px;}
.calendarComp{display: flex;font-family: sans-serif;flex-wrap: wrap;}
    #calendar{padding:20px;margin: 0 auto;width: 100%;}
    h2 > small{font-size: 18px;font-style: italic;}

    .calendarCtrl{display: grid;grid-template-columns: 1fr 1fr 1fr 1fr 3fr 1fr;width: 100%;margin:5px 0;gap:5px}
    .calendarCtrl button{padding: 10px;display: block;box-sizing: border-box}
    .calendarCtrl input{padding: 10px;display: block;box-sizing: border-box}
    .calendarView {display: grid;grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;border:1px solid #ccc;border-bottom:none}
    .calendarView > div{padding: 10px}
    .calendarView > div:not(:nth-child(7n)){border-right: 1px solid #ccc;}
    .calendarView .calendarWeekHeads{text-align: center;border-bottom:1px solid #ccc}
    .calendarView .calendarDays{min-height: 170px;transition:0.4s;position: relative; height: 115px;overflow-y: auto;border-bottom:1px solid #ccc}
    
    .calendarView .dateBox:hover, .calendarView .dateBox.dragEnter{outline:2px dotted #555; box-shadow: inset 0 0 5px #aaa}
    .calendarView .dateBox.selected{outline:2px solid #555;}
    .calendarView .emptyBox{pointer-events:none}
    .calendarView .today{background:rgba(255,220,40,.15)}
    .dayMarkPanel{width: 100%;padding: 20px;}
    .timeView {max-height: calc(100vh - 180px);overflow-y: scroll;border:1px solid #ddd;padding: 15px;resize: vertical;position:relative}
    .timeView .time{display: flex;border-top:1px solid #ddd;height: 30px;padding: 10px;}
    .timeView .time span{margin-top: -20px;background: #fff;padding: 0 5px;}

    .modal{background: rgb(0,0,0,0.5);position: fixed;width: 100%;height: 100%;top:0;left:0;display:flex;z-index: 1050; overflow: scroll;}
    input[type='time'],input[type='date'],.color_selector_input{margin-bottom: 10px;}
    input:not([type='time']):not([type='date']):not(.color_selector_input){width: 100%;margin: 5px 0;padding: 10px;}
    .dayMark{background: #ff9e9e;padding: 5px;font-size: 12px;margin: 10px 0; color: #fff;border-radius: 5px;border: 4px double #fff;}
    .dayMark em{font-size:11px;}
    .dayMark strong, .dayMark p{white-space: nowrap;overflow: hidden;text-overflow: ellipsis;margin: 0;}
    .dayMark strong{margin: 0 0 5px;display: block;font-size: 14px;}
    .dayMark > *:not(a){pointer-events: none;}

    .weekgrid1{display: grid;grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;}
    

    .weekgrid2{display: grid;grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr;}
    [class^="weekgrid"] div{padding:10px;text-align: center;}
    .weekgrid2 > div:first-child, .weekgrid2 > div:nth-child(9n){text-align: left;}
    [class^="weekgrid"] div:not(:nth-child(7n)){border-right: 1px solid #aaa;}
    .weekgrid1 div:last-child{border-right:none}
    [class^="weekgrid"] span{display: flex;width: 40px;height: 40px;align-items: center;background: #ddd;justify-content: center;margin: 10px auto 0px;border-radius: 50%;}
    .weekgrid2 > div:first-child{display: flex;align-items: center;}
    .weekgrid2 div:not(:nth-child(8n)){border-right: 1px solid #aaa;}
    .schedBox,.employeegrid div:first-child{border-top:1px solid #aaa}
    
    .schedBox:hover{box-shadow: inset 0 0 7px #aaa;}
    .selectedMark{border: 3px inset #555;}
    
    .color_selector_container{margin-top:10px;}
    .color_selector_container input{margin: 0;}
    .color_selector_container ul{margin: 0;list-style: none;padding-left: 0;border:1px solid #ccc;display: flex;justify-content: stretch;}
    .color_selector_container li{margin: 0;padding:20px;height: 20px;flex-grow: 1;transition:0.4s}
    .color_selector_container li.selected{border:3px solid #000 !important}

    .selected_emps{margin: 20px 0;position: relative;}
    .selected_emps input {margin:0 !important}
    .selected_emps_inputlist{position: relative;}
    .selected_emps #selected_emps_datalist {margin: 0;list-style: none;padding-left: 0;border:1px solid #ccc;position: absolute;top:100%;width: 100%;background: #fff;}
    .selected_emps #selected_emps_datalist li{margin: 0;padding:5px;transition:0.4s}
    .selected_emps #selected_emps_datalist li:hover{background: #ccc;}
    #selected_emps_emplist{display: flex;list-style: none;padding-left: 0;gap:5px}
    #selected_emps_emplist li{padding: 5px 10px;border: 1px solid #aaa;border-radius: 22px;}
    #selected_emps_emplist li a{text-decoration: none;text-decoration: none;color: #fff;border-radius: 50%;background: #aaa;padding: 2px;width: 15px;height: 15px;display: inline-block;text-align: center;font-size: 7px;vertical-align: middle;margin: 0 0 2px 5px;}
    #selected_emps_emplist li a:hover{background: #222;color:#fff}

    .branch_inputlist{position: relative;z-index: 20;}
    .branch_inputlist input {margin:5px 0 !important}
    .branch_inputlist input:hover + ul,.branch_inputlist ul:hover{display: block;}
    .branch_inputlist ul {display:none;margin: 0;list-style: none;padding-left: 0;border:1px solid #ccc;position: absolute;top:100%;width: 100%;background: #fff;}
    .branch_inputlist ul li{margin: 0;padding:5px;transition:0.4s}
    .branch_inputlist ul li:hover{background: #ccc;}
    
</style>
