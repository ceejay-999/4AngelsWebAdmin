<template>
    <LayoutView>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between card-design head">
                        <h2>Team Activity Today</h2>
                    </div>
                    <div class="card-body">
                        <div class="responsive-data-table">
                            <table id="hoverable-data-table" class="table table-hover nowrap dataTable no-footer display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Clock in</th>
                                        <th>Clock out</th>
                                        <th>Total hours</th>
                                        <th>Clock in Location</th>
                                        <th>Clock out Location</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3"></div>
                </div>
            </div>
        </div>
    </LayoutView>
</template>
<script>
import LayoutView from "../../views/SharedLayoutView/LayoutView.vue"
import { axios } from '@/functions';
import mapboxgl from 'mapbox-gl';
import '@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css';
import axiosA from "axios";
import { dateFormat } from "../../functions";

export default ({
    name: "App",
    components: {
    LayoutView
    },
    data(){
        return{
            datas: [],
            locstore: [],
            timerecord: [],
            mapToken: 'pk.eyJ1Ijoic3BlZWR5cmVwYWlyIiwiYSI6ImNsNWg4cGlzaDA3NTYzZHFxdm1iMTJ2cWQifQ.j_XBhRHLg-CcGzah7uepMA'
        }
    },
    mounted(){
        mapboxgl.accessToken = this.mapToken;

        axios.post("timerecord?_select=mobile_timerecord.id,mobile_timerecord.user_id,mobile_timerecord.time_in,mobile_timerecord.time_out,mobile_timerecord.branch_id,mobile_timerecord.location_long,mobile_timerecord.location_lat,mobile_timerecord.location_out_long,mobile_timerecord.location_out_lat,mobile_users.lastname,mobile_users.firstname&_joins=mobile_users&_on=mobile_timerecord.user_id=mobile_users.id&_batch=true").catch(res=>{

        }).then(res=>{
            let arr = [];
            if(res.data.result == null)
            {
                return;
            }
            this.timerecord = res.data.result;
            this.timerecord.forEach(async element => {
                const obj = {};
                let arr2 = [];
                if(element.location_long != "" && element.location_lat != "")
                {
                    

                    obj.id = element.id;
                    obj.name = ""+ element.firstname + " " + element.lastname;
                    obj.clockin = new Date(element.time_in).toLocaleTimeString();
                    if(element.time_out != null)
                    {
                        obj.clockout = new Date(element.time_out).toLocaleTimeString();
                        let clocki = new Date(element.time_in).getTime();
                        let clocko = new Date(element.time_out).getTime();
                        obj.totalhours = (clocko - clocki) / (60*60*1000);
                        obj.totalhours = obj.totalhours.toFixed(2);
                        obj.clockoutloc = await this.GetLocationOnGivenLatLong(element.location_out_lat,element.location_out_long);
                    }
                    else
                    {
                        obj.clockout = null;
                        obj.totalhours = 0;
                        obj.clockoutloc = null;
                    }
                    obj.clockinloc = await this.GetLocationOnGivenLatLong(element.location_lat,element.location_long);


                    this.datas.push(obj);
                }

                arr.push(JSON.parse(JSON.stringify(obj)));

                
            });

            setTimeout(()=>{

                $('#hoverable-data-table').DataTable({
                    aLengthMenu: [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true,
                    data: arr,
                    columns : [
                        { data : "id" },
                        { data : "name" },
                        { data : "clockin" },
                        { data : "clockout" },
                        { data : "totalhours" },
                        { data : "clockinloc" },
                        { data : "clockoutloc" },
                    ], 
                });
            },1000);

            

        });
        
         
         
    },
    methods: {
        async GetLocationOnGivenLatLong(lat,long){
            let data = await axios.get(`https://api.mapbox.com/geocoding/v5/mapbox.places/${long},${lat}.json?access_token=${mapboxgl.accessToken}`);
            let retdata = data.data.features[0].place_name;
            return " " + retdata;
        }
    }
})
</script>
<style scoped>
@import '../../assets/scss/_card.scss';
@import '../../assets/scss/_breadcrumb.scss';
@import '../../assets/sleek.min.css';


.responsive-data-table{
    overflow: auto;
}
</style>