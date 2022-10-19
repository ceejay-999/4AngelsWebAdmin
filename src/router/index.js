import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/AuthenticationView/LoginView.vue'
import DashboardView from '../views/ManagementView/DashboardView.vue'
import BranchesView from '../views/ManagementView/BranchesView.vue'
import DesignationView from '../views/ManagementView/RoleView.vue'
import EmployeeView from '../views/ManagementView/EmployeeView.vue'
import JobScheduleView from '../views/ManagementView/JobSchedulingView.vue'
import TimeclockView from '../views/ManagementView/TimeclockView.vue'
import TimesheetsView from '../views/ManagementView/TimesheetsView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: DashboardView
    },
    {
      path: '/branch',
      name: 'branch',
      component: BranchesView
    },
    {
      path: '/designation',
      name: 'designation',
      component: DesignationView
    },
    {
      path: '/employee',
      name: 'employee',
      component: EmployeeView
    },
    {
      path: '/jobschedule',
      name: 'jobschedule',
      component: JobScheduleView
    },
    {
      path: '/timeclock',
      name: 'timeclock',
      component: TimeclockView
    },
    {
      path: '/timesheets',
      name: 'timesheets',
      component: TimesheetsView
    },
  ]
})

export default router
