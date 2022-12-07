<template>
    <LayoutView>
        <div class="toast" >

        </div>
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary mr-2"><span class="mdi mdi-download text-default">Download Excel CSV</span></button>
            <!-- <button class="btn btn-info"><span class="mdi mdi-printer text-default">Print</span></button> -->
        </div>
        <div class="card card-default">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h5 class="card-title text-secondary">{{branch.name}}</h5>
                    <small class="text-secondary">{{branch.location}}</small>
                </div>
                <div class="mr-4 text-secondary" v-if="totalhoursb != ''"><h5>Total Hours</h5><small>{{totalhoursb}}</small></div>
                <div class="mr-4 text-secondary" v-else ><h5>Total Hours </h5> <h4 class="d-flex justify-content-center">{{totalhoursb}}</h4></div>
                <div class="mr-4 text-secondary" v-if="totalwageb"><h5>Total Wages</h5> <h4 class="d-flex justify-content-center">{{totalwageb}}</h4></div>
                <div class="mr-4 text-secondary" v-else><h5>Total Wages</h5> <h4 class="d-flex justify-content-center">{{totalwageb}}</h4></div>
                <div class="date-range-report text-secondary d-flex align-items-center">
                    <input type="date" class="form-control datepick" v-model="datetoday">
                    <button class="btn btn-success" @click="SearchRecordData"><p class="mdi mdi-calendar-search"></p></button>
				</div>
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
                            <div v-for="sched in SchedToday">
                                <div class="text-secondary m-3">{{sched.shift_start}}</div>
                                <div  v-for = "ass in sched.assignedEmps">
                                    <div class="bd-callout" :class="{'bd-callout-default': (ass.time_in == null),'bd-callout-success':(ass.time_in != null)}" v-if="(ass.time_out == null )">
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <img class="mr-3 img-fluid rounded" :src="ass.profile_img"/>
                                                <div class="d-flex flex-column font-weight-bold"> {{ass.lastname}}, {{ass.firstname}} {{ass.position}} <small>rate: ${{ass.hourly_rate}} per hour</small>
                                                <small>Clockin: {{ass.time_in}} </small>
                                                <small>Clockout: {{ass.time_out}} </small> 
                                                <small>Shift Start: {{sched.shift_start}} Shift End: {{sched.shift_end}}</small>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                Total Hours
                                                <p class="d-flex justify-content-center" v-if="(ass.total_reg_rendered != null)">{{ass.total_reg_rendered}}</p>
                                                <p class="d-flex justify-content-center" v-else>0</p>
                                            </div>
                                            <div class="d-flex flex-column">
                                                Wages
                                                <p class="d-flex justify-content-center" v-if="(ass.total_earned != null)"> {{ass.total_earned}}</p>
                                                <p class="d-flex justify-content-center" v-else>0</p>
                                            </div>
                                            <div>
                                                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" v-if="(ass.time_in == null || ass.time_in == '')">Add Clockin</a>
                                                    <a class="dropdown-item" href="#" v-else>Edit Clockin</a>
                                                    <a class="dropdown-item" href="#" v-if="(ass.time_out == null || ass.time_out == '')">Add Clockout</a>
                                                    <a class="dropdown-item" href="#" v-else>Edit Clockout</a>
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
                            <div v-for="sched in SchedToday">
                                <div class="text-secondary m-3">{{sched.shift_start}}</div>
                                <div  v-for = "ass in sched.assignedEmps">
                                    <div class="bd-callout bd-callout-primary" v-if="(ass.time_out != null)">
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <img class="mr-3 img-fluid rounded" :src="ass.profile_img"/>
                                                <div class="d-flex flex-column"> {{ass.lastname}}, {{ass.firstname}} {{ass.position}} rate: ${{ass.hourly_rate}} per hour
                                                <small>Clockin: {{ass.time_in}} </small><small>Clockout: {{ass.time_out}} </small> <small>Shift Start: {{sched.shift_start}} Shift End: {{sched.shift_end}}</small>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                Total Hours
                                                <p class="d-flex justify-content-center">{{ass.total_reg_rendered}}</p>
                                            </div>
                                            <div class="d-flex flex-column">
                                                Wages
                                                <p class="d-flex justify-content-center"> {{ass.total_earned}}</p>
                                            </div>
                                            <div>
                                                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" v-if="(ass.time_in == null || ass.time_in == '')">Add Clockin</a>
                                                    <a class="dropdown-item" href="#" v-else>Edit Clockin</a>
                                                    <a class="dropdown-item" href="#" v-if="(ass.time_out == null || ass.time_out == '')">Add Clockout</a>
                                                    <a class="dropdown-item" href="#" v-else>Edit Clockout</a>
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
import { lStore,axios,QueryBuilder, formatDateString } from '../../functions';
import mapboxgl from 'mapbox-gl';
import '@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css';
import { objectToString } from '@vue/shared';

export default({
  name: 'LoginPage',
  data() {
      return{
        color: "",
        SchedToday: [],
        branch: {},
        mapToken: 'pk.eyJ1Ijoic3BlZWR5cmVwYWlyIiwiYSI6ImNsNWg4cGlzaDA3NTYzZHFxdm1iMTJ2cWQifQ.j_XBhRHLg-CcGzah7uepMA',
        datetoday: "",
        totalhoursb: 0,
        totalwageb: 0,
        
      };
  },
  mounted() {
    this.datetoday = new Date().toJSON().slice(0, 10);


    axios.post("branches?id="+lStore.get("branchidemp")).catch(res=>{

    }).then(res=>{
        this.branch = res.data.result;
    });

    axios.post("assigned/joint?range="+this.datetoday+"&_batch=true&branch_id="+lStore.get("branchidemp")).catch(res=>{

    }).then(res=>{
        if(res.data.success == false)
        {
            return;
        }
        console.log(res.data.result);
        this.tempschedstorage = res.data.result;
        this.tempschedstorage.forEach(element => {
            let obj = element;
            let assigned = element.assignedEmps;
            if(element.assignedEmps == null) return;
            element.assignedEmps.forEach((el,i)=>{
                if(element.timerecords == null) return;
                let filtered = element.timerecords.filter(el2 => el2.user_id == el.user_id && element.id == el2.schedule_id);
                filtered = filtered[0];
                for(let f in filtered){
                    assigned[i][f] = filtered[f];
                }
            })

            element.assignedEmps = assigned;

            this.SchedToday.push(element);
            this.SchedToday.forEach(element => {
                if(element.total_reg_rendered != null)
                {
                    this.totalhoursb = this.totalhoursb + element.total_reg_rendered;
                }
                if(element.total_earned != null)
                {
                    this.totalwageb = this.totalwageb + this.total_earned;
                }
            });
        });
    });
    
    },
    methods : {
        SearchRecordData(){
            this.SchedToday.splice(0);
            axios.post("assigned/joint?range="+this.datetoday+"&_batch=true&branch_id="+lStore.get("branchidemp")).catch(res=>{

            }).then(res=>{
                if(res.data.success == false)
                {
                    return;
                }
                console.log(res.data.result);
                this.tempschedstorage = res.data.result;
                this.tempschedstorage.forEach(element => {
                    let obj = element;
                    let assigned = element.assignedEmps;
                    if(element.assignedEmps == null) return;
                    element.assignedEmps.forEach((el,i)=>{
                        if(element.timerecords == null) return;
                        let filtered = element.timerecords.filter(el2 => el2.user_id == el.user_id && element.id == el2.schedule_id);
                        filtered = filtered[0];
                        for(let f in filtered){
                            assigned[i][f] = filtered[f];
                        }
                    })

                    element.assignedEmps = assigned;

                    this.SchedToday.push(element);
                    this.SchedToday.forEach(element => {
                        if(element.total_reg_rendered != null)
                        {
                            this.totalhoursb = this.totalhoursb + element.total_reg_rendered;
                        }
                        if(element.total_earned != null)
                        {
                            this.totalwageb = this.totalwageb + this.total_earned;
                        }
                    });
                });
            });
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
.datepick{
    border-style: none;
}
</style>