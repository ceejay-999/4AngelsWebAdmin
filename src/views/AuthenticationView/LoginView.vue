<template>
    <div class="container d-flex align-items-center justify-content-center vh-100">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10">
          <div class="card">

            <div class="card-body p-5">
              <img class="logo-img" src="../../assets/Logo.png" />
              <h4 class="text-dark mb-5" id="cent">Sign In Admin</h4>
              <form action="/index.html">
                <div class="row">
                  <div class="form-group col-md-12 mb-4">
                    <input type="email" class="form-control input-lg" id="email" aria-describedby="emailHelp" placeholder="Username">
                  </div>
                  <div class="form-group col-md-12 ">
                    <input type="password" class="form-control input-lg" id="password" placeholder="Password">
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
                    <button type="submit" class="btn btn-lg btn-primary btn-block mb-4">Sign In</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>
<script>

</script>

<style scoped>
@import '../../assets/sleek.css';
@import '../../assets/sleek.rtl.css';
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