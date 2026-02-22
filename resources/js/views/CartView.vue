<script setup>
import { cart } from '../store/cart'
import axios from 'axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const successMessage = ref(false)

const checkout = async () => {

    if (cart.items.length === 0) return

    try {
        await axios.post('/api/orders', {
            items: cart.items
        })

        // Vaciar carrito correctamente
        cart.items.splice(0, cart.items.length)
        localStorage.removeItem('cart')

        successMessage.value = true

    } catch (error) {
        if (error.response?.status === 401) {
            router.push('/login')
        }
    }
}

const goToShop = () => {
    router.push('/')
}
</script>

<template>
    <div style="padding:40px;">

        <h1>Carrito</h1>

        <!-- MENSAJE COMPRA COMPLETADA -->
        <div
            v-if="successMessage"
            style="
            background:#dcfce7;
            color:#166534;
            padding:15px;
            border-radius:8px;
            margin-bottom:20px;
            font-weight:bold;
        "
        >
            Su compra ha sido completada con éxito ✅
        </div>

        <!-- BOTÓN VOLVER -->
        <button
            @click="goToShop"
            style="
            margin-bottom:20px;
            background:#2563eb;
            color:white;
            padding:8px 15px;
            border:none;
            border-radius:8px;
            cursor:pointer;
        "
        >
            Volver a la tienda
        </button>

        <!-- SI NO HAY MENSAJE Y NO HAY ITEMS -->
        <div v-if="cart.items.length === 0 && !successMessage">
            Carrito vacío
        </div>

        <!-- PRODUCTOS -->
        <div
            v-for="item in cart.items"
            :key="item.id"
            style="
            display:flex;
            gap:20px;
            align-items:center;
            margin-bottom:20px;
            border-bottom:1px solid #ddd;
            padding-bottom:10px;
        "
        >

            <img
                v-if="item.image"
                :src="'/storage/' + item.image"
                style="width:80px; height:80px; object-fit:cover;"
            />

            <div style="flex:1;">
                <h3>{{ item.name }}</h3>
                <p>{{ item.price }} €</p>

                <input
                    type="number"
                    v-model="item.quantity"
                    min="1"
                    style="width:60px;"
                />

                <button @click="cart.remove(item.id)">
                    Eliminar
                </button>
            </div>

        </div>

        <!-- TOTAL -->
        <h2 v-if="cart.items.length > 0">
            Total: {{ cart.totalPrice }} €
        </h2>

        <!-- FINALIZAR -->
        <button
            v-if="cart.items.length > 0"
            @click="checkout"
            style="
            margin-top:20px;
            background:green;
            color:white;
            padding:10px 20px;
            border:none;
            border-radius:8px;
            cursor:pointer;
        "
        >
            Finalizar compra
        </button>

    </div>
</template>
