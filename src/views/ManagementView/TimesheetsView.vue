<template>
    <LayoutView>
        <div id="toaster" >

        </div>
        <div class="modal fade" id="ViewClockModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFormTitle"> {{ viewemployeeclock.user_firstname }} {{ viewemployeeclock.user_lastname }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="space">
                            <h5>Worked</h5>
                            <h6 v-if="viewemployeeclock.clock_event_isclockin == 1 && viewemployeeclock.clock_event_isclockout == 1">{{ Math.floor(viewemployeeclock.clock_event_totalacthour) }} hrs {{ Math.round(parseFloat(viewemployeeclock.clock_event_totalacthour) *60) }}m • {{ new Date(viewemployeeclock.clock_event_intime).toLocaleTimeString() }} - {{ new Date(viewemployeeclock.clock_event_outtime).toLocaleTimeString() }}</h6>
                            <h6 v-else-if="viewemployeeclock.clock_event_isclockin == 1 && viewemployeeclock.clock_event_isclockout == 0 || viewemployeeclock.clock_event_isclockin == 1 && viewemployeeclock.clock_event_isclockout == null">{{ Math.floor(viewemployeeclock.clock_event_totalacthour) }} hrs {{ Math.round(parseFloat(viewemployeeclock.clock_event_totalacthour) *60) }}m • {{ new Date(viewemployeeclock.clock_event_intime).toLocaleTimeString() }} - <span class="text-danger">Missing Clockout</span></h6>
                            <h6 v-else-if="viewemployeeclock.clock_event_isclockin == 0 && viewemployeeclock.clock_event_isclockout == 1||viewemployeeclock.clock_event_isclockin == null && viewemployeeclock.clock_event_isclockout == 1">{{ Math.floor(viewemployeeclock.clock_event_totalacthour) }} hrs {{ Math.round(parseFloat(viewemployeeclock.clock_event_totalacthour) *60) }}m • <span class="text-danger">Missing Clockin</span> - {{ new Date(viewemployeeclock.clock_event_outtime).toLocaleTimeString() }}</h6>
                            <h6 v-else class="text-danger">No Show</h6>
                            <h6>Scheduled: {{ Math.floor(viewemployeeclock.schedule_detail_hours) }} hrs {{ Math.round(parseFloat(viewemployeeclock.schedule_detail_hours) * 60) }} min ({{ new Date(viewemployeeclock.schedule_detail_date +' '+viewemployeeclock.schedule_detail_start_time).toLocaleTimeString() }} - {{ new Date(viewemployeeclock.schedule_detail_date+' '+viewemployeeclock.schedule_detail_end_time).toLocaleTimeString() }})</h6>
                        </div>
                        <div class="space">
                            <div v-if="viewemployeeclock.clock_event_isclockin == 1 && viewemployeeclock.clock_event_isclockout == 1">
                                <h5>GPS Validation</h5>
                                <h6><a :href="'https://www.google.com/maps/@?api=1&map_action=pano&viewpoint='+viewemployeeclock.clock_event_inlat+'%2C'+viewemployeeclock.clock_event_inlong+'&heading=-45&pitch=38&fov=80'" target="_blank">View Clockin Location</a></h6>
                                <h6><a :href="'https://www.google.com/maps/@?api=1&map_action=pano&viewpoint='+viewemployeeclock.clock_event_outlat+'%2C'+viewemployeeclock.clock_event_outlong+'&heading=-45&pitch=38&fov=80'" target="_blank">View Clockout Location</a></h6>
                            </div>
                            <div v-else-if="viewemployeeclock.clock_event_isclockin == 1 && viewemployeeclock.clock_event_isclockout == 0 || viewemployeeclock.clock_event_isclockin == 1 && viewemployeeclock.clock_event_isclockout == null">
                                <h5>GPS Validation</h5>
                                <h6><a :href="'https://www.google.com/maps/@?api=1&map_action=pano&viewpoint='+viewemployeeclock.clock_event_inlat+'%2C'+viewemployeeclock.clock_event_inlong+'&heading=-45&pitch=38&fov=80'" target="_blank">View Clockin Location</a></h6>
                            </div>
                            <div v-else-if="viewemployeeclock.clock_event_isclockin == 0 && viewemployeeclock.clock_event_isclockout == 1 || viewemployeeclock.clock_event_isclockin == null && viewemployeeclock.clock_event_isclockout == 1">
                                <h5>GPS Validation</h5>
                                <h6><a :href="'https://www.google.com/maps/@?api=1&map_action=pano&viewpoint='+viewemployeeclock.clock_event_outlat+'%2C'+viewemployeeclock.clock_event_outlong+'&heading=-45&pitch=38&fov=80'" target="_blank">View Clockout Location</a></h6>
                            </div>
                            <div v-else>
                                No Data
                            </div>
                        </div>
                        <div class="space">
                            <div v-if="viewemployeeclock.timesheet_file_status == 1">
                                <h5>Timesheet Files</h5>
                                <br />
                                <img @click="window.open('https://www.4angelshc.com/wangelmobile/filesystem/'+ viewemployeeclock.timesheet_file)" :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+ viewemployeeclock.timesheet_file" class="timg" />
                            </div>
                            <divv v-else>
                                No Uploaded Timesheet
                            </divv>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addClockinModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFormTitle">Clockin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Clockin Time</label>
                                <input type="time" class="form-control" v-model="assignschedclockin">
                                <div class="invalid-feedback feedback1">
                                    
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal" @click="cleardata()">Close</button>
                        <button type="button" class="btn btn-primary btn-pill" @click="EditClockin()" data-dismiss="modal"> Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addClockoutModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFormTitle">Clockout</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Clockout Time</label>
                                <input type="time" class="form-control" v-model="assignschedclockout">
                                <div class="invalid-feedback feedback1">
                                    
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal" @click="cleardata()">Close</button>
                        <button type="button" class="btn btn-primary btn-pill" @click="EditClockout()" data-dismiss="modal"> Save Changes</button>
                    </div>
                </div>
            </div>
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
                <h3 v-if="fromdate != null && todate != null" class="text-dark">Timesheet for the Month of: {{ new Date().toLocaleString('en-US',{timeZone: 'america/new_york', month: 'long'}) }}</h3>
                <h3 v-else class="text-dark">Timesheet for from: {{ fromdate }} to {{ todate }}</h3>
            </div>
            <div>
                <RouterLink class="btn btn-primary" @click="ExportTimesheet()" to="#" target="_blank"> Export to Excel</RouterLink>
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
                    <tr data-toggle="collapse" :data-target="'#accordion'+timeshet.timesheet_id" class="clickable">
                        <td class="font-weight-bold text-left">{{ new Date(timeshet.timesheet_date).toLocaleString('en-US',{
                        weekday: "long",
                        year: "numeric",
                        month: "long",
                        day: "numeric",
                    })  }}</td>
                        <td></td>
                        <td></td>
                        <td>{{ timeshet.timesheet_time_card }} Total Time Cards</td>
                        <td class="font-weight-bold text-left"></td>
                        <td class="font-weight-bold text-left"></td>
                        <td></td>
                    </tr>
                    <tr :id="'accordion'+timeshet.timesheet_id" class="collapse bg-light" v-for="sched in timeshet.timesheetdetails">
                        <td><div>{{ sched.user_firstname+" "+ sched.user_lastname }}</div></td>
                        <td><div>{{ sched.role_name }}</div></td>
                        <td><div>$ {{ sched.schedule_assign_wage }}</div></td>
                        <td><div v-if="sched.clock_event_isclockin == 1 && sched.clock_event_isclockout == 1 ">{{ new Date(sched.clock_event_intime).toLocaleTimeString() +" - "+ new Date(sched.clock_event_outtime).toLocaleTimeString() }}</div>
                            <div v-else-if="sched.clock_event_isclockin == 1 && sched.clock_event_isclockout == 0 ">{{ new Date(sched.clock_event_intime).toLocaleTimeString() +" - "}}<span class="text-danger">No Clockout</span></div>
                            <div v-else-if="sched.clock_event_isclockin == 1 && sched.clock_event_isclockout == null ">{{ new Date(sched.clock_event_intime).toLocaleTimeString() +" - "}}<span class="text-danger">No Clockout</span></div>
                            <div v-else-if="sched.clock_event_isclockin == 0 && sched.clock_event_isclockout == 1 "><span class="text-danger">No Clockin</span> - {{new Date(sched.clock_event_outtime).toLocaleTimeString() }}</div>
                            <div v-else-if="sched.clock_event_isclockin == null && sched.clock_event_isclockout == 1 "><span class="text-danger">No Clockin</span> - {{new Date(sched.clock_event_outtime).toLocaleTimeString() }}</div>
                        <div class="text-danger" v-else>No Clockin / No Clockout</div></td>
                        <td><div>{{ sched.timesheet_detail_paid_hours }}</div></td>
                        <td><div>${{ sched.timesheet_detail_total_est_wage }}</div></td>
                        <td><a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(sched.clock_event_id)">Edit Clockin</a>
                            <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockoutModalForm" @click="GetClockinorClockout(sched.clock_event_id)">Edit Clockout</a>
                            <a class="dropdown-item addclockin" data-toggle="modal" data-target="#ViewClockModalForm" @click="GetEmployeeScheduleDetails(sched.clock_event_id)">View Clockin/Clockout Details</a>
                        </div></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </LayoutView>
</template>
<script>
import LayoutView from "../../views/SharedLayoutView/LayoutView.vue"
import { axios , validateForm,lStore,dateFormat } from '@/functions.js';
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
            fromdate: "",
            todate: "",
            assignschedclockout: "",
            assignschedclockin: "",
            viewemployeeclock: [],
            clockid: "",
            schedassignid: "",
            window
        }
    },
    mounted(){
        axios.post('dashboardcontroller/checkScheduleTimesheet',{pwauth: lStore.get('usertoken')});
        axios.post('Timesheetcontroller/GetTimesheet',{pwauth: lStore.get('usertoken')},{facilityid: lStore.get('selected_facilityId')}).then(res=>{
            this.timesheets = res.data.result;
            console.log(res.data.result);
        });
    },
    methods:{
        EditClockin(){
            let indate = new Date().toLocaleDateString('en-US',{timeZone: "America/New_York"});
            let outdate = new Date().toLocaleDateString('en-US',{timeZone: "America/New_York"});
            if(this.assignschedclockin == "00:00"){
                indate = "0000-00-00";
            }
            axios.post('dashboardcontroller/UpdateClockinevent',{pwauth: lStore.get('usertoken')},{clockid: this.clockid, clockin:dateFormat('%y-%m-%D %H:%I:%S',indate+' '+this.assignschedclockin+':00'),assignschedid: this.schedassignid}).then(res=>{
                if(res.data.success){
                    this.callToaster("toast-top-right",res.data);
                    this.cleardata();
                    setTimeout(() => {
                        this.$router.go(0);
                    }, 3000);
                }else{
                    this.callToaster("toast-top-right",res.data);
                    this.cleardata();
                    setTimeout(() => {
                        this.$router.go(0);
                    }, 3000);
                }
            });
        },
        EditClockout(){
            let indate = new Date().toLocaleDateString('en-US',{timeZone: "America/New_York"});
            let outdate = new Date().toLocaleDateString('en-US',{timeZone: "America/New_York"});
            if(this.assignschedclockout == "00:00"){
                outdate = "0000-00-00";
            }
            axios.post('dashboardcontroller/UpdateClockoutevent',{pwauth: lStore.get('usertoken')},{clockid: this.clockid, clockout:dateFormat('%y-%m-%D %H:%I:%S',indate+' '+this.assignschedclockout+':00'),assignschedid: this.schedassignid}).then(res=>{
                if(res.data.success){
                    this.callToaster("toast-top-right",res.data);
                    setTimeout(() => {
                        this.$router.go(0);
                    }, 3000);
                }else{
                    this.callToaster("toast-top-right",res.data);
                    setTimeout(() => {
                        this.$router.go(0);
                    }, 3000);
                }
            });
        },
        cleardata(){
            this.assignschedclockout = "";
            this.assignschedclockin = "";
            this.viewemployeeclock = [];
        },
        GetClockinorClockout(data){
            axios.post('dashboardcontroller/GetClockevent',{pwauth: lStore.get('usertoken')},{clockid: data}).then(res=>{
                console.log(res.data.result);
                if(res.data.result[0].clock_event_isclockin == 0 && res.data.result[0].clock_event_isclockout == 0)
                {
                    this.clockid = data;
                    
                    return;
                }
                if(res.data.success){
                    this.clockid = data;
                    this.assignschedclockin = new Date(res.data.result[0].clock_event_intime).toLocaleTimeString('en-Us',{hour12:false,hour:'2-digit',minute:'2-digit'});
                    this.assignschedclockout = new Date(res.data.result[0].clock_event_outtime).toLocaleTimeString('en-Us',{hour12:false,hour:'2-digit',minute:'2-digit'});
                    this.schedassignid = res.data.result[0].schedule_assigns_id
                    
                }
            });
        },
        GetEmployeeScheduleDetails(data){
            axios.post('dashboardcontroller/GetClockevent',{pwauth: lStore.get('usertoken')},{clockid: data}).then(res=>{
                console.log(res.data.result);
                if(res.data.success){
                    this.viewemployeeclock = res.data.result[0];
                }
            });
        },
        ExportTimesheet(){
            this.$router.push({ name: 'timesheetexport', params: { variable: JSON.stringify(this.timesheets) }})
        },
        FilterDates(currentDateString,weekDateString){
            this.timesheets = [];
            if(currentDateString == null || currentDateString == "")
            {
                this.callToaster1("toast-top-right",2);
                return;
            }
            if(weekDateString == null || weekDateString == "")
            {
                this.callToaster1("toast-top-right",2);
                return;
            }
            axios.post('Timesheetcontroller/SearchTimesheet',{pwauth: lStore.get('usertoken')},{facilityid: lStore.get('selected_facilityId'),fromdate:currentDateString,todate:weekDateString}).then(res=>{
            this.timesheets = res.data.result;
        });
        },
        callToaster1(positionClass, reserror) {
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
                if(reserror.success == true)
                {
                    toastr.success(""+reserror.msg, "Successfully!");
                }
                else
                {
                    toastr.error(""+reserror.msg, "Error!");
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
.datepick{
    border-style: none;
}
.space{
    margin-bottom: 20px;
    padding:20px;
    border: 1px solid #000;
}
.timg{
    width: 100%;
    max-width: 500px;
    height: 100%;
    max-height: 600px;
}
</style>