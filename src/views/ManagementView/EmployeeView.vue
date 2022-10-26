<template>
    <LayoutView>
        <div class="modal fade" id="modal-add-contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <form >
                    <div class="modal-header px-4">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Create New Employee</h5>
                    </div>

                    <div class="modal-body px-4">
                    <div class="form-group row mb-6">
                            <label for="coverImage" class="col-sm-4 col-lg-3 col-form-label">User Image</label>

                        <div class="col-sm-8 col-lg-6">
                            <FileView></FileView>
                            </div>
                    </div>
                    <div class="row">
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
								<label for="fname">Phone number</label>
								<input type="text" v-model="phonenumber" class="form-control" placeholder="+63">
                                <div class="invalid-feedback feedback3">
								   
							    </div>
							</div>
						</div>
                        <div class="col-sm-6">
							<div class="form-group">
								<label for="fname">Designation</label>
								<select class="form-control" id="des">
                                    <option value="">Please Select Designation</option>
                                    <option v-for="desig in designation" :value="desig.id">{{desig.position}}</option>
                                </select>
                                <div class="invalid-feedback feedback4">
								   
							    </div>
							</div>
						</div>
                        <div class="col-sm-6">
							<div class="form-group">
								<label for="fname">Gender</label>
								<select class="form-control" id="gender">
                                    <option value="">Please select gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <div class="invalid-feedback feedback5">
								   
							    </div>
							</div>
						</div>
                        <div class="col-sm-6">
							<div class="form-group">
								<label for="fname">Role</label>
								<select class="form-control" id="role">
                                    <option value="">Please select gender</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Employee">Employee</option>
                                </select>
                                <div class="invalid-feedback feedback12">
								   
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
								<label for="fname">Assign to branch</label>
								<select class="chosen-select" id="branc" multiple>
                                    <option v-for="bran in branches" :value="bran.id">{{bran.name}}</option>
                                </select>
                                <div class="invalid-feedback feedback8">
								   
							    </div>
							</div>
						</div>
					</div>
                    <div class="row">
                        <div class="col-sm">
							<div class="form-group">
								<label for="fname">Address</label>
								<input type="text" v-model="address" class="form-control" placeholder="">
                                <div class="invalid-feedback feedback7">
								   
							    </div>
							</div>
						</div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
							<div class="form-group">
								<label for="fname">Username</label>
								<input type="text" v-model="username" class="form-control" placeholder="">
                                <div class="invalid-feedback feedback9">
								   
							    </div>
							</div>
						</div>
                        <div class="col-sm">
							<div class="form-group">
								<label for="fname">Email</label>
								<input type="text" v-model="email" class="form-control" placeholder="">
                                <div class="invalid-feedback feedback10">
								   
							    </div>
							</div>
						</div>
                    </div>
                    <div class="row">
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
                    <a href="index.html">
                        <span class="mdi mdi-home"></span>                
                    </a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Employee</li>
                </ol>
                </nav>

        </div>

        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-contact"> Add Employee
            </button>
        </div>
        </div>
        <div class="row">
            <div class="textcenter"></div>
            <div class="col-lg-6 col-xl-4" v-for="u in users" :key = "u.id">
                <div class="card card-default p-4">
                <a href="javascript:0" class="media text-secondary" data-toggle="modal" data-target="#modal-contact" @click="ViewDetailsEmp(u.id)">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/f9/Phoenicopterus_ruber_in_S%C3%A3o_Paulo_Zoo.jpg" class="mr-3 img-fluid rounded" alt="Avatar Image">

                    <div class="media-body">
                    <h5 class="mt-0 mb-2 text-dark">{{u.firstname}} {{u.lastname}}</h5>

                    <ul class="list-unstyled">
                        <li class="d-flex mb-1">
                        <i class="mdi mdi-map mr-1"></i>
                        <span>{{u.address}}</span>
                        </li>

                        <li class="d-flex mb-1">
                        <i class="mdi mdi-email mr-1"></i>
                        <span>{{u.email_address}}</span>
                        </li>

                        <li class="d-flex mb-1">
                        <i class="mdi mdi-phone mr-1"></i>
                        <span>{{u.phonenumber}}</span>
                        </li>
                    </ul>
                    </div>
                </a>
                </div>
            </div>
        </div>
    </LayoutView>
    <!--EDIT MODAL-->
    <div class="modal fade" id="modal-edit-contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <form >
                    <div class="modal-header px-4">
                    <h5 class="modal-title" id="exampleModaleditCenterTitle">Edit Employee</h5>
                    </div>

                    <div class="modal-body px-4">
                    <div class="form-group row mb-6">
                            <label for="coverImage" class="col-sm-4 col-lg-3 col-form-label">User Image</label>

                        <div class="col-sm-8 col-lg-6">
                            <FileView></FileView>
                            </div>
                    </div>
                    <div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="fname">First name</label>
								<input type="text" v-model="firstname" class="form-control" placeholder="">
                                <div class="invalid-feedback feedback13">
								   
							    </div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label for="lname">Last name</label>
								<input type="text" v-model="lastname" class="form-control" placeholder="">
                                <div class="invalid-feedback feedback14">
								   
							    </div>
							</div>
						</div>

                        <div class="col-sm-6">
							<div class="form-group">
								<label for="fname">Phone number</label>
								<input type="text" v-model="phonenumber" class="form-control" placeholder="">
                                <div class="invalid-feedback feedback15">
								   
							    </div>
							</div>
						</div>
                        <div class="col-sm-6">
							<div class="form-group">
								<label for="fname">Designation</label>
								<select class="form-control" id="edes" placeholder="{{viewusers.position}}">
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
                                    <option value="">Please select gender</option>
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
								<input type="date" v-model="datehired" id="edate" class="form-control" placeholder="">
                                <div class="invalid-feedback feedback19">
								   
							    </div>
							</div>
						</div>
                        <div class="col-sm">
							<div class="form-group">
								<label for="fname">Assign to Facilities</label>
								<select class="chosen-select" id="ebranc" multiple>
                                    <option v-for="bran in branches" :value="bran.id">{{bran.name}}</option>
                                </select>
                                <div class="invalid-feedback feedback20">
								   
							    </div>
							</div>
						</div>
					</div>
                    <div class="row">
                        <div class="col-sm">
							<div class="form-group">
								<label for="fname">Address</label>
								<input type="text" v-model="address" class="form-control" placeholder="">
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
                    </div>
                    <div class="modal-footer px-4">
                    <button type="button" class="btn btn-secondary btn-pill" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-pill" @click="UpdateData(userid)" >Update</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    <div class="modal fade" id="modal-contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="">
                <div class="modal-content">
                <div class="modal-header justify-content-end border-bottom-0">
                    <button type="button" class="btn-edit-icon" data-dismiss="modal" data- target="_blank" data-toggle="modal" data-target="#modal-edit-contact" @click="EditEmployee">
                    <i class="mdi mdi-pencil"></i>
                    </button>

                    <div class="dropdown">
                    <button class="btn-dots-icon" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                    </div>

                    <button type="button" class="btn-close-icon" data-dismiss="modal" aria-label="Close">
                    <i class="mdi mdi-close"></i>
                    </button>
                </div>

                <div class="modal-body pt-0">
                    <div class="row no-gutters">
                    <div class="col-md-6">
                        <div class="profile-content-left px-4">
                        <div class="card text-center widget-profile px-0 border-0">
                            <div class="card-img mx-auto rounded-circle">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/f/f9/Phoenicopterus_ruber_in_S%C3%A3o_Paulo_Zoo.jpg" class="mr-3 img-fluid rounded" alt="Avatar Image">
                            </div>

                            <div class="card-body">
                            <h4 class="py-2 text-dark">{{viewusers.firstname}} {{viewusers.lastname}}</h4>
                            <p>{{viewusers.email_address}}</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between ">
                            <div class="text-center pb-4">
                            <h6 class="text-dark pb-2">{{viewusers.gender}}</h6>
                            <p>Gender</p>
                            </div>

                            <div class="text-center pb-4">
                            <h6 class="text-dark pb-2">{{viewusers.role}}</h6>
                            <p>Role</p>
                            </div>

                            <div class="text-center pb-4">
                            <h6 class="text-dark pb-2">{{viewusers.position}}</h6>
                            <p>Designation</p>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="contact-info px-4">
                        <h4 class="text-dark mb-1">Employee Details</h4>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Address</p>
                        <p>{{viewusers.address}}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Phone Number</p>
                        <p>{{viewusers.phonenumber}}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Username</p>
                        <p>{{viewusers.username}}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Date Hired</p>
                        <p>{{viewusers.date_hired}}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Assigned Facilities</p>
                        <p v-for="br in viewdetailsusersbranch"><span>{{br.name}}</span> {{br.location}}</p>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
</template>
<script>
import LayoutView from "../../views/SharedLayoutView/LayoutView.vue"
import { axios,validateForm } from '@/functions';
import 'chosen-js/chosen.jquery.min.js'
import { elementLoad } from "../../functions";
import toastr from 'toastr';

export default ({
    name: "App",
    components: {
    LayoutView
    },
    data(){
        return{
            branches: [],
            designation: [],
            firstname: "",
            lastname: "",
            phonenumber: "",
            gender: "",
            datehired: "",
            address: "",
            username: "",
            email: "",
            password: "",
            confirmpassword: "",
            designations: "",
            branch: [],
            users:[],
            viewdetailsusersbranch: [{}],
            viewusers: {},
            role: "",
            userid: "",
            search: "",
        }
    }, 
    mounted() {
        axios.post("branches?_batch=true").catch(res=>{
        }).then(res=>{
            if(res.data.success){
                this.branches = res.data.result;
                console.log(this.branches);
                elementLoad('.chosen-select').then(()=>{
                    $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
                    $(".chosen-container").css({"width": "337.5px"});
                    $(".chosen-choices").css({"height": "44.5px"});
                    $(".chosen-search-input").css({"width": "337.5px"});
                    $(".chosen-choices").css({"border-color": "#e5e9f2"});
                });
            }
        });

        axios.post("designation?_batch=true").catch(res=>{

        }).then(res=>{
            if(res.data.success){
                this.designation = res.data.result;
            }
        });
        axios.post("users?_batch=true").catch(res=>{
                }).then(res=>{
                  this.users = res.data.result;
                })
        //Searching
        document.querySelector("#search-input").onkeyup = (e)=>{
        if(!(e.key == 'Enter')) return;
        this.search = document.querySelector("#search-input").value;
        axios.post("users?lastname="+this.search+"&_like=true&_batch=true").catch(res=>{

            }).then(res=>{
                if(res.data.success)
                {
                    this.users = [];
                    if(res.data.success){
                        this.users = res.data.result;
                        document.querySelector(".textcenter").style.display = "none";
                    }
                    else{
                        document.querySelector(".textcenter").textContent = "No Data to be presented!";
                        document.querySelector(".textcenter").style.display = "block";
                    }
                }
                else
                {
                    axios.post("users?firstname="+this.search+"&_like=true&_batch=true").catch(res=>{

                    }).then(res=>{
                        if(res.data.success)
                        {
                            this.users = [];
                            if(res.data.success){
                                this.users = res.data.result;
                                document.querySelector(".textcenter").style.display = "none";
                            }
                            else{
                                document.querySelector(".textcenter").textContent = "No Data to be presented!";
                                document.querySelector(".textcenter").style.display = "block";
                            }
                        }
                        else
                        {
                            
                        }
                    });
                }
            });
        //End of Searching
        }
        document.querySelector("#search-btn").onclick = ()=>{
        this.search = document.querySelector("#search-input").value;
        axios.post("users?lastname="+this.search+"&_like=true&_batch=true").catch(res=>{

            }).then(res=>{
                if(res.data.success)
                {
                    this.users = [];
                    if(res.data.success){
                        this.users = res.data.result;
                        document.querySelector(".textcenter").style.display = "none";
                    }
                    else{
                        document.querySelector(".textcenter").textContent = "No Data to be presented!";
                        document.querySelector(".textcenter").style.display = "block";
                    }
                }
                else
                {
                    axios.post("users?firstname="+this.search+"&_like=true&_batch=true").catch(res=>{

                    }).then(res=>{
                        if(res.data.success)
                        {
                            this.users = [];
                            if(res.data.success){
                                this.users = res.data.result;
                                document.querySelector(".textcenter").style.display = "none";
                            }
                            else{
                                document.querySelector(".textcenter").textContent = "No Data to be presented!";
                                document.querySelector(".textcenter").style.display = "block";
                            }
                        }
                        else
                        {
                            
                        }
                    });
                }
            });
        };
    },
    methods : {
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
            document.querySelector('#edes').value = this.viewusers.designation_id;
            document.querySelector('#egender').value = this.viewusers.gender;
            document.querySelector('#erole').value = this.viewusers.role;
            document.querySelector('#egender').value = this.viewusers.gender;
            document.querySelector('#edate').value = this.viewusers.date_hired;
            

            let branches = [];
            
            this.viewdetailsusersbranch.forEach(el=>{
                branches.push(el.id);
            });
            $("#ebranc").chosen().val(branches);
            $("#ebranc").trigger("chosen:updated");
            setTimeout(()=>{
                document.querySelector('#body').classList.add('modal-open');
            },500);
        },
        ViewDetailsEmp(data){
            this.viewdetailsusersbranch = [];
            this.viewusers = "";
            axios.post("users?id="+data+"&_joins=mobile_branchusers,mobile_designation,mobile_branches&_on=mobile_users.id=mobile_branchusers.user_id,mobile_users.designation_id=mobile_designation.id,mobile_branchusers.branch_id=mobile_branches.id&_batch=true",null,{}).catch(res=>{
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    console.log(res.data.result);
                    res.data.result.forEach(el => {
                        
                        this.viewdetailsusersbranch.push(el);
                    });
                    res.data.result.forEach(el => {
                        this.viewusers = el;
                        return;
                    });
                });
        },

        SaveEmployee(){
            document.querySelector('.feedback1').style.display = "none";
            document.querySelector('.feedback2').style.display = "none";
            document.querySelector('.feedback3').style.display = "none";
            document.querySelector('.feedback4').style.display = "none";
            document.querySelector('.feedback5').style.display = "none";
            document.querySelector('.feedback6').style.display = "none";
            document.querySelector('.feedback7').style.display = "none";
            document.querySelector('.feedback8').style.display = "none";
            document.querySelector('.feedback9').style.display = "none";
            document.querySelector('.feedback10').style.display = "none";
            document.querySelector('.feedback11').style.display = "none";
            document.querySelector('.feedback12').style.display = "none";
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
                address: "required",
                username: "required",
                email: {
                    isEmail: true,
                    isRequired:true,
                    callback: res=>{
                        if(res!='invalid_email') return;
                        document.querySelector('.feedback10').textContent = "Email is not valid!";
                        document.querySelector('.feedback10').style.display = "block";
                    }
                },
                password: "required",
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
                        document.querySelector('.feedback3').textContent = "Phone number is required";
                        document.querySelector('.feedback3').style.display = "block";
                    }
                    if(a == "datehired")
                    {
                        document.querySelector('.feedback6').textContent = "Date Hired is required";
                        document.querySelector('.feedback6').style.display = "block";
                    }
                    if(a == "address")
                    {
                        document.querySelector('.feedback7').textContent = "Address is required";
                        document.querySelector('.feedback7').style.display = "block";
                    }
                    if(a == "username")
                    {
                        document.querySelector('.feedback9').textContent = "Username is required";
                        document.querySelector('.feedback9').style.display = "block";
                    }
                    if(a == "email")
                    {
                        document.querySelector('.feedback10').textContent = "Email is required";
                        document.querySelector('.feedback10').style.display = "block";
                    }
                    if(a == "password")
                    {
                        document.querySelector('.feedback10').textContent = "Password is required";
                        document.querySelector('.feedback10').style.display = "block";
                    }
                    if(a == "confirmpassword")
                    {
                        document.querySelector('.feedback11').textContent = "Confirm Password is required";
                        document.querySelector('.feedback11').style.display = "block";
                    }
                }   
                
            });
            if(document.querySelector("#gender").value == ""){
                valid.allValid = false;
                document.querySelector('.feedback5').textContent = "Gender is required";
                document.querySelector('.feedback5').style.display = "block";
            }
            if(document.querySelector("#des").value == "")
            {
                valid.allValid = false;
                document.querySelector('.feedback4').textContent = "Designation is required";
                document.querySelector('.feedback4').style.display = "block";
            }
            if(document.querySelector("#branc").value == "")
            {
                valid.allValid = false;
                document.querySelector('.feedback8').textContent = "Branch is required";
                document.querySelector('.feedback8').style.display = "block";
            }
            if(document.querySelector('#role').value == "")
            {
                valid.allValid = false;
                document.querySelector('.feedback12').textContent = "Role is required";
                document.querySelector('.feedback12').style.display = "block";
            }
            if(valid.allValid) {
                this.designations = document.querySelector("#des").value;
                this.branch = $("#branc").chosen().val();
                this.gender = document.querySelector("#gender").value;
                this.role = document.querySelector("#role").value;

               this.branch = this.branch;
                console.log(this.phonenumber);

                axios.post("users/create",null,{lastname: this.lastname, firstname: this.firstname, phonenumber: this.phonenumber, email_address: this.email,
                username: this.username, password: this.password, address: this.address, gender: this.gender, date_hired : this.datehired, role: this.role, designation_id:this.designations,branches: this.branch}).catch(res=>{
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    console.log(res.data);
                    if(res.data.success)
                    {
                        this.callToaster("toast-top-right",2);
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
                return;
            }
        },
        callToaster(positionClass, reserror) {
            if (document.getElementById("toaster")) {
                console.log("aw");
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
        UpdateData(data){
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
                address: "required",
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
            if(document.querySelector("#ebranc").value == "")
            {
                valid.allValid = false;
                document.querySelector('.feedback20').textContent = "Branch is required";
                document.querySelector('.feedback20').style.display = "block";
            }
            if(document.querySelector('#erole').value == "")
            {
                valid.allValid = false;
                document.querySelector('.feedback18').textContent = "Role is required";
                document.querySelector('.feedback18').style.display = "block";
            }
            if(valid.allValid) {
                this.designations = document.querySelector("#edes").value;
                this.branch = $("#ebranc").chosen().val();
                this.gender = document.querySelector("#egender").value;
                this.role = document.querySelector("#erole").value;

               this.branch = this.branch;
                console.log(this.phonenumber);

                axios.post("users/update?id="+data,null,{lastname: this.lastname, firstname: this.firstname, phonenumber: this.phonenumber, email_address: this.email,
                username: this.username, address: this.address, gender: this.gender, date_hired : this.datehired, role: this.role, designation_id:this.designations,branches: this.branch}).catch(res=>{
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    console.log(res.data);
                    if(res.data.success)
                    {
                        this.callToaster("toast-top-right",2);

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
                return;
            }
        }
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
@import '../../assets/scss/_todo.scss';
.img-fluid{
    width: 100px;
    height: 100px !important;
}
.textcenter{
    display: none;
    margin: 0 auto;
    font-size: 20px;
}
</style>