<script setup>
import { cart } from '../store/cart'
import axios from 'axios'

const checkout = async () => {
    try {
        await axios.post('/api/orders', {
            items: cart.items
        })

        alert('Pedido realizado correctamente')

        cart.items = []

    } catch (error) {
        alert('Error al procesar pedido')
    }
}
</script>

<template>
    <div style="padding:40px;">
        <h1>Carrito</h1>

        <div v-if="cart.items.length === 0">
            El carrito está vacío.
        </div>

        <div
            v-for="item in cart.items"
            :key="item.id"
            style="border:1px solid #ddd; padding:20px; margin-bottom:20px; border-radius:8px;"
        >
            <h3>{{ item.name }}</h3>

            <div style="display:flex; align-items:center; gap:10px;">
                <button @click="cart.decrease(item.id)">-</button>
                <strong>{{ item.quantity }}</strong>
                <button @click="cart.increase(item.id)">+</button>
            </div>

            <p>Precio unitario: {{ item.price }} €</p>
            <p>Subtotal: {{ (item.price * item.quantity).toFixed(2) }} €</p>

            <button @click="cart.remove(item.id)">
                Eliminar
            </button>
        </div>

        <div v-if="cart.items.length > 0">
            <h2>Total: {{ cart.totalPrice.toFixed(2) }} €</h2>

            <button
                @click="checkout"
                style="margin-top:20px; padding:10px 20px; background:black; color:white; border:none;"
            >
                Finalizar compra
            </button>
        </div>
    </div>
</template>
