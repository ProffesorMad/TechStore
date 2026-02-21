<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'

const route = useRoute()
const order = ref(null)

onMounted(async () => {
    const response = await axios.get('/api/orders/' + route.params.id)
    order.value = response.data
})
</script>

<template>
    <div style="padding:40px;" v-if="order">
        <h1>Pedido #{{ order.id }}</h1>

        <div
            v-for="item in order.items"
            :key="item.id"
            style="border:1px solid #ddd; padding:15px; margin-bottom:15px;"
        >
            <h3>{{ item.product.name }}</h3>
            <p>Cantidad: {{ item.quantity }}</p>
            <p>Precio: {{ item.price }} €</p>
        </div>

        <h2>Total: {{ order.total }} €</h2>
    </div>
</template>
