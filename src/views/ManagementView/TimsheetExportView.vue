<template>
    <table class="table table-hover" id="DataTable_Element">
        <thead>
            <tr>
                <th class="font-weight-bold">Employee Name</th>
                <th class="font-weight-bold">Role</th>
                <th class="font-weight-bold">Wage</th>
                <th class="font-weight-bold">Time Card</th>
                <th class="font-weight-bold">Total Hours</th>
                <th class="font-weight-bold">Total Paid</th>
            </tr>
        </thead>
        
        <tbody v-for="timeshet in timesheets">
            <tr>
                <th :id="timeshet.timesheets_schedule" class="font-weight-bold text-left">{{ new Date(timeshet.timesheets_schedule).toLocaleString('en-US',{
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric",
            })  }}</th>
                <th></th>
                <th></th>
                <th>{{ timeshet.timesheets_totaltimecard }} Total Time Cards</th>
                <th class="font-weight-bold text-left">{{ timeshet.timesheets_totalhour }}</th>
                <th class="font-weight-bold text-left">${{ timeshet.timesheets_totalpaid }}</th>
            </tr>
            <tr v-for="sched in pastschedules" v-show="new Date(sched.schedules_dates).getTime() == new Date(timeshet.timesheets_schedule).getTime()">
            <template v-if="new Date(sched.schedules_dates).getTime() == new Date(timeshet.timesheets_schedule).getTime()">
                <td :headers="timeshet.timesheets_schedule"><div>{{ sched.employee_firstname+" "+ sched.employee_lastname }}</div></td>
                <td :headers="timeshet.timesheets_schedule"><div>{{ sched.role_name }}</div></td>
                <td :headers="timeshet.timesheets_schedule"><div>{{ sched.assignschedules_lastrecordrate }}</div></td>
                <td :headers="timeshet.timesheets_schedule"><div v-if="sched.assignschedules_timein != null && sched.assignschedules_timeout != null ">{{ sched.assignschedules_timein +" - "+ sched.assignschedules_timeout }}</div><div class="text-danger" v-else>No Clockin / No Clockout</div></td>
                <td :headers="timeshet.timesheets_schedule"><div>{{ sched.assignschedules_totalhours }}</div></td>
                <td :headers="timeshet.timesheets_schedule"><div>${{ sched.assignschedules_totalwage }}</div></td>
            </template>
            <template v-else>
                
            </template>
            </tr>
        </tbody>
    </table>
</template>
<script>
import LayoutView from "../../views/SharedLayoutView/LayoutView.vue"
import { axios , validateForm,lStore } from '@/functions.js';
import {utils,writeFileXLSX} from 'xlsx';
import { elementLoad } from "../../functions";


export default ({
    name: "App",
    components: {
    LayoutView
    },
    data(){
        return{
            branchselected: lStore.get('selected_facility'),
            timesheets: [],
            pastschedules: [],
            loaded: "",
        }
    },
    mounted(){
        this.loadTable();
        let rep = setInterval(() => {
            if(this.loaded == "loaded");
            {
                clearInterval(rep);
                this.genXLSXTable();
            }
        }, 3000);
    },
    methods:{
        genXLSXTable(){
            console.log(this.loaded);
            if(this.loaded != null)
            {
                const table = document.getElementById("DataTable_Element");
                const wb = utils.table_to_book(table,{raw:true});

                writeFileXLSX(wb,`4AngelsTimesheets-${new Date().getTime()}.xlsx`);
            }
        },
        async loadTable(){
            await axios.post('timesheet?_batch=true').then(res=>{
                if(res.data.result == null)
                {
                    return;
                }
                this.timesheets = res.data.result;
                console.log("on timesheetpage:",this.timesheets);
                if(this.timesheets != null)
                {
                    let temp = []
                    axios.post("assigned?schedules_facilityid="+lStore.get("selected_facilityId")+"&_joins=assignschedules,assigndesignation,employee,role&_on=assignschedules_scheduleid=schedules_id,assigndesignation_id=assignschedules_assigndesignationid,employee_id=assigndesignation_employeeid,role_id=assigndesignation_roleid&_batch=true").then(res=>{
                        temp = res.data.result;
                        this.timesheets.forEach(element => {
                            temp.forEach(e => {
                                if(new Date(e.schedules_dates).getTime() == new Date(element.timesheets_schedule).getTime() && e.assignschedules_status == 4)
                                {

                                    this.pastschedules.push(e);
                                }
                            });
                        });
                    });
                }
            });
            this.loaded = true;
        }
    }
})
</script>
<style scoped>
@import '../../assets/scss/_card.scss';
@import '../../assets/scss/_breadcrumb.scss';
@import '../../assets/sleek.min.css';

.card{
    overflow: auto;
}
.table th{
    border-bottom: none !important;
}
.card-default{
    padding: 0  !important;
}
.card-default .card-header, .card-table-border-none .card-header,.card-default .card-body, .card-table-border-none .card-body
{
    padding-left: 15px;
    padding-top: 0px;
    padding-bottom: 0px;
    padding-right: 0px;
}
.empcard{
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}
.row .align-items-start
{
    width: 100%;
    padding:20px;
}
</style>