<template>
    <LayoutView>
        <div id="toaster" >

        </div>
        <!--Termination Modal-->
        <div class="modal fade" id="termModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFormTitle">Terminate Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea v-model="comments" class="form-control"></textarea>
                                <div class="invalid-feedback feedback">
                                    
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal" @click="cleardata()">Close</button>
                        <button type="button" class="btn btn-primary btn-pill" @click="TermiEmp">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--End of Termination Modal-->
        <!--Contact Modal-->
        <div class="modal fade" id="contactModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFormTitle">Edit Contact Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Firsname</label>
                                <input type="text" class="form-control" v-model="firstname" placeholder="Enter Firstname">
                                <div class="invalid-feedback feedback1">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Lastname</label>
                                <input type="text" class="form-control" v-model="lastname" placeholder="Enter Lastname">
                                <div class="invalid-feedback feedback2">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" v-model="email" placeholder="Enter Email">
                                <div class="invalid-feedback feedback3">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Number</label>
                                <input type="text" class="form-control" v-model="phonenumber" placeholder="Enter Number">
                                <div class="invalid-feedback feedback4">
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Birthday</label>
                                <input type="text" class="form-control" v-model="birthdate" placeholder="Enter Number">
                                <div class="invalid-feedback feedback4">
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Date Hired</label>
                                <input type="date" class="form-control" v-model="datehired" placeholder="Enter Number">
                                <div class="invalid-feedback feedback4">
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" v-model="password" placeholder="Enter Number">
                                <div class="invalid-feedback feedback4">
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" v-model="confirmpassword" placeholder="Enter Number">
                                <div class="invalid-feedback feedback4">
                                    
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal" @click="cleardata()">Close</button>
                        <button type="button" class="btn btn-primary btn-pill" @click="ContactModalEditSave">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--End of Contact Modal-->

        <!--Personal Info Modal-->
        <div class="modal fade" id="personalModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFormTitle">Edit Personal Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <label for="coverImage" class="col-sm-4 col-lg-3 col-form-label">User Image</label>
                                <div class="col-sm-8 col-lg-6">
                                    <div class="form-group">
                                        <input type="file" id="uploadFile1" class="form-control-file form-control height-auto" accept="image/x-png,image/gif,image/jpeg">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Birthdate</label>
                                <input type="date" class="form-control" v-model="birthdate">
                                <div class="invalid-feedback feedback5">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" v-model="username" placeholder="Enter username">
                                <div class="invalid-feedback feedback6">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Date Hired</label>
                                <input type="text" class="form-control" v-model="datehired" placeholder="Enter Number">
                                <div class="invalid-feedback feedback8">
                                    
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal" @click="cleardata()">Close</button>
                        <button type="button" class="btn btn-primary btn-pill" @click="EditPersonalSave" >Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--End of Personal Info Modal-->
        <!--Role Modal-->
        <div class="modal fade" id="EditRoleModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFormTitle">Edit Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Facility</label>
                                <input type="text" class="form-control" v-model="efacility" placeholder="Enter Rate Per Hour" disabled>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control" id="desss">
                                    <option value="">Please Select Role</option>
                                    <option v-for="desig in designation" :value="desig.role_id">{{desig.role_name}}</option>
                                </select>
                                <div class="invalid-feedback feedback14">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Wages</label>
                                <input type="text" class="form-control" v-model="rates" placeholder="Enter Rate Per Hour">
                            </div>
                            <div class="invalid-feedback feedback15">
                                
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal" @click="cleardata()">Close</button>
                        <button type="button" class="btn btn-primary btn-pill" @click="EditRoleInfoSave">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--End of Role-->
        <!--Add Role-->
        <div class="modal fade" id="AddRoleModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFormTitle">Add Role Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Facility</label>
                                <select class="form-control" id="branchs">
                                    <option value="">Please Select Facilities</option>
                                    <option v-for="br in branches" :value="br.facility_id">{{br.facility_name}}</option>
                                </select>
                                <div class="invalid-feedback feedback9">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control" id="dess">
                                    <option value="">Please Select Role</option>
                                    <option v-for="desig in designation" :value="desig.role_id">{{desig.role_name}}</option>
                                </select>
                                <div class="invalid-feedback feedback11">
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Rate per hour</label>
                                <input type="text" class="form-control" v-model="rate" placeholder="Enter rate per hour">
                                <div class="invalid-feedback feedback12">
                                    
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal" @click="cleardata()">Close</button>
                        <button type="button" class="btn btn-primary btn-pill" @click="AddRoleSave">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--End of Add Role-->
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Employee</h1>    
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item">
                        <RouterLink to="/dashboard">
                        <span class="mdi mdi-home"></span>                
                        </RouterLink>
                    </li>
                    <li class="breadcrumb-item" aria-current="page" @click="late-ups"><RouterLink to="/employee">Employee</RouterLink></li>
                    <li class="breadcrumb-item" aria-current="page" >Profile</li>
                </ol>
                </nav>
            </div>
        </div>
        <div class="alert alert-danger" role="alert" v-if="viewusers.user_status == 0">
            Reason of Terminate: <br />
            {{viewusers.user_comment}}
        </div>  
        <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img v-if="viewusers.user_photo == null || viewusers.user_photo == ''" src="../../assets/default-profile.png" class="mr-3 img-fluid rounded" alt="Avatar Image" />
                    <img v-else :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+ viewusers.user_photo" class="mr-3 img-fluid rounded" alt="Avatar Image" />
                    <div>
                        <h2 class="text-dark font-weight-medium">{{viewusers.user_firstname}} {{viewusers.user_lastname}}</h2>
                        <ul class="list-unstyled">
                            <li class="d-flex mb-1">
                            <i class="mdi mdi-map mr-1"></i>
                            <span>Employee at {{count}} locations</span>
                            </li>

                            <li class="d-flex mb-1">
                            <i class="mdi mdi-phone mr-1"></i>
                            <span>{{viewusers.user_phone}} | <i class="mdi mdi-email mr-1"></i> {{viewusers.user_email}}</span>
                            </li>
                        </ul>
                        <h5 v-if="viewusers.user_status == 1" class="text-success">Active</h5>
                        <h5 v-else class="text-danger">Terminate</h5>
                    </div>
                </div>
                <div class="btn-group d-flex">
                    <button class="btn btn-sm btn-danger" v-if="value == 1" data-toggle="modal" data-target="#termModalForm">
                        <i class="mdi mdi-account-alert"></i> Terminate
                    </button>
                    
                    <button class="btn btn-sm btn-primary" v-else @click="TermiEmp">
                        <i class="mdi mdi-printer"></i> Rehire
                    </button>
                </div>
            </div>
            <!--List Group Start-->
            <div class="col-lg-12 col-xl-12">
                <div class="profile-right-spacing py-5">
                    <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Personal Information</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="timeline-tab" data-toggle="tab" href="#timeline" role="tab" aria-controls="timeline" aria-selected="true">Documents</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Role</a>
                    </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                            <FileMngr2></FileMngr2>
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="tab-widget mt-3">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#AddRoleModalForm">
                                        <i class="mdi mdi-account-key"></i> Add Role
                                    </button>
                                </div>

                                <div class="card-body">
                                    <div id="accordion3" class="accordion accordion-bordered">
                                        <div class="card" v-for="r in viewusers.facility">
                                            <div class="card-header d-flex justify-content-between border-bottom" id="heading1">
                                                <div class="p-4">
                                                    {{r.facility_name}}
                                                </div>
                                                <div>
                                                    <a href="" data-toggle="modal" data-target="#EditRoleModalForm" @click="EditRoleInfo(r.prof_id)"><span class="mdi mdi-pencil"></span></a>
                                                </div>
                                            </div>

                                            <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#accordion3">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm font-weight-bold">
                                                        Role
                                                        </div>
                                                        <div class="col-sm font-weight-bold">
                                                        Wages
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm text-uppercase">
                                                        {{r.role_name}} <div class="box" :style="'background:'+r.role_color"></div>
                                                        </div>
                                                        <div class="col-sm text-uppercase">
                                                        ${{r.prof_wage}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <div class="tab-pane-content mt-5">
                                <div class="card card-default">
                                    <div class="card-header card-header-border-bottom d-flex justify-content-between">
                                        Contact Information
                                        <div>
                                            <a href="#" data-toggle="modal" data-target="#contactModalForm" @click="EditcontactInfo"><span class="mdi mdi-pencil"></span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm font-weight-bold">
                                            Preferred Name:
                                            </div>
                                            <div class="col-12 col-md-9 text-uppercase">
                                            {{viewusers.user_firstname}} {{viewusers.user_lastname}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm font-weight-bold">
                                            Personal Email:
                                            </div>
                                            <div class="col-12 col-md-9 text-uppercase">
                                            {{viewusers.user_email}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm font-weight-bold">
                                            Phone Number:
                                            </div>
                                            <div class="col-12 col-md-9 text-uppercase">
                                            {{viewusers.user_phone}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm font-weight-bold">
                                            Birthday:
                                            </div>
                                            <div class="col-12 col-md-9 text-uppercase">
                                            {{viewusers.user_birthday}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm font-weight-bold">
                                            Date Hired:
                                            </div>
                                            <div class="col-12 col-md-9 text-uppercase">
                                            {{viewusers.user_datehired}}
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

import {axios,validateForm, lStore, elementLoad } from '../../functions';
import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder';
import mapboxgl from 'mapbox-gl';
import '@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css';
import toastr from 'toastr';
import FileMngr2 from '../../views/SharedLayoutView/FileMngr2.vue'

export default({
  name: 'LoginPage',
  data() {
      return{
            efacility:"",
            branchid:"",
            comments:"",
            count: 0,
            branches: [],
            value: 0,
            designation: [],
            firstname: "",
            lastname: "",
            phonenumber: "",
            gender: "",
            datehired: "",
            rate: "",
            birthdate: "",
            username: "",
            email: "",
            password: "",
            confirmpassword: "",
            designations: "",
            users:[],
            viewdetailsusersbranch: [{}],
            viewusers: {},
            role: "",
            listRole: [],
            userid: "",
            search: "",
            filesrc: "",
            comment:"",
            editrole:{},
            rates: "",
          viewusers: {},
          mapToken: 'pk.eyJ1Ijoic3BlZWR5cmVwYWlyIiwiYSI6ImNsNWg4cGlzaDA3NTYzZHFxdm1iMTJ2cWQifQ.j_XBhRHLg-CcGzah7uepMA'
      };
  },
  mounted() 
  {
    this.userid = lStore.get("employeeid");
    axios.post("rolecontroller/DisplayAllRoles").catch(res=>{

    }).then(res=>{
        if(res.data.success){
            this.designation = res.data.result;
        }
    });
    axios.post("facilitycontroller/facilities").catch(res=>{

    }).then(res=>{
            if(res.data.success){
                this.branches = res.data.result;
            }
    });
    mapboxgl.accessToken = this.mapToken;

    const geocoder3 = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl
    });
    const geocoder4 = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl
    });

    elementLoad('#geocoder3').then(()=>{
        geocoder3.addTo('#geocoder3');
    });
    elementLoad('#geocoder4').then(()=>{
        if($('.mapboxgl-ctrl-geocoder').length == 1){
            
            geocoder4.addTo('#geocoder4');
        }
    });
    
    axios.post("usercontroller/ReadSpecificEmployee",null,{userid: this.userid}).then(res=>{
            this.viewusers = res.data.result[0];
            this.value = this.viewusers.user_status;
            this.count = this.viewusers.facility.length;
    });

  },
  methods: {
    cleardata(){
            this.firstname = "";
            this.lastname = "";
            this.phonenumber = "";
            this.gender = "";
            this.datehired = "";
            this.birthdate = "";
            this.username = "";
            this.email = "";
            this.password = "";
            this.confirmpassword = "";
            this.designations = "";
            this.role = "";
            this.userid = "";
            this.search = "";
            this.filesrc = "";
            this.rate = "";
        },
        TermiEmp(){
            if(this.value == 0) //Meaning kay rehired
            {
                this.comments = "";
                this.value = this.viewusers.user_status;
                axios.post("usercontroller/TermiEmployee",null,{userid: lStore.get('employeeid'), comment: this.comments, value: 1}).then(res=>{
                    if(res.data.success)
                    {
                        this.callToaster("toast-top-right", res.data);
                        this.cleardata();
                        setTimeout(() => {
                            this.$router.go();
                        }, 2000);
                    }
                    else
                    {
                        this.callToaster("toast-top-right", res.data);
                    }
                });
            }
            else
            {
                this.value = this.viewusers.user_status;
                axios.post("usercontroller/TermiEmployee",null,{userid: lStore.get('employeeid'), comment: this.comments, value: 0}).then(res=>{
                    if(res.data.success)
                    {
                        this.callToaster("toast-top-right", res.data);
                        this.clearModal("termModalForm");
                        this.cleardata();
                        setTimeout(() => {
                            this.$router.go();
                        }, 2000);
                    }
                    else
                    {
                        this.callToaster("toast-top-right", res.data);
                    }
                });
            }
        },
        EditRoleInfoSave(){
     
            document.querySelector('.feedback14').style.display = "none";
            document.querySelector('.feedback15').style.display = "none";
            let newRole={
                rate: this.rates,
                roles: document.querySelector("#desss").value,
            }
            const valid = validateForm(newRole,{
                roles: "required",
                rate: "required",
                callback: (a)=>{
                    if(a == "roles")
                    {
                        document.querySelector('.feedback14').textContent = "Role is required";
                        document.querySelector('.feedback14').style.display = "block";
                    }
                    if(a == "rate")
                    {
                        document.querySelector('.feedback15').textContent = "Rate is required";
                        document.querySelector('.feedback15').style.display = "block";
                    }
                }
            });
            if(valid.allValid)
            {
                axios.post("rolecontroller/EditProfession",null,{profid: this.branchid,userid: lStore.get("employeeid"),roleid:newRole.roles,wage: newRole.rate}).then(res=>{
                    if(res.data.success)
                    {   
                        this.callToaster("toast-top-right", res.data);
                        document.querySelector('#EditRoleModalForm').style.display = "none";
                        this.cleardata();
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 2000);
                    }
                    else
                    {
                        this.callToaster("toast-top-right", res.data);
                    }
                });
            }
        },
        AddRoleSave(){
            document.querySelector('.feedback9').style.display = "none";
            document.querySelector('.feedback11').style.display = "none";
            document.querySelector('.feedback12').style.display = "none";
            let newRole = {
                facility: document.querySelector("#branchs").value,
                rate: this.rate,
                roles: document.querySelector("#dess").value,    
            }

            const valid = validateForm(newRole,{
                facility:"required",
                roles: "required",
                rate: "required",
                callback: (a)=>{
                    if(a == "facility")
                    {
                        document.querySelector('.feedback9').textContent = "Facility is required";
                        document.querySelector('.feedback9').style.display = "block";
                    }
                    if(a == "roles")
                    {
                        document.querySelector('.feedback11').textContent = "Role is required";
                        document.querySelector('.feedback11').style.display = "block";
                    }
                    if(a == "rate")
                    {
                        document.querySelector('.feedback12').textContent = "Rate is required";
                        document.querySelector('.feedback12').style.display = "block";
                    }
                }
            });
            if(valid.allValid == true)
            {
                axios.post("rolecontroller/InsertProfession",null,{facilityid: newRole.facility,roleid: newRole.roles,wage: newRole.rate,userid: lStore.get("employeeid")}).catch(res=>{

                }).then(res=>{
                    if(res.data.success)
                    {
                        this.callToaster("toast-top-right", res.data);
                        document.querySelector('#AddRoleModalForm').style.display = "none"
                        this.cleardata();
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 2000);
                    }
                    else
                    {
                        this.callToaster("toast-top-right", res.data);
                    }
                });
            }
        },
        EditPersonalSave()
        {
            document.querySelector('.feedback5').style.display = "none";
            document.querySelector('.feedback6').style.display = "none";
            document.querySelector('.feedback8').style.display = "none";
            let newUser = {}
            if(document.getElementById('uploadFile1').files.length > 0)
            {
                newUser = {
                employee_username: this.username,
                employee_hiredate: this.datehired,
                employee_birthday: this.birthdate,
                employee_profilepicture: document.getElementById('uploadFile1').files[0]
                }
            }
            else
            {
                newUser = {
                employee_username: this.username,
                employee_hiredate: this.datehired,
                employee_birthday: this.birthdate,
                }
            }

            const valid = validateForm(newUser,{
                employee_username:"required",
                employee_hiredate: "required",
                employee_birthday: "required",
                callback: (a)=>{
                    if(a == "employee_username")
                    {
                        document.querySelector('.feedback6').textContent = "Username is required";
                        document.querySelector('.feedback6').style.display = "block";
                    }
                    if(a == "employee_birthday")
                    {
                        document.querySelector('.feedback7').textContent = "Address is required";
                        document.querySelector('.feedback7').style.display = "block";
                    }
                    if(a == "employee_hiredate")
                    {
                        document.querySelector('.feedback8').textContent = "Date Hired is required";
                        document.querySelector('.feedback8').style.display = "block";
                    }
                }
            });
            if(valid.allValid == true)
            {
                axios.post("employee/update?id="+lStore.get("userdetails"),null,newUser).catch(res=>{
                    this.callToaster("toast-top-right", res.data);
                }).then(res=>{
                    if(res.data.success)
                    {
                        this.callToaster("toast-top-right", res.data);
                        document.querySelector('#personalModalForm').style.display = "none"
                        this.cleardata();
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 2000);
                    }
                    else
                    {
                        this.callToaster("toast-top-right", res.data);
                    }
                });
            }

        },
        ContactModalEditSave()
        {
            document.querySelector('.feedback1').style.display = "none";
            document.querySelector('.feedback2').style.display = "none";
            document.querySelector('.feedback3').style.display = "none";
            document.querySelector('.feedback4').style.display = "none";
            let newUser = {
                employee_firstname: this.firstname,
                employee_lastname: this.lastname,
                employee_emailaddress: this.email,
                employee_phonenumber: this.phonenumber
            }
            const valid = validateForm(newUser,{
                employee_firstname:"required",
                employee_lastname:"required",
                employee_phonenumber: "required",
                employee_emailaddress: {
                    isEmail: true,
                    isRequired:true,
                    callback: res=>{
                        if(res!='invalid_email') return;
                        document.querySelector('.feedback10').textContent = "Email is not valid!";
                        document.querySelector('.feedback10').style.display = "block";
                    }
                },
                callback: (a)=>{
                    if(a == "employee_firstname")
                    {
                        document.querySelector('.feedback1').textContent = "Firstname is required";
                        document.querySelector('.feedback1').style.display = "block";
                    }
                    if(a == "employee_lastname")
                    {
                        document.querySelector('.feedback2').textContent = "Lastname is required";
                        document.querySelector('.feedback2').style.display = "block";
                    }
                    if(a == "employee_phonenumber")
                    {
                        document.querySelector('.feedback4').textContent = "Phone number is required";
                        document.querySelector('.feedback4').style.display = "block";
                    }
                    if(a == "employee_emailaddress")
                    {
                        document.querySelector('.feedback3').textContent = "Email is required";
                        document.querySelector('.feedback3').style.display = "block";
                    }
                }
            });
            if(valid.allValid == true)
            {
                axios.post("employee/update?id="+lStore.get("userdetails"),null,{employee_firstname: this.firstname,employee_lastname: this.lastname,employee_emailaddress: this.email, employee_phonenumber: this.phonenumber}).catch(res=>{
                    this.callToaster("toast-top-right", res.data);
                }).then(res=>{
                    if(res.data.success)
                    {
                        this.callToaster("toast-top-right", res.data);
                        document.querySelector('#contactModalForm').style.display = "none"
                        this.cleardata();
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 2000);
                    }
                    else
                    {
                        this.callToaster("toast-top-right", res.data);
                    }
                });
            }
        },
        EditRoleInfo(data){
            axios.post("rolecontroller/ViewProfession",null,{profid:data}).then(res=>{
                if(res.data.success == true)
                {
                    this.branchid = data;
                    var dessselected = document.getElementById('desss');
                    this.editrole = res.data.result[0];
                    this.efacility = this.editrole.facility_name;
                    dessselected.options[dessselected.selectedIndex].text = this.editrole.role_name;
                    dessselected.options[dessselected.selectedIndex].value = this.editrole.prof_role_id;
                    dessselected.options[dessselected.selectedIndex].disabled = true;
                    this.rates = this.editrole.prof_wage;
                }
            });

        },
        EditPersonalInfo(){
            this.cleardata();
            this.username = this.viewusers.employee_username;
            this.birthdate = this.viewusers.employee_birthday;
            this.datehired = this.viewusers.employee_hiredate;
        },
        EditcontactInfo(){
            this.cleardata();
            this.firstname = this.viewusers.user_firstname;
            this.lastname = this.viewusers.user_lastname;
            this.phonenumber = this.viewusers.user_phone;
            this.datehired = this.viewusers.user_datehired;
            this.birthdate = this.viewusers.user_birthday;
            this.email = this.viewusers.user_email;
            
        },
    EditEmployee(){
        this.cleardata();
        this.role = this.viewusers.role;
        this.firstname = this.viewusers.user_firstname;
        this.lastname = this.viewusers.user_lastname;
        this.phonenumber = this.viewusers.user_phone;
        this.datehired = this.viewusers.user_datehired;
        this.birthdate = this.viewusers.user_birthday;
        this.email = this.viewusers.user_email;
        this.userid = this.viewusers.user_id;
        this.rate = this.viewusers.prof_wage;
        document.querySelector('#edes').value = this.viewusers.role_id;
        document.querySelector('#erole').value = this.viewusers.role_name;
        document.querySelector('#edate').value = this.viewusers.user_datehired;
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
#empterm{
  display: flex;
flex-wrap: wrap;
width: auto;
float: right;
margin-right: 20px;
position: absolute;
top: 0;
right: 0;
}
.tab-content > .active
{
    display: block !important;
}
.accordion .card-header .btn::after{
    display: none;
}
.box{
    padding: 10px;
    width: 5%;
}
</style>