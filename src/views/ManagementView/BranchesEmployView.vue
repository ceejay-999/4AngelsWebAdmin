<template>
    <LayoutView>
        <div class="toast" >

        </div>
        <div class="card card-default">
            <div class="card-body d-flex justify-content-between">
                <h5 class="card-title text-secondary">Facility Name</h5>
                <div class="mr-4 text-secondary"><h5>Paid Hours</h5></div>
                <div class="mr-4 text-secondary"><h5>Total Wages</h5></div>
                <div class="mr-4 text-"><h5><span class="mdi mdi-file-excel text-secondary">Export to Excel</span></h5></div>
                <div class="mr-4 text-"><h5><span class="mdi mdi-printer text-secondary">Print</span></h5></div>
                <div class="date-range-report text-secondary">
                    Nov, 30 2022
					<span></span>
				</div>
            </div>
        </div>

        <div class="card card-default">
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
                            <div class="bd-callout bd-callout-default d-flex justify-content-between">
                                <div class="d-flex flex-column">
                                    <div>image / name <small>role / rate</small></div>
                                    <small>clockin and clockout / Schedule</small>
                                </div>
                                <div>
                                    Hours lend
                                </div>
                                <div>
                                    Wages
                                </div>
                                <div></div>
                                <div>
                                    <div class="btn-group">
                                        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Add Clockin</a>
                                            <a class="dropdown-item" href="#">Edit Clockin</a>
                                            <a class="dropdown-item" href="#">Add Clockout</a>
                                            <a class="dropdown-item" href="#">Edit Clockout</a>
                                        </div>
                                    </div>
                                </div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="Complete" role="tabpanel" aria-labelledby="settings-tab">
                        <div class="tab-pane-content">
                            <div class="bd-callout bd-callout-default d-flex justify-content-between">
                                <div class="d-flex flex-column">
                                    <div>image / name <small>role / rate</small></div>
                                    <small>clockin and clockout / Schedule</small>
                                </div>
                                <div>
                                    Hours lend
                                </div>
                                <div>
                                    Wages
                                </div>
                                <div></div>
                                <div>
                                    <div class="btn-group">
                                        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Add Clockin</a>
                                            <a class="dropdown-item" href="#">Edit Clockin</a>
                                            <a class="dropdown-item" href="#">Add Clockout</a>
                                            <a class="dropdown-item" href="#">Edit Clockout</a>
                                        </div>
                                    </div>
                                </div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LayoutView>
</template>
<script>
import { lStore,axios,QueryBuilder, formatDateString } from '../../functions';
import mapboxgl from 'mapbox-gl';
import '@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css';

export default({
  name: 'LoginPage',
  data() {
      return{
        branches: {},
        mapToken: 'pk.eyJ1Ijoic3BlZWR5cmVwYWlyIiwiYSI6ImNsNWg4cGlzaDA3NTYzZHFxdm1iMTJ2cWQifQ.j_XBhRHLg-CcGzah7uepMA',
        schedules: [],
      };
  },
  mounted() {
    axios.post("assigned/joint?range=2022-01-01,2023-03-01&_batch=true").catch(res=>{

    }).then(res=>{
            this.branches = res.data.result;
            console.log(this.branches)
        
    });
    let q = new QueryBuilder('https://www.4angelshc.com/mobile/assigned');
    let dateToday = new Date();
    let dateTomm = new Date();
    dateTomm.setDate(dateTomm.getDate() + 1);
    let dateTodayString = formatDateString(String(dateToday.getFullYear())+'-'+String(dateToday.getMonth()+1)+'-'+String(String(dateToday.getDate()))).replaceAll(' ','');
    let dateTommString = formatDateString(String(dateTomm.getFullYear())+'-'+String(dateTomm.getMonth()+1)+'-'+String(String(dateTomm.getDate()))).replaceAll(' ','');

    q
    .select({
        mobile_schedule: ['id','title','shift_start','shift_end','shift_date','shift_date_end'],
        mobile_branches: ['name'],
        mobile_users: ['lastname','firstname','email_address'],
        mobile_designation:['position'],
        mobile_timerecord: ['location','time_in','time_out','location_out']
    })
    .join({
        mobile_schedule: ['mobile_assignedusers.schedule_id','mobile_schedule.id'],
        mobile_branches:['mobile_schedule.branch_id','mobile_branches.id'],
        mobile_users:['mobile_assignedusers.user_id','mobile_users.id'],
        mobile_designation:['mobile_users.designation_id','mobile_designation.id'],
        mobile_timerecord: ['mobile_assignedusers.schedule_id','mobile_timerecord.schedule_id'],
    })
    .compare({
        'mobile_schedule:shift_date': ['<=', dateTodayString]
    })
    .compare({
        'mobile_schedule:shift_date_end': ['>=', dateTodayString]
    })
    .where({
        'mobile_schedule:branch_id': 20
    })
    .order('mobile__schedule.shift__start','ASC')
    .batch()


    let ajax_url = q.toString();
    mapboxgl.accessToken = this.mapToken;
    axios.post("branches?id="+lStore.get('branchidemp')).catch(res=>{

    }).then(res=>{
            this.branches = res.data.result;
            console.log(this.branches)
        
    });
    
    document.querySelector(".toast").id = "";
        $('#hoverable-data-table').dataTable({
            aLengthMenu: [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
            emptyTable:     "No data available in table",
            rowReorder: {
            selector: 'td:nth-child(2)'
            },
            responsive: true,
            ajax : {
            url: ajax_url,
            dataSrc: 'result'
            },
            columns : [
            { data : "id" },
            { data : "firstname" },
            { data : "email_address" },
            { data : "position" },
            { data : "time_in"},
            { data : "time_out"},
            { data : "location"},
            { data : "location_out"},                                                
            ]
        });
    },
    methods : {
        async GetLocationOnGivenLatLong(lat,long){
            let data = await axios.get(`https://api.mapbox.com/geocoding/v5/mapbox.places/${long},${lat}.json?access_token=${mapboxgl.accessToken}`);
            let retdata = data.data.features[0].place_name;
            return " " + retdata;
        }
    }
});
</script>
<style scoped>
@import 'chosen-js/chosen.css';
@import '../../assets/scss/_card.scss';
@import '../../assets/scss/_breadcrumb.scss';
@import '../../assets/scss/_type.scss';
@import '../../assets/scss/_reboot.scss';
@import '../../assets/sleek.min.css';
@import '../../assets/plugins/daterangepicker/daterangepicker.css';

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
</style>