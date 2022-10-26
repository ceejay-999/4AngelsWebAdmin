<template>
    <button @click="view = !view">{{(view) ? 'Employee' : 'Month'}} View</button>
    <div class="calendarComp">
        <div id="calendar" >
            <div v-if="view==0">
                <h2>Month View</h2>
                <h3>{{currentCalendar.monthString}} of {{currentCalendar.year}}</h3>
                <div class="calendarCtrl">
                    <button @click="prevYear">&laquo;</button>
                    <button @click="prevMonth">&#10094;</button>
                    <button @click="nextMonth">&#10095;</button>
                    <button @click="nextYear">&raquo;</button>
                    <input type="date" v-model="queryDate.rcvrString">
                    <button @click="gotoDate">Go</button>
                </div>
                
                    
            
                <div class="calendarView">
                    <div class="calendarWeekHeads" v-for="c in currentCalendar.weekString" :key="c">{{c}}</div>
                    <div class="calendarDays"  :key="c" :id="c.dateId" :class="c.type" v-for="c in currentCalendar.viewArray" :data-dispkey="c.dateNum" @click="selectDay($event,c.dateNum)" @dragenter.prevent="dragEnter" @dragover.prevent @dragleave="dragLeave" @drop="drop" :data-datestring="c.dateString">
                        {{c.dateNum}}
                        <div class="dayMark" v-for="(d,i) in c.dayMark" :key="d" :draggable="d.refMarker == null" :data-daymark="stringify(d)" @dragstart="dragStart" :style="'background:'+d.color" @click="selectDayMark(d)" :class="{selectedMark: (d.index == this.newMarkDetails.index)}">
                            <strong>{{d.title}}</strong>
                            <em>{{d.index}}</em>
                            <p>From {{d.time_start}}</p>
                            <p>To {{d.time_end}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="employeeWeekView" v-if="view==1">
                
                <h2>Employee View <small>({{dateFormat('%lm %d, %y',computeDays(1)[2])}} to {{dateFormat('%lm %d, %y',computeDays(7)[2])}})</small></h2>
                <button @click="weekStartChange(7,'dec')">&laquo; -1 Week</button>
                <button @click="weekStartChange(1,'dec')">&#10094; -1 Day</button>
                <button @click="weekStartChange(1,'inc')">&#10095; +1 Day</button>
                <button @click="weekStartChange(7,'inc')">&raquo; +1 Week</button>
                <h3>Open Schedules</h3>
                <div class="weekgrid1">
                    <div v-for="i in 7" :key="i">{{weekViewLabel(computeDays(i)[2])}} <span>{{computeDays(i)[0]}}</span></div>
                </div>
                <div class="weekgrid1">
                    <div class="schedBox dateBox" v-for="i in 7" :key="i" :id="'date-'+computeDays(i)[1]" @dragenter.prevent="dragEnter" @dragover.prevent @dragleave="dragLeave" @drop="drop" :data-datestring="computeDays(i)[2]" @click="selectDate($event,'date-'+computeDays(i)[2])">
                        <div class="dayMark" v-for="(d) in dayMarks['date-'+computeDays(i)[1]]" :key="d" draggable="true" :data-daymark="stringify(d)" @dragstart="dragStart" :style="'background:'+d.color"
                            @click="selectDayMark(d)" :class="{selectedMark: (d == this.selectedDayMark)}" v-show="isOpenSchedule(d)">
                            <strong>{{d.title}}</strong>
                            <em>{{d.index}}</em>
                            <p>From {{d.time_start}}</p>
                            <p>To {{d.time_end}}</p>
                            <p>Employees: {{objectKeys(d.employees).length}}/{{d.max_emp}}</p>

                        </div>
                    </div>
                </div>

                <h3>Employee Schedules</h3>
                <div class="weekgrid2">
                    <div><strong>Employee</strong></div>
                    <div v-for="i in 7" :key="i">{{weekViewLabel(computeDays(i)[2])}} <span>{{computeDays(i)[0]}}</span></div>
                </div>
                <div class="weekgrid2 employeegrid" v-for="emp in empScheds" :key="emp">
                    <div><strong>{{emp.name}}</strong></div>
                    <div class="schedBox empSchedBox" v-for="i in 7" :key="i" :data-day="'date-'+computeDays(i)[1]" :data-for="emp.id" @dragenter.prevent="dragEnter" @dragover.prevent @dragleave="dragLeave" @drop="dropSched">

                        <div class="dayMark" v-for="(d,i) in empSchedList('date-'+computeDays(i)[1],emp.id)" :key="d" :data-daymark="stringify(d)" :style="'background:'+d.color">
                            <strong>{{d.title}}</strong>
                            <em>{{d.index}}</em>
                            <p>From {{d.time_start}}</p>
                            <p>To {{d.time_end}}</p>
                            <a href="javascript:;" @click="deleteThis(d.index,emp.id)">(x) Remove</a>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>

        <div class="modal" v-if="hasSelected">
            <div class="addMarker">
                <h2>{{(selectedDayMark == null) ? 'Add':'Edit'}} Schedule</h2>
                Date: <strong>{{queryDate.monthString}} {{queryDate.day}}, {{currentCalendar.year}}</strong> to <input id="end_date" type="date" v-model="newMarkDetails.end_date">
                <br />
                Time: From <input type="time" v-model="newMarkDetails.time_start"> to <input type="time"  v-model="newMarkDetails.time_end"><br/>
                Color: <input type="color" placeholder="Add Branch" v-model="newMarkDetails.color">
                <input placeholder="Add Title" v-model="newMarkDetails.title">
                <input placeholder="Add Branch" v-model="newMarkDetails.branch">
                <input type="number" placeholder="Max Employees" v-model="newMarkDetails.max_emp">
                <button @click="addMarker">{{(selectedDayMark == null) ? 'Create':'Update'}} Schedule</button>
                <button @click="newMarkDetails = {index:0};selectedDayMark=null;hasSelected = false;">Cancel</button>
            </div>
        </div>
        <div class="dayMarkPanel">
             
            <div hidden>
                <h3>Time View for {{queryDate.monthString}} {{queryDate.day}}, {{currentCalendar.year}}</h3>
                <div class="timeView">
                    <div class="time" v-for="(index,i) in 24" :key="i" :id="'timemark-'+i">
                        <span>{{(i == 0) ? '12' :(i>12) ? (i-12):i}} {{(i==12) ? 'pm' : (i>12) ? 'pm' : 'am'}}</span>
                    </div>
                </div>
            </div>
        </div>

        
        

    </div>
    
</template>

<script>
import {dateFormat, elementLoad,formatDateString} from '../../functions';

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
            colors: ['#ff9e9e','#ffe29e','#caff9e','#9effe0','#9ec3ff'],

            dayMarks:{},
            empScheds:[
                {id:1,name: 'Kim'},
                {id:2,name: 'Ceejay'},
                {id:3,name: 'James'},
                {id:4,name: 'Marco'},
            ],
            newMarkDetails:{},
            selectedDayMark:null
    
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

            
            
            let dateString = String(year)+'-'+String(month+1)+'-'+String(days);
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
            if(!e.target.classList.contains('dayMark')) {this.selectedDayMark = null;this.newMarkDetails = {index:0}}
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
            if(!e.target.classList.contains('dayMark')) {this.selectedDayMark = null;this.newMarkDetails = {index:0}}
        	if(document.querySelector(".selected") != null)
                document.querySelector(".selected").classList.remove("selected");
            console.log(dateString);
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
                let a1 = new Date(dateString+' '+x.time_start+':00').getTime();
                let b1 = new Date(dateString+' '+x.time_end+':00').getTime();
                let a2 = new Date(dateString+' '+y.time_start+':00').getTime();
                let b2 = new Date(dateString+' '+y.time_end+':00').getTime();
                
                if(
                    ((a1 >= a2 && a1 < b2) || (a1 <= a2 && b1 > a2))
                ){
                    conflicts++;
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
            this.newMarkDetails.employees = {};
            this.dayMarks[this.newMarkDetails.dateId].push(JSON.parse(JSON.stringify(this.newMarkDetails)));
            this.dayMarks[this.newMarkDetails.dateId].sort((e,f)=>{
                let a = new Date(dateString+' '+e.time_start+':00').getTime();
                let b = new Date(dateString+' '+f.time_start+':00').getTime();
                return a - b;
            });
            this.buildCalendar();
            this.duplicateMarker(this.newMarkDetails);
            
            this.newMarkDetails = {index:0};
            this.hasSelected = false;
            
        },

        duplicateMarker(markDet){
            markDet = JSON.parse(JSON.stringify(markDet));
            
            let dateStart = new Date(markDet.start_date);
            dateStart.setDate(dateStart.getDate()+1);
            let dateEnd = new Date(markDet.end_date);
            let numDays = Math.round((dateEnd-dateStart)/(1000*60*60*24));

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
                    let a1 = new Date(newDateString+' '+x.time_start+':00').getTime();
                    let b1 = new Date(newDateString+' '+x.time_end+':00').getTime();
                    let a2 = new Date(newDateString+' '+sched.time_start+':00').getTime();
                    let b2 = new Date(newDateString+' '+sched.time_end+':00').getTime();
                    
                    if(
                        ((a1 >= a2 && a1 < b2) || (a1 <= a2 && b1 > a2))
                    ){
                        conflicts++;
                    }

                });

                if(conflicts > 0){
                    alert('Schedule Conflict!');
                    this.hasSelected = false;
                    return;
                }


                this.dayMarks[newDateId].push(JSON.parse(JSON.stringify(sched)));
            }
            

            this.buildCalendar();


        },
        updateMarker(){
            
            let mark = this.newMarkDetails;
            
            

            let conflicts = 0;
            let index = this.dayMarks[mark.dateId].indexOf(this.dayMarks[mark.dateId].find(el=> el.index == this.newMarkDetails.index));
            
            let y = this.newMarkDetails;

            this.dayMarks[mark.dateId].forEach(x=>{
                let a1 = new Date(x.dateString+' '+x.time_start+':00').getTime();
                let b1 = new Date(x.dateString+' '+x.time_end+':00').getTime();
                let a2 = new Date(y.dateString+' '+y.time_start+':00').getTime();
                let b2 = new Date(y.dateString+' '+y.time_end+':00').getTime();

                if(
                    ((a1 >= a2 && a1 < b2) || (a1 <= a2 && b1 > a2)) &&
                    x.index != y.index
                ){
                    conflicts++;
                }
            });

            if(conflicts > 0){
                alert('Schedule Conflict!');
                this.hasSelected = false;
                return;
            }
            
            if(this.newMarkDetails.max_emp <= Object.keys(this.dayMarks[mark.dateId][index].employees).length){
                alert(`Please reduce the number of employees having this schedule to ${this.newMarkDetails.max_emp}!`);
                this.hasSelected = false;

                return;
            }
            
            
            

            for(let dayMark in this.dayMarks){
                for(let i = this.dayMarks[dayMark].length - 1; i >= 0; i--  ){
                    if(this.dayMarks[dayMark][i].index === mark.index) { 
                        // console.log(this.dayMarks[dayMark][i].dateString,this.dayMarks[dayMark][i].index, mark.index, this.dayMarks[dayMark][i].index === mark.index);
                        this.dayMarks[dayMark].splice(i,1);
                        
                    }
                }
            }
            

            this.duplicateMarker(this.newMarkDetails);
            delete this.newMarkDetails.refMarker;
            let newDate = new Date(formatDateString(mark.start_date).replaceAll(' ',''));
            let newDateId = 'date-'+String(newDate.getFullYear()) + String(newDate.getMonth()) + String(newDate.getDate());
            let newDateString = String(newDate.getFullYear())+"-"+ String(newDate.getMonth()+1)+"-"+ String(newDate.getDate());
            this.newMarkDetails.dateId = newDateId;
            this.newMarkDetails.dateString = newDateString;

            

            this.dayMarks[newDateId].push(JSON.parse(JSON.stringify(this.newMarkDetails)));


            this.buildCalendar();
            this.buildTimeView();
            this.newMarkDetails = {index:0};
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
                
                let dateString = formatDateString(el.dateString+' '+el.time_start+':00');
                let dateString2 = formatDateString(el.dateString+' '+el.time_end+':00');
                let dateString3 = formatDateString(el.dateString +' 00:00:00');
                let diff = (new Date(dateString).getTime() - new Date(dateString3).getTime())/3600000;
                let diff2 = (new Date(dateString2).getTime() - new Date(dateString).getTime())/3600000;
                const left = 85 + (i * 20);
                const colors = ['#ff9e9e','#ffe29e','#caff9e','#9effe0','#9ec3ff'];
    
                let top = document.getElementById('timemark-'+Math.floor(diff)).offsetTop;
                let height = (top - document.getElementById('timemark-23').offsetTop) + 41;
                if(diff2 >= 0) height = (diff2*document.getElementById('timemark-'+Math.floor(new Date(dateString).getHours())).offsetHeight)-8;

                
                top+= document.getElementById('timemark-'+Math.floor(diff)).offsetHeight * (diff % 1);
                newEl.style = `position: absolute;top: ${top}px;background: ${colors[colorIndexer]};left: ${left}px;padding: 4px;height: ${height}px;position: absolute;box-shadow: 0 0 5px #000;min-height:20px;overflow:hidden`;
                document.querySelector('.timeView').appendChild(newEl);
                newEl.innerHTML = `<strong class="dayMarkerTitle" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;margin: 0 0 5px;display: block;font-size: 14px;">${el.title}</strong>`+
                `<p class="dayMarkerP" style="font-size:12px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;margin: 0 !important">${el.time_start}</p>`+
                `<p class="dayMarkerP" style="font-size:12px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;margin: 0 !important;">${el.time_end}</p>`;
                if(colorIndexer >= 4) colorIndexer = 0;
                else colorIndexer++;
            });
        },
        dragStart(e){
            this.selectedDayMark = null;
            this.newMarkDetails = {index:0};
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
            this.dayMarks[newKey].forEach(x=>{
                let a1 = new Date(formatDateString(newDate+' '+x.time_start+':00')).getTime();
                let b1 = new Date(formatDateString(newDate+' '+x.time_end+':00')).getTime();
                let a2 = new Date(formatDateString(newDate+' '+obj.time_start+':00')).getTime();
                let b2 = new Date(formatDateString(newDate+' '+obj.time_end+':00')).getTime();
                
                if(
                    ((a1 >= a2 && a1 < b2) || (a1 <= a2 && b1 > a2)) &&
                    x.index != obj.index
                ){
                    conflicts++;
                }

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
            console.log(obj.dateString);
            let dateEndDate = new Date(obj.start_date);
            dateEndDate.setDate(dateEndDate.getDate()+numDays);
            obj.end_date = dateEndDate.getFullYear()+"-"+(dateEndDate.getMonth()+1)+"-"+dateEndDate.getDate();
            obj.end_date = formatDateString(obj.end_date).replaceAll(' ','');
            

            for(let dayMark in this.dayMarks){
                for(let i = this.dayMarks[dayMark].length - 1; i >= 0; i--  ){
                    if(this.dayMarks[dayMark][i].index === obj.index) this.dayMarks[dayMark].splice(i,1);
                }
            }
            console.log(obj.dateString);

            this.duplicateMarker(obj);

            delete obj.refMarker;
            
            console.log(obj.dateString);
            
            this.dayMarks[newKey].push(JSON.parse(JSON.stringify(obj)));
            this.dayMarks[newKey].sort((e,f)=>{
                let a = new Date(e.dateString+' '+e.time_start+':00').getTime();
                let b = new Date(f.dateString+' '+f.time_start+':00').getTime();
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
            this.newMarkDetails = {index:0};
            let test = '';
            try{test = JSON.parse(e.dataTransfer.getData('daymarkData'));}
            catch(err){return;}
            let obj = JSON.parse(e.dataTransfer.getData('daymarkData'));
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
                        this.dayMarks[dayMark][i].employees[empid] = {id:emp.id,name:emp.name};
                        
                    }
                }
            }
            
            this.newMarkDetails = {index:0};
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

        deleteThis(index,empId){
            for(let dayMark in this.dayMarks){
                for(let i = this.dayMarks[dayMark].length - 1; i >= 0; i--  ){
                    if(this.dayMarks[dayMark][i].index === index) { 
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
        'queryDate.rcvrString' : function(){
            this.queryDate.year = parseInt(this.queryDate.rcvrString.split("-")[0]);
            this.queryDate.month = parseInt(this.queryDate.rcvrString.split("-")[1]) -1;
            this.queryDate.day = parseInt(this.queryDate.rcvrString.split("-")[2]);
            const d = new Date(this.queryDate.year,this.queryDate.month,1);
            this.queryDate.monthString = d.toLocaleDateString('en-us',{
                    month: 'long'
            });            
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
    computed:{

    }


})
</script>



<style scoped>
.calendarComp{display: flex;font-family: sans-serif;flex-wrap: wrap;}
    #calendar{padding:20px;margin: 0 auto;width: calc(70% - 41px);border-right:1px solid #ddd}
    h2 > small{font-size: 18px;font-style: italic;}

    .calendarCtrl{display: grid;grid-template-columns: 1fr 1fr 1fr 1fr 3fr 1fr;width: 100%;margin:5px 0;gap:5px}
    .calendarCtrl button{padding: 10px;display: block;box-sizing: border-box}
    .calendarCtrl input{padding: 10px;display: block;box-sizing: border-box}
    .calendarView {display: grid;grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;gap:5px;}
    .calendarView > div{border-bottom: 1px solid #ccc;padding: 10px}
    .calendarView .calendarWeekHeads{text-align: center;}
    .calendarView .calendarDays{min-height: 70px;transition:0.4 s;position: relative;  max-height: 115px;overflow-y: auto;}
    .calendarView .dateBox:hover, .calendarView .dateBox.dragEnter{outline:2px dotted #555; box-shadow: inset 0 0 5px #aaa}
    .calendarView .dateBox.selected{outline:2px solid #555;}
    .calendarView .emptyBox{pointer-events:none}
    .calendarView .today{background:#ddd}
    .dayMarkPanel{width: calc(30% - 40px);padding: 20px;}
    .timeView {max-height: 300px;overflow-y: scroll;border:1px solid #ddd;padding: 15px;resize: vertical;position:relative}
    .timeView .time{display: flex;border-top:1px solid #ddd;height: 30px;padding: 10px;}
    .timeView .time span{margin-top: -20px;background: #fff;padding: 0 5px;}

    .modal{background: rgb(0,0,0,0.5);position: fixed;width: 100%;height: 100%;top:0;left:0;display:flex;justify-content: center;align-items: center;}
    .addMarker {background: #fff;padding: 20px;max-width: 600px;border-radius: 20px;}
    .addMarker input{border: none;background: #eee;padding: 5px;font-size: 16px;font-weight: medium;}
    input[type='time'],input[type='date'],input[type='color']{margin-bottom: 10px;}
    input:not([type='time']):not([type='date']):not([type='color']){width: calc(100% - 20px);margin: 5px 0;padding: 10px;}
    .addMarker button{width: 120px;height: 30px;margin-left: auto;display: block;}
    .dayMark{background: #ff9e9e;padding: 5px;font-size: 12px;margin: 10px 0;}
    .dayMark em{font-size:11px;}
    .dayMark strong, .dayMark p{white-space: nowrap;overflow: hidden;text-overflow: ellipsis;margin: 0;}
    .dayMark strong{margin: 0 0 5px;display: block;font-size: 14px;}
    .dayMark > *:not(a){pointer-events: none;}

    .weekgrid1{display: grid;grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;}
    

    .weekgrid2{display: grid;grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr;}
    [class^="weekgrid"] div{padding:10px;text-align: center;}
    .weekgrid2 > div:first-child, .weekgrid2 > div:nth-child(9n){text-align: left;}
    [class^="weekgrid"] div:not(:nth-child(8n)){border-right: 1px solid #aaa;}
    .weekgrid1 div:last-child{border-right:none}
    [class^="weekgrid"] span{display: flex;width: 40px;height: 40px;align-items: center;background: #ddd;justify-content: center;margin: 10px auto 0px;border-radius: 50%;}
    .weekgrid2 > div:first-child{display: flex;align-items: center;}
    .schedBox,.employeegrid div:first-child{border-top:1px solid #aaa}
    .schedBox:hover{box-shadow: inset 0 0 7px #aaa;}
    .selectedMark{border: 3px inset #555;}  
    
</style>
