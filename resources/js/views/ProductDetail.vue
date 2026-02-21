<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'
import { cart } from '../store/cart'

const route = useRoute()
const product = ref(null)

onMounted(async () => {
    const response = await axios.get('/api/products/' + route.params.id)
    product.value = response.data
})
</script>

<template>
    <div style="padding:40px;" v-if="product">
        <h1>{{ product.name }}</h1>

        <p>{{ product.description }}</p>

        <h2>{{ product.price }} €</h2>

        <p>Categoría: {{ product.category.name }}</p>

        <br>

        <router-link to="/">
            ← Volver a la tienda
        </router-link>
    </div>
    <button @click="cart.add(product)"
            style="padding:10px 15px; background:black; color:white; border:none; margin-top:15px;">
        Añadir al carrito
    </button>
</template>
