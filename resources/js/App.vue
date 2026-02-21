<script setup>
import { cart } from './store/cart'
</script>

<template>
    <div style="
        padding:20px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        border-bottom:1px solid #ddd;
    ">
        <router-link to="/" style="text-decoration:none; color:black;">
            <h2>TechStore</h2>
        </router-link>

        <router-link
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
    </div>

    <router-view />
</template>
