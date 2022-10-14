<template>
    <LayoutView>
        <div class="toast" >

        </div>
        <div class="modal fade" id="exampleEditModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFormTitle">Edit Role ID: {{roleid}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control" v-model="rolename"  placeholder="Role Name *">
                                <div class="invalid-feedback feedback1">
								   
							    </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea type="text" class="form-control" v-model="roledesc" id="exampleInputPassword1" placeholder="Description"/>
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
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control" v-model="rolename"  placeholder="Role Name *">
                                <div class="invalid-feedback feedback2">
								   
							    </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea type="text" class="form-control" v-model="roledesc" id="exampleInputPassword1" placeholder="Description" />
                            </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="clearVariable" class="btn btn-danger btn-pill" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-pill" id="submitbut" @click="SubmitRole">Submit</button>
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
                        Are you sure you want to delete this? {{roleid}}
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
                        <h5>Role Name: {{rolename}}</h5>
                        <p>Description: {{roledesc}}</p>
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

                        <a @click="clearVariable" data-toggle="modal" data-target="#exampleModalForm" target="_blank" class="btn btn-outline-primary btn-sm text-uppercase link">
                            <span class="mdi mdi-briefcase-plus"></span>&nbsp; Add Role
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="responsive-data-table">
                            <table id="hoverable-data-table" class="table table-hover nowrap dataTable no-footer display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LayoutView>
</template>
<script>
import LayoutView from '../SharedLayoutView/LayoutView.vue';
import { axios , elementLoad} from '@/functions';
import toastr from 'toastr';

export default ({
    name: "App",
    components: {
    LayoutView
    },
    data(){
        return {
            rolename: "",
            roledesc: "",
            roleid: "",
        }
    },
    methods:{
        EditRole()
        {
            if(this.rolename == "")
            {
                document.querySelector(".feedback1").textContent = "Role name is required!";
                document.querySelector(".feedback1").style.display = "block";
                return;
            }
            else{
                document.querySelector(".toast").id = "toaster";
                axios.post("roles/update?id="+this.roleid,null,{name:this.rolename,description:this.roledesc,created_at:""}).catch(res=>{
                    this.clearVariable();
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    if(res.data.success)
                    {
                        this.clearVariable();
                        this.callToaster("toast-top-right",1);
                        document.querySelector('#exampleEditModalForm').style.display = "none"
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 3000);
                    }
                    else
                    {
                        this.clearVariable();
                        this.callToaster("toast-top-right",2);
                    }
                });
            }
        },
        ViewRole(data)
        {
            this.clearVariable();
            axios.post("roles?id="+data).catch(res=>{

                }).then(res=>{
                    this.rolename = res.data.result.name;
                    this.roledesc = res.data.result.description;
                    this.roleid = data;
                });
        },
        SubmitRole()
        {
            if(this.rolename == "")
            {
                document.querySelector(".feedback2").textContent = "Role name is required!";
                document.querySelector(".feedback2").style.display = "block";
                return;
            }
            else{
                document.querySelector(".toast").id = "toaster";
                document.querySelector(".feedback2").style.display = "none";
                axios.post("roles/create",null,{name:this.rolename,description:this.roledesc,created_at:""}).catch(res=>{
                    this.clearVariable();
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    if(res.data.success)
                    {
                        this.clearVariable();
                        this.callToaster("toast-top-right",1);
                        document.querySelector('#exampleModalForm').style.display = "none"
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 2000);
                    }
                    else
                    {
                        this.clearVariable();
                        this.callToaster("toast-top-right",2);
                    }
                });

            }
        },
        DeleteRole(data)
        {
            this.clearVariable();
            if(data == "")
            {
                document.querySelector(".toast").id = "toaster";
                this.callToaster("toast-top-right",2);
            }
            else
            {
                document.querySelector(".toast").id = "toaster";
                axios.post("roles/delete?id="+data).catch(res=>{
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
        clearVariable()
        {
            this.roleid = "",
            this.rolename = "";
            this.roledesc = "";
        }
    },
    mounted() {
        document.querySelector(".toast").id = "";
            $('#hoverable-data-table').dataTable({
              aLengthMenu: [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
              rowReorder: {
                selector: 'td:nth-child(2)'
              },
              responsive: true,
              ajax : {
                url: 'https://www.4angelshc.com/mobile/roles?_batch=true',
                dataSrc: 'result'
              },
              columns : [
                { data : "id" },
                { data : "name" },
                { data : "id",
                    render: function(data){
                        return '<a class="actionb" data-toggle="modal" data-target="#exampleEditModalForm" target="_blank"><span id="editrow" data-value='+data+' class="mdi mdi-square-edit-outline"></span></a> <a class="actionb" data-toggle="modal" data-target="#exampleModalTooltip" target="_blank"><span id="viewrow" data-value='+data+' class="mdi mdi-eye"></span></a> <a class="actionb" data-toggle="modal" data-target="#exampleModal" target="_blank"><span id="deleterow" data-value='+data+' class="mdi mdi-trash-can red"></span></a>'
                    }
                }
              ],
          });
          elementLoad('#deleterow').then(()=>{
            document.querySelectorAll('#deleterow').forEach(el=>{
                el.onclick = e=>{
                this.clearVariable();
                const dataelem = e.target.closest("[data-value]")
                this.roleid = dataelem.dataset.value;
                }
            })
          });
          elementLoad('#viewrow').then(()=>{
            document.querySelectorAll('#viewrow').forEach(el=>{
                el.onclick = e=>{
                this.clearVariable();
                const dataelem = e.target.closest("[data-value]")
                this.roleid = dataelem.dataset.value;
                this.ViewRole(this.roleid);
                }
            })
          });
          elementLoad('#editrow').then(()=>{
            document.querySelectorAll('#editrow').forEach(el=>{
                el.onclick = e=>{
                this.clearVariable();
                const dataelem = e.target.closest("[data-value]")
                this.roleid = dataelem.dataset.value;
                this.ViewRole(this.roleid);
                }
            })
          });
    },
})
</script>
<style>
@import '../../assets/sleek.css';
@import 'toastr/build/toastr.min.css';

.red{
    color: #aa0927;
}
.head{
    background-color: #ffff !important;

}
.link{
    display: flex !important;
    align-items: center !important;
}
.close{
    background-color: transparent;
    border: 0;
}
.modal-body{
    position: relative;
    flex: 1 1 auto;
    padding: 1rem;
}
.form-group,.input-group{
    margin-bottom: 1.25rem;
}
.form-group label, .input-group label {
  color: #1b223c;
  font-size: 0.98rem;
}
.form-group .form-control, .input-group .form-control {
  font-size: 0.98rem;
  padding: .5rem 1.06rem;
  border-color: #e5e9f2;
}
.text-muted {
  color: #6c757d !important;
}
.pl-0, .px-0 {
  padding-left: 0 !important;
}
.form-check {
  position: relative;
  display: block;
  padding-left: 1.25rem;
}
label {
  display: inline-block;
}
.btn:not(:disabled):not(.disabled) {
  cursor: pointer;
}
.btn-primary {
  color: #ffffff;
  background-color: #4c84ff;
  border-color: #4c84ff;
}
.btn {
  display: inline-block;
  font-weight: 500;
  color: #8a909d;
  text-align: center;
  vertical-align: middle;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  background-color: transparent;
  border: 1px solid transparent;
    border-top-color: transparent;
    border-right-color: transparent;
    border-bottom-color: transparent;
    border-left-color: transparent;
  padding: 0.59rem 1rem;
  font-size: 0.875rem;
  line-height: 1.5;
  border-radius: 0.25rem;
  transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.modal-footer > * {
  margin: 0.25rem;
}
.btn.btn-pill {
  border-radius: 100px;
}
.modal-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  padding: 1rem 1rem;
  border-bottom: 1px solid #e5e9f2;
  border-top-left-radius: calc(0.3rem - 1px);
  border-top-right-radius: calc(0.3rem - 1px);
}
.modal-body {
  position: relative;
  flex: 1 1 auto;
  padding: 1rem;
}
.card-body{
    overflow: auto;
}
.breadcrumb{
    background-color: transparent !important;
}
.breadcrumb-wrapper h1 {
  color: #1b223c;
  font-size: 1.63rem;
  font-weight: 500;
  font-family: "Roboto", sans-serif;
  line-height: 1.5;
  color: #8a909d;
  text-align: left;
}
.actionb{
    cursor: pointer;
}
</style>