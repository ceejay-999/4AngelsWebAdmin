<template>
    <LayoutView>
        <div id="toaster" >

        </div>
        <div class="bg-white border rounded">
            <div class="row no-gutters">
                <div class="col-lg-4 col-xl-3">
                <div class="profile-content-left profile-left-spacing pt-5 pb-3 px-3 px-xl-5">
                    <div class="card text-center widget-profile px-0 border-0">
                    <div class="card-img mx-auto">
                        <img v-if="profile.user_photo == '' || profile.user_photo == null" src="../../assets/default-profile.png" class="rounded-circle" alt="user image" />
                        <img v-if="profile.user_photo != '' || profile.user_photo != null" :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+profile.user_photo" class="rounded-circle" alt="user image" />
                    </div>

                    <div class="card-body">
                        <h4 class="py-2 text-dark font-weight-bold">{{ profile.user_firstname }} {{ profile.user_lastname }}</h4>
                        <p>{{ profile.user_email }}</p>
                        <p class="py-2" v-if="profile.user_access_level_id == 1">( Admin )</p>
                        <p class="py-2" v-if="profile.user_access_level_id == 2">( Supervisor )</p>
                        <p class="py-2" v-if="profile.user_access_level_id == 3">( Manager )</p>
                    </div>
                    </div>

                    <!-- <div class="d-flex justify-content-between ">
                    <div class="text-center pb-4">
                        <h6 class="text-dark pb-2">1503</h6>
                        <p>Friends</p>
                    </div>

                    <div class="text-center pb-4">
                        <h6 class="text-dark pb-2">2905</h6>
                        <p>Followers</p>
                    </div>

                    <div class="text-center pb-4">
                        <h6 class="text-dark pb-2">1200</h6>
                        <p>Following</p>
                    </div>
                    </div> -->

                    <hr class="w-100">

                    <div class="contact-info pt-4">
                    <h5 class="text-dark mb-1 font-weight-bold">Contact Information</h5>
                    <p class="text-dark font-weight-medium pt-4 mb-2">Email address</p>
                    <p>{{ profile.user_email }}</p>
                    <p class="text-dark font-weight-medium pt-4 mb-2">Phone Number</p>
                    <p>{{ profile.user_phone }}</p>
                    <p class="text-dark font-weight-medium pt-4 mb-2">Birthday</p>
                    <p>{{ profile.user_birthday }}</p>
                    </div>
                </div>
                </div>

                <div class="col-lg-8 col-xl-9">
                <div class="profile-content-right profile-right-spacing py-5">
                    <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myTab" role="tablist">
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                    </li> -->

                    <li class="nav-item">
                        <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
                    </li>
                    </ul>

                    <div class="tab-content px-3 px-xl-5" id="myTabContent">

                    <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                        <div class="tab-pane-content mt-5">
                        <form>
                            <div class="form-group row mb-6 cimg">
                            <label for="coverImage" class="col-sm-4 col-lg-2 col-form-label">User Image</label>
                            <div class="col-sm-8 col-lg-10">
                                <img v-if="profile.user_photo == '' && this.photo == '' || profile.user_photo == null && this.photo == null" src="../../assets/default-profile.png" class="rounded-circle" alt="user image" />
                                <img v-else-if="profile.user_photo !== '' && this.photo === '' || profile.user_photo !== null && this.photo === null" :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+profile.user_photo" class="rounded-circle" alt="user image" />
                                <img v-else :src="this.photo" class="rounded-circle" alt="user image" />
                                <div class="custom-file mb-1">
                                <input type="file" class="form-control" @change="onImageChange">
                                </div>
                            </div>
                            </div>

                            <div class="row mb-2">
                            <div class="col-lg-6">
                                <div class="form-group">
                                <label for="firstName">First name</label>
                                <input type="text" class="form-control" v-model="firstname" >
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                <label for="lastName">Last name</label>
                                <input type="text" class="form-control" v-model="lastname" >                  
                                </div>
                            </div>
                            </div>

                            <div class="form-group mb-4">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" v-model="email">
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                    <label for="email">Birthday</label>
                                    <input type="date" class="form-control" v-model="birthday">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                    <label for="email">Phone</label>
                                    <input type="text" class="form-control" v-model="phone">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                            <label for="oldPassword">Old password</label>
                            <input type="password" class="form-control" v-model="oldpass">
                            </div>

                            <div class="form-group mb-4">
                            <label for="newPassword">New password</label>
                            <input type="password" class="form-control" v-model="newpass">
                            </div>

                            <div class="form-group mb-4">
                            <label for="conPassword">Confirm password</label>
                            <input type="password" class="form-control" v-model="confirmpass">
                            </div>

                            <div class="d-flex justify-content-end mt-5">
                            <a href="#" type="button" class="btn btn-primary mb-2 btn-pill" @click="UpdateProfile">Update Profile</a>
                            </div>
                        </form>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
    </LayoutView>
</template>
<script>
import { lStore, axios } from '../../functions';
import axiosA from 'axios';
import toastr from 'toastr';

export default({
  name: 'Profilepage',
  data() {
      return{
        profile: [],
        firstname: "",
        lastname: "",
        email: "",
        birthday: "",
        phone: "",
        oldpass: "",
        newpass: "",
        confirmpass: "",
        photo: "",
        userid: "",
      };
  },
  mounted(){
    this.profile = lStore.get('userdetails');
    this.firstname = this.profile.user_firstname;
    this.lastname = this.profile.user_lastname;
    this.email = this.profile.user_email;
    this.birthday = this.profile.user_birthday;
    this.phone = this.profile.user_phone;
    this.oldpass = "";
    this.newpass = "";
    this.confirmpass = "";
    this.userid = this.profile.user_id;
  },
  methods: {
    UpdateProfile(){
        if(this.photo == null || this.photo == ""){
            axios.post('usercontroller/editprofile',{pwauth: lStore.get('usertoken')},{
                userid: this.userid,
                firstname: this.firstname,
                lastname: this.lastname,
                email: this.email,
                birthday: this.birthday,
                phone: this.phone,
                oldpass: this.oldpass,
                newpass: this.newpass,
                confirmpass: this.confirmpass,
            }).then(res=>{
                if(res.data.success){
                    lStore.set('userdetails',res.data.result);
                    this.profile  = lStore.get('userdetails');
                    this.callToaster("toast-top-right",res.data);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }else{
                    this.callToaster("toast-top-right",res.data);
                }
            });
        }else{
            let file = this.selectedImage;
            let formData = new FormData();
            formData.append('file', file);
            formData.append('userid', this.userid);
            axiosA.post('https://www.4angelshc.com/wangelmobile/usercontroller/uploadfile',formData,{headers:{pwauth: lStore.get('usertoken')}}).then(() => {
                    axios.post('usercontroller/editprofile',{pwauth: lStore.get('usertoken')},{
                    userid: this.userid,
                    firstname: this.firstname,
                    lastname: this.lastname,
                    email: this.email,
                    birthday: this.birthday,
                    phone: this.phone,
                    oldpass: this.oldpass,
                    newpass: this.newpass,
                    confirmpass: this.confirmpass,
                }).then(res=>{
                    if(res.data.success){
                        lStore.set('userdetails',res.data.result);
                        this.profile = lStore.get('userdetails');
                        this.callToaster("toast-top-right",res.data);
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }else{
                        this.callToaster("toast-top-right",res.data);
                    }
                });
            });

        }
    },
    onImageChange(e) {
        const selectedFile = e.target.files[0];
        this.photo = URL.createObjectURL(selectedFile);
        this.selectedImage = e.target.files[0];
    },
    fileType(filename) {
        if (typeof filename != 'string') return;
        let fileSplit = filename.toLowerCase().split('.');
        let ext = fileSplit[fileSplit.length - 1];
        let image = ['gif', 'png', 'jpg', 'jpeg'];
        let video = ['mp4', 'webm', 'ogv'];
        let doc = ['doc', 'docx', 'xls', 'xlsx', 'csv', 'pdf'];
        if (image.includes(ext)) return 'image';
        if (video.includes(ext)) return 'video';
        if (doc.includes(ext)) return 'document';
        return '';
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
});
</script>
<style scoped>
@import '../../assets/scss/_sidebar.scss';
@import '../../assets/scss/_reboot.scss';
@import '../../assets/sleek.min.css';

.card-img img{
    object-fit: cover;
    width: 100%;
    height: 100%;
}
.cimg img{
    object-fit: cover;
    width: 100%;
    height: 100%;
    max-width: 255px;
}
#settings{
    display: block;
}

</style>