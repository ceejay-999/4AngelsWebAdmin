<template>
    <LayoutView>
        <div class="toast" >

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
                                <textarea id="comments" class="form-control"></textarea>
                                <div class="invalid-feedback feedback1">
                                    
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
                                <label>Gender</label>
                                <select class="form-control" id="gender">
                                    <option value="">Please select gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
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
                                <label>Address</label>
                                <div id="geocoder3"></div>
                                <div class="invalid-feedback feedback7">
                                    
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
                                <label>Role</label>
                                <select class="form-control" id="desss">
                                    <option value="">Please Select Role</option>
                                    <option v-for="desig in designation" :value="desig.id">{{desig.position}}</option>
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
                                    <option v-for="br in branches" :value="br.id">{{br.name}}</option>
                                </select>
                                <div class="invalid-feedback feedback9">
                                    
                                </div>
                            </div>
<!-- 
                            <div class="form-group">
                                <label>Access Level</label>
                                <select class="form-control" id="role">
                                    <option value="">Please select Access Level</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Employee">Employee</option>
                                </select>
                                <div class="invalid-feedback feedback10">
                                    
                                </div>
                            </div> -->

                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control" id="dess">
                                    <option value="">Please Select Role</option>
                                    <option v-for="desig in designation" :value="desig.id">{{desig.position}}</option>
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
        <div class="alert alert-danger" role="alert">
            Reason of Terminate: <br />
            {{viewusers.comments}}
        </div>  
        <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img :src="viewusers.profile_img" class="mr-3 img-fluid rounded" alt="Avatar Image" />
                    <div>
                        <h2 class="text-dark font-weight-medium">{{viewusers.firstname}} {{viewusers.lastname}}</h2>
                        <ul class="list-unstyled">
                        <li class="d-flex mb-1">
                        <i class="mdi mdi-map mr-1"></i>
                        <span>Employee at {{count}} locations</span>
                        </li>

                        <li class="d-flex mb-1">
                        <i class="mdi mdi-phone mr-1"></i>
                        <span>{{viewusers.phonenumber}} | <i class="mdi mdi-email mr-1"></i> {{viewusers.email_address}}</span>
                        </li>
                    </ul>
                    </div>
                </div>
                <div class="btn-group d-flex">
                    <button class="btn btn-sm btn-danger" v-if="value == 0" data-toggle="modal" data-target="#termModalForm">
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
                                        <div class="card" v-for="r in usersroleb">
                                            <div class="card-header d-flex justify-content-between border-bottom" id="heading1">
                                                <div class="p-4">
                                                    {{r.name}}
                                                </div>
                                                <div>
                                                    <a href="" data-toggle="modal" data-target="#EditRoleModalForm" @click="EditRoleInfo(r.branch_id)"><span class="mdi mdi-pencil"></span></a>
                                                </div>
                                            </div>

                                            <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#accordion3">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm font-weight-bold">
                                                        Access level
                                                        </div>
                                                        <div class="col-sm font-weight-bold">
                                                        Role
                                                        </div>
                                                        <div class="col-sm font-weight-bold">
                                                        Wages
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm text-uppercase">
                                                        {{viewusers.role}}
                                                        </div>
                                                        <div class="col-sm text-uppercase">
                                                        {{r.position}}
                                                        </div>
                                                        <div class="col-sm text-uppercase">
                                                        ${{r.hourly_rate}}
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
                                            {{viewusers.firstname}} {{viewusers.lastname}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm font-weight-bold">
                                            Personal Email:
                                            </div>
                                            <div class="col-12 col-md-9 text-uppercase">
                                            {{viewusers.email_address}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm font-weight-bold">
                                            Phone Number:
                                            </div>
                                            <div class="col-12 col-md-9 text-uppercase">
                                            {{viewusers.phonenumber}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-3"></div>
                                <div class="card card-default">
                                    <div class="card-header card-header-border-bottom d-flex justify-content-between">
                                        Personal Information
                                        <div>
                                            <a href="" data-toggle="modal" data-target="#personalModalForm" @click="EditPersonalInfo"><span class="mdi mdi-pencil"></span></a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm font-weight-bold">
                                            Gender:
                                            </div>
                                            <div class="col-12 col-md-9 text-uppercase">
                                            {{viewusers.gender}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm font-weight-bold">
                                            Username:
                                            </div>
                                            <div class="col-12 col-md-9 text-uppercase">
                                            {{viewusers.username}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm font-weight-bold">
                                            Address:
                                            </div>
                                            <div class="col-12 col-md-9 text-uppercase">
                                            {{viewusers.address}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm font-weight-bold">
                                            Date Hired:
                                            </div>
                                            <div class="col-12 col-md-9 text-uppercase">
                                            {{viewusers.date_hired}}
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
            comments:"",
            count: 0,
            branches: [],
            usersroleb: [],
            value: 0,
            designation: [],
            firstname: "",
            lastname: "",
            phonenumber: "",
            gender: "",
            datehired: "",
            rate: "",
            address: "",
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
    axios.post("designation?_batch=true").catch(res=>{

    }).then(res=>{
        if(res.data.success){
            this.designation = res.data.result;
        }
    });
    axios.post("branches?name="+this.search+"&_like=true&_batch=true").catch(res=>{

    }).then(res=>{
            if(res.data.success){
                this.branches = res.data.result;
                console.log(this.branches);
            }
    });
    document.querySelector(".toast").id = "toaster";
    mapboxgl.accessToken = this.mapToken;

        const geocoder3 = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl
        });
        console.log(geocoder3);
        const geocoder4 = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl
        });

        elementLoad('#geocoder3').then(()=>{
            geocoder3.addTo('#geocoder3');
        });
        elementLoad('#geocoder4').then(()=>{
            if($('.mapboxgl-ctrl-geocoder').length == 1){
                
                geocoder4.addTo('#geocoder2');
            }
         });

        geocoder3.on('result', e => {
            console.log(e);
            this.address = e.result.place_name;
        });

        geocoder4.on('result', e => {
            console.log(e);
            this.address = e.result.place_name;
        });
        axios.post("designation?_batch=true").catch(res=>{
        }).then(res=>{
            if(res.data.success){
                this.designation = res.data.result;
            }
        });
    this.viewusers = ""
    axios.post("users?id="+lStore.get("userdetails")+"&_batch=true",null,{}).catch(res=>{
            this.callToaster("toast-top-right",2);
        }).then(res=>{
            res.data.result.forEach(el => {
                this.viewusers = el;
                if(this.viewusers.status == 0)
                {
                    this.value = 0;
                }
                else
                {
                    this.value = 1;
                }
                if(this.viewusers.comments == null && this.viewusers.status == 1 || this.viewusers.comments == "" && this.viewusers.status == 1)
                {
                  elementLoad('.alert').then(()=>{
                    document.querySelector(".alert").style.display = "block";
                    document.querySelector(".alert").textContent = "No reason added for the termination of this employee";
                  });
                }
                else if(this.viewusers.comments == null && this.viewusers.status == 0 || this.viewusers.comments == "" && this.viewusers.status == 0)
                {
                  elementLoad('.alert').then(()=>{
                    document.querySelector(".alert").style.display = "none";
                  });
                }
                else{
                  elementLoad('.alert').then(()=>{
                    document.querySelector(".alert").style.display = "block";
                  });
                }
                return;
            });
        });
    axios.post("userDesignations?user_id="+lStore.get("userdetails")+"&_joins=mobile_branches,mobile_designation&_on=mobile_userdesignations.branch_id=mobile_branches.id,mobile_userdesignations.designation_id=mobile_designation.id&_batch=true",null,{}).catch(res=>{
        this.callToaster("toast-top-right",2);
    }).then(res=>{
        if(res.data.success == true)
        {
            this.usersroleb = res.data.result;
            this.count = this.usersroleb.length;
        }
        else
        {
            return;
        }
    });

  },
  methods: {
    cleardata(){
            this.firstname = "";
            this.lastname = "";
            this.phonenumber = "";
            this.gender = "";
            this.datehired = "";
            this.address = "";
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
            if(this.value == 1) //Meaning kay rehired
            {
                this.comments = "";
                this.value = 0;
                axios.post("users/update?id="+lStore.get("userdetails"),null,{status: 0, comments: this.comments}).catch(res=>{
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    if(res.data.success)
                    {
                        console.log(res.data.success);
                        this.callToaster("toast-top-right",1);
                        document.querySelector('#termModalForm').style.display = "none"
                        this.cleardata();
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 2000);
                    }
                    else
                    {
                        this.callToaster("toast-top-right",2);
                    }
                });
            }
            else
            {
                this.comments = document.querySelector("#comments").value;
                this.value = 1;
                axios.post("users/update?id="+lStore.get("userdetails"),null,{status: 1, comments: this.comments}).catch(res=>{
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    if(res.data.success)
                    {
                        console.log("aw");
                        this.callToaster("toast-top-right",1);
                        this.cleardata();
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 2000);
                    }
                    else
                    {
                        this.callToaster("toast-top-right",2);
                    }
                });
            }
        },
        EditRoleInfoSave(){
            console.log('aw');            
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
                axios.post("userDesignations/update?user_id="+lStore.get("userdetails")+"&branch_id="+lStore.get("editrolebranchid"),null,{designation_id: newRole.roles,hourly_rate: newRole.rate}).catch(res=>{

                }).then(res=>{
                    if(res.data.success)
                    {
                        console.log("aw");
                        this.callToaster("toast-top-right",1);
                        document.querySelector('#EditRoleModalForm').style.display = "none";
                        this.cleardata();
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 2000);
                    }
                    else
                    {
                        this.callToaster("toast-top-right",2);
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
                axios.post("userDesignations/create",null,{branch_id: newRole.facility,designation_id: newRole.roles,hourly_rate: newRole.rate,user_id: lStore.get("userdetails")}).catch(res=>{

                }).then(res=>{
                    if(res.data.success)
                    {
                        console.log("aw");
                        this.callToaster("toast-top-right",1);
                        document.querySelector('#AddRoleModalForm').style.display = "none"
                        this.cleardata();
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 2000);
                    }
                    else
                    {
                        this.callToaster("toast-top-right",2);
                    }
                });
            }
        },
        EditPersonalSave()
        {
            document.querySelector('.feedback5').style.display = "none";
            document.querySelector('.feedback6').style.display = "none";
            document.querySelector('.feedback7').style.display = "none";
            document.querySelector('.feedback8').style.display = "none";
            let newUser = {}
            if(document.getElementById('uploadFile1').files.length > 0)
            {
                newUser = {
                gender: document.querySelector("#gender").value,
                username: this.username,
                date_hired: this.datehired,
                address: this.address,
                file: document.getElementById('uploadFile1').files[0]
                }
            }
            else
            {
                newUser = {
                gender: document.querySelector("#gender").value,
                username: this.username,
                date_hired: this.datehired,
                address: this.address,
                }
            }

            const valid = validateForm(newUser,{
                gender:"required",
                username:"required",
                date_hired: "required",
                address: "required",
                callback: (a)=>{
                    if(a == "gender")
                    {
                        document.querySelector('.feedback5').textContent = "Gender is required";
                        document.querySelector('.feedback5').style.display = "block";
                    }
                    if(a == "username")
                    {
                        document.querySelector('.feedback6').textContent = "Username is required";
                        document.querySelector('.feedback6').style.display = "block";
                    }
                    if(a == "address")
                    {
                        document.querySelector('.feedback7').textContent = "Address is required";
                        document.querySelector('.feedback7').style.display = "block";
                    }
                    if(a == "date_hired")
                    {
                        document.querySelector('.feedback8').textContent = "Date Hired is required";
                        document.querySelector('.feedback8').style.display = "block";
                    }
                }
            });
            if(valid.allValid == true)
            {
                this.gender = document.querySelector("#gender").value;
                axios.post("users/update?id="+lStore.get("userdetails"),null,newUser).catch(res=>{
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    if(res.data.success)
                    {
                        console.log("aw");
                        this.callToaster("toast-top-right",1);
                        document.querySelector('#personalModalForm').style.display = "none"
                        this.cleardata();
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 2000);
                    }
                    else
                    {
                        this.callToaster("toast-top-right",2);
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
                firstname: this.firstname,
                lastname: this.lastname,
                email_address: this.email,
                phonenumber: this.phonenumber
            }
            const valid = validateForm(newUser,{
                firstname:"required",
                lastname:"required",
                phonenumber: "required",
                email_address: {
                    isEmail: true,
                    isRequired:true,
                    callback: res=>{
                        if(res!='invalid_email') return;
                        document.querySelector('.feedback10').textContent = "Email is not valid!";
                        document.querySelector('.feedback10').style.display = "block";
                    }
                },
                callback: (a)=>{
                    if(a == "firstname")
                    {
                        document.querySelector('.feedback1').textContent = "Firstname is required";
                        document.querySelector('.feedback1').style.display = "block";
                    }
                    if(a == "lastname")
                    {
                        document.querySelector('.feedback2').textContent = "Lastname is required";
                        document.querySelector('.feedback2').style.display = "block";
                    }
                    if(a == "phonenumber")
                    {
                        document.querySelector('.feedback4').textContent = "Phone number is required";
                        document.querySelector('.feedback4').style.display = "block";
                    }
                    if(a == "email_address")
                    {
                        document.querySelector('.feedback3').textContent = "Email is required";
                        document.querySelector('.feedback3').style.display = "block";
                    }
                }
            });
            if(valid.allValid == true)
            {
                axios.post("users/update?id="+lStore.get("userdetails"),null,{firstname: this.firstname,lastname: this.lastname,email_address: this.email, phonenumber: this.phonenumber}).catch(res=>{
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    if(res.data.success)
                    {
                        console.log("aw");
                        this.callToaster("toast-top-right",1);
                        document.querySelector('#contactModalForm').style.display = "none"
                        this.cleardata();
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 2000);
                    }
                    else
                    {
                        this.callToaster("toast-top-right",2);
                    }
                });
            }
        },
        EditRoleInfo(data){
            console.log(data);
            axios.post("userDesignations?branch_id="+data+"&_joins=mobile_branches,mobile_designation&_on=mobile_userdesignations.branch_id=mobile_branches.id,mobile_userdesignations.designation_id=mobile_designation.id&_batch=true",null,{}).catch(res=>{
            }).then(res=>{
                if(res.data.success == true)
                {
                    let arr = [];
                    arr = res.data.result;
                    arr.forEach(element => {
                        if(element.branch_id == data)
                        {
                            this.editrole = {
                                position: element.position,
                                designation_id: element.designation_id,
                                hourly_rate: element.hourly_rate,
                            }
                            lStore.set("editrolebranchid",data);
                            var dessselected = document.getElementById('desss');
                            dessselected.options[dessselected.selectedIndex].text = this.editrole.position;
                            dessselected.options[dessselected.selectedIndex].value = this.editrole.designation_id;
                            dessselected.options[dessselected.selectedIndex].disabled = true;
                            this.rates = this.editrole.hourly_rate;
                        }
                    });
                }
                else
                {
                    return;
                }
            });

        },
        EditPersonalInfo(){
            this.cleardata();
            var genderselected = document.getElementById('gender');
            genderselected.options[genderselected.selectedIndex].text = this.viewusers.gender;
            genderselected.options[genderselected.selectedIndex].value = this.viewusers.gender;
            genderselected.options[genderselected.selectedIndex].disabled = true;
            this.username = this.viewusers.username;
            this.address = this.viewusers.address;
            this.datehired = this.viewusers.date_hired;
        },
        EditcontactInfo(){
            this.cleardata();
            this.firstname =  this.viewusers.firstname;
            this.lastname = this.viewusers.lastname;
            this.phonenumber = this.viewusers.phonenumber;
            this.email = this.viewusers.email_address;
            
        },
    EditEmployee(){
        this.cleardata();
        this.role = this.viewusers.role;
        this.firstname = this.viewusers.firstname;
        this.lastname = this.viewusers.lastname;
        this.phonenumber = this.viewusers.phonenumber;
        this.gender = this.viewusers.gender;
        this.datehired = this.viewusers.date_hired;
        this.address = this.viewusers.address;
        this.username = this.viewusers.username;
        this.email = this.viewusers.email_address;
        this.userid = this.viewusers.user_id;
        this.rate = this.viewusers.hourly_rate;
        document.querySelector('#edes').value = this.viewusers.designation_id;
        document.querySelector('#egender').value = this.viewusers.gender;
        document.querySelector('#erole').value = this.viewusers.role;
        document.querySelector('#egender').value = this.viewusers.gender;
        document.querySelector('#edate').value = this.viewusers.date_hired;
    },
    callToaster(positionClass, reserror) {
            if (document.getElementById("toaster")) {
                toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: false,
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
                if(reserror == 1)
                {
                    toastr.success("Data was save successfully", "Successfully Save!");
                }
                if(reserror == 2)
                {
                    toastr.error("Something went Wrong!", "Error!");
                }
                if(reserror == 3)
                {
                    toastr.success("Data was successfully deleted!", "Successfully Deleted!");
                }
            }
        },
        TermEmployee(){
          this.status = 1
          axios.post("users/update?id="+lStore.get("userdetails"),null,{comments: this.comment,status: this.status}).catch(res=>{
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    if(res.data.success)
                    {
                        this.callToaster("toast-top-right",1);
                        this.cleardata();
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 2000);
                    }
                    else
                    {
                        this.callToaster("toast-top-right",2);
                    }
                });
        },
        RehireEmployee(){
          this.status = 0;
          axios.post("users/update?id="+lStore.get("userdetails"),null,{comments: this.comment,status: this.status}).catch(res=>{
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    if(res.data.success)
                    {
                        this.callToaster("toast-top-right",1);
                        this.cleardata();
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 2000);
                    }
                    else
                    {
                        this.callToaster("toast-top-right",2);
                    }
                });
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
.alert{
  display:none;
  margin-top: 20px;
}
.tab-content > .active
{
    display: block !important;
}
.accordion .card-header .btn::after{
    display: none;
}
</style>