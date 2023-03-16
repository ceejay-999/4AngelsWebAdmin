<template>
    <LayoutView>
        <div id="toaster" >

        </div>
        <div class="modal fade" id="modal-add-contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <form >
                    <div class="modal-header px-4">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Create New Employee</h5>
                    </div>

                    <div class="modal-body px-4">
                        <div class="form-group row">
                                <label for="coverImage" class="col-sm-4 col-lg-3 col-form-label">User Image</label>
                                <div class="col-sm-8 col-lg-6">
                                    <div class="form-group">
                                        <input type="file" id="uploadFile1" class="form-control-file form-control height-auto" accept="image/x-png,image/gif,image/jpeg">
                                    </div>
                                </div>
                        </div>
                        <h4 class="mt-4">General Information</h4>
                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fname">First name</label>
                                    <input type="text" v-model="firstname" class="form-control" placeholder="John">
                                    <div class="invalid-feedback feedback1">
                                    
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="lname">Last name</label>
                                    <input type="text" v-model="lastname" class="form-control" placeholder="Smith">
                                    <div class="invalid-feedback feedback2">
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fname">Date Hired</label>
                                    <input type="date" v-model="datehired" class="form-control" placeholder="">
                                    <div class="invalid-feedback feedback6">
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="fname">Birthdate</label>
                                    <input type="date" v-model="birthdate" class="form-control" placeholder="">
                                    <div class="invalid-feedback feedback7">
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="mt-4">Contact Information</h4>
                        <div class="row mt-4">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="fname">Phone number</label>
                                    <input type="text" v-model="phonenumber" class="form-control" placeholder="">
                                    <div class="invalid-feedback feedback3">
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="fname">Email</label>
                                    <input type="email" v-model="email" class="form-control" placeholder="">
                                    <div class="invalid-feedback feedback10">
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="fname">Password</label>
                                    <input type="password" v-model="password" class="form-control" placeholder="">
                                    <div class="invalid-feedback feedback11">
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="fname">Confirm Password</label>
                                    <input type="password" v-model="confirmpassword" class="form-control" placeholder="">
                                    <div class="invalid-feedback feedback12">
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="mt-4">Roles Manangement</h4>
                            <div class="invalid-feedback feedback13">
                                                
                            </div>
                            <div class="mt-4">
                                <a id="add_role" class="adrole ml-2 btn btn-primary btn-sm">Add Role</a>
                            </div>
                            <div id="phone_number_form">
                                <div class="row mt-4">
                                    <div class="col-sm-3">

                                            <label for="fname">Role</label>
                                            <select class="form-control" id="des">
                                                <option value="">Please Select Role</option>
                                                <option v-for="desig in designation" :value="desig.role_id">{{desig.role_name}}</option>
                                            </select>

                                    </div>
                                    <div class="col-sm-3">

                                            <label for="fname">Rate $ (per hour)</label>
                                            <input id="rates" type="text" class="form-control" placeholder="$">

                                    </div>
                                    <div class="col-sm-4">

                                            <label for="fname">Facilities</label>
                                            <select class="form-control" id="bran">
                                                <option value="">Please Select Facilities</option>
                                                <option v-for="br in branches" :value="br.facility_id">{{br.facility_name}}</option>
                                            </select>

                                    </div>
                                    <div class="col-sm-1">
                                        <label></label>
                                        <input type="button" id="remove_phone_number" class="adrole mt-2 btn btn-danger" value="X">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer px-4">
                    <button type="button" class="btn btn-secondary btn-pill" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-pill savedB" @click="SaveEmployee">Save Employee</button>
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
                    <li class="breadcrumb-item" aria-current="page">Employee</li>
                </ol>
                <div class="form-check form-check-inline">
                    <button type="button" class="btn btn-outline-primary" v-if="value==0" @click="ShowTerm">Show Terminate</button>
                    <button type="button" class="btn btn-primary" v-else @click="ShowTerm">Hide Terminate</button>
                </div>
                </nav>

        </div>
        <div class="d-flex align-items-center">

            <div class="form-inline mr-2">
                <input class="form-control" type="search" v-model="searchkey" placeholder="Search" aria-label="Search">
                <button class="btn btn-success my-2 my-sm-0" @click="SearchEmp" type="submit"><span class="mdi mdi-magnify"></span></button>
            </div>
            <RouterLink to="/employeeexcel" target="_blank"><div class="mr-2 btn btn-primary"><span class="mdi mdi-download">Download Excel CSV</span></div></RouterLink>
            <!-- <RouterLink to="/employeeprint" target="_blank"><div class="mr-2 btn btn-info"><span class="mdi mdi-printer">Print</span></div></RouterLink> -->
            <button @click="cleardata" type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-add-contact"> Add Employee
            </button>
        </div>
        </div>
        <div class="row">
            <div class="textcenter"></div>
            <div class="d-flex justify-content-center" v-if="users.length == 0"><div> No Data Found </div></div>
            <div class="col-lg-6 col-xl-4" v-else v-for="u in users" :key = "u.user_id">
                <div class="card card-default p-4">
                <a href="#" class="media text-secondary" @click="ViewEmployee(u.user_id)">
                    <img src="../../assets/default-profile.png" class="mr-3 img-fluid rounded" alt="Avatar Image" v-if="u.user_photo == null || u.user_photo == ''">
                    <img v-else :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+ u.user_photo" class="mr-3 img-fluid rounded" alt="Avatar Image">

                    <div class="media-body">
                    <h5 class="mt-0 mb-2 text-dark">{{u.user_firstname}} {{u.user_lastname}}</h5>

                    <ul class="list-unstyled">
                        <li class="d-flex mb-1">
                        <i class="mdi mdi-email mr-1"></i>
                        <span>{{u.user_email}}</span>
                        </li>

                        <li class="d-flex mb-1">
                        <i class="mdi mdi-phone mr-1"></i>
                        <span>{{u.user_phone}}</span>
                        </li>
                        
                        <li class="d-flex mb-1">
                        <i class="mdi mdi-account-check text-success" v-if="u.user_status == 1"></i>
                        <i class="mdi mdi-account-alert text-danger" v-else></i>
                        <span v-if="u.user_status == 1" class="text-success"> Active</span>
                        <span v-else class="text-danger"> Terminate</span>
                        </li>
                    </ul>
                    </div>
                </a>
                </div>
            </div>
        </div>
    </LayoutView>
</template>
<script>
import LayoutView from "../../views/SharedLayoutView/LayoutView.vue"
import { axios,validateForm } from '@/functions';
import 'chosen-js/chosen.jquery.min.js'
import { elementLoad, lStore } from "../../functions";
import toastr from 'toastr';
import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder';
import mapboxgl from 'mapbox-gl';
import '@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css';

export default ({
    name: "App",
    components: {
    LayoutView
    },
    data(){
        return{
            rolenumberformindex: 0,
            value: "",
            branches: [],
            designation: [],
            firstname: "",
            lastname: "",
            phonenumber: "",
            gender: "",
            datehired: "",
            rate: "",
            birthdate: "",
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
            mapToken: 'pk.eyJ1Ijoic3BlZWR5cmVwYWlyIiwiYSI6ImNsNWg4cGlzaDA3NTYzZHFxdm1iMTJ2cWQifQ.j_XBhRHLg-CcGzah7uepMA',
            searchkey: ""
        }
    }, 
    mounted() {
        $("#add_role").click(()=>{
            this.rolenumberformindex++;
            $("#phone_number_form").after($("#phone_number_form").clone().attr("id","phone_number_form" + this.rolenumberformindex));
            $("#phone_number_form" + this.rolenumberformindex).css("display","inline");
            var a = this.rolenumberformindex;
            $("#phone_number_form" + this.rolenumberformindex + " :input").each(function(){
                $(this).attr("name",$(this).attr("name") + a);
                $(this).attr("id",$(this).attr("id") + a);
                });
            
            $("#remove_phone_number" + this.rolenumberformindex).click(()=>{
                this.rolenumberformindex--;
            })
            $("#remove_phone_number" + this.rolenumberformindex).click(function(){
                $("#phone_number_form"+ a).remove();
            });
        });
        //End Adding multiple role
        mapboxgl.accessToken = this.mapToken;

        const geocoder1 = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl
        });
        const geocoder2 = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl
        });

        elementLoad('#geocoder1').then(()=>{
            geocoder2.addTo('#geocoder1');
        });
        elementLoad('#geocoder2').then(()=>{
            if($('.mapboxgl-ctrl-geocoder').length == 1){
                
                geocoder2.addTo('#geocoder2');
            }
         });

        geocoder1.on('result', e => {
            this.address = e.result.place_name;
        });

        geocoder2.on('result', e => {
            this.address = e.result.place_name;
        });

        axios.post("rolecontroller/DisplayAllRoles",{pwauth: lStore.get('usertoken')}).then(res=>{
            if(res.data.success){
                this.designation = res.data.result;
            }
        });
        axios.post("usercontroller/ReadEmployee",{pwauth: lStore.get('usertoken')},null).catch(res=>{
        }).then(res=>{
            console.log(res.data.success);
            if(res.data.success)
            {
                this.users = res.data.result;
            }
            console.log(this.users);
        });
        axios.post("facilitycontroller/facilities").then(res=>{
            this.branches = res.data.result;
        })
    },
    methods : {
        // SearchEmp(){
        //     this.users = [];
        //     axios.post("employee/search?concat=firstname:+:lastname&s="+this.searchkey+"&batch=true").then(res=>{
        //         if(res.data.result == null)
        //         {
        //             return;
        //         }
        //         this.users = res.data.result;
        //         this.searchkey = "";
        //     });
        // },
        ShowTerm(){                                                                                                                                        
            if(this.value == 0)
            {
                this.value = 1;
                axios.post("usercontroller/ReadwithTermiEmployee",{pwauth: lStore.get('usertoken')}).then(res=>{
                  this.users = res.data.result;
                })
            }
            else
            {
                this.value = 0;
                axios.post("usercontroller/ReadEmployee",{pwauth: lStore.get('usertoken')}).catch(res=>{
                }).then(res=>{
                    this.users = res.data.result;
                });
            }
        },
        SaveEmployee(){
            document.querySelector('.feedback1').style.display = "none";
            document.querySelector('.feedback2').style.display = "none";
            document.querySelector('.feedback3').style.display = "none";
            document.querySelector('.feedback6').style.display = "none";
            document.querySelector('.feedback7').style.display = "none";
            document.querySelector('.feedback10').style.display = "none";
            document.querySelector('.feedback11').style.display = "none";
            document.querySelector('.feedback12').style.display = "none";
            document.querySelector('.feedback13').style.display = "none";
            let newUser = {
                employee_firstname: this.firstname,
                employee_lastname:this.lastname,
                employee_hiredate: this.datehired,
                employee_phonenumber:this.phonenumber,
                employee_birthday: this.birthdate,
                employee_emailaddress:this.email,
                employee_password:this.password,
                confirmpassword:this.confirmpassword,
                file: document.getElementById('uploadFile1').files[0]
            };
            let check = 0;
            if(this.rolenumberformindex > 0)
            {
                let newArrRole = [];
                let newRole = {
                    assigndesignation_roleid: document.querySelector("#des").value,
                    assigndesignation_facilityid: document.querySelector("#bran").value,
                    assigndesignation_wagerate: document.querySelector("#rates").value,
                }
                newArrRole.push(newRole);
                for(let i = 1; i <= this.rolenumberformindex; i++)
                {
                    newRole = {
                        assigndesignation_roleid: document.querySelector("#des"+ i).value,
                        assigndesignation_facilityid: document.querySelector("#bran"+ i).value,
                        assigndesignation_wagerate: document.querySelector("#rates"+ i).value,
                    }
                    newArrRole.push(newRole);
                    (newArrRole).forEach(element => {
                        let roleval = validateForm(element,{
                            assigndesignation_roleid: "required",
                            assigndesignation_facilityid: "required",
                            assigndesignation_wagerate: "required",
                            callback: (a)=>{
                                if(a == "role")
                                {
                                    document.querySelector('.feedback13').textContent = "There is Field that is required but empty";
                                    document.querySelector('.feedback13').style.display = "block";
                                }
                                if(a == "branch")
                                {
                                    document.querySelector('.feedback13').textContent = "There is Field that is required but empty";
                                    document.querySelector('.feedback13').style.display = "block";
                                }
                                if(a == "rate")
                                {
                                    document.querySelector('.feedback13').textContent = "There is Field that is required but empty";
                                    document.querySelector('.feedback13').style.display = "block";
                                }
                            }
                        });
                        if(!roleval.allValid)
                        {
                            check++;
                        }
                    });
                }
            }
            else{
                let newRole = {
                    assigndesignation_roleid: document.querySelector("#des").value,
                    assigndesignation_facilityid: document.querySelector("#bran").value,
                    assigndesignation_wagerate: document.querySelector("#rates").value,
                    }
                    let rolevalid = validateForm(newRole,{
                        assigndesignation_roleid: "required",
                        assigndesignation_facilityid: "required",
                        assigndesignation_wagerate: "required",
                        callback: (a)=>{
                            if(a == "role")
                            {
                                document.querySelector('.feedback13').textContent = "There is Field that is required but empty";
                                document.querySelector('.feedback13').style.display = "block";
                            }
                            if(a == "branch")
                            {
                                document.querySelector('.feedback13').textContent = "There is Field that is required but empty";
                                document.querySelector('.feedback13').style.display = "block";
                            }
                            if(a == "rate")
                            {
                                document.querySelector('.feedback13').textContent = "There is Field that is required but empty";
                                document.querySelector('.feedback13').style.display = "block";
                            }
                        }
                    });
                    if(!rolevalid.allValid)
                    {
                        check++;
                    }
            }
            const valid = validateForm(newUser,{
                employee_firstname:"required",
                employee_lastname:"required",
                employee_phonenumber: "required",
                employee_birthday: "required",
                employee_hiredate: "required",
                employee_emailaddress: {
                    isEmail: true,
                    isRequired:true,
                    callback: res=>{
                        if(res!='invalid_email') return;
                        document.querySelector('.feedback10').textContent = "Email is not valid!";
                        document.querySelector('.feedback10').style.display = "block";
                    }
                },
                employee_password: "required",
                confirmpassword: {
                    equalTo: this.password,
                    isRequired: true,
                    callback: res=>{
                        if(res == "values_not_match")
                        {
                            document.querySelector('.feedback11').textContent = "Password and Confirm Password doesn`t match";
                            document.querySelector('.feedback11').style.display = "block";
                        }
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
                        document.querySelector('.feedback3').textContent = "Phone number is required";
                        document.querySelector('.feedback3').style.display = "block";
                    }
                    if(a == "employee_birthday")
                    {
                        document.querySelector('.feedback3').textContent = "Birthday is required";
                        document.querySelector('.feedback3').style.display = "block";
                    }
                    if(a == "employee_emailaddress")
                    {
                        document.querySelector('.feedback10').textContent = "Email is required";
                        document.querySelector('.feedback10').style.display = "block";
                    }
                    if(a == "employee_password")
                    {
                        document.querySelector('.feedback11').textContent = "Password is required";
                        document.querySelector('.feedback11').style.display = "block";
                    }
                    if(a == "confirmpassword")
                    {
                        document.querySelector('.feedback12').textContent = "Confirm Password is required";
                        document.querySelector('.feedback12').style.display = "block";
                    }
                }
            });
            if(valid.allValid && check == 0){
                let roleArrusers = [];
                let roleusers = {
                    assigndesignation_roleid: document.querySelector("#des").value,
                    assigndesignation_wagerate: document.querySelector("#rates").value,
                    assigndesignation_facilityid: document.querySelector("#bran").value,
                };
                roleArrusers.push(roleusers);
                if(this.rolenumberformindex > 0)
                {
                    for(let i = 1; i <= this.rolenumberformindex; i++)
                    {
                        roleusers = {
                            assigndesignation_roleid: document.querySelector("#des"+i).value,
                            assigndesignation_wagerate: document.querySelector("#rates"+i).value,
                            assigndesignation_facilityid: document.querySelector("#bran"+i).value,
                        };
                        roleArrusers.push(roleusers);
                    }
                }
                delete newUser.confirmpassword;
                axios.post("usercontroller/CreateEmployee",{pwauth: lStore.get('usertoken')},newUser).then(res=>{
                     let user = res.data.result;
                     roleArrusers.forEach((el,i)=>{
                        let data = {
                            'userid': user,
                            'roleid': el.assigndesignation_roleid,
                            'facilityid': el.assigndesignation_facilityid,
                            'wage': el.assigndesignation_wagerate,
                        };
                        axios.post("rolecontroller/InsertProfession",null,data).then(ress=>{
                            if(ress.data.success){
                            }
                        });
                     });
                     this.callToaster("toast-top-right",res.data);
                     setTimeout(() => {
                        this.$router.go();
                     }, 2000);
                });
            }

        },
        ViewEmployee(data){
           lStore.set('employeeid',data);
           this.$router.replace('/employee/profile');
        },
        cleardata(){
            this.firstname = "";
            this.lastname = "";
            this.phonenumber = "";
            this.gender = "";
            this.datehired = "";
            this.address = "";
            this.email = "";
            this.password = "";
            this.confirmpassword = "";
            this.designations = "";
            this.role = "";
            this.userid = "";
            this.search = "";
            this.filesrc = "";
            this.rate = "";
            document.querySelector('.feedback1').style.display = "none";
            document.querySelector('.feedback2').style.display = "none";
            document.querySelector('.feedback3').style.display = "none";
            document.querySelector('.feedback6').style.display = "none";
            document.querySelector('.feedback7').style.display = "none";
            document.querySelector('.feedback10').style.display = "none";
            document.querySelector('.feedback11').style.display = "none";
            document.querySelector('.feedback12').style.display = "none";
            document.querySelector('.feedback13').style.display = "none";
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
    },
})

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
.adrole{
    cursor: pointer;
}
#remove_phone_number{
    display: none;
}
</style>