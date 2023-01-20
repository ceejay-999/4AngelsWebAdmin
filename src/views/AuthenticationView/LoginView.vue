<template>
<div class="toast" >

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
                    <input type="email" v-model="loginInput" class="form-control input-lg" id="email" aria-describedby="emailHelp" placeholder="Username">
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
import { lStore, axios , validateForm } from '../../functions';
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
      document.querySelector(".toast").id = "toaster";
      let rules = {password:{isRequired:true}};
      let input = {password:this.password};
      rules.email = {isRequired:true};
      input.email = this.loginInput;
      rules.email.callback = ()=>{this.callToaster("toast-top-right",5)};
      const valid = validateForm(input,rules);
        if(!valid.allValid) return;

        

        axios.post('users/login',null,{
            login: this.loginInput,
            password: this.password
        }).catch(err=>{
            this.callToaster("toast-top-right",5);
        }).then(res=>{
            if(res.data.success == false && res.data.msg === 'user not found')
            {
              this.callToaster("toast-top-right",6);
            }
            else if(res.data.success == false && res.data.msg == 'wrong password'){
              this.callToaster("toast-top-right",6);
            }
            else if(res.data.success == true){
              if(res.data.result.users_permission_status == 1)
              {
                lStore.remove('selected_facility');
                lStore.set('users_id',res.data.result.users_id);
                lStore.set('users_token',res.data.token);
                lStore.set('users_info', res.data.result);
                console.log(res.data.result);
                this.callToaster("toast-top-right",1);
                this.$router.replace('/dashboard');
              }
              if(res.data.result.users_permission_status == 2)
              {
                lStore.remove('selected_facility');
                lStore.set('users_id',res.data.result.users_id);
                lStore.set('users_token',res.data.token);
                lStore.set('users_info', res.data.result);
                console.log(res.data.result);
                this.callToaster("toast-top-right",1);
                this.$router.replace('/dashboard');
              }
              if(res.data.result.users_permission_status == 3)
              {
                lStore.remove('selected_facility');
                lStore.set('users_id',res.data.result.users_id);
                lStore.set('users_token',res.data.token);
                lStore.set('users_info', res.data.result);
                console.log(res.data.result);
                this.callToaster("toast-top-right",1);
                this.$router.replace('/dashboard');
              }
            }
            else
            {
              this.callToaster("toast-top-right",2);
            }
      });
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
                if(reserror == 1)
                {
                    toastr.success("Login successfully!", "Login Successfully!");
                }
                else if(reserror == 2)
                {
                    toastr.error("Something went Wrong!", "Error!");
                }
                else if(reserror == 3)
                {
                    toastr.error("Password must be more than 8 characters!", "Error!");
                }
                else if(reserror == 4)
                {
                  toastr.error("Email must be in valid format!", "Error!");
                }
                else if(reserror == 5)
                {
                  toastr.error("All fields are required!", "Error!");
                }
                else if(reserror == 6)
                {
                  toastr.error("Username or password doesn`t match!","Error!");
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