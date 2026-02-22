<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
import { cart } from '../store/cart'

const route = useRoute()
const product = ref(null)

const load = async () => {
    const res = await axios.get('/api/products/' + route.params.id)
    product.value = res.data
}

const addToCart = () => {
    cart.add(product.value)
    alert('Producto añadido al carrito')
}

onMounted(load)
</script>

<template>
    <div style="padding:40px;" v-if="product">

        <!-- IMAGEN GRANDE -->
        <img
            v-if="product.image"
            :src="'/storage/' + product.image"
            style="
            width:100%;
            max-height:400px;
            object-fit:cover;
            border-radius:12px;
            margin-bottom:20px;
        "
        />

        <h1>{{ product.name }}</h1>

        <h2>{{ product.price }} €</h2>

        <p style="margin:20px 0;">
            {{ product.description }}
        </p>

        <button
            @click="addToCart"
            style="
            background:black;
            color:white;
            padding:10px 20px;
            border:none;
            border-radius:8px;
            cursor:pointer;
        "
        >
            Añadir al carrito
        </button>

    </div>
</template>
