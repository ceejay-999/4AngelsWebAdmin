<template>
    <LayoutView>
        <div class="toast" >

        </div>
        <div class="breadcrumb-wrapper breadcrumb-contacts">
        <div>
            <h1>Assigned Employees</h1>    
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-0">
                <li class="breadcrumb-item">
                    <RouterLink to="/dashboard">
                    <span class="mdi mdi-home"></span>                
                    </RouterLink>
                </li>
                <li class="breadcrumb-item" aria-current="page"><RouterLink to="/branch">Facilities</RouterLink></li>
                <li class="breadcrumb-item" aria-current="page">Assigned Employees</li>
            </ol>
            </nav>
        </div>
        </div>
        <div class="card" role="">
            <div class="modal-content">
            <div class="modal-header justify-content-end border-bottom-0">
            </div>

            <div class="modal-body pt-0">
                <div class="row no-gutters">
                <div class="col-md-12">
                    <div class="profile-content-left px-4">
                        <div class="card text-center widget-profile px-0 border-0">
                            <div class="card-img mx-auto rounded-circle">
                                <img :src="branches.branch_img" class="mr-3 img-fluid rounded" alt="Avatar Image">
                            </div>

                            <div class="card-body">
                            <h4 class="py-2 text-dark">{{branches.name}}</h4>
                            <p>{{branches.location}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr />
                    <div class="contact-info px-4 contact-details">
                        <h4 class="text-dark mb-1">Employee Assigned Today Schedule</h4>
                    </div>
                    <div class="card-body">
                        <div class="responsive-data-table">
                            <table id="hoverable-data-table" class="table table-hover nowrap dataTable no-footer display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Position</th>
                                        <th>Clock In</th>
                                        <th>Clock Out</th>
                                        <th>Clock In Location</th>
                                        <th>Clock Out Location</th>
                                    </tr>
                                </thead>
                            </table>
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
import { lStore,axios,QueryBuilder, formatDateString } from '../../functions';
import mapboxgl from 'mapbox-gl';
import '@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css';

export default({
  name: 'LoginPage',
  data() {
      return{
        branches: {},
        mapToken: 'pk.eyJ1Ijoic3BlZWR5cmVwYWlyIiwiYSI6ImNsNWg4cGlzaDA3NTYzZHFxdm1iMTJ2cWQifQ.j_XBhRHLg-CcGzah7uepMA'
      };
  },
  mounted() {
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
.img-fluid{
    width: 100px;
    height: 100px !important;
}
.textcenter{
    display: none;
    margin: 0 auto;
    font-size: 20px;
}
.card {
    overflow: hidden;
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
</style>