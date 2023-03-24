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
                            <h6>{{ Math.floor(viewemployeeclock.clock_event_totalacthour) }} hrs {{ Math.round(parseFloat(viewemployeeclock.clock_event_totalacthour) *60) }}m • {{ new Date(viewemployeeclock.clock_event_intime).toLocaleTimeString() }} - {{ new Date(viewemployeeclock.clock_event_outtime).toLocaleTimeString() }}</h6>
                            <h6>Scheduled: {{ Math.floor(viewemployeeclock.schedule_detail_hours) }} hrs {{ Math.round(parseFloat(viewemployeeclock.schedule_detail_hours) * 60) }} min ({{ new Date(viewemployeeclock.schedule_detail_date +' '+viewemployeeclock.schedule_detail_start_time).toLocaleTimeString() }} - {{ new Date(viewemployeeclock.schedule_detail_date+' '+viewemployeeclock.schedule_detail_end_time).toLocaleTimeString() }})</h6>
                        </div>
                        <div class="space">
                            <h5>GPS Validation</h5>
                            <h6><a :href="'https://www.google.com/maps/@?api=1&map_action=pano&viewpoint='+viewemployeeclock.clock_event_inlat+'%2C'+viewemployeeclock.clock_event_inlong+'&heading=-45&pitch=38&fov=80'" target="_blank">View Clockin Location</a></h6>
                            <h6><a :href="'https://www.google.com/maps/@?api=1&map_action=pano&viewpoint='+viewemployeeclock.clock_event_outlat+'%2C'+viewemployeeclock.clock_event_outlong+'&heading=-45&pitch=38&fov=80'" target="_blank">View Clockout Location</a></h6>
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
                        <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-pill" @click="EditClockout()" data-dismiss="modal"> Save Changes</button>
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
                <div class="mr-4 text-secondary" v-if="totalShoursb != null"><h5>Total Scheduled Hours</h5><h4 class="d-flex justify-content-center">{{totalShoursb.toFixed(2)}}</h4></div>
                <div class="mr-4 text-secondary" v-if="totalAhoursb != null"><h5>Total Actual Hours</h5><h4 class="d-flex justify-content-center">{{totalAhoursb.toFixed(2)}}</h4></div>
                <div class="mr-4 text-secondary" v-if="totalRhoursb != null"><h5>Total Paid Hours</h5><h4 class="d-flex justify-content-center">{{totalRhoursb.toFixed(2)}}</h4></div>
                <div class="mr-4 text-secondary" v-if="totalwageb != null"><h5>Total Wages Today</h5> <h4 class="d-flex ju{{parseFloat(arr.clock_event_totalacthour).toFixed(2)}}stify-content-center">${{totalwageb.toFixed(2)}}</h4></div>
                <!-- <div class="date-range-report text-secondary d-flex align-items-cent{{parseFloat(arr.clock_event_totalwage).toFixed(2)}}er">
                    <input type="date" class="form-control datepick" v-model="datetoday">
                    <button class="btn btn-success" @click="SearchRecordData"><p class="mdi mdi-calendar-search"></p></button>
                </div> -->
            </div>
        </div>
        <div class="card card-default mt-3">
            <div class="card-body">
                <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#NowUpComming" role="tab" aria-controls="settings" aria-selected="false">Now & Upcoming ({{ nowup }})</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#Complete" role="tab" aria-controls="timeline" aria-selected="true">Completed ({{ complte }})</a>
                    </li>
                </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="NowUpComming" role="tabpanel" aria-labelledby="settings-tab">
                            <div class="tab-pane-content">
                                <small class="d-flex justify-content-center text-default">{{ new Date().toLocaleTimeString('en-US',{timeZone: "America/New_York"}) }}</small>
                                <div v-if="nowup === 0">
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
                                                    <img v-if="arr.user_photo != ''" class="mr-3 img-fluid rounded-circle" :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+arr.user_photo"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/default-profile.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">
                                                    <div class="d-flex">
                                                        {{ arr.user_firstname }} {{arr.user_lastname}}<small class="d-flex pl-2 align-items-center"><div :style="'width: 10px; height:10px; background-color:'+ arr.role_color+';'"></div></small> <small class="d-flex pl-2 align-items-center">{{ arr.role_name }}</small>
                                                    </div>
                                                    <div class="d-flex">
                                                        <small>Clockin: {{ new Date(arr.clock_event_intime).toLocaleTimeString({
                        timeZone: "America/New_York",}) }}</small>
                                                        <small>Clockout: </small>
                                                    </div>
                                                    <div class="d-flex">
                                                        <small>{{parseFloat(arr.clock_event_totalacthour).toFixed(2)}} hours worked</small>
                                                        <small class="d-flex pl-2 align-items-center">{{ new Date(arr.schedule_detail_date+' '+arr.schedule_detail_start_time).toLocaleTimeString({
                        timeZone: "America/New_York",}) }} - {{new Date(arr.schedule_detail_date+' '+arr.schedule_detail_end_time).toLocaleTimeString({
                        timeZone: "America/New_York",})}}</small>
                                                    </div>
                                                    <small><span class="text-primary">Ongoing</span></small>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockin</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockoutModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockout</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#ViewClockModalForm" @click="GetEmployeeScheduleDetails(arr.clock_event_id)">View Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-for="arr in assignschedules.yellow">
                                        <div class="bd-callout mt-4 bd-callout-warning">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.user_photo != ''" class="mr-3 img-fluid rounded-circle" :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+arr.user_photo"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/default-profile.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">
                                                    <div class="d-flex">
                                                        {{ arr.user_firstname }} {{arr.user_lastname}}<small class="d-flex pl-2 align-items-center"><div :style="'width: 10px; height:10px; background-color:'+ arr.role_color+';'"></div></small> <small class="d-flex pl-2 align-items-center">{{ arr.role_name }}</small>
                                                    </div>
                                                    <div class="d-flex">
                                                        <small v-if="arr.clock_event_isclockin == 0 || arr.clock_event_isclockin == null" >Clockin:<span class="text-danger"> Missing Clockin</span> </small> <!--If On Time-->
                                                        <small v-else>Clockin: {{ new Date(arr.clock_event_intime).toLocaleTimeString({
                        timeZone: "America/New_York",}) }} <span class="text-danger">Clockin Late</span></small>
                                                        <small>Clockout: </small>
                                                    </div>
                                                    <div class="d-flex">
                                                        <small>{{parseFloat(arr.clock_event_totalacthour).toFixed(2)}} hours worked</small>
                                                        <small class="d-flex pl-2 align-items-center">{{ new Date(arr.schedule_detail_date+' '+arr.schedule_detail_start_time).toLocaleTimeString({
                        timeZone: "America/New_York",}) }} - {{new Date(arr.schedule_detail_date+' '+arr.schedule_detail_end_time).toLocaleTimeString({
                        timeZone: "America/New_York",})}}</small>
                                                    </div>
                                                    <small><span class="text-primary">Ongoing</span></small>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockin</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockoutModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockout</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#ViewClockModalForm" @click="GetEmployeeScheduleDetails(arr.clock_event_id)">View Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-for="arr in assignschedules.red">
                                        <div class="bd-callout mt-4 bd-callout-danger">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.user_photo != ''" class="mr-3 img-fluid rounded-circle" :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+arr.user_photo"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/default-profile.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">
                                                    <div class="d-flex">
                                                        {{ arr.user_firstname }} {{arr.user_lastname}}<small class="d-flex pl-2 align-items-center"><div :style="'width: 10px; height:10px; background-color:'+ arr.role_color+';'"></div></small> <small class="d-flex pl-2 align-items-center">{{ arr.role_name }}</small>
                                                    </div>
                                                    <div class="d-flex">
                                                        <small v-if="arr.clock_event_isclockin == 0 || arr.clock_event_isclockin == null" > Clockin:<span class="text-danger"> Missing Clockin </span> </small>
                                                        <small v-else> Clockin: {{ new Date(arr.clock_event_intime).toLocaleTimeString({
                        timeZone: "America/New_York",}) }}</small>
                                                        <small class="d-flex pl-2 align-items-center">Clockout: </small>
                                                    </div>
                                                    <div class="d-flex">
                                                        <small>{{parseFloat(arr.clock_event_totalacthour).toFixed(2)}} hours worked</small>
                                                        <small class="d-flex pl-2 align-items-center">{{ new Date(arr.schedule_detail_date+' '+arr.schedule_detail_start_time).toLocaleTimeString({
                        timeZone: "America/New_York",}) }} - {{new Date(arr.schedule_detail_date+' '+arr.schedule_detail_end_time).toLocaleTimeString({
                        timeZone: "America/New_York",})}}</small>
                                                    </div>
                                                    <small><span class="text-primary">Ongoing</span></small>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockin</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockoutModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockout</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#ViewClockModalForm" @click="GetEmployeeScheduleDetails(arr.clock_event_id)">View Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-for="arr in assignschedules.gray">
                                        <div class="bd-callout mt-4 bd-callout-default">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.user_photo != ''" class="mr-3 img-fluid rounded-circle" :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+arr.user_photo"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/default-profile.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">
                                                    <div class="d-flex">
                                                        {{ arr.user_firstname }} {{arr.user_lastname}}<small class="d-flex pl-2 align-items-center"><div :style="'width: 10px; height:10px; background-color:'+ arr.role_color+';'"></div></small> <small class="d-flex pl-2 align-items-center">{{ arr.role_name }}</small>
                                                    </div>
                                                    <div class="d-flex">
                                                        <small>Clockin:</small>
                                                        <small class="d-flex pl-2 align-items-center">Clockout: </small> 
                                                    </div>
                                                    <div class="d-flex">
                                                        <small>{{parseFloat(arr.clock_event_totalacthour).toFixed(2)}} hours worked</small>
                                                        <small class="d-flex pl-2 align-items-center">{{ new Date(arr.schedule_detail_date+' '+arr.schedule_detail_start_time).toLocaleTimeString({
                        timeZone: "America/New_York",}) }} - {{new Date(arr.schedule_detail_date+' '+arr.schedule_detail_end_time).toLocaleTimeString({
                        timeZone: "America/New_York",})}}</small>
                                                    </div>
                                                    <small><span class="text-primary"> Upcoming</span></small>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockin</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockoutModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockout</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#ViewClockModalForm" @click="GetEmployeeScheduleDetails(arr.clock_event_id)">View Details</a>
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
                                <small class="d-flex justify-content-center text-default">{{ new Date().toLocaleTimeString('en-US',{timeZone: "America/New_York"}) }}</small>
                                <div v-if="complte == 0">
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
                                                    <img v-if="arr.user_photo != ''" class="mr-3 img-fluid rounded-circle" :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+arr.user_photo"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/default-profile.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">
                                                    <div class="d-flex">
                                                        {{ arr.user_firstname }} {{arr.user_lastname}}<small class="d-flex pl-2 align-items-center"><div :style="'width: 10px; height:10px; background-color:'+ arr.role_color+';'"></div></small> <small class="d-flex pl-2 align-items-center">{{ arr.role_name }}</small>
                                                    </div>
                                                    <div class="d-flex">
                                                        <small>Clockin: {{ new Date(arr.clock_event_intime).toLocaleTimeString({
                        timeZone: "America/New_York",}) }}</small>
                                                        <small class="d-flex pl-2 align-items-center">Clockout: {{ new Date(arr.clock_event_outtime).toLocaleTimeString({
                        timeZone: "America/New_York",}) }} </small> 
                                                    </div>
                                                    <div class="d-flex">
                                                        <small>{{parseFloat(arr.clock_event_totalacthour).toFixed(2)}} hours worked</small>
                                                        <small class="d-flex pl-2 align-items-center">{{ new Date(arr.schedule_detail_date+' '+arr.schedule_detail_start_time).toLocaleTimeString({
                        timeZone: "America/New_York",}) }} - {{new Date(arr.schedule_detail_date+' '+arr.schedule_detail_end_time).toLocaleTimeString({
                        timeZone: "America/New_York",})}}</small>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockin</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockoutModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockout</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#ViewClockModalForm" @click="GetEmployeeScheduleDetails(arr.clock_event_id)">View Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="bd-callout mt-4 bd-callout-danger">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <img v-if="arr.user_photo != ''" class="mr-3 img-fluid rounded-circle" :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+arr.user_photo"/>
                                                    <img v-else class="mr-3 img-fluid rounded" src="../../assets/default-profile.png"/>
                                                    <div class="d-flex flex-column font-weight-bold">
                                                    <div class="d-flex">
                                                        {{ arr.user_firstname }} {{arr.user_lastname}}<small class="d-flex pl-2 align-items-center"><div :style="'width: 10px; height:10px; background-color:'+ arr.role_color+';'"></div></small> <small class="d-flex pl-2 align-items-center">{{ arr.role_name }}</small>
                                                    </div>
                                                    <div class="d-flex">
                                                        
                                                        <small v-if="arr.clock_event_isclockin != 0 || arr.clock_event_isclockin != null">Clockin: {{ new Date(arr.clock_event_intime).toLocaleTimeString({
                        timeZone: "America/New_York",}) }}</small>
                                                        <small v-else>Clockin: <span class="text-danger"> Missing Clockin</span></small>
                                                        <small v-if="arr.clock_event_isclockout != 0 || arr.clock_event_isclockout != null" class="d-flex pl-2 align-items-center">Clockout: {{ new Date(arr.clock_event_outtime).toLocaleTimeString({
                        timeZone: "America/New_York",}) }} </small>
                                                        <small v-else class="d-flex pl-2 align-items-center">Clockout: <span class="text-danger"> Missing Clockout</span></small>
                                                    </div>
                                                    <div class="d-flex">
                                                        <small>{{parseFloat(arr.clock_event_totalacthour).toFixed(2)}} hours worked</small>
                                                        <small class="d-flex pl-2 align-items-center">{{ new Date(arr.schedule_detail_date+' '+arr.schedule_detail_start_time).toLocaleTimeString({
                        timeZone: "America/New_York",}) }} - {{new Date(arr.schedule_detail_date+' '+arr.schedule_detail_end_time).toLocaleTimeString({
                        timeZone: "America/New_York",})}}</small>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockinModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockin</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#addClockoutModalForm" @click="GetClockinorClockout(arr.clock_event_id)">Edit Clockout</a>
                                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#ViewClockModalForm" @click="GetEmployeeScheduleDetails(arr.clock_event_id)">View Details</a>
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
import toastr from 'toastr';

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
            totalAhoursb: 0,
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
            nowup: "",
            totalShoursb: 0,
            complte: "",
            schedassignid: "",
            totalRhoursb: 0,
            viewemployeeclock: [],
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
                console.log(res.data.result);
                if(res.data.success){
                    this.assignschedules = res.data.result;
                    this.nowup = this.assignschedules.red.length + this.assignschedules.green.length + this.assignschedules.gray.length + this.assignschedules.yellow.length;
                    this.complte = this.assignschedules.complete.length;
                    this.totalShoursb = this.assignschedules.totalschedhours;
                    this.totalAhoursb = this.assignschedules.totalacthours;
                    this.totalRhoursb = this.assignschedules.totalreghours;
                    this.totalwageb = this.assignschedules.totalwage;
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
                }else{
                    this.callToaster("toast-top-right",res.data);
                    this.cleardata();
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
                }else{
                    this.callToaster("toast-top-right",res.data);
                }
            });
        },
        cleardata(){
            this.assignschedclockout = "";
            this.assignschedclockin = "";
            this.schedassignid = "";
        },
        clearModal(modalname){
            const exampleModalForm = document.querySelector('#'+ modalname);
            exampleModalForm.removeAttribute('aria-modal');
            exampleModalForm.removeAttribute('role');
            exampleModalForm.setAttribute('aria-hidden', 'true');
            exampleModalForm.classList.remove('show');
            exampleModalForm.style.display = "none";
            exampleModalForm.style.paddingRight = "0";
            const bodyForm = document.querySelector('#body');
            bodyForm.classList.remove('modal-open');
            bodyForm.style.paddingRight = "0";
            const modalBackdrop = document.querySelector('.modal-backdrop');
            modalBackdrop.parentNode.removeChild(modalBackdrop);
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

.tab-content > .active
{
    display: block !important;
}

.img-fluid{
    width: 50px;
    height: 50px !important;
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
.space{
    margin-bottom: 20px;
    padding:20px;
    border: 1px solid #000;
}
</style>