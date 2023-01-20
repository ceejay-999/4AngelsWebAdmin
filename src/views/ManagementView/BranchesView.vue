<template>
    <LayoutView>
        <div class="toast" >

        </div>
        <!-- <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        </div> -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <img v-if="branchimg != 'https://www.4angelshc.com/mobile/filesystem/'" :src = "branchimg" class="img-fluid" alt="Avatar Image">
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
                    <button type="button" class="btn btn-primary btn-pill editedB" @click="SaveBranch(branchid)">Update Branch</button>
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
                                <input type="file" id="uploadFile1" class="form-control-file form-control height-auto" accept="image/x-png,image/gif,image/jpeg">
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
                    <button type="button" class="btn btn-primary btn-pill savedB" @click="SaveBranch(0)">Save Branch</button>
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
                <button v-if="permi == '1'" type="button" class="btn btn-primary" @click="clearVariable" data-toggle="modal" data-target="#modal-add-contact"> Add Facility
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
                            <a class="dropdown-item" data-toggle="modal" data-target="#modal-edit-contact" @click="EditBranch(a.facility_id)" href="#">Edit</a>
                        </div>
                    </div>
                    <a href="#" class="media text-secondary" @click="SelectedBranch(a.facility_name,a.facility_id)" >
                        <img v-if="a.facility_image != 'https://www.4angelshc.com/mobile/filesystem/'" :src = "a.facility_image" class="mr-3 img-fluid rounded" alt="Avatar Image">
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
            axios.post("branches/search?from=name&s="+this.searchkey+"&batch=true").then(res=>{
                if(res.data.success){
                    this.branches = res.data.result;
                    console.log(res.data.result);
                    document.querySelector(".textcenter").style.display = "none";
                }
                else{
                    document.querySelector(".textcenter").textContent = "No Data to be presented!";
                }
            });
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
        // DelBranch(data){
        //     this.branchid = data;

        // },
        // DeleteBranch(data){
        //     this.clearVariable();
        //     if(data == "")
        //     {
        //         document.querySelector(".toast").id = "toaster";
        //         this.callToaster("toast-top-right",2);
        //     }
        //     else
        //     {
        //         document.querySelector(".toast").id = "toaster";
        //         axios.post("branches/delete?id="+data).catch(res=>{
        //             this.callToaster("toast-top-right",2);
        //         }).then(res=>{
        //             if(res.data.success)
        //             {
        //                 this.callToaster("toast-top-right",3);
        //                 setTimeout(() => {
        //                     this.$router.go(0);
        //                 }, 2000);
        //             }
        //             else
        //             {
        //                 this.callToaster("toast-top-right",2);
        //             }
        //         });
        //     }
        // },
        EditBranch(data){
            this.clearVariable();
            axios.post("branches?id="+data).catch(res=>{

            }).then(res=>{
                this.branchname = res.data.result.facility_name;
                this.branchloc = res.data.result.facility_location;
                this.branchid = data;
                this.long = res.data.result.facility_location_long;
                this.lat = res.data.result.facility_location_lat;
            });
        },
        ViewBranch(data){
            this.clearVariable();
            axios.post("branches?id="+data).catch(res=>{

            }).then(res=>{
                this.branchname = res.data.result.facility_name;
                this.branchloc = res.data.result.facility_location;
                this.branchid = data;
                this.long = res.data.result.facility_location_long;
                this.lat = res.data.result.facility_location_lat;
                this.branchimg = res.data.result.facility_image;
                console.log(res.data.result.facility_image)
            });
        },
        SaveBranch(data){
            if(this.checkError(1) === 0 && data == 0)
            {
                document.querySelector(".feedback5").style.display = "none";
                document.querySelector(".feedback6").style.display = "none";
                document.querySelector(".toast").id = "toaster";
                if( document.getElementById("uploadFile1").files.length == 0 ){
                    axios.post("branches/create",null,{facility_name: this.branchname,facility_location_long: this.long,facility_location_lat: this.lat, facility_location: this.branchloc,facility_image: "https://www.4angelshc.com/mobile/filesystem/"+this.filesrc}).catch(res=>{
                        this.clearVariable();
                        this.callToaster("toast-top-right",2);
                    }).then(res=>{
                        if(res.data.success)
                        {
                            let facilityid = res.data.result.facility_id;
                            let userid = lStore.get("users_id");
                            axios.post("branches/createpermit",null,{permission_facility_id: facilityid,permission_user_id: userid}).catch(ress=>{
                                this.clearVariable();
                                this.callToaster("toast-top-right",2);
                            }).then(ress=>{
                                this.clearVariable();
                                this.callToaster("toast-top-right",1);
                                document.querySelector("#modal-add-contact").style.display = "none";
                                setTimeout(() => {
                                    this.$router.go(0);
                                }, 2000);
                            })
                        }
                        else
                        {
                            this.clearVariable();
                            this.callToaster("toast-top-right",2);
                        }
                    });
                    return;
                }

                let fname = document.getElementById("uploadFile1").files[0].name

                axios.post('files/upload?keep_filename=true',null,
                {file:document.getElementById("uploadFile1").files[0]},
                {onUploadProgress:progressEvent =>{
                    this.uploading[fname] = Math.floor((progressEvent.loaded/progressEvent.total) * 100);
                }}).catch(ress=>{
                    console.log(ress.data);
                    console.log('aw2');
                }).then(ress=>{
                    console.log(ress.data);
                    if(!ress.data.success){
                        alert('Error Uploading File!');
                        return;
                    }
                    this.filesrc = ress.data.file_name;
                    axios.post("branches/create",null,{facility_name: this.branchname,facility_location_long: this.long,facility_location_lat: this.lat, facility_location: this.branchloc,facility_image: "https://www.4angelshc.com/mobile/filesystem/"+ this.filesrc}).catch(res=>{
                        this.clearVariable();
                        this.callToaster("toast-top-right",2);
                    }).then(res=>{
                        if(res.data.success)
                        {
                            let facilityid = res.data.result.facility_id;
                            let userid = lStore.get("users_id");
                            axios.post("branches/createpermit",null,{permission_facility_id: facilityid,permission_user_id: userid}).catch(ress=>{
                                this.clearVariable();
                                this.callToaster("toast-top-right",2);
                            }).then(ress=>{
                                this.clearVariable();
                                this.callToaster("toast-top-right",1);
                                document.querySelector("#modal-add-contact").style.display = "none";
                                setTimeout(() => {
                                    this.$router.go(0);
                                }, 2000);
                            })
                        }
                        else
                        {
                            this.clearVariable();
                            this.callToaster("toast-top-right",2);
                        }
                    });
                })
            }
            if(this.checkError(2) === 0 && data != 0)
            {
                document.querySelector(".feedback2").style.display = "none";
                document.querySelector(".feedback3").style.display = "none";
                document.querySelector(".toast").id = "toaster";
                 if( document.getElementById("uploadFile2").files.length == 0 ){
                    axios.post("branches/update?id="+data,null,{facility_name: this.branchname,facility_location_long: this.long,facility_location_lat: this.lat, facility_location: this.branchloc}).catch(res=>{
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
                     return;
                 }

                let fname = document.getElementById("uploadFile2").files[0].name;

                axios.post('files/upload?keep_filename=true',null,
                {file:document.getElementById("uploadFile2").files[0]},
                {onUploadProgress:progressEvent =>{
                    this.uploading[fname] = Math.floor((progressEvent.loaded/progressEvent.total) * 100);
                }}).catch(ress=>{
                    console.log(ress.data);
                }).then(ress=>{
                    console.log(ress.data);
                    if(!ress.data.success){
                        alert('Error Uploading File!');
                    }
                    this.filesrc = ress.data.file_name;
                    axios.post("branches/update?id="+data,null,{facility_name: this.branchname,facility_location_long: this.long,facility_location_lat: this.lat, facility_location: this.branchloc,facility_image: "https://www.4angelshc.com/mobile/filesystem/"+this.filesrc}).catch(res=>{
                        this.clearVariable();
                        this.callToaster("toast-top-right",2);
                    }).then(res=>{
                        console.log(res.data);
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
                });
            }
        },
        checkError(data){
            var val = 0;
            if(this.branchname == "" && data == 2)
            {
                document.querySelector(".feedback2").textContent = "Facility name is required!";
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
                document.querySelector(".feedback5").textContent = "Facility name is required!";
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
                document.querySelector(".feedback6").textContent = "Facility name is required!";
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
                document.querySelector(".feedback3").textContent = "Facility location is required!";
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
           this.filesrc = "";
           this.long = "";
           this.lat = "";
           this.branchimg = "";
        }
    },
    mounted() {
        //mapbox Start
        let permiss = lStore.get('users_info')
        this.permi = permiss.users_permission_status;
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
            geocoder1.addTo('#geocoder1');
        });

        elementLoad('#geocoder2').then(()=>{
            geocoder2.addTo('#geocoder2');
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
        document.querySelector(".toast").id = "";
        this.clearVariable();
        axios.post("branches?_batch=true").catch(res=>{

        }).then(res=>{
            if(res.data.success){
                let br = res.data.result;
                let obj = {};
                axios.post("branches/viewpermit?_batch=true").catch(ress=>{

                }).then(ress=>{
                    br.forEach(element => {
                        ress.data.result.forEach(el => {
                            if(element.facility_id == el.permission_facility_id && el.permission_user_id == lStore.get('users_id'))
                            {
                                obj = JSON.parse(JSON.stringify(element));
                                this.branches.push(obj);
                                console.log(this.branches);
                            }
                        });
                    });
                });
                console.log(this.branches);
                document.querySelector(".textcenter").style.display = "none";
            }
            else{
                document.querySelector(".textcenter").textContent = "No Data to be presented!";
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