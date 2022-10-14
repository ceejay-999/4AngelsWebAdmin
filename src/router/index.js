import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/AuthenticationView/LoginView.vue'
import DashboardView from '../views/ManagementView/DashboardView.vue'
import RoleView from '../views/ManagementView/RoleView.vue'
import BranchesView from '../views/ManagementView/BranchesView.vue'
import DesignationView from '../views/ManagementView/DesignationView.vue'

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
      path: '/role',
      name: 'role',
      component: RoleView
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
    }
  ]
})

export default router
