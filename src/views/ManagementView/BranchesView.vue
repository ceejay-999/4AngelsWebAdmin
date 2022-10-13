<template>
    <LayoutView>
        <div class="modal fade" id="exampleModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFormTitle">Add Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control" v-model="rolename"  placeholder="Role Name *" required>
                                <div class="invalid-feedback">
								   
							    </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea type="text" class="form-control" v-model="roledesc" id="exampleInputPassword1" placeholder="Description" />
                            </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-pill" @click="SubmitRole">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal-->
        <div class="breadcrumb-wrapper">
            <h1>Branches</h1>

            
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item">
                    <a href="index.html">
                        <span class="mdi mdi-home"></span>                
                    </a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Branches</li>
                </ol>
                </nav>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom d-flex justify-content-between card-design head">
                        <h2>Branches Table</h2>

                        <a data-toggle="modal" data-target="#exampleModalForm" target="_blank" class="btn btn-outline-primary btn-sm text-uppercase link">
                            <span class="mdi mdi-briefcase-plus"></span>&nbsp; Add
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
import { axiosReq } from '@/functions';

export default ({
    name: "App",
    components: {
    LayoutView
    },
    data(){
        return {
            rolename: "",
            roledesc: "",
        }
    },
    mounted() {
        $(document).ready(function(){
            $('#hoverable-data-table').dataTable({
              aLengthMenu: [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
              rowReorder: {
                selector: 'td:nth-child(2)'
              },
              responsive: true,
              ajax : {
                url: 'https://www.4angelshc.com/mobile/branches/',
                dataSrc: 'result'
              },
              columns : [
                { data : "id" },
                { data : "name" },
                { data : "id",
                    render: function(data){
                        return '<span class="mdi mdi-square-edit-outline"></span> <span class="mdi mdi-eye"></span> <span class="mdi mdi-trash-can red"></span>'
                    }
                }
              ],
          });
        });
        
    },
    methods:{
        SubmitRole(){
            if(this.rolename == "")
            {
                document.querySelector(".invalid-feedback").style.display = "block";
                document.querySelector(".invalid-feedback").textContent = "Role Name is Required!";

            }
            else
            {
                if(document.querySelector(".invalid-feedback").style.display == "none")
                {
                    document.querySelector(".invalid-feedback").style.display = "none";
                    document.querySelector(".invalid-feedback").textContent = "";
                }
                else
                {
                    document.querySelector(".invalid-feedback").style.display = "none";
                    document.querySelector(".invalid-feedback").textContent = "";
                }
                axiosReq({
                    method: 'post',
                    url: 'https://www.4angelshc.com/mobile/roles/create',
                    data:{
                        name: this.rolename,
                    }
                }).then(res=>{
                    document.querySelector(".modal").style.display = "none";
                    this.$router.go(0);
                    
                })
            }
        },
    }
})
</script>
<style>

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
</style>