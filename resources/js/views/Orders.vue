<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const orders = ref([])

onMounted(async () => {
    const response = await axios.get('/api/orders')
    orders.value = response.data
})
</script>

<template>
    <div style="padding:40px;">
        <h1>Mis pedidos</h1>

        <div v-if="orders.length === 0">
            No tienes pedidos.
        </div>

        <div
            v-for="order in orders"
            :key="order.id"
            style="border:1px solid #ddd; padding:20px; margin-bottom:20px;"
        >
            <h3>Pedido #{{ order.id }}</h3>
            <p>Total: {{ order.total }} €</p>
            <p>Estado: {{ order.status }}</p>

            <router-link :to="'/orders/' + order.id">
                Ver detalle
            </router-link>
        </div>
    </div>
</template>
