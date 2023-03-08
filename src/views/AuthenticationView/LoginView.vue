<template>
<div id="toaster" >

</div>
    <div class="container d-flex align-items-center justify-content-center vh-100">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10">
          <div class="card">
            <div class="card-body p-5">
              <img class="logo-img" src="../../assets/Logo.png" />
              <h4 class="text-dark mb-5" id="cent">Sign In Admin</h4>
                <div class="row">
                  <div class="form-group col-md-12 mb-4">
                    <input type="email" v-model="loginInput" class="form-control input-lg" id="email" aria-describedby="emailHelp" placeholder="Email">
                  </div>
                  <div class="form-group col-md-12 ">
                    <input type="password" class="form-control input-lg" v-model="password" id="password" placeholder="Password">
                  </div>
                  <div class="col-md-12">
                    <div class="d-flex my-2 justify-content-between">
                      <div class="d-inline-block mr-3">
                        <label class="control control-checkbox">Remember me
                          <input type="checkbox" />
                          <div class="control-indicator"></div>
                        </label>
                      </div>
                      <p><a class="text-blue" href="#">Forgot Your Password?</a></p>
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary btn-block mb-4" @click="login">Sign In</button>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
<script>
import { lStore, axios } from '../../functions';
import toastr from 'toastr';

export default({
  name: 'LoginPage',
  data() {
      return{
        loginInput: "",
        password: "",
      };
  },
  methods: {
    login(){

      axios.post('usercontroller/authuser',null,{email: this.loginInput, password:this.password}).then(res=>{
        if(res.data.success){
          this.callToaster("toast-top-right",res.data);
          lStore.set('userdetails',res.data.result[0]);
          this.$router.push('/dashboard');
        }else{
          this.callToaster("toast-top-right",res.data)
        }
      })
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
@import '../../assets/sleek.min.css';
.logo-img{
  margin: 0 auto;
  display: flex;
  padding-bottom: 15px;
}
#cent{
  margin: 0 auto;
  display: flex;
  justify-content: center;                 
  padding-bottom: 15px;
}
</style>                                                                                                                                                                                  