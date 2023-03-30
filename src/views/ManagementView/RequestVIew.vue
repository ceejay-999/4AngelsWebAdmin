<template>
    <LayoutView>
        <div id="toaster" >

        </div>
        <div class="modal fade" id="ViewDetailsRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFormTitle">Request ID: {{ specificrequest.requests_id }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div v-if="specificrequest.length != 0" class="modal-body">
                        <h5>Name: {{ specificrequest.user_firstname }} {{ specificrequest.user_lastname }}</h5>
                        <br />
                        <h5>Request Date: 
                            {{ new Date(specificrequest.requests_created_at).toDateString() }}</h5>
                        <br />
                        <!-- <h5 v-if="specificrequest.requests_type == 1">Request Type: Reschedule</h5> -->
                        <h5 v-if="specificrequest.requests_type == 2">Request Type: Reassign</h5>
                        <br />
                        <h5>Request Reason: {{ specificrequest.requests_reason }}</h5>
                        <br />
                        <h5 v-if="specificrequest.requests_status == 1">Status: Approved</h5>
                        <h5 v-if="specificrequest.requests_status == 2">Status: Disapproved</h5>
                        <h5 v-if="specificrequest.requests_status == 0">Status: Pending</h5>
                        <br />
                        <h5 v-if="specificrequest.requests_approvedby != null">Approved By: Manager </h5>
                    </div>
                    <div v-else class="modal-body">
                        <h5 class="text-center">Loading Data..</h5>
                    </div>

                    <div class="modal-footer">
                        <button v-if="specificrequest.requests_status == 0" type="button" class="btn btn-danger btn-pill" data-dismiss="modal" @click="DisapproveRequest(specificrequest.requests_id)">Disapprove</button>
                        <button v-if="specificrequest.requests_status == 0" type="button" class="btn btn-primary btn-pill" data-dismiss="modal" @click="ApproveRequest(specificrequest.requests_id)"> Approve</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-wrapper" v-if="branchselected != null">
            <h1 class="text-dark">Facility Name: {{branchselected}}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item">
                    <RouterLink to="/dashboard">
                        <span class="mdi mdi-home"></span>                
                    </RouterLink>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Requests</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between card-design head">
                        <h2>Requests</h2>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Request Date</th>
                                <th scope="col">Request type</th>
                                <th scope="col">Request status</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="r in request">
                                <th scope="row">{{r.requests_id}}</th>
                                <td>{{ r.user_firstname }} {{ r.user_lastname }}</td>
                                <td>{{ new Date(r.requests_created_at).toLocaleDateString() }}</td>
                                <!-- <td v-if="r.requests_type == 1">Reschedule</td> -->
                                <td v-if="r.requests_type == 2">Reassign</td>
                                <td v-if="r.requests_status == 0">Pending</td>
                                <td v-if="r.requests_status == 1">Approved</td>
                                <td v-if="r.requests_status == 2">Disapproved</td>
                                <td>
                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mdi mdi-dots-horizontal"></span></a>
                                    <div class="dropdown-menu">
                                        <a v-if="r.requests_status == 0" class="dropdown-item addclockin" data-toggle="modal" data-target="#ViewClockModalForm" @click="ApproveRequest(r.requests_id)">Approve</a>
                                        <a v-if="r.requests_status == 0" class="dropdown-item addclockin" data-toggle="modal" data-target="#ViewClockModalForm" @click="DisapproveRequest(r.requests_id)">Disapprove</a>
                                        <a class="dropdown-item addclockin" data-toggle="modal" data-target="#ViewDetailsRequest" @click="ViewDetailsRequest(r.requests_id)">View Details</a>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3"></div>
                </div>
            </div>
        </div>
    </LayoutView>
</template>
<script>
import LayoutView from "../../views/SharedLayoutView/LayoutView.vue"
import { lStore,axios } from '@/functions.js';
import toastr from 'toastr';

export default ({
    name: "App",
    components: {
        LayoutView,
    },
    data(){
        return{
            branchselected: lStore.get('selected_facility'),
            request: [],
            specificrequest: [],
        }
    },
    mounted(){
        axios.post('requestcontroller/DisplayAllRequest',{pwauth: lStore.get('usertoken')},{facilityid: lStore.get('selected_facilityId')}).then(res=>{
            if(res.data.success)
            {
                this.request = res.data.result;
                console.log(this.request);
            }
        })
    },
    methods:{
        ViewDetailsRequest(requestid){
            axios.post('requestcontroller/DisplaySpecificRequest',{pwauth: lStore.get('usertoken')},{requestid: requestid}).then(res=>{
                if(res.data.success){
                    this.specificrequest = res.data.result[0];
                }
            })
        },
        DisapproveRequest(requestid){
            axios.post('requestcontroller/DisapproveRequest',{pwauth: lStore.get('usertoken')},{requestid: requestid, managerid: lStore.get('userdetails').user_id}).then(res=>{
                if(res.data.success){
                    this.callToaster("toast-top-right",res.data);
                    setTimeout(() => {
                        this.$router.go(0);
                    }, 2000);
                }else{
                    this.callToaster("toast-top-right",res.data);
                }
            })
        },
        ApproveRequest(requestid){
            
            axios.post('requestcontroller/ApproveRequest',{pwauth: lStore.get('usertoken')},{requestid: requestid, managerid: lStore.get('userdetails').user_id}).then(res=>{
                if(res.data.success){
                    this.callToaster("toast-top-right",res.data);
                    setTimeout(() => {
                        this.$router.go(0);
                    }, 2000);
                }
                else{
                    this.callToaster("toast-top-right",res.data);
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

</style>