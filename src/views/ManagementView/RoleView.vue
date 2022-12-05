<template>
    <LayoutView>
        <div class="toast" >

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
                                <input type="text" class="form-control" v-model="position"  placeholder="Position *">
                                <div class="invalid-feedback feedback1">
								   
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
                                <div class="invalid-feedback feedback3">
								   
							    </div>
                            </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="clearVariable" class="btn btn-danger btn-pill" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-pill" id="submitbut">Submit</button>
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
                                        <th>Role</th>
                                        <th>Date Created</th>
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
<script type="script">
import LayoutView from '../SharedLayoutView/LayoutView.vue';
import { axios , elementLoad} from '@/functions';
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
        }
    },
    methods:{
        EditRole()
        {
            if(this.position == "")
            {
                document.querySelector(".feedback1").textContent = "Position name is required!";
                document.querySelector(".feedback1").style.display = "block";
                return;
            }
            else{
                document.querySelector(".toast").id = "toaster";
                axios.post("designation/update?id="+this.roleid,null,{position:this.position}).catch(res=>{
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
            axios.post("designation?id="+data).catch(res=>{

                }).then(res=>{
                    this.position = res.data.result.position;
                    this.roleid = data;
                });
        },
        SubmitRole()
        {
            if(this.position == "")
            {
                document.querySelector(".feedback3").textContent = "Position name is required!";
                document.querySelector(".feedback3").style.display = "block";
                return;
            }
            else{
                document.querySelector(".toast").id = "toaster";
                document.querySelector(".feedback3").style.display = "none";
                axios.post("designation/create",null,{position:this.position}).catch(res=>{
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
            this.position = "";
            this.roleid = "";
        },
        checkError(data){
            var val = 0;
            if(this.position == "" && data == 2)
            {
                document.querySelector(".feedback2").textContent = "Branch name is required!";
                document.querySelector(".feedback2").style.display = "block";
                val = 1;
            }
            else
            {
                document.querySelector(".feedback2").textContent = "";
                document.querySelector(".feedback2").style.display = "none";
            }
            if(this.basic_salary == "" && data == 1)
            {
                document.querySelector(".feedback5").textContent = "Branch name is required!";
                document.querySelector(".feedback5").style.display = "block";
                val = 1;
            }
            if(this.branchname != "" && this.branchloc != "")
            {
                document.querySelector(".feedback1").textContent = "";
                document.querySelector(".feedback2").textContent = "";
                document.querySelector(".feedback3").textContent = "";
                document.querySelector(".feedback4").textContent = "";
                document.querySelector(".feedback5").style.display = "none";
                document.querySelector(".feedback3").style.display = "none";
                document.querySelector(".feedback5").style.display = "none";
                document.querySelector(".feedback6").style.display = "none";
                val = 0;
            }
            return val;
        },
    },
    mounted() {
        document.querySelector(".toast").id = "";
            $('#hoverable-data-table').dataTable({
              aLengthMenu: [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
              emptyTable:     "No data available in table",
              rowReorder: {
                selector: 'td:nth-child(2)'
              },
              responsive: true,
              ajax : {
                url: 'https://www.4angelshc.com/mobile/designation?_batch=true',
                dataSrc: 'result'
              },
              columns : [
                { data : "id" },
                { data : "position" },
                { data : "created_at" },
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
<style scoped>
@import '../../assets/scss/_card.scss';
@import '../../assets/scss/_breadcrumb.scss';
@import '../../assets/sleek.min.css';

.responsive-data-table{
    overflow: auto;
}
</style>