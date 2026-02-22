import { createRouter, createWebHistory } from 'vue-router'

import Home from '../views/Home.vue'
import ProductDetail from '../views/ProductDetail.vue'
import CartView from '../views/CartView.vue'
import AdminProducts from '../views/AdminProducts.vue'
import AdminCategories from '../views/AdminCategories.vue'
import AdminOrders from '../views/AdminOrders.vue'

const routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/product/:id',
        component: ProductDetail
    },
    {
        path: '/cart',
        component: CartView
    },
    {
        path: '/admin/products',
        component: AdminProducts
    },
    {
        path: '/admin/categories',
        component: AdminCategories
    },
    {
        path: '/admin/orders',
        component: AdminOrders
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
