<template>
    <LayoutView>
        <div class="toast" >

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
                        <button type="button" class="btn btn-primary btn-pill" @click="EditClockin()" data-dismiss="modal"> Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-wrapper" v-if="branchselected != null">
            <h1 class="text-dark">Facility Name: {{branchselected}}</h1>
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item text-secondary" aria-current="page"><i class="mdi mdi-view-dashboard-outline"></i> Dashboard</li>
                </ol>
                </nav>
        </div>
        <div class="breadcrumb-wrapper" v-else>
            <h1 class="text-info">Overall Report</h1>
        </div>
        <div class="row" v-if="branchselected == null">
            <div class="col-xl-3 col-sm-3">
                <div class="card card-mini mb-4">
                <div class="card-body">
                    <h2 class="mb-1">{{ totalfacility }}</h2>
                    <p>Total Facility</p>
                </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-3">
                <div class="card card-mini  mb-4">
                <div class="card-body">
                    <h2 class="mb-1">{{ totalsupervisor }}</h2>
                    <p>Total Supervisor</p>
                </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-3">
                <div class="card card-mini mb-4">
                <div class="card-body">
                    <h2 class="mb-1">{{ totalmanagers }}</h2>
                    <p>Total Mangers</p>
                </div>
                </div>
            </div>
            <div v-if="accesslevel.user_access_level_id == 1" class="col-xl-3 col-sm-3">
                <div class="card card-mini mb-4">
                <div class="card-body">
                    <h2 class="mb-1">0</h2>
                    <p>Total Revenue This Year</p>
                </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="card card-default">
            <div class="card-body d-flex justify-content-between">
                <div class="text-uppercase text-secondary">
                    <h4>{{ new Date().toLocaleString('en-US',{
                        timeZone: "America/New_York",
                        weekday: "long",
                        year: "numeric",
                        month: "long",
                        day: "numeric",
                    }) }}</h4>
                </div>
                <div class="mr-4 text-secondary" v-if="totalhoursb != null"><h5>Total Hours</h5><h4 class="d-flex justify-content-center">{{totalhoursb.toFixed(2)}}</h4></div>
                <div class="mr-4 text-secondary" v-if="totalwageb != null"><h5>Total Wages Today</h5> <h4 class="d-flex justify-content-center">${{totalwageb.toFixed(2)}}</h4></div>
                <!-- <div class="date-range-report text-secondary d-flex align-items-center">
                    <input type="date" class="form-control datepick" v-model="datetoday">
                    <button class="btn btn-success" @click="SearchRecordData"><p class="mdi mdi-calendar-search"></p></button>
                </div> -->
            </div>
        </div>
        <div class="card card-default mt-3">
            <div class="card-body">
                <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#NowUpComming" role="tab" aria-controls="settings" aria-selected="false">Now & Upcoming</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#Complete" role="tab" aria-controls="timeline" aria-selected="true">Completed</a>
                    </li>
                </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="NowUpComming" role="tabpanel" aria-labelledby="settings-tab">
                            <div class="tab-pane-content">
                                <div v-if="assignschedules === null">
                                    <div class="d-flex justify-content-center">
                                    <div class="text-center mt-5">
                                        <h3 class="mb-2">Keep track of your Employees.</h3>
                                        <p class="mb-2">See who`s clocked in, who`s late and who`s scheduled.</p>
                                        <RouterLink class="btn btn-primary" to="/jobschedule">Create a Schedule</RouterLink>
                                    </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <div v-for="arr in assignschedules.green">
                                        <div class="bd-callout mt-4 bd-callout-success">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.user_photo != ''" class="mr-3 img-fluid rounded" :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+arr.user_photo"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/default-profile.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">{{ arr.user_firstname }} {{arr.user_lastname}}
                                                    <small>Clockin: {{ new Date(arr.clock_event_intime).toLocaleTimeString() }}</small>
                                                    <small>Clockout: </small>
                                                    <small><span class="text-info"> Ongoing</span> </small>
                                                    <small>{{ new Date(arr.schedule_detail_date+' '+arr.schedule_detail_start_time).toLocaleTimeString() }} - {{new Date(arr.schedule_detail_date+' '+arr.schedule_detail_end_time).toLocaleTimeString()}}</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Total Hours
                                                    <p class="d-flex justify-content-center"></p>
                                                    <p class="d-flex justify-content-center">0</p>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Wages
                                                    <p class="d-flex justify-content-center"></p>
                                                    <p class="d-flex justify-content-center">0</p>
                                                </div>
                                                <div>
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockin</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockoutModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockout</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-for="arr in assignschedules.yellow">
                                        <div class="bd-callout mt-4 bd-callout-warning">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.user_photo != ''" class="mr-3 img-fluid rounded" :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+arr.user_photo"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/users.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">{{ arr.user_firstname }} {{arr.user_lastname}}

                                                    <small v-if="arr.clock_event_isclockin == 0" >Clockin:<span class="text-danger">Missing Clockin</span> </small> <!--If On Time-->
                                                    <small v-else>Clockin: {{ new Date(arr.clock_event_intime).toLocaleTimeString() }} <span class="text-danger">Clockin Late</span></small>
                                                    <small>Clockout: </small>
                                                    <small><span class="text-info"> Ongoing</span> </small>
                                                    <small>{{ new Date(arr.schedule_detail_date+' '+arr.schedule_detail_start_time).toLocaleTimeString() }} - {{new Date(arr.schedule_detail_date+' '+arr.schedule_detail_end_time).toLocaleTimeString()}}</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Total Hours
                                                    <p class="d-flex justify-content-center"></p>
                                                    <p class="d-flex justify-content-center">0</p>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Wages
                                                    <p class="d-flex justify-content-center"></p>
                                                    <p class="d-flex justify-content-center">0</p>
                                                </div>
                                                <div>
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockin</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockoutModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockout</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-for="arr in assignschedules.red">
                                        <div class="bd-callout mt-4 bd-callout-danger">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.user_photo != ''" class="mr-3 img-fluid rounded" :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+arr.user_photo"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/default-profile.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">{{ arr.user_firstname }} {{arr.user_lastname}}

                                                    <small v-if="arr.clock_event_isclockin == 0" >Clockin:<span class="text-danger">Missing Clockin</span> </small> <!--If On Time-->
                                                    <small v-else>Clockin: {{ new Date(arr.clock_event_intime).toLocaleTimeString() }}</small>
                                                    <small>Clockout: </small>
                                                    <small><span class="text-info"> Ongoing</span> </small>
                                                    <small>{{ new Date(arr.schedule_detail_date+' '+arr.schedule_detail_start_time).toLocaleTimeString() }} - {{new Date(arr.schedule_detail_date+' '+arr.schedule_detail_end_time).toLocaleTimeString()}}</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Total Hours
                                                    <p class="d-flex justify-content-center"></p>
                                                    <p class="d-flex justify-content-center">0</p>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Wages
                                                    <p class="d-flex justify-content-center"></p>
                                                    <p class="d-flex justify-content-center">0</p>
                                                </div>
                                                <div>
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockin</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockoutModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockout</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-for="arr in assignschedules.gray">
                                        <div class="bd-callout mt-4 bd-callout-default">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.user_photo != ''" class="mr-3 img-fluid rounded" :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+arr.user_photo"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/default-profile.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">{{ arr.user_firstname }} {{arr.user_lastname}}
                                                    <small>Clockin: </small>
                                                    <small>Clockout: </small>
                                                    <small><span class="text-info"> Upcomming</span> </small>
                                                    <small>{{ new Date(arr.schedule_detail_date+' '+arr.schedule_detail_start_time).toLocaleTimeString() }} - {{new Date(arr.schedule_detail_date+' '+arr.schedule_detail_end_time).toLocaleTimeString()}}</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Total Hours
                                                    <p class="d-flex justify-content-center"></p>
                                                    <p class="d-flex justify-content-center">0</p>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Wages
                                                    <p class="d-flex justify-content-center"></p>
                                                    <p class="d-flex justify-content-center">0</p>
                                                </div>
                                                <div>
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockin</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockoutModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockout</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="Complete" role="tabpanel" aria-labelledby="settings-tab">
                            <div class="tab-pane-content">
                                <div v-if="assignschedules.length == 0">
                                    <div class="d-flex justify-content-center">
                                    <div class="text-center mt-5">
                                        <h3 class="mb-2">Keep track of your Employees.</h3>
                                        <p class="mb-2">See who`s clocked in, who`s late and who`s scheduled.</p>
                                        <RouterLink class="btn btn-primary" to="/jobschedule">Create a Schedule</RouterLink>
                                    </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <div v-for="arr in assignschedules.complete">
                                        <div v-if="arr.clock_event_isclockin == 1 && arr.clock_event_isclockout == 1" class="bd-callout mt-4 bd-callout-success">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.user_photo != ''" class="mr-3 img-fluid rounded" :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+arr.user_photo"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/default-profile.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">{{ arr.user_firstname }} {{arr.user_lastname}}
                                                    <small>Clockin: {{ new Date(arr.clock_event_intime).toLocaleTimeString() }}</small>
                                                    <small>Clockout: {{ new Date(arr.clock_event_outtime).toLocaleTimeString() }}</small>
                                                    <small><span class="text-success"> Completed</span> </small>
                                                    <small>{{ new Date(arr.schedule_detail_date+' '+arr.schedule_detail_start_time).toLocaleTimeString() }} - {{new Date(arr.schedule_detail_date+' '+arr.schedule_detail_end_time).toLocaleTimeString()}}</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Total Hours
                                                    <p class="d-flex justify-content-center"></p>
                                                    <p class="d-flex justify-content-center">0</p>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Wages
                                                    <p class="d-flex justify-content-center"></p>
                                                    <p class="d-flex justify-content-center">0</p>
                                                </div>
                                                <div>
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockin</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockoutModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockout</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="bd-callout mt-4 bd-callout-danger">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.user_photo != ''" class="mr-3 img-fluid rounded" :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+arr.user_photo"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/default-profile.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">{{ arr.user_firstname }} {{arr.user_lastname}}
                                                    <small>Clockin: {{ new Date(arr.clock_event_intime).toLocaleTimeString() }}</small>
                                                    <small>Clockout: {{ new Date(arr.clock_event_outtime).toLocaleTimeString() }}</small>
                                                    <small><span class="text-success"> Completed</span> </small>
                                                    <small>{{ new Date(arr.schedule_detail_date+' '+arr.schedule_detail_start_time).toLocaleTimeString() }} - {{new Date(arr.schedule_detail_date+' '+arr.schedule_detail_end_time).toLocaleTimeString()}}</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Total Hours
                                                    <p class="d-flex justify-content-center"></p>
                                                    <p class="d-flex justify-content-center">0</p>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Wages
                                                    <p class="d-flex justify-content-center"></p>
                                                    <p class="d-flex justify-content-center">0</p>
                                                </div>
                                                <div>
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockin</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockoutModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockout</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </LayoutView>
</template>

<script>
import LayoutView from "../../views/SharedLayoutView/LayoutView.vue"
import { axios , validateForm,lStore,dateFormat } from '@/functions.js';

export default ({
    name: "App",
    components: {
        LayoutView
    },
    data() {
        return{
            branchselected: lStore.get('selected_facility'),
            totalfacility: 0,
            totalsupervisor: 0,
            totalmanagers: 0,
            users: [],
            branch: [],
            totalhoursb: 0,
            totalwageb: 0,
            assignschedules:[],
            timetoday: 0,
            date: 0,
            assignschedid: "",
            assignschedclockin: "",
            assignschedclockout: "",
            pastschedule:[],
            timesheets: [],
            facilityid: "",
            accesslevel: lStore.get('userdetails'),
            clockid: "",
        }
    },
    mounted(){
        this.datetoday = new Date();
        axios.post('dashboardcontroller/DashboardTotalReport',{pwauth: lStore.get('usertoken')}).then(res=>{
            this.totalfacility = res.data.result.facilities;
            this.totalsupervisor = res.data.result.supervisor;
            this.totalmanagers = res.data.result.manager;
        });
        this.gethourlydata();
        setInterval(() => {
            this.gethourlydata();
            
        }, 3000);

    },
    methods: {
        gethourlydata(){
            this.facilityid = lStore.get('selected_facilityid');
            axios.post('dashboardcontroller/DashboardTodaySched',{pwauth: lStore.get('usertoken')},{facilityid: lStore.get('selected_facilityId')}).then(res=>{
                if(res.data.success){
                    console.log(res.data.result);
                    this.assignschedules = res.data.result;
                }
            });
        },
        GetClockinorClockout(data){
            axios.post('dashboardcontroller/GetClockevent',{pwauth: lStore.get('usertoken')},{clockid: data}).then(res=>{
                if(res.data.result[0].clock_event_isclockin == 0 && res.data.result[0].clock_event_isclockout == 0)
                {
                    this.clockid = data;
                    return;
                }
                if(res.data.success){
                    this.clockid = data;
                    this.assignschedclockin = new Date(res.data.result[0].clock_event_intime).toLocaleTimeString();
                    this.assignschedclockout = new Date(res.data.result[0].clock_event_outtime).toLocaleTimeString();
                }
            });
        },
        EditClockin(){
            let indate = new Date().toLocaleDateString('en-US',{timeZone: "America/New_York"});
            let outdate = new Date().toLocaleDateString('en-US',{timeZone: "America/New_York"});
            if(this.assignschedclockin == "00:00"){
                indate = "0000-00-00";
            }
            if(this.assignschedclockout == "00:00"){
                outdate = "0000-00-00";
            }
            console.log(dateFormat('%y-%m-%D %H:%I:%S',indate+' '+this.assignschedclockin+':00'));
            console.log(outdate+' '+this.assignschedclockout+':00');
            axios.post('dashboardcontroller/UpdateClockevent',{pwauth: lStore.get('usertoken')},{clockid: this.clockid, clockin:dateFormat('%y-%m-%D %H:%I:%S',indate+' '+this.assignschedclockin+':00'),clockout: dateFormat('%y-%m-%D %H:%I:%S',outdate+' '+this.assignschedclockout+':00')}).then(res=>{
                if(res.data.success){
                    // this.$router.go(0);
                }
            });
        }
    }
})
</script>

<style scoped>
@import '../../assets/scss/_card.scss';
@import '../../assets/scss/_breadcrumb.scss';
@import '../../assets/scss/_type.scss';
@import '../../assets/scss/_reboot.scss';
@import '../../assets/sleek.min.css';

.tab-content > .active
{
    display: block !important;
}

.img-fluid{
    width: 100px;
    height: 100px !important;
}
.textcenter{
    display: none;
    margin: 0 auto;
    font-size: 20px;
}
.contact-details{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
}
.responsive-data-table{
    overflow: auto;
}
.tab-content > .active
{
    display: block !important;
}
.bd-callout {
padding: 1.25rem;
margin-bottom: 1.25rem;
border: 1px solid #eee;
border-left-width: .25rem;
border-radius: .25rem
}

.bd-callout h4 {
margin-top: 0;
margin-bottom: .25rem
}

.bd-callout p:last-child {
margin-bottom: 0
}

.bd-callout code {
border-radius: .25rem
}

.bd-callout+.bd-callout {
margin-top: -.25rem
}

.bd-callout-info {
border-left-color: #5bc0de
}

.bd-callout-info h4 {
color: #5bc0de
}

.bd-callout-warning {
border-left-color: #f0ad4e
}

.bd-callout-warning h4 {
color: #f0ad4e
}

.bd-callout-danger {
border-left-color: #d9534f
}

.bd-callout-danger h4 {
color: #d9534f
}

.bd-callout-primary{
border-left-color: #007bff
}

.bd-callout-primaryh4 {
color: #007bff
}

.bd-callout-success{
border-left-color: #28a745
}

.bd-callout-successh4 {
color: #28a745
}

.bd-callout-default{
border-left-color: #6c757d
}

.bd-callout-defaulth4 {
color: #6c757d
}
.datepick{
    border-style: none;
}
</style>