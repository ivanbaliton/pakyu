import { createRouter, createWebHistory } from '@ionic/vue-router';
import { RouteRecordRaw } from 'vue-router';




const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    redirect: '/login'
  },
  {
    path: '/home',
    name: 'Home',
    component: () => import('../views/HomePage.vue')  
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/LoginPage.vue')
  },
  {
    path: '/signup',
    name: 'Signup',
    component: () => import('../views/SignupPage.vue')
  },
 
  {
    path: '/addproducts',
    name: 'AddProducts',
    component: () => import('../views/AddProducts.vue')
  },
  {
    path: '/sellerhome',
    name: 'SellerHome',
    component: () => import('../views/SellerHomePage.vue')
  },{
    path: '/ViewProducts/:id',
    name: 'ViewProducts',
    component: () => import('../views/ViewProducts.vue')
   
  },{
    path: '/EditProducts/:id',
    name: 'EditProducts',
    component: () => import('../views/EditProducts.vue')
  }
  
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

export default router
