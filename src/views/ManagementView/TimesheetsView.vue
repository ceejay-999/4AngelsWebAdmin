<template>
    <LayoutView>
        <div class="toast" >

        </div>
        <div class="breadcrumb-wrapper d-flex justify-content-between" v-if="branchselected != null">
            <div>
                <h1 class="text-dark">Facility Name: {{branchselected}}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0">
                        <li class="breadcrumb-item">
                        <RouterLink to="/dashboard">
                            <span class="mdi mdi-home"></span>                
                        </RouterLink>   
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Timesheets</li>
                    </ol>
                </nav>
            </div>
            <div>
                <RouterLink class="btn btn-primary" to="/timesheetexport" target="_blank"> Export to Excel</RouterLink>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3 d-flex align-items-center">
                <label for="validationTooltip01" class="mr-2">From: </label>
                <input type="date" class="form-control" v-model="fromdate" required>
                <label for="validationTooltip02" class="ml-2 mr-2">To: </label>
                <input type="date" class="form-control" v-model="todate" required>
                <button class="btn btn-info ml-2" @click="FilterDates(fromdate,todate)">Filter</button>
            </div>
        </div>
        <div class="card card-default">
            <table class="table table-hover" id="DataTable_Element">
                <thead>
                    <tr>
                        <th class="font-weight-bold">Employee Name</th>
                        <th class="font-weight-bold">Role</th>
                        <th class="font-weight-bold">Wage</th>
                        <th class="font-weight-bold">Time Card</th>
                        <th class="font-weight-bold">Total Hours</th>
                        <th class="font-weight-bold">Total Paid</th>
                        <th class="font-weight-bold">Action</th>
                    </tr>
                </thead>
                
                <tbody v-for="timeshet in timesheets">
                    <tr data-toggle="collapse" :data-target="'#accordion'+timeshet.timesheets_id" class="clickable">
                        <td class="font-weight-bold text-left">{{ new Date(timeshet.timesheets_schedule).toLocaleString('en-US',{
                        weekday: "long",
                        year: "numeric",
                        month: "long",
                        day: "numeric",
                    })  }}</td>
                        <td></td>
                        <td></td>
                        <td>{{ timeshet.timesheets_totaltimecard }} Total Time Cards</td>
                        <td class="font-weight-bold text-left">{{ timeshet.timesheets_totalhour }}</td>
                        <td class="font-weight-bold text-left">${{ timeshet.timesheets_totalpaid }}</td>
                        <td></td>
                    </tr>
                    <tr :id="'accordion'+timeshet.timesheets_id" class="collapse" v-for="sched in pastschedules">
                        <td v-if="new Date(sched.schedules_dates).getTime() == new Date(timeshet.timesheets_schedule).getTime()"><div>{{ sched.employee_firstname+" "+ sched.employee_lastname }}</div></td>
                        <td v-if="new Date(sched.schedules_dates).getTime() == new Date(timeshet.timesheets_schedule).getTime()"><div>{{ sched.role_name }}</div></td>
                        <td v-if="new Date(sched.schedules_dates).getTime() == new Date(timeshet.timesheets_schedule).getTime()"><div>{{ sched.assignschedules_lastrecordrate }}</div></td>
                        <td v-if="new Date(sched.schedules_dates).getTime() == new Date(timeshet.timesheets_schedule).getTime()"><div v-if="sched.assignschedules_timein != null && sched.assignschedules_timeout != null ">{{ sched.assignschedules_timein +" - "+ sched.assignschedules_timeout }}</div><div class="text-danger" v-else>No Clockin / No Clockout</div></td>
                        <td v-if="new Date(sched.schedules_dates).getTime() == new Date(timeshet.timesheets_schedule).getTime()"><div>{{ sched.assignschedules_totalhours }}</div></td>
                        <td v-if="new Date(sched.schedules_dates).getTime() == new Date(timeshet.timesheets_schedule).getTime()"><div>${{ sched.assignschedules_totalwage }}</div></td>
                        <td><a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.assignschedules_id)">Edit Clockin / Clockout</a>
                        </div></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </LayoutView>
</template>
<script>
import LayoutView from "../../views/SharedLayoutView/LayoutView.vue"
import { axios , validateForm,lStore } from '@/functions.js';
import {utils,writeFileXLSX} from 'xlsx';
import toastr from 'toastr';


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
            fromdate: "",
            todate: "",
        }
    },
    mounted(){
        axios.post('timesheetcontroller/gettimesheet?facility='+this.branchselected).then(res=>{
            console.log(res);
        });
        // axios.post('timesheet?_batch=true').then(res=>{
        //     if(res.data.result == null)
        //     {
        //         return;
        //     }
        //     this.timesheets = res.data.result;
        //     if(this.timesheets != null)
        //     {
        //         let temp = []
        //         axios.post("")
        //         // axios.post("assigned?schedules_facilityid="+lStore.get("selected_facilityId")+"&_joins=assignschedules,assigndesignation,employee,role&_on=assignschedules_scheduleid=schedules_id,assigndesignation_id=assignschedules_assigndesignationid,employee_id=assigndesignation_employeeid,role_id=assigndesignation_roleid&_batch=true").then(res=>{
        //         //     temp = res.data.result;
        //         //     this.timesheets.forEach(element => {
        //         //         temp.forEach(e => {
        //         //             if(new Date(e.schedules_dates).getTime() == new Date(element.timesheets_schedule).getTime() && e.assignschedules_status == 4)
        //         //             {

        //         //                 this.pastschedules.push(e);
        //         //             }
        //         //         });
        //         //     });
        //         // });
        //     } 
        // });
    },
    methods:{
        FilterDates(currentDateString,weekDateString){
            this.pastschedules = [];
            this.timesheets = [];
            document.querySelector(".toast").id = "toaster";
            if(currentDateString == null || currentDateString == "")
            {
                this.callToaster("toast-top-right",2);
                return;
            }
            if(weekDateString == null || weekDateString == "")
            {
                this.callToaster("toast-top-right",2);
                return;
            }
            axios.post(`timesheet?_batch=true&_GTE_timesheets_schedule=${currentDateString}&_LSE_timesheets_schedule=${weekDateString}`).then(res=>{
                if(res.data.success == false)
                {
                    this.callToaster("toast-top-right",3);
                    return;
                }
                this.timesheets = res.data.result;
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
        },
        callToaster(positionClass, reserror) {
            if (document.getElementById("toaster")) {
                toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: true,
                progressBar: true,
                positionClass: positionClass,
                preventDuplicates: false,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "2000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
                };
                if(reserror == 2)
                {
                    toastr.error("Error Dates", "Error!");
                }
                if(reserror == 3)
                {
                    toastr.error("No Timesheets Found", "Error!");
                }
            }
        },
    }
})
</script>
<style scoped>
@import '../../assets/scss/_card.scss';
@import '../../assets/scss/_breadcrumb.scss';
@import '../../assets/scss/_type.scss';
@import '../../assets/scss/_reboot.scss';
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