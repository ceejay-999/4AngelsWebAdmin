import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/AuthenticationView/LoginView.vue'
import DashboardView from '../views/ManagementView/DashboardView.vue'

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
    }
  ]
})

export default router
