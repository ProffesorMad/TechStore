<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { cart } from '../store/cart'

const products = ref([])

const load = async () => {
    const res = await axios.get('/api/products')
    products.value = res.data
}

const addToCart = (product) => {
    cart.add(product)
}

onMounted(load)
</script>

<template>
    <div style="padding:40px;">

        <h1>Tienda</h1>

        <div class="grid">

            <div
                v-for="product in products"
                :key="product.id"
                class="card"
            >

                <img
                    v-if="product.image"
                    :src="'/storage/' + product.image"
                    class="product-image"
                />

                <h3>{{ product.name }}</h3>

                <p class="price">
                    {{ product.price }} €
                </p>

                <div style="display:flex; gap:10px;">

                    <router-link
                        :to="'/product/' + product.id"
                        class="btn"
                    >
                        Ver
                    </router-link>

                    <button
                        @click="addToCart(product)"
                        class="btn-cart"
                    >
                        Añadir
                    </button>

                </div>

            </div>

        </div>
    </div>
</template>

<style scoped>
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 25px;
    margin-top: 30px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.product-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 10px;
}

.price {
    font-weight: bold;
    margin: 10px 0;
}

.btn {
    background: #2563eb;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
}

.btn-cart {
    background: black;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
}
</style>
