<template>
    <LayoutView>
        <div id="toaster" >

        </div>
        <div class="modal fade" id="exampleEditModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalFormTitle">Edit Role ID: {{roleid}}</h5>
                            <button type="button" @click="clearVariable" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Role</label>
                                <input type="text" class="form-control" v-model="position" placeholder="Position *">
                                <div class="invalid-feedback feedback3">
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Color</label>
                                <input type="color" class="form-control form-control-color" v-model="rolecolor">
                                <div class="invalid-feedback feedback4">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="clearVariable" class="btn btn-danger btn-pill" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-pill editbut" data-dismiss="" @click="EditRole">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFormTitle">Add Role</h5>
                        <button type="button" @click="clearVariable" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Role</label>
                                <input type="text" class="form-control" v-model="position" placeholder="Position *">
                                <div class="invalid-feedback feedback1">
								   
							    </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Color</label>
                                <input type="color" class="form-control form-control-color" v-model="rolecolor">
                                <div class="invalid-feedback feedback2">
                                
                                </div>
                            </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="clearVariable" class="btn btn-danger btn-pill" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-pill" @click="SubmitRole" id="submitbut">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                        <button type="button" @click="clearVariable" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to delete this role? {{roleid}}
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="clearVariable" class="btn btn-light btn-pill" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger btn-pill delbut" data-dismiss="modal" @click="DeleteRole(roleid)">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModalTooltip" tabindex="-1" role="dialog" aria-labelledby="exampleModalTooltip" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle2">Role ID: {{roleid}}</h5>
                        <button type="button" @click="clearVariable" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <h5>Role: {{position}}</h5>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal" @click="DeleteRole(roleid)">Delete</button>
                        <button type="button" data-dismiss="modal" data-toggle="modal" data-target="#exampleEditModalForm" target="_blank" class="btn btn-primary btn-pill">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal-->
        <div class="breadcrumb-wrapper">
            <h1>Role</h1>
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-0">
                <li class="breadcrumb-item">
                <RouterLink to="/dashboard">
                    <span class="mdi mdi-home"></span>                
                </RouterLink>
                </li>
                <li class="breadcrumb-item" aria-current="page">Role</li>
            </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between card-design head">
                        <h2>Role Table</h2>
                        <div class="d-flex">
                            <div class="d-flex px-3">
                                <input class="form-control mr-sm-2" v-model="keyword" placeholder="Search Role" aria-label="Search">
                                <button class="btn btn-outline-success my-2 my-sm-0" @click="SearchRole">Search</button>
                            </div>
                            <a @click="clearVariable" data-toggle="modal" data-target="#exampleModalForm" target="_blank" class="btn btn-outline-primary text-uppercase link">
                                <span class="mdi mdi-briefcase-plus"></span>&nbsp; Add Role
                            </a>
                        </div>
                    </div>

                    <div class="card-body tableinside">
                        <table class="table card-table table-responsive table-responsive-large" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Role ID</th>
                                    <th>Role name</th>
                                    <th class="d-none d-lg-table-cell">Role Color</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="role == null || role == ''">
                                    <td colspan="4" v-if="users == null"> <div class="text-center"><div> No Data Found </div></div></td>
                                </tr>
                            <tr v-for="r in role">
                                <td >{{ r.role_id }}</td>
                                <td >
                                {{r.role_name}}
                                </td>
                                <td class="d-none d-lg-table-cell"><div class="box" :style="'background:'+r.role_color"></div></td>
                                <td class="text-right">
                                    <div class="dropdown show d-inline-block widget-dropdown">
                                        <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                        <li class="dropdown-item">
                                            <a href="#" @click="ViewRole(r.role_id)" data-toggle="modal" data-target="#exampleEditModalForm">Edit</a>
                                        </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>
    </LayoutView>
</template>
<script type="script">
import LayoutView from '../SharedLayoutView/LayoutView.vue';
import { axios,validateForm,lStore } from '@/functions';
import toastr from 'toastr';

export default ({
    name: "App",
    components: {
    LayoutView,
    },
    data(){
        return {
            position: "",
            roleid: "",
            rolecolor: "",
            role:[],
            keyword: "",
        }
    },
    mounted(){
        axios.post('rolecontroller/displayallroles',{pwauth: lStore.get('usertoken')},{}).then(res=>{
            if(res.data.success){
                this.role = res.data.result;
            }else{
                this.callToaster("toast-top-right", res.data);
            }
        });
    },
    methods:{
        SearchRole(){
            axios.post('rolecontroller/searchroles',{pwauth: lStore.get('usertoken')},{keyword: this.keyword}).then(res=>{
                if(res.data.success){
                    this.role = res.data.result;
                }else{
                    this.callToaster("toast-top-right", res.data);
                }
            });
        },
        EditRole()
        {
            if(this.position == "")
            {
                document.querySelector(".feedback1").textContent = "Position name is required!";
                document.querySelector(".feedback1").style.display = "block";
                return;
            }
            else{
                axios.post("rolecontroller/UpdateRoles",{pwauth: lStore.get('usertoken')},{roleid: this.roleid, rolename:this.position,rolecolor: this.rolecolor}).then(res=>{
                    if(res.data.success)
                    {
                        this.clearVariable();
                        this.callToaster("toast-top-right", res.data);
                        this.clearModal("exampleEditModalForm");
                        this.role = res.data.result;
                    }
                    else
                    {
                        this.clearVariable();
                        this.callToaster("toast-top-right", res.data);
                        this.clearModal("exampleEditModalForm");
                    }
                });
            }
        },
        ViewRole(data)
        {
            console.log(data);
            axios.post("rolecontroller/displayarole",{pwauth: lStore.get('usertoken')},{roleid: data}).then(res=>{
                console.log(res.data);
                this.position = res.data.result[0].role_name;
                this.rolecolor = res.data.result[0].role_color;
                this.roleid = data;
            });
        },
        SubmitRole()
        {
            let newRole = {
                rolename: this.position,
                rolecolor: this.rolecolor,
            }
            const valid = validateForm(newRole,{
                rolename: "required",
                rolecolor: "required",
                callback: (a)=>{
                    console.log(a);
                    if(a == "rolename")
                    {
                        console.log(a);
                        document.querySelector('.feedback1').textContent = "Role name is required";
                        document.querySelector('.feedback1').style.display = "block";
                    }
                    if(a == "rolecolor")
                    {
                        console.log(a);
                        document.querySelector('.feedback2').textContent = "Role color is required";
                        document.querySelector('.feedback2').style.display = "block";
                    }
                }
            })
            
            if(valid.allValid)
            {
                document.querySelector('.feedback1').style.display = "none";
                document.querySelector('.feedback2').style.display = "none";
                axios.post("rolecontroller/CreateRoles",{pwauth: lStore.get('usertoken')},{rolename:this.position,rolecolor:this.rolecolor}).then(res=>{
                    if(res.data.success)
                    {
                        this.clearVariable();
                        this.callToaster("toast-top-right", res.data);
                        this.clearModal("exampleModalForm");
                        this.role = res.data.result;
                    }
                    else
                    {
                        this.clearVariable();
                        this.callToaster("toast-top-right", res.data);
                        this.clearModal("exampleModalForm");
                    }
                });
            }

        },
        DeleteRole(data)
        {
            this.clearVariable();
            if(data == "")
            {
                this.callToaster("toast-top-right",2);
            }
            else
            {
                axios.post("designation/delete?id="+data).catch(res=>{
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    if(res.data.success)
                    {
                        this.callToaster("toast-top-right",3);
                        document.querySelector(".delbut").dataset.dismiss = "modal";
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
        clearVariable()
        {
            this.position = "";
            this.roleid = "";
            this.rolecolor =  "";
            this.keyword = "";
        },
    },
})
</script>
<style scoped>
@import '../../assets/scss/_card.scss';
@import '../../assets/scss/_breadcrumb.scss';
@import '../../assets/sleek.min.css';

.responsive-data-table{
    overflow: auto;
}
.box{
    padding: 20px;
    width: 10%;
}
.card-table{
    margin-top: 0;
}
.tableinside{
    padding: 0;
}
</style>