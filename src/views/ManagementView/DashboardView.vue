<template>
    <LayoutView>
        <div class="toast" >

        </div>
        <div class="modal fade" id="addClockinModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFormTitle">Clockin / Clockout</h5>
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
                        <button type="button" class="btn btn-primary btn-pill" @click="EditClockin(assignschedid)" data-dismiss="modal"> Save Changes</button>
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
            <div class="col-xl-3 col-sm-3">
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
                                    <div v-for="arr in assignschedules">
                                        <div class="bd-callout mt-4 bd-callout-success" v-if="arr.assignschedules_status == 6">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.employee_profilepicture != 'https://www.4angelshc.com/mobile/filesystem/'" class="mr-3 img-fluid rounded" :src="arr.employee_profilepicture"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/users.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">{{ arr.employee_firstname }} {{arr.employee_lastname}} <small>rate: {{ arr.assigndesignation_wagerate }} </small>

                                                    <small v-if="arr.assignschedules_status == 6" >Clockin: {{ new Date(arr.schedules_dates+' '+arr.assignschedules_timein).toLocaleTimeString() }}</small> <!--If On Time-->

                                                    <small v-if="arr.assignschedules_status == 7" >Clockin: {{ new Date(arr.schedules_dates+' '+arr.assignschedules_timein).toLocaleTimeString() }} <span class="text-danger">Clocked in Late</span></small><!--if Late-->

                                                    <small v-if="arr.assignschedules_status == 8" >Clockin: {{ new Date(arr.schedules_dates+' '+arr.assignschedules_timein).toLocaleTimeString() }} <span class="text-danger">Missing Clock In</span></small><!--if not yet Clocked In-->

                                                    <small v-if="arr.assignschedules_status == 0 || arr.assignschedules_status == null " >Clockin: {{ arr.assignschedules_timein }}</small>

                                                    <small v-if=" arr.assignschedules_status == 5 && arr.assignschedules_timeout != null">Clockout: {{ new Date(arr.schedules_dates+' '+arr.assignschedules_timeout).toLocaleTimeString() }}</small> 
                                                    <small v-if="arr.assignschedules_status == 5">Clockout: <span class="text-danger">Missing ClockOut</span></small>
                                                    <small v-else>Clockout: </small>
                                                    <small>{{ new Date(arr.schedules_dates+' '+arr.schedules_timestart).toLocaleTimeString() }} - {{new Date(arr.schedules_dates+' '+arr.schedules_timeend).toLocaleTimeString()}}</small>
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
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.assignschedules_id)">Edit Clockin / Clockout</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--IF NO PROBLEM SA CLOCKIN-->
                                        <div class="bd-callout mt-4 bd-callout-warning" v-if="arr.assignschedules_status == 7">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.employee_profilepicture != 'https://www.4angelshc.com/mobile/filesystem/'" class="mr-3 img-fluid rounded" :src="arr.employee_profilepicture"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/users.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">{{ arr.employee_firstname }} {{arr.employee_lastname}} <small>rate: {{ arr.assigndesignation_wagerate }} </small>

                                                    <small v-if="arr.assignschedules_status == 6" >Clockin: {{ new Date(arr.schedules_dates+' '+arr.assignschedules_timein).toLocaleTimeString() }}</small> <!--If On Time-->

                                                    <small v-if="arr.assignschedules_status == 7" >Clockin: {{ new Date(arr.schedules_dates+' '+arr.assignschedules_timein).toLocaleTimeString() }} <span class="text-danger">Clocked in Late</span></small><!--if Late-->

                                                    <small v-if="arr.assignschedules_status == 8" >Clockin: {{ new Date(arr.schedules_dates+' '+arr.assignschedules_timein).toLocaleTimeString() }} <span class="text-danger">Missing Clock In</span></small><!--if not yet Clocked In-->

                                                    <small v-if="arr.assignschedules_status == 0 || arr.assignschedules_status == null " >Clockin: {{ new Date(arr.schedules_dates+' '+arr.assignschedules_timein).toLocaleTimeString() }}</small><!--if not yet Clocked In-->
                                                    <small v-if=" arr.assignschedules_status == 5 && arr.assignschedules_timeout != null">Clockout: {{ new Date(arr.schedules_dates+' '+arr.assignschedules_timeout).toLocaleTimeString() }}</small> 
                                                    <small v-if="arr.assignschedules_status == 5">Clockout: <span class="text-danger">Missing ClockOut</span></small>
                                                    <small v-else>Clockout: </small>
                                                    <small>{{ new Date(arr.schedules_dates+' '+arr.schedules_timestart).toLocaleTimeString() }} - {{new Date(arr.schedules_dates+' '+arr.schedules_timeend).toLocaleTimeString()}}</small>
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
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.assignschedules_id)">Edit Clockin / Clockout</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bd-callout mt-4 bd-callout-danger" v-if="arr.assignschedules_status == 8">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.employee_profilepicture != 'https://www.4angelshc.com/mobile/filesystem/'" class="mr-3 img-fluid rounded" :src="arr.employee_profilepicture"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/users.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">{{ arr.employee_firstname }} {{arr.employee_lastname}} <small>rate: {{ arr.assigndesignation_wagerate }} </small>

                                                    <small v-if="arr.assignschedules_status == 6" >Clockin: {{ arr.assignschedules_timein }}</small> <!--If On Time-->

                                                    <small v-if="arr.assignschedules_status == 7" >Clockin: {{ arr.assignschedules_timein }} <span class="text-danger">Clocked in Late</span></small><!--if Late-->

                                                    <small v-if="arr.assignschedules_status == 8" >Clockin: {{ arr.assignschedules_timein }} <span class="text-danger">Missing Clock In</span></small><!--if not yet Clocked In-->

                                                    <small v-if="arr.assignschedules_status == 0 || arr.assignschedules_status == null " >Clockin: {{ arr.assignschedules_timein }}</small><!--if not yet Clocked In-->
                                                    <small v-if=" arr.assignschedules_status == 5 && arr.assignschedules_timeout != null">Clockout: {{ new Date(arr.schedules_dates+' '+arr.assignschedules_timeout).toLocaleTimeString() }}</small> 
                                                    <small v-if="arr.assignschedules_status == 5">Clockout: <span class="text-danger">Missing ClockOut</span></small>
                                                    <small v-else>Clockout: </small>
                                                    <small>{{ new Date(arr.schedules_dates+' '+arr.schedules_timestart).toLocaleTimeString() }} - {{new Date(arr.schedules_dates+' '+arr.schedules_timeend).toLocaleTimeString()}}</small>
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
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.assignschedules_id)">Edit Clockin / Clockout</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--Missing Clock In-->
                                        <div class="bd-callout mt-4 bd-callout-primary" v-if="(arr.assignschedules_status < 5)">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.employee_profilepicture != 'https://www.4angelshc.com/mobile/filesystem/'" class="mr-3 img-fluid rounded" :src="arr.employee_profilepicture"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/users.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">{{ arr.employee_firstname }} {{arr.employee_lastname}} <small>rate: {{ arr.assigndesignation_wagerate }} </small>

                                                    <small v-if="arr.assignschedules_status == 6" >Clockin: {{ arr.assignschedules_timein }}</small> <!--If On Time-->

                                                    <small v-if="arr.assignschedules_status == 7" >Clockin: {{ arr.assignschedules_timein }} <span class="text-danger">Clocked in Late</span></small><!--if Late-->

                                                    <small v-if="arr.assignschedules_status == 8" >Clockin: {{ arr.assignschedules_timein }} <span class="text-danger">Missing Clock In</span></small><!--if not yet Clocked In-->

                                                    <small v-if="arr.assignschedules_status == 0 || arr.assignschedules_status == null " >Clockin: {{ arr.assignschedules_timein }}</small><!--if not yet Clocked In-->

                                                    <small v-if=" arr.assignschedules_status == 5 && arr.assignschedules_timeout != null">Clockout: {{ new Date(arr.schedules_dates+' '+arr.assignschedules_timeout).toLocaleTimeString() }}</small> 
                                                    <small v-if="arr.assignschedules_status == 5">Clockout: <span class="text-danger">Missing ClockOut</span></small>
                                                    <small v-else>Clockout: </small>
                                                    <small>{{ new Date(arr.schedules_dates+' '+arr.schedules_timestart).toLocaleTimeString() }} - {{new Date(arr.schedules_dates+' '+arr.schedules_timeend).toLocaleTimeString()}}</small>
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
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.assignschedules_id)">Edit Clockin / Clockout</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--wala pay time in-->
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
                                    <div v-for="arr in assignschedules">
                                        <div class="bd-callout mt-4 bd-callout-danger" v-if="arr.assignschedules_status == 5 && arr.assignschedules_timeout == '' ||arr.assignschedules_status == 5 && arr.assignschedules_timein == '' || arr.assignschedules_status == 5 && arr.assignschedules_timeout == null ||arr.assignschedules_status == 5 && arr.assignschedules_timein == null ">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.employee_profilepicture != 'https://www.4angelshc.com/mobile/filesystem/'" class="mr-3 img-fluid rounded" :src="arr.employee_profilepicture"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/users.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">{{ arr.employee_firstname }} {{arr.employee_lastname}}<small>rate: {{ arr.assignschedules_lastrecordrate }} </small>
                                                    <small v-if="arr.assignschedules_timein != null" >Clockin: {{ new Date(arr.schedules_dates+" "+arr.assignschedules_timein).toLocaleTimeString() }}</small>
                                                    <small v-else>Clockin:<span class="text-danger"> No Clockin </span></small>
                                                    <small v-if="arr.assignschedules_timeout != null">Clockout: {{  new Date(arr.schedules_dates+" "+arr.assignschedules_timeout).toLocaleTimeString() }}</small> 
                                                    <small v-else>Clockout: <span class="text-danger"> No Clockout </span></small>
                                                    <small>{{ new Date(arr.schedules_dates+" "+arr.schedules_timestart).toLocaleTimeString() }} - {{ new Date(arr.schedules_dates+" "+arr.schedules_timeend).toLocaleTimeString() }} </small>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Total Hours
                                                    <p class="d-flex justify-content-center" v-if="arr.assignschedules_totalhours != null || arr.assignschedules_totalhours != ''"> {{ parseFloat(arr.assignschedules_totalhours).toFixed(2) }} </p>
                                                    <p class="d-flex justify-content-center" v-else>0</p>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Wages
                                                    <p class="d-flex justify-content-center" v-if="arr.assignschedules_totalwage != null || arr.assignschedules_totalwage != ''">${{ parseFloat(arr.assignschedules_totalwage).toFixed(2) }}</p>
                                                    <p class="d-flex justify-content-center" v-else>0</p>
                                                </div>
                                                <div>
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.assignschedules_id)">Edit Clockin / Clockout</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bd-callout mt-4 bd-callout-success" v-if="arr.assignschedules_status == 5 && arr.assignschedules_timeout != null && arr.assignschedules_timein != null">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.employee_profilepicture != 'https://www.4angelshc.com/mobile/filesystem/'" class="mr-3 img-fluid rounded" :src="arr.employee_profilepicture"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/users.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">{{ arr.employee_firstname }} {{arr.employee_lastname}}<small>rate: {{ arr.assignschedules_lastrecordrate }} </small>
                                                    <small v-if="arr.assignschedules_timein != null" >Clockin: {{ new Date(arr.schedules_dates+" "+arr.assignschedules_timein).toLocaleTimeString() }}</small>
                                                    <small v-else>Clockin:<span class="text-danger"> No Clockin </span></small>
                                                    <small v-if="arr.assignschedules_timeout != null">Clockout: {{  new Date(arr.schedules_dates+" "+arr.assignschedules_timeout).toLocaleTimeString() }}</small> 
                                                    <small v-else>Clockout: <span class="text-danger"> No Clockout </span></small>
                                                    <small>{{ new Date(arr.schedules_dates+" "+arr.schedules_timestart).toLocaleTimeString() }} - {{ new Date(arr.schedules_dates+" "+arr.schedules_timeend).toLocaleTimeString() }} </small>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Total Hours
                                                    <p class="d-flex justify-content-center" v-if="arr.assignschedules_totalhours != null || arr.assignschedules_totalhours != ''"> {{ parseFloat(arr.assignschedules_totalhours).toFixed(2) }} </p>
                                                    <p class="d-flex justify-content-center" v-else>0</p>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    Wages
                                                    <p class="d-flex justify-content-center" v-if="arr.assignschedules_totalwage != null || arr.assignschedules_totalwage != ''">${{ parseFloat(arr.assignschedules_totalwage).toFixed(2) }}</p>
                                                    <p class="d-flex justify-content-center" v-else>0</p>
                                                </div>
                                                <div>
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.assignschedules_id)">Edit Clockin / Clockout</a>
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
import { axios , validateForm,lStore } from '@/functions.js';

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
        }
    },
    mounted(){
        
        this.datetoday = new Date().toLocaleString();

        axios.post("branches?_batch=true").catch(res=>{
        }).then(res=>{
            this.totalfacility = res.data.result.length;
        });
        axios.post("employee?_batch=true").catch(res=>{
        }).then(res=>{
            let obj = {};
            res.data.result.forEach(element => {
                if(element.users_permission_status == 2)
                {
                    obj = element;
                    this.users.push(obj);
                }
            });
            this.totalsupervisor = this.users.length;
            this.users = [];
            obj = {};
            res.data.result.forEach(element => {
                if(element.users_permission_status == 3)
                {
                    obj = element;
                    this.users.push(obj);
                }
            });
            this.totalmanagers = this.users.length;
        });
        
        axios.post("branches?facility_id="+lStore.get("selected_facilityId")).catch(res=>{

        }).then(res=>{
            if(res.data.success)
            {
                this.branch = res.data.result;
            }
        });
        this.gethourlydata();
        setInterval(() => {
            this.gethourlydata();
        }, 3000);
    },
    methods:{
        cleardata(){
            this.assignschedid = "";
            this.assignschedclockin = "";
            this.assignschedclockout = "";
        },
        gethourlydata(){
            axios.post("assigned?schedules_facilityid="+lStore.get("selected_facilityId")+"&_joins=assignschedules,assigndesignation,employee&_on=assignschedules_scheduleid=schedules_id,assigndesignation_id=assignschedules_assigndesignationid,employee_id=assigndesignation_employeeid&_batch=true").catch(res=>{

            }).then(res=>{
                if(res.data.result == null)
                {
                    return;
                }
                if(res.data.success)
                {
                    this.totalhoursb = 0;
                    this.totalwageb = 0;
                    this.assignschedules = [];
                    let allarr = [];
                    allarr = res.data.result;
                    allarr.forEach(element => {
                        //first checking if ang data is karon nga date
                        if(new Date(element.schedules_dates).toLocaleDateString() == new Date().toLocaleDateString())
                        {
                            // console.log(new Date().toLocaleTimeString(),element.schedules_timeend+'|'+ new Date(element.schedules_dates+" "+element.schedules_timeend).getTime(), new Date().getTime());
                            if(new Date(element.schedules_dates+" "+element.schedules_timeend).getTime() < new Date().getTime() && element.assignschedules_status != 5)
                            {
                                element.assignschedules_status = 5;
                                let scheduleDate = element.schedules_dates;
                                let scheduleTimeStart = element.schedules_timestart;
                                let scheduleTimeEnd = element.schedules_timeend;
                                let clockTimeEnd = element.assignschedules_timeout;
                                let clockTimeStart = element.assignschedules_timein;

                                let schedStart = new Date(scheduleDate+' '+scheduleTimeStart);
                                let schedEnd = new Date(scheduleDate+' '+scheduleTimeEnd);
                                let clockStart = new Date(scheduleDate+' '+clockTimeStart);
                                let clockEnd = new Date(scheduleDate+' '+clockTimeEnd);
                                let scheduleTomorrowDateObj = new Date(scheduleDate+' '+scheduleTimeStart);
                                scheduleTomorrowDateObj.setDate(scheduleTomorrowDateObj.getDate() + 1);

                                const dayHrs = 1000 * 60 * 60;

                                //checks if schedule end time is smaller than schedule start time. if yes, adds 1 day to schedule end datetime
                                if(schedEnd.getTime() < schedStart.getTime()) {
                                    //if clock in time is smaller than clock out time, this checks if the clockin time is smaller than clock out time, if yes, adds 1 day to clock in (meaning the user clocked in in date after the scheduled date)
                                if(clockStart.getTime() < clockEnd.getTime()){
                                    clockStart.setDate(clockStart.getDate() + 1);
                                }
                                
                                //if clock out time is smaller than schedule start time, adds 1 day to clock out datetime
                                if(clockEnd.getTime() < schedStart.getTime()) {
                                    clockEnd.setDate(clockEnd.getDate() + 1);
                                }

                                    schedEnd.setDate(schedEnd.getDate() + 1);
                                }



                                let lateHours = 0;
                                let overHours = 0;
                                let underHours = 0;
                                let regularHours = (schedEnd.getTime() - schedStart.getTime()) / dayHrs;



                                if(clockStart.getTime() > schedStart.getTime()){
                                    lateHours = (clockStart.getTime() - schedStart.getTime()) / dayHrs;
                                }

                                if(clockEnd.getTime() > schedEnd.getTime()){
                                    overHours = (clockEnd.getTime() - schedEnd.getTime()) / dayHrs;
                                }

                                if(schedEnd.getTime() > clockEnd.getTime()){
                                    underHours = (schedEnd.getTime() - clockEnd.getTime()) / dayHrs;
                                }

                                regularHours = regularHours - (lateHours + underHours);

                                // console.log(regularHours,lateHours,underHours);

                                if(regularHours <= 0.5) regularHours = 0;
                                if(clockTimeStart == null || clockTimeEnd == null)
                                {
                                    regularHours = 0;
                                }

                                

                                
                                element.assignschedules_totalhours = regularHours;
                                element.assignschedules_totalwage = regularHours * element.assigndesignation_wagerate;
                                element.assignschedules_lastrecordrate = element.assigndesignation_wagerate;
                                axios.post("assigned/update?id="+element.assignschedules_id,null,{assignschedules_status: 5,assignschedules_totalhours: element.assignschedules_totalhours, assignschedules_totalwage: element.assignschedules_totalwage,assignschedules_lastrecordrate: element.assigndesignation_wagerate}).catch(res=>{

                                }).then(res=>{

                                });
                            }
                            else if(new Date(element.schedules_dates+" "+element.schedules_timeend).getTime() >= new Date().getTime() && element.assignschedules_status != 5 && element.assignschedules_timeout != null)
                            {
                                element.assignschedules_status = 5;
                                let scheduleDate = element.schedules_dates;
                                let scheduleTimeStart = element.schedules_timestart;
                                let scheduleTimeEnd = element.schedules_timeend;
                                let clockTimeEnd = element.assignschedules_timeout;
                                let clockTimeStart = element.assignschedules_timein;

                                let schedStart = new Date(scheduleDate+' '+scheduleTimeStart);
                                let schedEnd = new Date(scheduleDate+' '+scheduleTimeEnd);
                                let clockStart = new Date(scheduleDate+' '+clockTimeStart);
                                let clockEnd = new Date(scheduleDate+' '+clockTimeEnd);
                                let scheduleTomorrowDateObj = new Date(scheduleDate+' '+scheduleTimeStart);
                                scheduleTomorrowDateObj.setDate(scheduleTomorrowDateObj.getDate() + 1);

                                const dayHrs = 1000 * 60 * 60;

                                //checks if schedule end time is smaller than schedule start time. if yes, adds 1 day to schedule end datetime
                                if(schedEnd.getTime() < schedStart.getTime()) {
                                    //if clock in time is smaller than clock out time, this checks if the clockin time is smaller than clock out time, if yes, adds 1 day to clock in (meaning the user clocked in in date after the scheduled date)
                                if(clockStart.getTime() < clockEnd.getTime()){
                                    clockStart.setDate(clockStart.getDate() + 1);
                                }
                                
                                //if clock out time is smaller than schedule start time, adds 1 day to clock out datetime
                                if(clockEnd.getTime() < schedStart.getTime()) {
                                    clockEnd.setDate(clockEnd.getDate() + 1);
                                }

                                    schedEnd.setDate(schedEnd.getDate() + 1);
                                }



                                let lateHours = 0;
                                let overHours = 0;
                                let underHours = 0;
                                let regularHours = (schedEnd.getTime() - schedStart.getTime()) / dayHrs;



                                if(clockStart.getTime() > schedStart.getTime()){
                                    lateHours = (clockStart.getTime() - schedStart.getTime()) / dayHrs;
                                }

                                if(clockEnd.getTime() > schedEnd.getTime()){
                                    overHours = (clockEnd.getTime() - schedEnd.getTime()) / dayHrs;
                                }

                                if(schedEnd.getTime() > clockEnd.getTime()){
                                    underHours = (schedEnd.getTime() - clockEnd.getTime()) / dayHrs;
                                }

                                regularHours = regularHours - (lateHours + underHours);

                                if(regularHours <= 0.01)regularHours = 0;

                                
                                element.assignschedules_totalhours = regularHours;
                                element.assignschedules_totalwage = regularHours * element.assigndesignation_wagerate;
                                element.assignschedules_lastrecordrate = element.assigndesignation_wagerate;
                                axios.post("assigned/update?id="+element.assignschedules_id,null,{assignschedules_status: 5,assignschedules_totalhours: element.assignschedules_totalhours, assignschedules_totalwage: element.assignschedules_totalwage,assignschedules_lastrecordrate: element.assigndesignation_wagerate}).catch(res=>{

                                }).then(res=>{

                                });
                            }
                            if(element.assignschedules_timein == null && new Date(element.schedules_dates+' '+new Date().toLocaleTimeString('en-US',{hour12:false,hour:'numeric',minute:'2-digit',second:'2-digit'})).getTime() > (new Date(element.schedules_dates+' '+element.schedules_timestart).getTime()+1*60000) && element.assignschedules_status != 2)
                            {
                                axios.post("assigned/update?id="+element.assignschedules_id,null,{assignschedules_status: 8}).catch(res=>{

                                }).then(res=>{
                                    return;
                                });
                            }


                            if(element.assignschedules_totalhours == null || element.assignschedules_totalwage == null)
                            {
                                this.totalhoursb = parseFloat(this.totalhoursb) + parseFloat(0);
                                this.totalwageb = parseFloat(this.totalwageb) + parseFloat(0);
                            }
                            this.totalhoursb = parseFloat(this.totalhoursb) + parseFloat(element.assignschedules_totalhours);
                            this.totalwageb = parseFloat(this.totalwageb) + parseFloat(element.assignschedules_totalwage);
                            this.assignschedules.push(element);
                        }
                    });
                }
                else
                {
                    return;
                }
            });
        },
        GetClockinorClockout(data){
            axios.post('assignschedule?assignschedules_id='+data,null,{}).catch(res=>{

            }).then(res=>{
                if(res.data.success)
                {
                    this.assignschedid = res.data.result.assignschedules_id;
                    this.assignschedclockin = res.data.result.assignschedules_timein;
                    this.assignschedclockout = res.data.result.assignschedules_timeout;
                }
                else
                {
                    return;
                }
            })
        },
        EditClockin(data){

            axios.post('assignschedule/update?id='+data,null,{assignschedules_timein: this.assignschedclockin, assignschedules_timeout: this.assignschedclockout}).catch(res=>{

            }).then(res=>{
                if(res.data.success)
                {
                    this.assignschedid = "";
                    this.assignschedclockin = "";
                    this.assignschedclockout = "";
                    document.querySelector('#addClockinModalForm').style.display = "none";
                    setTimeout(() => {
                        this.$router.go(0);
                    }, 2000);
                }
                else
                {
                    return;
                }
            })
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