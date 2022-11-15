import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/AuthenticationView/LoginView.vue'
import DashboardView from '../views/ManagementView/DashboardView.vue'
import BranchesView from '../views/ManagementView/BranchesView.vue'
import DesignationView from '../views/ManagementView/RoleView.vue'
import EmployeeView from '../views/ManagementView/EmployeeView.vue'
import JobScheduleView from '../views/ManagementView/JobSchedulingView.vue'
import TimeclockView from '../views/ManagementView/TimeclockView.vue'
import TimesheetsView from '../views/ManagementView/TimesheetsView.vue'
import { lStore } from '../functions'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/login'
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
      beforeEnter: () => {
        if (lStore.isset('user_token')) return '/dashboard';
      },
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: DashboardView,
      beforeEnter: () => {
        if (!lStore.isset('user_token')) return '/login';
      },
      
    },
    {
      path: '/branch',
      name: 'branch',
      component: BranchesView,
      beforeEnter: () => {
        
        if (!lStore.isset('user_token')) return '/login';
      },
    },
    {
      path: '/designation',
      name: 'designation',
      component: DesignationView,
      beforeEnter: () => {
        if (!lStore.isset('user_token')) return '/login';
      },
    },
    {
      path: '/employee',
      name: 'employee',
      component: EmployeeView,
      beforeEnter: () => {
        console.log(lStore.isset('user_token'));
        if (!lStore.isset('user_token')) return '/login';
      },
    },
    {
      path: '/jobschedule',
      name: 'jobschedule',
      component: JobScheduleView,
      beforeEnter: () => {
        if (!lStore.isset('user_token')) return '/login';
      },
    },
    {
      path: '/timeclock',
      name: 'timeclock',
      component: TimeclockView,
      beforeEnter: () => {
        if (!lStore.isset('user_token')) return '/login';
      },
    },
    {
      path: '/timesheets',
      name: 'timesheets',
      component: TimesheetsView,
      beforeEnter: () => {
        if (!lStore.isset('user_token')) return '/login';
      },
    },
  ]
})

export default router
