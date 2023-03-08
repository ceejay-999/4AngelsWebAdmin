<template>
    <LayoutView>
        <div id="toaster" >

        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <img v-if="branchimg != ''" :src = "'https://www.4angelshc.com/wangelmobile/filesystem/' +branchimg" class="img-fluid" alt="Avatar Image">
                        <img v-else src="../../assets/building.jpg" class="img-fluid" alt="Avatar Image">
                        <div class="mt-3">
                            Facility Name:<h5 class="text-primary"> {{ branchname }}</h5>
                            <div class="mt-3">
                                Address:<p class="text-primary"> {{ branchloc }}</p>
                            </div>
                        </div>
                        <!-- <div class="mt-3">
                            No of Employees:<h5 class="text-primary"> {{ }}</h5>
                        </div> -->

                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="clearVariable" class="btn btn-light btn-pill" data-dismiss="modal">Cancel</button>
                        <button type="button" data-toggle="modal" data-target="#modal-edit-contact" @click="EditBranch(branchid)" class="btn btn-primary btn-pill" data-dismiss="modal">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-edit-contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <form >
                    <div class="modal-header px-4">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Facility ID: {{branchid}}</h5>
                    </div>

                    <div class="modal-body px-4">
                    <div class="form-group row mb-6">
                        <label for="coverImage" class="col-sm-4 col-lg-3 col-form-label">Facility Image</label>

                        <div class="form-group">
                            <input type="file" id="uploadFile2" class="form-control-file form-control height-auto" accept="image/x-png,image/gif,image/jpeg">
                        </div>
                    </div>

                        <div class="row mb-2">
                            <div class="col-lg-12">
                            <div class="form-group">
                                <label for="firstName">Facility name</label>
                                <input type="text" class="form-control" v-model="branchname" placeholder="Branch Name *">
                                <div class="invalid-feedback feedback2">
                                            
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-12">
                            <div class="form-group">
                                <label for="firstName">Location </label>
                                <div id="geocoder2"></div>
                                <div class="invalid-feedback feedback3">
                                            
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer px-4">
                    <button type="button" class="btn btn-secondary btn-pill" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-pill editedB" @click="Updatebranch(branchid)">Update Branch</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-add-contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <form>
                    <div class="modal-header px-4">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Create New Facility</h5>
                    </div>

                    <div class="modal-body px-4">
                    <div class="form-group row mb-6">
                        <label for="coverImage" class="col-sm-4 col-lg-3 col-form-label">Facility Image</label>

                        <div class="col-sm-8 col-lg-6">
                            <div class="form-group">
                                <input type="file" @change="onImageChange" id="facilityImage" class="form-control-file form-control height-auto" accept="image/x-png,image/gif,image/jpeg">
                            </div>
                        </div>
                    </div>

                        <div class="row mb-2">
                            <div class="col-lg-12">
                            <div class="form-group">
                                <label for="firstName">Facility name</label>
                                <input type="text" class="form-control" v-model="branchname" placeholder="Branch Name *">
                                <div class="invalid-feedback feedback5">
                                    
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-12">
                            <div class="form-group">
                                <label for="firstName">Location</label>
                                <div id="geocoder1">
                                </div>
                                <div class="invalid-feedback feedback6">
                                            
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer px-4">
                    <button type="button" class="btn btn-secondary btn-pill" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-pill savedB" @click="SaveBranch()" :disabled="this.loading">
                        <span v-if="this.loading">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            Saving Branch
                        </span>
                        <span v-else>Save Branch</span>
                    </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!--Modal-->
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Facilities to Manage</h1>

            
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item">
                    <RouterLink to="/dashboard">
                        <span class="mdi mdi-home"></span>                
                    </RouterLink>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Facilities</li>
                </ol>
                </nav>
            </div>
            <div class="d-flex">
                <div class="form-inline mr-2">
                    <input class="form-control" type="search" v-model="searchkey" placeholder="Search" aria-label="Search">
                    <button class="btn btn-success my-2 my-sm-0" @click="SearchFacilities" type="submit"><span class="mdi mdi-magnify"></span></button>
                </div>
                <button v-if="permi == 1" type="button" class="btn btn-primary" @click="clearVariable" data-toggle="modal" data-target="#modal-add-contact"> Add Facility
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
                            <!-- <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal1" @click="DelBranch(a.facility_id)" href="#">Delete</a> -->
                            <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal" @click="ViewBranch(a.facility_id)" href="#">View</a>
                            <!-- <a class="dropdown-item" data-toggle="modal" data-target="#modal-edit-contact" @click="EditBranch(a.facility_id)" href="#">Edit</a> -->
                        </div>
                    </div>
                    <a href="#" class="media text-secondary" @click="SelectedBranch(a.facility_name,a.facility_id)" >
                        <img v-if="a.facility_photo != null && a.facility_photo != ''" :src = "'https://www.4angelshc.com/wangelmobile/filesystem/'+a.facility_photo" class="mr-3 img-fluid rounded" alt="Avatar Image">
                        <img v-else src="../../assets/building.jpg" class="mr-3 img-fluid rounded" alt="Avatar Image">
                        <div class="media-body">
                        <h5 class="mt-0 mb-2 text-dark">{{a.facility_name}}</h5>

                        <ul class="list-unstyled">
                            <li class="d-flex mb-1">
                            <i class="mdi mdi-map mr-1"></i>
                            <span>{{a.facility_location}}</span>
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
import axiosA from 'axios';
import toastr from 'toastr';
import FileView from '../../views/FileManager.vue';
import { elementLoad, lStore } from '../../functions';
import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder';
import mapboxgl from 'mapbox-gl';
import '@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css';



export default ({
    name: "App",
    components: {
    LayoutView,
    FileView
    },
    data(){
        return {
            branches: [],
            branchname: "",
            branchloc: "",
            permi: "",
            branchid: "",
            branchimg: "",
            search: "",
            uploading: {},
            filesrc: "",
            searchkey: "",
            long: "",
            lat: "",
            employee: "",
            mapToken: 'pk.eyJ1Ijoic3BlZWR5cmVwYWlyIiwiYSI6ImNsNWg4cGlzaDA3NTYzZHFxdm1iMTJ2cWQifQ.j_XBhRHLg-CcGzah7uepMA',
            selected_facility:'',
            userid: "",
            selectedImage: "",
            loading: false
        }
    },
    methods:{
        SelectedBranch(data1,data2){
            lStore.set('selected_facility',data1);
            lStore.set('selected_facilityId',data2);
            window.location.assign("/adminapp/dashboard");
        },
        SearchFacilities()
        {
            axios.post('facilitycontroller/searchfacility',null,{search: this.searchkey, userid: this.userid}).then(res=>{
                if(res.data.result.length != 0){
                    this.branches = res.data.result;
                    document.querySelector(".textcenter").style.display = "none";
                }else{
                    this.branches = res.data.result;
                    document.querySelector(".textcenter").textContent = "No Data to be presented!";
                    document.querySelector(".textcenter").style.display = "block";
                }
            });
            // axios.post("branches/search?from=name&s="+this.searchkey+"&batch=true").then(res=>{
            //     if(res.data.success){
            //         this.branches = res.data.result;
            //         document.querySelector(".textcenter").style.display = "none";
            //     }
            //     else{
            //         document.querySelector(".textcenter").textContent = "No Data to be presented!";
            //     }
            // });
        },
        fileType(filename){
            if(typeof filename != 'string') return;
            let fileSplit = filename.toLowerCase().split('.');
            let ext = fileSplit[fileSplit.length - 1];
            let image = ['gif','png','jpg','jpeg'];
            let video = ['mp4','webm','ogv'];
            let doc = ['doc','docx','xls','xlsx','csv','pdf'];
            if(image.includes(ext)) return 'image'; 
            if(video.includes(ext)) return 'video';
            if(doc.includes(ext)) return 'document';
            return '';
        },
        Updatebranch($data){
            //Update
            
        },
        EditBranch(data){
            this.clearVariable();
            axios.post("facilitycontroller/viewspecificfacility",null,{facilityid: data}).catch(res=>{

            }).then(res=>{
                this.branchname = res.data.result[0].facility_name;
                this.branchloc = res.data.result[0].facility_location;
                this.branchid = data;
                this.long = res.data.result[0].facility_location_long;
                this.lat = res.data.result[0].facility_location_lat;
            });
        },
        ViewBranch(data){
            this.clearVariable();
            axios.post("facilitycontroller/viewspecificfacility",null,{facilityid: data}).then(res=>{
                console.log(res.data);
                this.branchname = res.data.result[0].facility_name;
                this.branchloc = res.data.result[0].facility_location;
                this.branchid = data;
                this.long = res.data.result[0].facility_location_long;
                this.lat = res.data.result[0].facility_location_lat;
                this.branchimg = res.data.result[0].facility_photo;
                document.querySelector('#geocoder2 input').value = res.data.result[0].facility_location;
                // document.querySelector('#facilityImage').value = res.data.result[0].facility_photo;
            });
        },
        SaveBranch(){
            this.loading = true;

            let form = new FormData();
            let file = null;
            if(this.selectedImage != null){
                file = this.selectedImage;
            }
            form.append('facilityname', this.branchname);
            form.append('facilitylocation', this.branchloc);
            form.append('facilitylong', this.long);
            form.append('facilitylat',this.lat);
            form.append('userid', this.userid);
            form.append('file',file);
            axiosA.post('https://www.4angelshc.com/wangelmobile/facilitycontroller/createfacility',form).then(res=>{
                if(res.data.success){
                    this.loading = false;
                    this.clearModal('modal-add-contact');
                    this.clearVariable();
                    this.callToaster("toast-top-right", res.data);
                    this.branches = res.data.result;
                    this.selectedImage = null;
                    document.querySelector('#geocoder1 input').value = '';
                    document.querySelector('#facilityImage').value = '';
                    if(document.querySelector(".textcenter").style.display == 'block'){
                        document.querySelector(".textcenter").style.display = 'none';
                    }
                }else{
                    this.loading = false;
                    this.callToaster("toast-top-right", res.data);
                }
            });
        },
        onImageChange(e) {
            const selectedFile = e.target.files[0];
            this.photo = URL.createObjectURL(selectedFile);
            this.selectedImage = e.target.files[0];
            e.target.files[0] = null;
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
        clearVariable()
        {
           this.branchname = "";
           this.branchloc = "";
           this.branchid = "";
           this.filesrc = "";
           this.long = "";
           this.lat = "";
           this.branchimg = "";
        }
    },
    mounted() {
        
        //mapbox Start
        let permiss = lStore.get('userdetails')
        this.permi = permiss.user_access_level_id;
        mapboxgl.accessToken = this.mapToken;
        this.userid = permiss.user_id;

        const geocoder1 = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl
        });
        const geocoder2 = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl
        });

        elementLoad('#geocoder1').then(()=>{
            if(document.getElementById("geocoder1").querySelector("div")){

            }else{
                geocoder1.addTo('#geocoder1');
            }
        });

        elementLoad('#geocoder2').then(()=>{
           if(document.getElementById("geocoder2").querySelector("div")){
                
            }else{
                geocoder2.addTo('#geocoder2');
            }
        });

        geocoder1.on('result', e => {
            this.branchloc = e.result.place_name;
            this.long = e.result.center[0];
            this.lat = e.result.center[1];
        });

        geocoder2.on('result', e => {
            this.branchloc = e.result.place_name;
            this.long = e.result.center[0];
            this.lat = e.result.center[1];
        });
        //mapbox End
        this.clearVariable();

        axios.post("facilitycontroller/viewallfacility",null,{'userid': this.userid}).then(res=>{
            if(res.data.success){
                this.branches = res.data.result;
                document.querySelector(".textcenter").style.display = "none";
            }else{
                document.querySelector(".textcenter").textContent = "No Data to be presented!";
                document.querySelector(".textcenter").style.display = "block";
            }
        });
    },
})
</script>
<style scoped>
@import '../../assets/scss/_card.scss';
@import '../../assets/scss/_breadcrumb.scss';
@import '../../assets/scss/_type.scss';
@import '../../assets/scss/_reboot.scss';
@import '../../assets/sleek.min.css';
@import '../../assets/base.css';
.textcenter{
    display: block;
    margin: 0 auto;
    font-size: 20px;
}
.img-fluid{
    width: 100px;
    height: 100px;
}
.btn-dots-icon
{
    position: absolute;
    top: -26px;
    right: -8px;
    font-size: 25px;
}
.modal-body .img-fluid{
    width: 100%;
    height: auto;
}
</style>