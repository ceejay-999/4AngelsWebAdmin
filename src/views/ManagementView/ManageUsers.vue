<template>
    <LayoutView>
        <div id="toaster" >

        </div>
        <div class="modal fade" id="modal-add-users" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <form >
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create New Users</h5>
                        <button type="button" @click="clearVariable" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body px-4">
                        <div class="row mt-4">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                        <label for="coverImage" class="col-sm-4 col-lg-3 col-form-label">User Image</label>
                                        <div class="col-sm-8 col-lg-6">
                                            <div class="form-group">
                                                <input type="file" @change="onImageChange" class="form-control-file form-control height-auto" accept="image/x-png,image/gif,image/jpeg">
                                            </div>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label for="fname">Email Address</label>
                                    <input type="email" v-model="emailadd" class="form-control" placeholder="example@gmail.com">
                                    <div class="invalid-feedback feedback1">
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="lname">Firstname</label>
                                    <input type="text" v-model="firstname" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="lname">Lastname</label>
                                    <input type="text" v-model="lastname" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="lname">Hire Date</label>
                                    <input type="date" v-model="hiredate" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="fname">Access Level</label>
                                    <select class="form-control" id="role">
                                        <option value="">Please select Access Level</option>
                                        <option value="3">Manager</option>
                                        <option value="2">Supervisor</option>
                                    </select>
                                    <div class="invalid-feedback feedback3">
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label>Facilities</label>
                                <div  class="custom-control custom-checkbox mr-sm-2">
                                    <input @click="checkclicked" class="custom-control-input" type="checkbox" id="facility" name="facility" value="All"  ref="facilitySelected"/>
                                    <label class="custom-control-label" for="facility">All Facility</label>
                                </div>
                                <div class="selectfacility">
                                    <div id="roles_select_con" class="full">
                                        <input class="form-control" id="roles_select_input" v-model="searchDesignations" placeholder="Search in Facilities">
                                        <ul>
                                            <li v-for="d,i in filteredDesignations" :key="i" @click="selectDesignation(d.facility_id)">{{d.facility_name}}</li>
                                        </ul>
                                    </div>
                                    <div class="roles_select_selected full" >
                                        <div class="roles_selected_item" v-for="qd,i in queSched.designations" :key="i">
                                            {{objFromArr('designations',qd).facility_name}}
                                            <a href="javascript:;" @click="queSched.designations.splice(i,1)">&times;</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback feedback4">
                                    
                                </div>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <div class="form-group">
                                    <label for="lname">Password</label>
                                    <input type="password" v-model="password" class="form-control" placeholder="******">
                                    <div class="invalid-feedback feedback5">
                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="lname">Confirm Password</label>
                                    <input type="password" v-model="cpassword" class="form-control" placeholder="******">
                                    <div class="invalid-feedback feedback6">
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer px-4">
                        <button type="button" class="btn btn-secondary btn-pill" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-pill savedB" @click="SaveUsers">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!--Add User Modal End-->
        <div class="modal fade" id="modal-view-users" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalFormTitle">User ID: <span class="text-white">{{ specificusers.users_id }}</span></h5>
                        <button type="button" @click="clearVariable" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex justify-content-center">
                                <img class="mr-3 img-fluid rounded" src="../../assets/users.png" />
                                <div class="info">
                                    <h5 class="mt-0 mb-2 text-dark">{{ specificusers.users_username}}</h5>
                                    <h5 class="mt-0 mb-2 text-dark">{{ specificusers.users_email_address}}</h5>
                                    <h5 class="mt-0 mb-2 text-dark" v-if="specificusers.users_permission_status == 1">Admin</h5>
                                    <h5 class="mt-0 mb-2 text-dark" v-if="specificusers.users_permission_status == 2">Supervisor</h5>
                                    <h5 class="mt-0 mb-2 text-dark" v-if="specificusers.users_permission_status == 3">Manager</h5>
                                    <h5 class="mt-0 mb-4 text-dark">Manage {{ lfacility }} Facilities</h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end text-primary">
                                <span class="mdi mdi-circle-edit-outline">Edit Info</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>Facilities Manage</h5>
                                    <div class="text-primary" v-for="f in facilitiesm">
                                        <h4>{{ f.facility_name }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="clearVariable" class="btn btn-danger btn-pill" data-dismiss="modal">Cancel</button>
                        <!-- <button type="button" class="btn btn-primary btn-pill editbut" data-dismiss="" @click="EditRole">Edit</button> -->
                    </div>
                </div>
            </div>
        </div>
        <!--View User Modal End-->
        <div class="breadcrumb-wrapper breadcrumb-contacts">
        <div>
            <h1>Managers Accounts</h1>
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item">
                        <RouterLink to="/dashboard">
                        <span class="mdi mdi-home"></span>                
                        </RouterLink>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Manager Accounts</li>
                </ol>
                </nav>
        </div>
        <div class="d-flex align-items-center">
            <div class="form-inline mr-2">
                <input class="form-control" type="search" v-model="searchkey" placeholder="Search" aria-label="Search">
                <button class="btn btn-success my-2 my-sm-0" @click="SearchEmp" type="submit"><span class="mdi mdi-magnify"></span></button>
            </div>
            <button class="btn btn-primary my-2 my-sm-0" data-toggle="modal" data-target="#modal-add-users" @click="cleardata()" type="submit">Add User</button>
        </div>
        </div>
        <div class="card card-table-border-none recent-orders" id="recent-orders">
                    <div class="card-header justify-content-between">
                      <h2>Users Table</h2>
                    </div>
                    <div class="card-body pt-0 pb-5">
                      <table class="table card-table table-responsive table-responsive-large" style="width:100%">
                        <thead>
                          <tr>
                            <th>User ID</th>
                            <th>Image</th>
                            <th>Fullname</th>
                            <th class="d-none d-lg-table-cell">Email</th>
                            <th>Status</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" v-if="users == null"> <div class="text-center"><div> No Data Found </div></div></td>
                            </tr>
                          <tr v-for="u in users">
                            <td >{{ u.user_id }}</td>
                            <td><img v-if="u.user_photo == '' || u.user_photo == null" src="../../assets/default-profile.png" alt="Profile" class="rounded float-start"> <img v-else :src="'https://www.4angelshc.com/wangelmobile/'+u.user_photo" alt="Profile" class="rounded float-start"></td>
                            <td >
                              {{u.user_firstname}} {{ u.user_lastname }}
                            </td>
                            <td class="d-none d-lg-table-cell">{{u.user_email}}</td>
                            <td >
                              <span class="badge badge-success" v-if="u.user_access_level_id == 1">Admin</span>
                              <span class="badge badge-primary" v-if="u.user_access_level_id == 2">Supervisor</span>
                              <span class="badge badge-info" v-if="u.user_access_level_id == 3">Manager</span>
                            </td>
                            <td class="text-right">
                              <div class="dropdown show d-inline-block widget-dropdown">
                                <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                  <li class="dropdown-item">
                                    <a href="#" @click="ViewUsers(u.users_id)" data-toggle="modal" data-target="#modal-view-users">View</a>
                                  </li>
                                </ul>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>

    </LayoutView>
</template>
<script>
import LayoutView from "../../views/SharedLayoutView/LayoutView.vue"
import axiosA from 'axios';
import 'chosen-js/chosen.jquery.min.js'
import toastr from 'toastr';
import { lStore, axios , validateForm, elementLoad } from '../../functions';

export default ({
    name: "App",
    components: {
    LayoutView
    },
    data(){
        return{
            queSched: {
                designations: [],
            },
            rolenumberformindex: 0,
            users: [],
            cpassword: "",
            password: "",
            hiredate: "",
            firstname: "",
            lastname: "",
            emailadd: "",
            designations:[],
            searchDesignations: "",
            specificusers: [],
            lfacility: 0,
            facilitiesm: [],
            searchkey: "",
            profile: [],
            userid: "",
            searchkey: "",
            selectedImage: "",
        }
    },
    computed:{
        filteredDesignations(){
            let filtered = this.designations.filter(el=>{
                return el.facility_name.toLowerCase().includes(this.searchDesignations.toLowerCase()) && !this.queSched.designations.includes(el.facility_id);
            });
            return filtered;
        }
    },
    mounted(){
        this.profile = lStore.get('userdetails');
        this.userid = this.profile.user_id;

        axios.post("usercontroller/viewallusermanagers",null,{useraccess: this.profile.user_access_level_id}).then(res=>{
            if(res.data.success){
                this.users = res.data.result;
            }
        });
        axios.post("facilitycontroller/viewallfacility",null,{'userid': this.userid}).then(res=>{
            if(res.data.success){
                this.designations = res.data.result;
            }
        });
    },
    methods: {
        SearchEmp(){
            axios.post("usercontroller/viewsearchusermanagers",null,{ useraccess: this.profile.user_access_level_id, $key: this.searchkey   }).then(res=>{
                this.users = res.data.result;
            });
        },
        checkclicked(){
            if(this.$refs.facilitySelected.checked == true)
            {
                document.querySelector('.selectfacility').style.display = 'none';
            }
            else
            {
                document.querySelector('.selectfacility').style.display = 'block';
            }
        },
        objFromArr(arr,id){
            return this[arr].find(el=>el.facility_id == id);
        },
        selectDesignation(num){
            if(this.queSched.designations.includes(num))
                this.queSched.designations.splice(this.queSched.designations.indexOf(num),1);
            else
                this.queSched.designations.push(num);
            this.searchDesignations = '';
        },
        cleardata(){
            this.rolenumberformindex = 0;
        },
        SaveUsers(){
            document.querySelector('.feedback1').style.display = "none";
            document.querySelector('.feedback3').style.display = "none";
            document.querySelector('.feedback4').style.display = "none";
            document.querySelector('.feedback5').style.display = "none";
            document.querySelector('.feedback6').style.display = "none";
            let checkvalid = 0;
            let newUsers = {
                password : this.password,
                emailadd : this.emailadd,
                cpassword: this.cpassword,
                accesslevel : document.querySelector("#role").value,
                facility: this.$refs.facilitySelected.checked,
                branch: this.queSched.designations,
            }
            const valid = validateForm(newUsers,{
                password: "required",
                accesslevel: "required",
                facility: "required",
                branch: "required",
                emailadd: {
                    isEmail: true,
                    isRequired:true,
                    callback: res=>{
                        if(res=='invalid_email'){
                            document.querySelector('.feedback1').textContent = "Email is not valid!";
                            document.querySelector('.feedback1').style.display = "block";
                            checkvalid = 1;
                        }
                        if(res == 'empty')
                        {
                            document.querySelector('.feedback1').textContent = "Email is required!";
                            document.querySelector('.feedback1').style.display = "block";
                            checkvalid = 1;
                        }
                    }
                },
                cpassword: {
                    equalTo: this.password,
                    isRequired: true,
                    callback: res=>{
                        if(res == "values_not_match")
                        {
                            document.querySelector('.feedback6').textContent = "Password and Confirm Password doesn`t match";
                            document.querySelector('.feedback6').style.display = "block";
                            checkvalid = 1;
                        }
                        if(res == "empty")
                        {
                            document.querySelector('.feedback6').textContent = "Confirm Password is required";
                            document.querySelector('.feedback6').style.display = "block";
                            checkvalid = 1;
                        }
                    }
                },
                callback: (a)=>{
                    if(a == "password")
                    {
                        document.querySelector('.feedback5').textContent = "password is required";
                        document.querySelector('.feedback5').style.display = "block";
                        checkvalid = 1;
                    }
                    if(a == "accesslevel")
                    {
                        document.querySelector('.feedback3').textContent = "access level is required";
                        document.querySelector('.feedback3').style.display = "block";
                        checkvalid = 1;
                    }
                    if(a == "facility")
                    {
                        if(newUsers.branch.length == 0)
                        {
                            document.querySelector('.feedback4').textContent = "Facilities is required";
                            document.querySelector('.feedback4').style.display = "block";
                            checkvalid = 1;
                        }
                    }
                }
            });
            if(checkvalid == 0)
            {
                let email = newUsers.emailadd;
                let password = newUsers.password;
                let accesslevel = newUsers.accesslevel;
                let file = null;
                if(this.selectedImage != null){
                    file = this.selectedImage;
                }
                let form = new FormData();
                form.append('email', this.emailadd);
                form.append('status', accesslevel);
                form.append('password', this.password);
                form.append('firstname', this.firstname);
                form.append('lastname', this.lastname);
                form.append('datehired', this.datehired);
                form.append('confirmpassword', this.cpassword);
                form.append('file', file);
                axiosA.post('https://www.4angelshc.com/wangelmobile/usercontroller/addusermangers',form).then(res =>{
                    if(res.data.success)
                    {
                        newUsers.branch.forEach(element => {
                            axios.post('facilitycontroller/createpermition',null,{userid: res.data.result, facilityid: element}).then(res=>{
                                if(res.data.success)
                                {
                                    
                                }
                            });
                        });
                        this.callToaster("toast-top-right",res.data);
                        this.clearModal('modal-add-users');
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 2000);
                    } 
                    else
                    {
                        this.callToaster("toast-top-right",res.data);
                        return;
                    }
                })


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
        onImageChange(e) {
            const selectedFile = e.target.files[0];
            this.photo = URL.createObjectURL(selectedFile);
            this.selectedImage = e.target.files[0];
            e.target.files[0] = null;
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
@import 'chosen-js/chosen.css';
@import '../../assets/scss/_card.scss';
@import '../../assets/scss/_breadcrumb.scss';
@import '../../assets/scss/_type.scss';
@import '../../assets/scss/_reboot.scss';
@import '../../assets/sleek.min.css';

.card-body{
    overflow: auto;
}
#remove_phone_number{
    display: none;
}
#add_role{
    display: none;
}
/* multiple selection */
#roles_select_con{position: relative;}
#roles_select_input{width: calc(100% - 10px);}
#roles_select_con ul{
    display: none;
    position: absolute;
    top: 100%;
    list-style: none;
    padding: 0;
    width: 100%;
    margin: 0;
    box-shadow: 0 0 2px #000;
    z-index: 100;
}
#roles_select_con:focus-within ul,#roles_select_con ul:hover{ display: block;}
#roles_select_con ul li{
    padding: 7px;
    background: #fff;
}

#roles_select_con ul li:hover{
    padding: 7px;
    background: #2095db;
    color:#fff
}
.roles_select_selected{
    display: flex;
    flex-wrap: wrap;
    gap:3px;
}
.roles_selected_item{
    display: inline-block;
    border: 1px solid #aaa;
    padding: 5px 7px;
    border-radius: 50px;
    margin-top: 5px;
}
.roles_selected_item a{
    background: #777;
    width: 28px;
    height: 28px;
    display: inline-block;
    text-align: center;
    color: #fff;
    text-decoration: none;
    border-radius: 50%;
    margin-left: 5px;
}
.roles_selected_item a:hover{background: #555;}
.modal-header{
    border-radius: 20px 20px 0 0;
}
.modal-content{
    border-radius: 20px;
}
.rounded{
    max-width: 50px;
}
</style>