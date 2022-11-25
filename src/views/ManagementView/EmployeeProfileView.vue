<template>
    <LayoutView>
        <div class="toast" >

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
                    <li class="breadcrumb-item" aria-current="page" @click="late-ups"><RouterLink to="/employee">Employee</RouterLink></li>
                    <li class="breadcrumb-item" aria-current="page" >Profile</li>
                </ol>
                </nav>
            </div>
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
                        <span>Employee at {{}} locations</span>
                        </li>

                        <li class="d-flex mb-1">
                        <i class="mdi mdi-phone mr-1"></i>
                        <span>{{viewusers.phonenumber}} | <i class="mdi mdi-email mr-1"></i> {{viewusers.email_address}}</span>
                        </li>
                    </ul>
                    </div>
                </div>

                <div class="btn-group d-flex">
                    <button class="btn btn-sm btn-danger" v-if="value == 0">
                        <i class="mdi mdi-account-alert"></i> Terminate
                    </button>
                    
                    <button class="btn btn-sm btn-primary" v-else>
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
                        <div class="tab-widget mt-5">
                            <div class="card-body">
                                <div id="accordion3" class="accordion accordion-bordered">
                                    <div class="card" v-for="r in usersroleb">
                                        <div class="card-header" id="heading1">
                                            <button class="btn btn-link text-uppercase font-weight-bold" data-toggle="collapse" data-target="#" aria-expanded="true" aria-controls="collapse1">
                                                {{r.name}}
                                            </button>
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
                            <div class="card">
                                <div class="card-header">
                                    Contact Information
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
                            <div class="card">
                                <div class="card-header">
                                    Personal Information
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
    axios.post("users?id="+lStore.get("userdetails")+"&_batch=true",null,{}).catch(res=>{
            this.callToaster("toast-top-right",2);
        }).then(res=>{
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
    axios.post("userDesignations?user_id="+lStore.get("userdetails")+"&_joins=mobile_branches,mobile_designation&_on=mobile_userdesignations.branch_id=mobile_branches.id,mobile_userdesignations.designation_id=mobile_designation.id&_batch=true",null,{}).catch(res=>{
        this.callToaster("toast-top-right",2);
    }).then(res=>{
        if(res.data.success == true)
        {
            this.usersroleb = res.data.result;
            console.log(this.usersroleb);
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

                }).then(ress=>{

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