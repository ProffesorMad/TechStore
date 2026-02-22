<script setup>
import { onMounted } from 'vue'
import { cart } from './store/cart'
import { user } from './store/user'
import axios from 'axios'

onMounted(() => {
    user.load()
})

const logout = async () => {
    await axios.post('/logout')
    window.location.href = '/login'
}
</script>

<template>
    <div>

        <!-- HEADER -->
        <div style="
        padding:20px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        border-bottom:1px solid #ddd;
        background:white;
    ">

            <router-link to="/" style="text-decoration:none; color:black;">
                <h2>TechStore</h2>
            </router-link>

            <div style="display:flex; gap:20px; align-items:center;">

                <!-- ADMIN MENU -->
                <template v-if="user.isAdmin">

                    <router-link
                        to="/admin/orders"
                        style="text-decoration:none; font-weight:bold;"
                    >
                        Pedidos
                    </router-link>

                    <router-link
                        to="/admin/products"
                        style="text-decoration:none; font-weight:bold;"
                    >
                        Productos
                    </router-link>

                    <router-link
                        to="/admin/categories"
                        style="text-decoration:none; font-weight:bold;"
                    >
                        Categorías
                    </router-link>

                </template>

                <!-- CARRITO SOLO PARA USUARIO NORMAL -->
                <router-link
                    v-if="!user.isAdmin"
                    to="/cart"
                    style="
                    background:black;
                    color:white;
                    padding:8px 15px;
                    border-radius:6px;
                    text-decoration:none;
                    font-weight:bold;
                "
                >
                    🛒 Carrito ({{ cart.totalItems }})
                </router-link>

                <!-- LOGOUT -->
                <button
                    v-if="user.data"
                    @click="logout"
                    style="
                    background:#dc2626;
                    color:white;
                    border:none;
                    padding:6px 12px;
                    border-radius:6px;
                    cursor:pointer;
                "
                >
                    Logout
                </button>

            </div>
        </div>

        <router-view />

    </div>
</template>
