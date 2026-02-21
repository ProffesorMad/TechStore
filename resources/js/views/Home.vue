<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const products = ref([])

onMounted(async () => {
    const response = await axios.get('/api/products')
    products.value = response.data
})
</script>

<template>
    <div style="padding:40px;">
        <h1>TechStore</h1>

        <div v-for="product in products"
             :key="product.id"
             style="border:1px solid #ccc; padding:20px; margin-bottom:20px; border-radius:8px;">

            <h3>{{ product.name }}</h3>
            <p>{{ product.description }}</p>
            <strong>{{ product.price }} €</strong>

            <br><br>

            <router-link :to="'/product/' + product.id">
                Ver detalle
            </router-link>

        </div>
    </div>
</template>
