
<template>
  <div class="wrapper">
    <aside class="left-sidebar bg-sidebar">
    <div id="sidebar" class="sidebar ">
      <!-- Aplication Brand -->
      <div class="app-brand">
        <RouterLink class="sidenav-item-link" to="/dashboard">
          <img class="brand-icon" src="../../assets/icon.png" />
          <img class="brand-name text-truncate" src="../../assets/dashlogo.png" />
        </RouterLink>
      </div>

      <!-- begin sidebar scrollbar -->
      <div class="" data-simplebar style="height: 100%; overflow:hidden !important;">
        <!-- sidebar menu -->
        <ul class="nav sidebar-inner" id="sidebar-menu">
          <li class="has-sub"  data-url="/dashboard">
            <RouterLink class="sidenav-item-link" to="/dashboard">
              <i class="mdi mdi-view-dashboard-outline"></i>
              <span class="nav-text">Dashboard</span>
            </RouterLink>
          </li>
          <li class="has-sub " data-url="/timeclock">
            <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#buttons"
                          aria-expanded="false" aria-controls="buttons">
              <i class="mdi mdi-calendar-clock"></i>
              <span class="nav-text">Time Clock</span><b class="caret"></b>
            </a>
            <ul class="collapse " id="buttons">
              <div class="sub-menu">
                <li class="">
                  <RouterLink class="sidenav-item-link" to="/timeclock">Today</RouterLink>
                </li>

                <li class="">
                  <RouterLink class="sidenav-item-link"  to="/timesheets">Timesheets</RouterLink>
                </li>

                <li class="">
                  <a href="button-group.html">Request</a>
                </li>

              </div>
            </ul>
          </li>
          <li class="has-sub " data-url="/jobschedule">
            <RouterLink class="sidenav-item-link" to="/jobschedule">
              <i class="mdi mdi-calendar"></i>
              <span class="nav-text">Job Scheduling</span>
            </RouterLink>
          </li>
          <li class="has-sub " data-url="/employee">
            <RouterLink class="sidenav-item-link" to="/employee">
              <i class="mdi mdi-account-multiple"></i>
              <span class="nav-text">Employee</span>
            </RouterLink>
          </li>

          <li class="has-sub" data-url="/designation">
            <RouterLink class="sidenav-item-link" to="/designation">
              <i class="mdi mdi-settings"></i>
              <span class="nav-text">Role</span>
            </RouterLink>
          </li>

          <li class="has-sub" data-url="/branch">
            <RouterLink class="sidenav-item-link" to="/branch">
              <i class="mdi mdi-hospital-building"></i>
              <span class="nav-text">Facilities</span>
            </RouterLink>
          </li>
        </ul>
      </div>
    </div>
  </aside>
  <div class="page-wrapper">
    <header class="main-header " id="header">
    <nav class="navbar navbar-static-top navbar-expand-lg">
      <!-- Sidebar toggle button -->
      <button id="sidebar-toggler" class="sidebar-toggle">
        <span class="sr-only">Toggle navigation</span>
      </button>
      <!-- search form -->
      <div class="search-form d-none d-lg-inline-block">
        <div class="input-group">
          <button type="button" name="search" id="search-btn" class="btn btn-flat">
            <i class="mdi mdi-magnify"></i>
          </button>
          <input type="text" name="query" id="search-input" class="form-control" placeholder="'button', 'chart' etc."
            autofocus autocomplete="off" />
        </div>
        <div id="search-results-container">
          <ul id="search-results"></ul>
        </div>
      </div>

      <div class="navbar-right ">
        <ul class="nav navbar-nav">
          <li class="dropdown notifications-menu custom-dropdown">
            <button class="dropdown-toggle notify-toggler custom-dropdown-toggler">
              <i class="mdi mdi-bell-outline"></i>
            </button>

            <div class="card card-default dropdown-notify dropdown-menu-right mb-0">
              <div class="card-header card-header-border-bottom px-3">
                <h2>Notifications</h2>
              </div>

              <div class="card-body px-0 py-3">
                <ul class="nav nav-tabs nav-style-border p-0 justify-content-between" id="myTab" role="tablist">
                  <li class="nav-item mx-3 my-0 py-0">
                    <a class="nav-link active pb-3" id="home2-tab" data-toggle="tab" href="#home2" role="tab" aria-controls="home2" aria-selected="true">All (11)</a>
                  </li>

                  <li class="nav-item mx-3 my-0 py-0">
                    <a class="nav-link pb-3" id="profile2-tab" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile2" aria-selected="false">Msgs (6)</a>
                  </li>

                  <li class="nav-item mx-3 my-0 py-0">
                    <a class="nav-link pb-3" id="contact2-tab" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact2" aria-selected="false">Others (5)</a>
                  </li>
                </ul>

                <div class="tab-content" id="myTabContent3">
                  <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home2-tab">
                    <ul class="list-unstyled" data-simplebar style="height: 360px; overflow: scroll !important;">
                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification">
                          <div class="position-relative mr-3">
                            <!-- <img class="rounded-circle" src="assets/img/user/u2.jpg" alt="Image"> -->
                            <span class="status away"></span>
                          </div>
                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">Aaren</h4>
                              <p class="last-msg">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam itaque doloremque odio, eligendi delectus vitae.</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline"></i> 30 min ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification media-active">
                          <div class="position-relative mr-3">
                            <!-- <img class="rounded-circle" src="assets/img/user/u1.jpg" alt="Image"> -->
                            <span class="status active"></span>
                          </div>
                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">Abril</h4>
                              <p class="last-msg">Donec mattis augue a nisl consequat, nec imperdiet ex rutrum. Fusce et vehicula enim. Sed in enim eu odio vehic.</p>

                              <span class="font-size-12 font-weight-medium text-white">
                                <i class="mdi mdi-clock-outline"></i> Just now...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification">
                          <div class="position-relative mr-3">
                            <!-- <img class="rounded-circle" src="assets/img/user/u5.jpg" alt="Image"> -->
                            <span class="status away"></span>
                          </div>
                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">Emma</h4>
                              <p class="last-msg">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam itaque doloremque odio, eligendi delectus vitae.</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline"></i> 1 hrs ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification event-active">

                          <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-info text-white">
                            <i class="mdi mdi-calendar-check font-size-20"></i>
                          </div>

                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">New event added</h4>
                              <p class="last-msg font-size-14">03/Jan/2020 (1pm - 2pm)</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline"></i> 10 min ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification">

                          <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-warning text-white">
                            <i class="mdi mdi-chart-areaspline font-size-20"></i>
                          </div>

                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">Sales report</h4>
                              <p class="last-msg font-size-14">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam itaque doloremque odio, eligendi delectus vitae.</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline"></i> 1 hrs ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification">

                          <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-primary text-white">
                            <i class="mdi mdi-account-multiple-check font-size-20"></i>
                          </div>

                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">Add request</h4>
                              <p class="last-msg font-size-14">Add Dany Jones as your contact consequat nec imperdiet ex rutrum. Fusce et vehicula enim. Sed in enim.</p>

                              <button type="button" class="my-1 btn btn-sm btn-success">Accept</button>
                              <button type="button" class="my-1 btn btn-sm btn-secondary">Delete</button>

                              <span class="font-size-12 font-weight-medium text-secondary d-block">
                                <i class="mdi mdi-clock-outline"></i> 5 min ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification">

                          <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-danger text-white">
                            <i class="mdi mdi-server-network-off font-size-20"></i>
                          </div>

                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">Server overloaded</h4>
                              <p class="last-msg font-size-14">Donec mattis augue a nisl consequat, nec imperdiet ex rutrum. Fusce et vehicula enim. Sed in enim eu odio vehic.</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline"></i> 30 min ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification">

                          <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-purple text-white">
                            <i class="mdi mdi-playlist-check font-size-20"></i>
                          </div>

                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">Task complete</h4>
                              <p class="last-msg font-size-14">Nam ut nisi erat. Ut quis tortor varius, hendrerit arcu quis, congue nisl. In scelerisque, sem ut ve.</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline"></i> 2 hrs ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                    </ul>
                  </div>

                  <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile2-tab">
                    <ul class="list-unstyled" data-simplebar style="height: 360px; overflow: scroll !important;">
                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification">
                          <div class="position-relative mr-3">
                            <!-- <img class="rounded-circle" src="assets/img/user/u6.jpg" alt="Image"> -->
                            <span class="status away"></span>
                          </div>
                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">William</h4>
                              <p class="last-msg">Donec mattis augue a nisl consequat, nec imperdiet ex rutrum. Fusce et vehicula enim. Sed in enim eu odio vehic.</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline"></i> 1 hrs ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification">
                          <div class="position-relative mr-3">
                            <!-- <img class="rounded-circle" src="assets/img/user/u7.jpg" alt="Image"> -->
                            <span class="status away"></span>
                          </div>
                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">Camble</h4>
                              <p class="last-msg">Nam ut nisi erat. Ut quis tortor varius, hendrerit arcu quis, congue nisl. In scelerisque, sem ut ve.</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline"></i> 1 hrs ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification media-active">
                          <div class="position-relative mr-3">
                            <!-- <img class="rounded-circle" src="assets/img/user/u1.jpg" alt="Image"> -->
                            <span class="status active"></span>
                          </div>
                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">Abril</h4>
                              <p class="last-msg">Donec mattis augue a nisl consequat, nec imperdiet ex rutrum. Fusce et vehicula enim. Sed in enim eu odio vehic.</p>

                              <span class="font-size-12 font-weight-medium text-white">
                                <i class="mdi mdi-clock-outline"></i> Just now...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification">
                          <div class="position-relative mr-3">
                            <!-- <img class="rounded-circle" src="assets/img/user/u2.jpg" alt="Image"> -->
                            <span class="status away"></span>
                          </div>
                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">Aaren</h4>
                              <p class="last-msg">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam itaque doloremque odio, eligendi delectus vitae.</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline"></i> 1 hrs ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification">
                          <div class="position-relative mr-3">
                            <!-- <img class="rounded-circle" src="assets/img/user/u5.jpg" alt="Image"> -->
                            <span class="status away"></span>
                          </div>
                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">Emma</h4>
                              <p class="last-msg">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam itaque doloremque odio, eligendi delectus vitae.</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline"></i> 1 hrs ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                    </ul>
                  </div>

                  <div class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact2-tab">
                    <ul class="list-unstyled" data-simplebar style="height: 360px; overflow: scroll;">
                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification event-active">

                          <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-info text-white">
                            <i class="mdi mdi-calendar-check font-size-20"></i>
                          </div>

                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">New event added</h4>
                              <p class="last-msg font-size-14">03/Jan/2020 (1pm - 2pm)</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline"></i> 10 min ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification">

                          <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-warning text-white">
                            <i class="mdi mdi-chart-areaspline font-size-20"></i>
                          </div>

                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">Sales report</h4>
                              <p class="last-msg font-size-14">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam itaque doloremque odio, eligendi delectus vitae.</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline"></i> 1 hrs ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification">

                          <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-primary text-white">
                            <i class="mdi mdi-account-multiple-check font-size-20"></i>
                          </div>

                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">Add request</h4>
                              <p class="last-msg font-size-14">Add Dany Jones as your contact consequat nec imperdiet ex rutrum. Fusce et vehicula enim. Sed in enim.</p>

                              <button type="button" class="my-1 btn btn-sm btn-success">Accept</button>
                              <button type="button" class="my-1 btn btn-sm btn-secondary">Delete</button>

                              <span class="font-size-12 font-weight-medium text-secondary d-block">
                                <i class="mdi mdi-clock-outline"></i> 5 min ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification">

                          <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-danger text-white">
                            <i class="mdi mdi-server-network-off font-size-20"></i>
                          </div>

                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">Server overloaded</h4>
                              <p class="last-msg font-size-14">Donec mattis augue a nisl consequat, nec imperdiet ex rutrum. Fusce et vehicula enim. Sed in enim eu odio vehic.</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline"></i> 30 min ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>

                      <li>
                        <a href="javscript:void(0)" class="media media-message media-notification">

                          <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-purple text-white">
                            <i class="mdi mdi-playlist-check font-size-20"></i>
                          </div>

                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">Task complete</h4>
                              <p class="last-msg font-size-14">Nam ut nisi erat. Ut quis tortor varius, hendrerit arcu quis, congue nisl. In scelerisque, sem ut ve.</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline"></i> 2 hrs ago...
                              </span>
                            </div>
                          </div>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <ul class="dropdown-menu dropdown-menu-right d-none">
              <li class="dropdown-header">You have 5 notifications</li>
              <li>
                <a href="#">
                  <i class="mdi mdi-account-plus"></i> New user registered
                  <span class=" font-size-12 d-inline-block float-right"><i class="mdi mdi-clock-outline"></i> 10 AM</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="mdi mdi-account-remove"></i> User deleted
                  <span class=" font-size-12 d-inline-block float-right"><i class="mdi mdi-clock-outline"></i> 07 AM</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="mdi mdi-chart-areaspline"></i> Sales report is ready
                  <span class=" font-size-12 d-inline-block float-right"><i class="mdi mdi-clock-outline"></i> 12 PM</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="mdi mdi-account-supervisor"></i> New client
                  <span class=" font-size-12 d-inline-block float-right"><i class="mdi mdi-clock-outline"></i> 10 AM</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="mdi mdi-server-network-off"></i> Server overloaded
                  <span class=" font-size-12 d-inline-block float-right"><i class="mdi mdi-clock-outline"></i> 05 AM</span>
                </a>
              </li>
              <li class="dropdown-footer">
                <a class="text-center" href="#"> View All </a>
              </li>
            </ul>
          </li>
          <li class="right-sidebar-in right-sidebar-2-menu">
            <i class="mdi mdi-settings mdi-spin"></i>
          </li>
          <!-- User Account -->
          
        </ul>
      </div>
    </nav>
  </header>
  <div class="content-wrapper">
    <div class="content">
      <slot />
    </div>
  </div>
  </div>
  </div>
</template>
<script>
export default ({
  name: "App",
  components: {

  },
  mounted(){
    $(document).ready(function () {

    /*======== SCROLLBAR SIDEBAR ========*/
    var sidebarScrollbar = $(".sidebar-scrollbar");
    if (sidebarScrollbar.length != 0) {
      sidebarScrollbar.slimScroll({
        opacity: 0,
        height: "100%",
        color: "#808080",
        size: "5px",
        touchScrollStep: 50
      })
        .mouseover(function () {
          $(this)
            .next(".slimScrollBar")
            .css("opacity", 0.5);
        });
    }

    /*======== MOBILE OVERLAY ========*/
    if ($(window).width() < 768) {
      $(".sidebar-toggle").on("click", function () {
        $("body").css("overflow", "hidden");
        $('body').prepend('<div class="mobile-sticky-body-overlay"></div>')
      });

      $(document).on("click", '.mobile-sticky-body-overlay', function (e) {
        $(this).remove();
        $("#body").removeClass("sidebar-mobile-in").addClass("sidebar-mobile-out");
        $("body").css("overflow", "auto");
      });
    }

    /*======== SIDEBAR MENU ========*/
    var sidebar = $(".sidebar")
    if (sidebar.length != 0) {
      $(".sidebar .nav > .has-sub > a").click(function () {
        $(this).parent().siblings().removeClass('expand')
        $(this).parent().toggleClass('expand')
      })

      $(".sidebar .nav > .has-sub .has-sub > a").click(function () {
        $(this).parent().toggleClass('expand')
      })
    }


    /*======== SIDEBAR TOGGLE FOR MOBILE ========*/
    if ($(window).width() < 768) {
      $(document).on("click", ".sidebar-toggle", function (e) {
        e.preventDefault();
        var min = "sidebar-mobile-in",
          min_out = "sidebar-mobile-out",
          body = "#body";
        $(body).hasClass(min)
          ? $(body)
            .removeClass(min)
            .addClass(min_out)
          : $(body)
            .addClass(min)
            .removeClass(min_out)
      });
    }

    /*======== SIDEBAR TOGGLE FOR VARIOUS SIDEBAR LAYOUT ========*/
    var body = $("#body");
    if ($(window).width() >= 768) {

      if (typeof window.isMinified === "undefined") {
        window.isMinified = false;
      }
      if (typeof window.isCollapsed === "undefined") {
        window.isCollapsed = false;
      }

      $("#sidebar-toggler").on("click", function () {
        if (
          body.hasClass("sidebar-fixed-offcanvas") ||
          body.hasClass("sidebar-static-offcanvas")
        ) {
          $(this)
            .addClass("sidebar-offcanvas-toggle")
            .removeClass("sidebar-toggle");
          if (window.isCollapsed === false) {
            body.addClass("sidebar-collapse");
            window.isCollapsed = true;
            window.isMinified = false;
          } else {
            body.removeClass("sidebar-collapse");
            body.addClass("sidebar-collapse-out");
            setTimeout(function () {
              body.removeClass("sidebar-collapse-out");
            }, 300);
            window.isCollapsed = false;
          }
        }

        if (
          body.hasClass("sidebar-fixed") ||
          body.hasClass("sidebar-static")
        ) {
          $(this)
            .addClass("sidebar-toggle")
            .removeClass("sidebar-offcanvas-toggle");
          if (window.isMinified === false) {
            body
              .removeClass("sidebar-collapse sidebar-minified-out")
              .addClass("sidebar-minified");
            window.isMinified = true;
            window.isCollapsed = false;
          } else {
            body.removeClass("sidebar-minified");
            body.addClass("sidebar-minified-out");
            window.isMinified = false;
          }
        }
      });
    }

    if ($(window).width() >= 768 && $(window).width() < 992) {
      if (
        body.hasClass("sidebar-fixed") ||
        body.hasClass("sidebar-static")
      ) {
        body
          .removeClass("sidebar-collapse sidebar-minified-out")
          .addClass("sidebar-minified");
        window.isMinified = true;
      }
    }

    /*======== TODO LIST ========*/
    function todoCheckAll() {
      var mdis = document.querySelectorAll(".todo-single-item .mdi");
      mdis.forEach(function (fa) {
        fa.addEventListener("click", function (e) {
          e.stopPropagation();
          e.target.parentElement.classList.toggle("finished");
        });
      });
    }

    if (document.querySelector("#todo")) {
      var list = document.querySelector("#todo-list"),
        todoInput = document.querySelector("#todo-input"),
        todoInputForm = todoInput.querySelector("form"),
        item = todoInputForm.querySelector("input");

      // document.querySelector("#add-task").addEventListener("click", function (e) {
      //   e.preventDefault();
      //   todoInput.classList.toggle("d-block");
      //   item.focus();
      // });

      todoInputForm.addEventListener("submit", function (e) {
        e.preventDefault();
        if (item.value.length <= 0) {
          return;
        }
        list.innerHTML =
          '<div class="todo-single-item d-flex flex-row justify-content-between alert alert-dismissible fade show" role="alert">' +
            '<i class="mdi"></i>' +
            '<span>' +
              item.value +
            '</span>' +
            '<div class="task-content">' +
              '<span data-dismiss="alert" aria-label="Close">' +
                '<svg class="remove-task" id="Capa_1" enable-background="new 0 0 515.556 515.556" height="16" viewBox="0 0 515.556 515.556" width="16" xmlns="http://www.w3.org/2000/svg"><path d="m64.444 451.111c0 35.526 28.902 64.444 64.444 64.444h257.778c35.542 0 64.444-28.918 64.444-64.444v-322.222h-386.666z"/><path d="m322.222 32.222v-32.222h-128.889v32.222h-161.111v64.444h451.111v-64.444z"/></svg>' +
              '</span>' +
            '</div>' +
          '</div>' +
        list.innerHTML;
        item.value = "";
        //Close input field
        // todoInput.classList.toggle("d-block");
        todoCheckAll();
      });

      todoCheckAll();
    }

    /*======== RIGHT SIDEBAR ========*/
    var rightSidebarIn = 'right-sidebar-in';
    var rightSidebarOut = 'right-sidebar-out';

    $('.nav-right-sidebar .nav-link').on('click', function () {

      if (!body.hasClass(rightSidebarIn)) {
        body.addClass(rightSidebarIn).removeClass(rightSidebarOut);

      } else if ($(this).hasClass('show')) {
        body.addClass(rightSidebarOut).removeClass(rightSidebarIn);
      }
    });

    $('.card-right-sidebar .close').on('click', function () {
      body.removeClass(rightSidebarIn).addClass(rightSidebarOut);
    })

    if ($(window).width() <= 1024) {

      var togglerInClass = "right-sidebar-toggoler-in"
      var togglerOutClass = "right-sidebar-toggoler-out"

      body.addClass(togglerOutClass);

      $('.btn-right-sidebar-toggler').on('click', function () {
        if (body.hasClass(togglerOutClass)) {
          body.addClass(togglerInClass).removeClass(togglerOutClass)
        } else {
          body.addClass(togglerOutClass).removeClass(togglerInClass);
        }
      });
    }


    /*======== DROPDOWN NOTIFY ========*/
    var dropdownToggle = $('.notify-toggler');
    var dropdownNotify = $('.dropdown-notify');

    if (dropdownToggle.length !== 0){
      dropdownToggle.on('click', function () {
        if (!dropdownNotify.is(':visible')){
          dropdownNotify.fadeIn(5);
        }else {
          dropdownNotify.fadeOut(5);
        }
      });

      $(document).mouseup(function (e) {
        if (!dropdownNotify.is(e.target) && dropdownNotify.has(e.target).length === 0){
          dropdownNotify.fadeOut(5);
        }
      });
    }

      /*======== TOOLTIPS AND POPOVER ========*/
      var tooltip = $('[data-toggle="tooltip"]')
      if(tooltip.length != 0){
        tooltip.tooltip({
          container: "body",
          template:
            '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
        });
      }

      var popover = $('[data-toggle="popover"]')

      if(popover.length != 0){
        popover.popover();
      }

    /*======== TOASTER ========*/
    function callToaster(positionClass) {
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
          timeOut: "5000",
          extendedTimeOut: "1000",
          showEasing: "swing",
          hideEasing: "linear",
          showMethod: "fadeIn",
          hideMethod: "fadeOut"
        };
        toastr.success("Welcome to sleek", "Howdy!");
      }
    }

    if (document.dir != "rtl" ){
      callToaster("toast-top-right");
    }else {
      callToaster("toast-top-left");
    }

    /*======== PROGRESS BAR ========*/


    /*======== MULTIPLE SELECT ========*/
    var jsExampleBasicMultiple = $(".js-example-basic-multiple");
    if (jsExampleBasicMultiple.length !== 0){
      jsExampleBasicMultiple.select2({});
    }

    /*======== CIRCLE PROGRESS ========*/
    var gray = '#f5f6fa';
    var circle = $('.circle');
    if(circle.length !== 0) {
      circle.circleProgress ({
        lineCap: "round",
        startAngle: 4.8,
        emptyFill: [gray]
      })
    };

    });
    this.navigateStyle();
  },
  watch: {
    $route(){
    this.navigateStyle();
    }
  },
  methods:{
    navigateStyle(){
        let navers = document.querySelectorAll('.has-sub');
        navers.forEach (el=>{
            if(el.dataset.url == this.$route.path){
                el.classList.add('active');
                el.classList.add('expand');
            }else{
                el.classList.remove('active');
                el.classList.remove('expand');
            }
        }); 
    }
  },
})
</script>
<style scoped>
@import '../../assets/scss/_sidebar.scss';
@import '../../assets/scss/_reboot.scss';
@import '../../assets/sleek.min.css';
.app-brand{
    background-color: #f3feff !important;
  }
  .app-brand .brand-name{
    margin-left: 0 !important;
    max-width: 160px !important;
  }
  .app-brand a{
    padding-left: 0.7rem !important;
  }
  .app-brand a img{
    max-width: 55px !important;
  }
</style>