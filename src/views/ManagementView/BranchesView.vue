<template>
    <LayoutView>
        <div class="toast" >

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
                        Are you sure you want to delete this? {{branchid}}
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="clearVariable" class="btn btn-light btn-pill" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger btn-pill" @click="DeleteBranch(branchid)" data-dismiss="modal">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-edit-contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <form >
                    <div class="modal-header px-4">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Branch ID: {{branchid}}</h5>
                    </div>

                    <div class="modal-body px-4">
                    <div class="form-group row mb-6">
                            <label for="coverImage" class="col-sm-4 col-lg-3 col-form-label">Branch Image</label>

                        <div class="col-sm-8 col-lg-9">
                            <div class="custom-file mb-1">
                                <input type="file" class="custom-file-input" id="coverImage" required>
                                <label class="custom-file-label" for="coverImage">Choose file...</label>
                                <div class="invalid-feedback feedback1">
                                            
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-12">
                            <div class="form-group">
                                <label for="firstName">Branch name</label>
                                <input type="text" class="form-control" v-model="branchname" placeholder="Branch Name *">
                                <div class="invalid-feedback feedback2">
                                            
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-12">
                            <div class="form-group">
                                <label for="firstName">Location name</label>
                                <input type="text" class="form-control" v-model="branchloc" placeholder="Location *">
                                <div class="invalid-feedback feedback3">
                                            
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer px-4">
                    <button type="button" class="btn btn-secondary btn-pill" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-pill editedB" @click="SaveBranch(branchid)">Update Branch</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-add-contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <form >
                    <div class="modal-header px-4">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Create New Branch</h5>
                    </div>

                    <div class="modal-body px-4">
                    <div class="form-group row mb-6">
                            <label for="coverImage" class="col-sm-4 col-lg-3 col-form-label">Branch Image</label>

                        <div class="col-sm-8 col-lg-9">
                            <div class="custom-file mb-1">
                                <input type="file" class="custom-file-input" id="coverImage" required>
                                <label class="custom-file-label" for="coverImage">Choose file...</label>
                                <div class="invalid-feedback feedback4">
                                            
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-12">
                            <div class="form-group">
                                <label for="firstName">Branch name</label>
                                <input type="text" class="form-control" v-model="branchname" placeholder="Branch Name *">
                                <div class="invalid-feedback feedback5">
                                            
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-12">
                            <div class="form-group">
                                <label for="firstName">Location name</label>
                                <input type="text" class="form-control" v-model="branchloc" placeholder="Location *">
                                <div class="invalid-feedback feedback6">
                                            
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer px-4">
                    <button type="button" class="btn btn-secondary btn-pill" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-pill savedB" @click="SaveBranch(0)">Save Branch</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!--Modal-->
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Manage</h1>

            
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item">
                    <RouterLink to="/dashboard">
                        <span class="mdi mdi-home"></span>                
                    </RouterLink>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Manage</li>
                </ol>
                </nav>
            </div>
            <div>
                <button type="button" class="btn btn-primary" @click="clearVariable" data-toggle="modal" data-target="#modal-add-contact"> Add Branch
                </button>
            </div>
        </div>
        <div class="row">
            <div class="textcenter"></div>
            <div class="col-lg-6 col-xl-4" v-for="a in branches" :key="a.id">
                <div class="card card-default p-4">
                    <div class="dropdown">
                        <button class="btn-dots-icon" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal" @click="DelBranch(a.id)" href="#">Delete</a>
                            <a class="dropdown-item" data-toggle="modal" data-target="#modal-edit-contact" @click="EditBranch(a.id)" href="#">Edit</a>
                        </div>
                    </div>
                    <a href="javascript:0" class="media text-secondary" data-toggle="modal" data-target="#modal-contact">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/f/f9/Phoenicopterus_ruber_in_S%C3%A3o_Paulo_Zoo.jpg" class="mr-3 img-fluid rounded" alt="Avatar Image">

                        <div class="media-body">
                        <h5 class="mt-0 mb-2 text-dark">{{a.name}}</h5>

                        <ul class="list-unstyled">
                            <li class="d-flex mb-1">
                            <i class="mdi mdi-map mr-1"></i>
                            <span>{{a.address}}</span>
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
import LayoutView from '../SharedLayoutView/LayoutView.vue';
import { axios } from '@/functions';
import toastr from 'toastr';

export default ({
    name: "App",
    components: {
    LayoutView
    },
    data(){
        return {
            branches: [],
            branchname: "",
            branchloc: "",
            branchid: "",
        }
    },
    methods:{
        DelBranch(data){
            this.branchid = data;
        },
        DeleteBranch(data){
            this.clearVariable();
            if(data == "")
            {
                document.querySelector(".toast").id = "toaster";
                this.callToaster("toast-top-right",2);
            }
            else
            {
                document.querySelector(".toast").id = "toaster";
                axios.post("branches/delete?id="+data).catch(res=>{
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    if(res.data.success)
                    {
                        this.callToaster("toast-top-right",3);
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
        EditBranch(data){
            axios.post("branches?id="+data).catch(res=>{

            }).then(res=>{
                this.branchname = res.data.result.name;
                this.branchloc = res.data.result.address;
                this.branchid = data;
            });
        },
        SaveBranch(data){
            if(this.checkError(1) === 0 && data == 0)
            {
                document.querySelector(".feedback5").style.display = "none";
                document.querySelector(".feedback6").style.display = "none";
                document.querySelector(".toast").id = "toaster";
                axios.post("branches/create",null,{name: this.branchname, address: this.branchloc, created_at: ""}).catch(res=>{
                    this.clearVariable();
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    if(res.data.success)
                    {
                        this.clearVariable();
                        this.callToaster("toast-top-right",1);
                        document.querySelector("#modal-add-contact").style.display = "none";
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
            if(this.checkError(2) === 0 && data != 0)
            {
                document.querySelector(".feedback2").style.display = "none";
                document.querySelector(".feedback3").style.display = "none";
                document.querySelector(".toast").id = "toaster";
                axios.post("branches/update?id="+data,null,{name: this.branchname, address: this.branchloc, created_at: ""}).catch(res=>{
                    this.clearVariable();
                    this.callToaster("toast-top-right",2);
                }).then(res=>{
                    if(res.data.success)
                    {
                        this.clearVariable();
                        this.callToaster("toast-top-right",1);
                        document.querySelector("#modal-edit-contact").style.display = "none";
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
        checkError(data){
            var val = 0;
            if(this.branchname == "" && data == 2)
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
            if(this.branchname == "" && data == 1)
            {
                document.querySelector(".feedback5").textContent = "Branch name is required!";
                document.querySelector(".feedback5").style.display = "block";
                val = 1;
            }
            else
            {
                document.querySelector(".feedback5").textContent = "";
                document.querySelector(".feedback5").style.display = "none";
            }
            if(this.branchloc == "" && data == 1)
            {
                document.querySelector(".feedback6").textContent = "Branch name is required!";
                document.querySelector(".feedback6").style.display = "block";
                val = 1;
            }
            else
            {
                document.querySelector(".feedback6").textContent = "";
                document.querySelector(".feedback6").style.display = "none";
            }
            if(this.branchloc == "" && data == 2)
            {
                document.querySelector(".feedback3").textContent = "Location is required!";
                document.querySelector(".feedback3").style.display = "block";
                val = 1;
            }
            else
            {
                document.querySelector(".feedback3").textContent = "";
                document.querySelector(".feedback3").style.display = "none";
            }
            if(this.branchname != "" && this.branchloc != "")
            {
                document.querySelector(".feedback3").textContent = "";
                document.querySelector(".feedback2").textContent = "";
                document.querySelector(".feedback6").textContent = "";
                document.querySelector(".feedback5").textContent = "";
                document.querySelector(".feedback2").style.display = "none";
                document.querySelector(".feedback3").style.display = "none";
                document.querySelector(".feedback5").style.display = "none";
                document.querySelector(".feedback6").style.display = "none";
                val = 0;
            }
            return val;
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
           this.branchname = "";
           this.branchloc = "";
           this.branchid = "";
        }
    },
    mounted() {
        document.querySelector(".toast").id = "";
        this.clearVariable();
        axios.post("branches?_batch=true").catch(res=>{

        }).then(res=>{
            if(res.data.success){
                this.branches = res.data.result;
                document.querySelector(".textcenter").style.display = "none";
            }
            else{
                document.querySelector(".textcenter").textContent = "No Data to be presented!";
            }
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
.breadcrumb .breadcrumb-item {
  font-size: 0.98rem;
  text-transform: capitalize;
}
.breadcrumb-wrapper.breadcrumb-contacts {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
}
.actionb{
    cursor: pointer;
}
.card {
  position: relative;
  display: flex;
  flex-direction: column;
  min-width: 0;
  word-wrap: break-word;
  background-color: #ffffff;
  background-clip: border-box;
  border: 1px solid #e5e9f2;
  border-radius: 0.25rem;
}
.card-default {
  margin-bottom: 1.5rem;
}
.media {
  display: flex;
  align-items: flex-start;
}
.media-body {
  flex: 1;
}
.text-dark {
  color: #1b223c !important;
}
.mb-2, .my-2 {
  margin-bottom: 0.5rem !important;
}
.list-unstyled {
  padding-left: 0;
  list-style: none;
}
ul {
  margin: 0;
  padding: 0;
    padding-left: 0px;
}
.mb-1, .my-1 {
  margin-bottom: 0.25rem !important;
}
ul li {
  list-style-type: none;
}
.d-flex {
  display: flex !important;
}
.rounded {
  border-radius: 0.25rem !important;
}
.img-fluid{
    width: 100px;
    height: 100px !important;
}
.card {
  word-wrap: break-word;
}
.btn-dots-icon
{
    position: absolute;
    top: -13px;
    right: 16px;
    font-size: 25px;
}
.textcenter{
    display: block;
    margin: 0 auto;
    font-size: 20px;
}
</style>