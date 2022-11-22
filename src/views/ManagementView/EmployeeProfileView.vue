<template>
    <LayoutView>
        <div class="toast" >

        </div>
        <div class="modal fade" id="modal-add-contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <form >
                    <div class="modal-header px-4">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Employee</h5>
                    </div>

                    <div class="modal-body px-4">
                    <div class="form-group row mb-6">
                            <label for="coverImage" class="col-sm-4 col-lg-3 col-form-label">User Image</label>
                            <div class="col-sm-8 col-lg-6">
                                <div class="form-group">
                                    <input type="file" id="uploadFile2" class="form-control-file form-control height-auto" accept="image/x-png,image/gif,image/jpeg">
                                </div>
                            </div>
                    </div>
                    <div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="fname">First name</label>
								<input type="text" v-model="firstname" class="form-control" placeholder="John">
                                <div class="invalid-feedback feedback13">
								   
							    </div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label for="lname">Last name</label>
								<input type="text" v-model="lastname" class="form-control" placeholder="Smith">
                                <div class="invalid-feedback feedback14">
								   
							    </div>
							</div>
						</div>

                        <div class="col-sm-6">
							<div class="form-group">
								<label for="fname">Phone number</label>
								<input type="text" v-model="phonenumber" class="form-control" placeholder="+63">
                                <div class="invalid-feedback feedback15">
								   
							    </div>
							</div>
						</div>
                        <div class="col-sm-6">
							<div class="form-group">
								<label for="fname">Designation</label>
								<select class="form-control" id="edes">
                                    <option value="">Please Select Designation</option>
                                    <option v-for="desig in designation" :value="desig.id">{{desig.position}}</option>
                                </select>
                                <div class="invalid-feedback feedback16">
								   
							    </div>
							</div>
						</div>
                        <div class="col-sm-6">
							<div class="form-group">
								<label for="fname">Gender</label>
								<select class="form-control" id="egender">
                                    <option value="">Please select gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <div class="invalid-feedback feedback17">
								   
							    </div>
							</div>
						</div>
                        <div class="col-sm-6">
							<div class="form-group">
								<label for="fname">Role</label>
								<select class="form-control" id="erole">
                                    <option value="">Please select role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Employee">Employee</option>
                                </select>
                                <div class="invalid-feedback feedback18">
								   
							    </div>
							</div>
						</div>
                        <div class="col-sm-6">
							<div class="form-group">
								<label for="fname">Date Hired</label>
								<input type="date" id="edate" v-model="edate" class="form-control" placeholder="">
                                <div class="invalid-feedback feedback19">
								   
							    </div>
							</div>
						</div>
                        <div class="col-sm-6">
							<div class="form-group">
								<label for="fname">Rate $ (per hour)</label>
								<input type="text" v-model="rate" class="form-control" placeholder="$">
                                <div class="invalid-feedback feedback20">
								   
							    </div>
							</div>
						</div>
					</div>
                    <div class="row">
                        <div class="col-sm">
							<div class="form-group">
								<label for="fname">Address</label>
								<div id="geocoder3"></div>
                                <div class="invalid-feedback feedback21">
								   
							    </div>
							</div>
						</div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
							<div class="form-group">
								<label for="fname">Username</label>
								<input type="text" v-model="username" class="form-control" placeholder="">
                                <div class="invalid-feedback feedback22">
								   
							    </div>
							</div>
						</div>
                        <div class="col-sm">
							<div class="form-group">
								<label for="fname">Email</label>
								<input type="text" v-model="email" class="form-control" placeholder="">
                                <div class="invalid-feedback feedback23">
								   
							    </div>
							</div>
						</div>
                    </div>
                    <div class="row">
                            <div class="col-sm">
							<div class="form-group">
								<label for="fname">Password</label>
								<input type="password" v-model="password" class="form-control" placeholder="">
                                <div class="invalid-feedback feedback24">
								   
							    </div>
							</div>
						</div>
                        <div class="col-sm">
							<div class="form-group">
								<label for="fname">Confirm Password</label>
								<input type="password" v-model="confirmpassword" class="form-control" placeholder="">
                                <div class="invalid-feedback feedback25">
								   
							    </div>
							</div>
						</div>
                    </div>
                    </div>
                    <div class="modal-footer px-4">
                    <button type="button" class="btn btn-secondary btn-pill" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-pill savedB" @click="SaveEmployee">Update</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-add-contact-term" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <form >
                    <div class="modal-header px-4">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Terminate Employee</h5>
                    </div>

                    <div class="modal-body px-4">
                    
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="fname">Reason</label>
                          <textarea v-model="comment" class="form-control"></textarea>
                          <div class="invalid-feedback feedback13"></div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer px-4">
                    <button type="button" class="btn btn-secondary btn-pill" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-pill savedB" @click="TermEmployee">Update</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
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
                    <li class="breadcrumb-item" aria-current="page"><RouterLink to="/employee">Employee</RouterLink></li>
                    <li class="breadcrumb-item" aria-current="page">Profile</li>
                </ol>
                </nav>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="content">
                <div class="alert alert-danger" role="alert">
            Reason of Termination: 
            {{viewusers.comments}}
          </div>
                <div class="bg-white border rounded">
  <div class="row no-gutters">
    <div class="col-lg-4 col-xl-3">
      <div class="profile-content-left profile-left-spacing pt-5 pb-3 px-3 px-xl-5">
        <div class="card text-center widget-profile px-0 border-0">
          <div class="card-img mx-auto rounded-circle">
            <img :src="viewusers.profile_img" class="mr-3 img-fluid rounded" alt="user image">
          </div>
          <div class="card-body">
            <h4 class="py-2 text-dark">{{viewusers.firstname}} {{viewusers.lastname}}</h4>
            <p>{{viewusers.email_address}}</p>
            <a class="btn btn-primary btn-pill btn-lg my-4" href="#" data-toggle="modal" data-target="#modal-add-contact" @click="EditEmployee">Edit</a>
          </div>
        </div>

        <div class="d-flex justify-content-between ">
          <div class="text-center pb-4">
            <h6 class="text-dark pb-2">{{viewusers.gender}}</h6>
            <p>Gender</p>
          </div>

          <div class="text-center pb-4">
            <h6 class="text-dark pb-2">{{viewusers.position}}</h6>
            <p>Designation</p>
          </div>

          <div class="text-center pb-4">
            <h6 class="text-dark pb-2" v-if="viewusers.status == 0">Hired</h6>
            <h6 class="text-dark pb-2" v-if="viewusers.status == 1">Terminate</h6>
            <p>Status</p>
          </div>
        </div>

        <hr class="w-100">

        <div class="contact-info pt-4">
          <h5 class="text-dark mb-1">Basic Information</h5>
          <p class="text-dark font-weight-medium pt-4 mb-2">Email address</p>
          <p>{{viewusers.email_address}}</p>
          <p class="text-dark font-weight-medium pt-4 mb-2">Phone Number</p>
          <p>{{viewusers.phonenumber}}</p>
          <p class="text-dark font-weight-medium pt-4 mb-2">Username</p>
          <p>{{viewusers.username}}</p>
          <p class="text-dark font-weight-medium pt-4 mb-2">Address</p>
          <p>{{viewusers.address}}</p>
          <p class="text-dark font-weight-medium pt-4 mb-2">Date Hired</p>
          <p>{{viewusers.date_hired}}</p>
          <p class="text-dark font-weight-medium pt-4 mb-2">Rate(per hour)</p>
          <p>${{viewusers.hourly_rate}}</p>
          <p class="text-dark font-weight-medium pt-4 mb-2"></p>
        </div>
      </div>
    </div>

    <div class="col-lg-8 col-xl-9">
      <div class="profile-content-right profile-right-spacing py-5">
        <a class="btn btn-primary btn-pill btn-lg my-4" id = "empterm" href="#" @click="RehireEmployee"  v-if="viewusers.status == 1">Rehire</a>
        <a class="btn btn-danger btn-pill btn-lg my-4" id = "empterm" href="#" data-toggle="modal" data-target="#modal-add-contact-term" v-if="viewusers.status == 0 ">Terminate</a>
        <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="timeline-tab" data-toggle="tab" href="#timeline" role="tab" aria-controls="timeline" aria-selected="true">Uploaded Documents</a>
          </li>
        </ul>
        <FileMngr2>

        </FileMngr2>
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
            userid: "",
            search: "",
            filesrc: "",
            rate:"",
            comment:"",
          viewusers: {},
          mapToken: 'pk.eyJ1Ijoic3BlZWR5cmVwYWlyIiwiYSI6ImNsNWg4cGlzaDA3NTYzZHFxdm1iMTJ2cWQifQ.j_XBhRHLg-CcGzah7uepMA'
      };
  },
  mounted() 
  {
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
    axios.post("users?id="+lStore.get("userdetails")+"&_joins=mobile_designation&_on=mobile_users.designation_id=mobile_designation.id&_batch=true",null,{}).catch(res=>{
            this.callToaster("toast-top-right",2);
        }).then(res=>{
            console.log(res.data.result);
            res.data.result.forEach(el => {
            
            });
            res.data.result.forEach(el => {
                this.viewusers = el;
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
        console.log(this.viewusers);

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
                    console.log(res.data);
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
                    console.log(res.data);
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
    SaveEmployee(){
      document.querySelector('.feedback13').style.display = "none";
            document.querySelector('.feedback14').style.display = "none";
            document.querySelector('.feedback15').style.display = "none";
            document.querySelector('.feedback16').style.display = "none";
            document.querySelector('.feedback17').style.display = "none";
            document.querySelector('.feedback18').style.display = "none";
            document.querySelector('.feedback19').style.display = "none";
            document.querySelector('.feedback20').style.display = "none";
            document.querySelector('.feedback21').style.display = "none";
            document.querySelector('.feedback22').style.display = "none";
            document.querySelector('.feedback23').style.display = "none";
            let newUser = {
                firstname: this.firstname,
                lastname:this.lastname,
                phonenumber:this.phonenumber,
                datehired:this.datehired,
                address:this.address,
                username:this.username,
                email:this.email,
                password:this.password,
                confirmpassword:this.confirmpassword
            };
            const valid = validateForm(newUser,{
                firstname:"required",
                lastname:"required",
                phonenumber: "required",
                datehired: "required",
                username: "required",
                email: {
                    isEmail: true,
                    isRequired:true,
                    callback: res=>{
                        if(res!='invalid_email') return;
                        document.querySelector('.feedback23').textContent = "Email is not valid!";
                        document.querySelector('.feedback23').style.display = "block";
                    }
                },
                callback: (a)=>{
                    if(a == "firstname")
                    {
                        document.querySelector('.feedback13').textContent = "Firstname is required";
                        document.querySelector('.feedback13').style.display = "block";
                    }
                    if(a == "lastname")
                    {
                        document.querySelector('.feedback14').textContent = "Lastname is required";
                        document.querySelector('.feedback14').style.display = "block";
                    }
                    if(a == "phonenumber")
                    {
                        document.querySelector('.feedback15').textContent = "Phone number is required";
                        document.querySelector('.feedback15').style.display = "block";
                    }
                    if(a == "datehired")
                    {
                        document.querySelector('.feedback19').textContent = "Date Hired is required";
                        document.querySelector('.feedback19').style.display = "block";
                    }
                    if(a == "address")
                    {
                        document.querySelector('.feedback21').textContent = "Address is required";
                        document.querySelector('.feedback21').style.display = "block";
                    }
                    if(a == "username")
                    {
                        document.querySelector('.feedback22').textContent = "Username is required";
                        document.querySelector('.feedback22').style.display = "block";
                    }
                    if(a == "email")
                    {
                        document.querySelector('.feedback23').textContent = "Email is required";
                        document.querySelector('.feedback23').style.display = "block";
                    }
                }   
                
            });
            if(document.querySelector("#egender").value == ""){
                valid.allValid = false;
                document.querySelector('.feedback17').textContent = "Gender is required";
                document.querySelector('.feedback17').style.display = "block";
            }
            if(document.querySelector("#edes").value == "")
            {
                valid.allValid = false;
                document.querySelector('.feedback16').textContent = "Designation is required";
                document.querySelector('.feedback16').style.display = "block";
            }
            if(document.querySelector('#erole').value == "")
            {
                valid.allValid = false;
                document.querySelector('.feedback18').textContent = "Role is required";
                document.querySelector('.feedback18').style.display = "block";
            }
            if(valid.allValid) {
                this.designations = document.querySelector("#edes").value;
                this.gender = document.querySelector("#egender").value;
                this.role = document.querySelector("#erole").value;
               if( document.getElementById("uploadFile2").files.length == 0 ){
                if(this.password == "")
                {
                    axios.post("users/update?id="+lStore.get("userdetails"),null,{lastname: this.lastname, firstname: this.firstname, phonenumber: this.phonenumber, email_address: this.email,
                username: this.username, address: this.address, gender: this.gender, date_hired : this.datehired, role: this.role, designation_id:this.designations,hourly_rate : this.rate}).catch(res=>{
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    console.log(res.data);
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
                    return;
                }
                else
                {
                    axios.post("users/update?id="+lStore.get("userdetails"),null,{lastname: this.lastname, firstname: this.firstname, phonenumber: this.phonenumber, email_address: this.email,
                username: this.username, address: this.address, password: this.password, gender: this.gender, date_hired : this.datehired, role: this.role, designation_id:this.designations,hourly_rate : this.rate}).catch(res=>{
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    console.log(res.data);
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
                    return;
                }
                }
                let fname = document.getElementById("uploadFile2").files[0].name
                axios.post('files/upload?keep_filename=true',null,
                {file:document.getElementById("uploadFile2").files[0]}).catch(ress=>{
                    console.log(ress.data);
                }).then(ress=>{
                    console.log(ress.data);
                    if(!ress.data.success){
                        alert('Error Uploading File!');
                    }
                    this.filesrc = ress.data.file_name;
                    if(this.password == "")
                    {
                        axios.post("users/update?id="+lStore.get("userdetails"),null,{profile_img: "https://www.4angelshc.com/mobile/filesystem/"+this.filesrc,lastname: this.lastname, firstname: this.firstname, phonenumber: this.phonenumber, email_address: this.email,
                    username: this.username, address: this.address, gender: this.gender, date_hired : this.datehired, role: this.role, designation_id:this.designations,hourly_rate : this.rate}).catch(res=>{
                        this.callToaster("toast-top-right",2);
                    }).then(res=>{
                        console.log(res.data);
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
                    }
                    else
                    {
                        axios.post("users/update?id="+lStore.get("userdetails"),null,{profile_img: "https://www.4angelshc.com/mobile/filesystem/"+this.filesrc,lastname: this.lastname, firstname: this.firstname, phonenumber: this.phonenumber, email_address: this.email,
                    username: this.username, address: this.address,password: this.password, gender: this.gender, date_hired : this.datehired, role: this.role, designation_id:this.designations,hourly_rate : this.rate}).catch(res=>{
                        this.callToaster("toast-top-right",2);
                    }).then(res=>{
                        console.log(res.data);
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
                    }
                });
            }
            else
            {
                return;
            }
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
#profile{
  display: block;
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
</style>