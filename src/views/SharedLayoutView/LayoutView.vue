
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
        <div class="sidebar-footer">
          <div class="sidebar-footer-content d-flex align-items-center justify-content-between">
            <RouterLink class="a-link" to="/branch">
            <i class="mdi mdi-hospital-building"></i>&nbsp;&nbsp;
              <span class="nav-text" v-if="branchselected == null"> {{branchselected}} Choose Facility</span>
              <span class="nav-text" v-else>{{ branchselected }}</span>
            </RouterLink>
            <button type="button" @click="removedManageBranch" class="close" v-if="branchselected != null">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <hr class="separator mb-0" />
        </div>
        <!-- sidebar menu -->
        <ul class="nav sidebar-inner" id="sidebar-menu">
          <li class="has-sub"  data-url="/dashboard">
            <RouterLink class="sidenav-item-link" to="/dashboard">
              <i class="mdi mdi-view-dashboard-outline"></i>
              <span class="nav-text">Dashboard</span>
            </RouterLink>
          </li>
          <li class="has-sub " data-url="/timesheets">
            <RouterLink class="sidenav-item-link" to="/timesheets" v-if="branchselected != null">
              <i class="mdi mdi-calendar-clock"></i>
              <span class="nav-text">Timesheets</span>
            </RouterLink>
          </li>
          <li class="has-sub " data-url="/request">
            <RouterLink class="sidenav-item-link" to="/request" v-if="branchselected != null">
              <i class="mdi mdi-account-details"></i>
              <span class="nav-text">Request</span>
            </RouterLink>
          </li>
          <li class="has-sub " data-url="/jobschedule">
            <RouterLink class="sidenav-item-link" to="/jobschedule" v-if="branchselected != null">
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
              <span class="nav-text">Roles</span>
            </RouterLink>
          </li>
          <li class="has-sub" data-url="/users"> <!--// Only For ADMINS-->
            <RouterLink class="sidenav-item-link" to="/users" v-if="infodata.user_access_level_id == 1">
              <i class="mdi mdi-account-box"></i>
              <span class="nav-text">Account</span>
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
        
      </div>

      <div class="navbar-right ">
        <ul class="nav navbar-nav">
          <li class="dropdown notifications-menu custom-dropdown">
            <button class="dropdown-toggle notify-toggler custom-dropdown-toggler">
              <i class="mdi mdi-bell-outline"><small class="text-danger" v-if="notify.notifcount != 0">{{ notify.notifcount }}</small></i>
            </button>

            <div class="card card-default dropdown-notify dropdown-menu-right mb-0">
              <div class="card-header card-header-border-bottom px-3">
                <h2>Notifications</h2>
              </div>

              <div class="card-body px-0 py-0">
                <div class="tab-content" id="myTabContent3">
                  <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home2-tab">
                    <ul class="list-unstyled" data-simplebar style="height: 360px;">
                      <li v-for="n in notify.notifications">
                        <RouterLink :to="n.notification_link" class="media media-message media-notification event-active" @click="ReadNotif(n.notification_id)" v-if="n.notification_isRead == 1">

                          <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-info text-white">
                            <i class="mdi mdi-calendar-check font-size-20"></i>
                          </div>

                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">{{ n.notification_title }}</h4>
                              <p class="last-msg font-size-14">{{ n.notification_description }}</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline">{{ n.notification_created_at }}</i>
                              </span>
                            </div>
                          </div>
                        </RouterLink>
                        <RouterLink :to="n.notification_link" class="media media-message media-notification event" v-else>

                          <div class="d-flex rounded-circle align-items-center justify-content-center mr-3 media-icon iconbox-45 bg-info text-white">
                            <i class="mdi mdi-calendar-check font-size-20"></i>
                          </div>

                          <div class="media-body d-flex justify-content-between">
                            <div class="message-contents">
                              <h4 class="title">{{ n.notification_title }}</h4>
                              <p class="last-msg font-size-14">{{ n.notification_description }}</p>

                              <span class="font-size-12 font-weight-medium text-secondary">
                                <i class="mdi mdi-clock-outline">{{ n.notification_created_at }}</i>
                              </span>
                            </div>
                          </div>
                        </RouterLink>
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
          <!-- User Account -->
          <li class="dropdown user-menu">
            <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false">
              <img v-if="infodata.user_photo == '' || infodata.user_photo == null" src="../../assets/default-profile.png" alt="Profile" class="user-image"> <img v-else :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+infodata.user_photo" alt="Profile" class="user-image">
              <span class="d-none d-lg-inline-block text-uppercase text-success">{{ infodata.user_firstname }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
              <!-- User image -->
              <li class="dropdown-header">
                <img v-if="infodata.user_photo == '' || infodata.user_photo == null" src="../../assets/default-profile.png" alt="Profile" class="user-image"> <img v-else :src="'https://www.4angelshc.com/wangelmobile/filesystem/'+infodata.user_photo" alt="Profile" class="user-image">
                <div class="d-inline-block text-success">
                  {{infodata.user_firstname}} {{ infodata.user_lastname }}<br/> 
                  <small class="pt-1" v-if="infodata.user_access_level_id == 1">( Admin )</small>
                  <small class="pt-1" v-if="infodata.user_access_level_id == 2">( Supervisor )</small>
                  <small class="pt-1" v-if="infodata.user_access_level_id == 3">( Manager )</small>
                </div>
              </li>
              <li>
                <RouterLink to="/profile">
                  <i class="mdi mdi-account"></i> My Profile
                </RouterLink>
              </li>
              <li class="dropdown-footer">
                <a href="#" @click="logoutAccount"> <i class="mdi mdi-logout"></i> Log Out </a>
              </li>
            </ul>
          </li>
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
import { lStore,axios } from '@/functions.js';

export default ({
  name: "App",
  components: {

  },
  data(){
    return{
      search: "",
      branches: [],
      infodata: [],
      branchselected: lStore.get('selected_facility'),
      user: lStore.get('userdetails'),
      notify: [],
    }
  },
  mounted(){
    this.infodata = lStore.get("userdetails");
    $(document).ready(function () {

    setInterval(()=>{
    },1000);

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
    this.notification();

    setInterval(() => {
      this.notification();
    }, 3000);
  },
  watch: {
    $route(){
    this.navigateStyle();
    }
  },
  methods:{
    ReadNotif(data){
      axios.post('notificationcontroller/ReadNotif',{pwauth: lStore.get('usertoken')},{notifid: data})
    },
    removedManageBranch()
    {
      this.branchselected = null;
      localStorage.removeItem('async_selected_facility');
      window.location.assign('/adminapp/dashboard');
    },
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
    },
    notification(){
      axios.post('notificationcontroller/ShowMyNotif',{pwauth: lStore.get('usertoken')},{userid: this.user.user_id}).then(res=>{
        if(res.data.success){
          this.notify = res.data.result
        }
      });
    },
    logoutAccount(){
      localStorage.clear();
      window.location.reload();
    }
  },
})
</script>
<style scoped>
@import '../../assets/scss/_sidebar.scss';
@import '../../assets/scss/_reboot.scss';
@import '../../assets/sleek.min.css';
.profile img {
  height: 100%;
  max-height: 36px;
}
.navbar{
  padding-right: 0;
}
.navbar .navbar-right .navbar-nav li > .dropdown-menu{
  min-width: 284px;
  width: 100%;
}
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
  .sidebar-footer-content{
    padding-top: 0.81rem !important;
    padding-bottom: 0rem !important;
    padding-left: 0.9rem !important;
  }
  .a-link{
    color: #fff;
  }
  .sidebar-footer-content .nav-text{
    font-size: 20px;
  }
  .close{
    color:#fff;
    text-shadow: none;
  }
  .close:hover{
    color:blue;
  }
  .tab-content, #home2{
    display: block !important;
  }
  .navbar .dropdown-menu li.dropdown-footer{
    margin-top: 0;
  }
  .navbar .dropdown-menu li.dropdown-header{
    margin-bottom: 0;
  }
  .navbar .dropdown-menu > li a[data-v-543bc2ab], .notifications-list li a{
    padding: .94rem 1.25rem;
  }
  .user-image{
    width: 100%;
    height: 100%;
    max-height: 250px;
  }
  .media-message .last-msg{
    text-overflow: unset !important;
    overflow: unset !important;
    white-space: unset !important;
  }
  .list-unstyled{
    overflow: auto;
  }
</style>