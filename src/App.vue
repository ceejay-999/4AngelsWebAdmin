<template>
  <RouterView />
</template>
<style>
@import 'toastr/build/toastr.min.css';
/*===== Toaster  =====*/
#toast-container {
  margin-top: 65px;
  right: 0;
  z-index: 999; }
#toast-container .toast {
  background-color: #030303;
  opacity: 1;
}
#toast-container .toast-success {
  background-color: #51A351;
  opacity: 1;
}
#toast-container .toast-error {
  background-color: #BD362F;
  opacity: 1;
}
#toast-container .toast-info {
  background-color: #2F96B4;
  opacity: 1;
}
#toast-container .toast-warning {
  background-color: #F89406;
  opacity: 1;
}

#toast-container > div {
  box-shadow: none;
}

#toast-container > div:hover {
  box-shadow: none;
}

  body{
    background: #f5f6fa !important;
  }
</style>
