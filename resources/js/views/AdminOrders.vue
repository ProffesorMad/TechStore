<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const orders = ref([])

const load = async () => {
    const res = await axios.get('/api/admin/orders')
    orders.value = res.data
}

const updateStatus = async (order) => {
    await axios.put('/api/admin/orders/' + order.id, {
        status: order.status
    })

    load()
}

onMounted(load)
</script>

<template>
    <div style="padding:40px;">

        <h1>Admin - Historial de Pedidos</h1>

        <div v-if="orders.length === 0">
            No hay pedidos todavía.
        </div>

        <div
            v-for="order in orders"
            :key="order.id"
            style="
            border:1px solid #ddd;
            padding:20px;
            border-radius:12px;
            margin-bottom:30px;
            background:#f9fafb;
        "
        >

            <!-- INFO GENERAL -->
            <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
                <div>
                    <strong>Pedido #{{ order.id }}</strong><br>
                    Usuario: {{ order.user?.email }}<br>
                    Total: {{ order.total }} €<br>
                    Fecha: {{ new Date(order.created_at).toLocaleString() }}
                </div>

                <div>
                    <select v-model="order.status" @change="updateStatus(order)">
                        <option value="pending">Pendiente</option>
                        <option value="shipped">Enviado</option>
                        <option value="completed">Completado</option>
                    </select>
                </div>
            </div>

            <!-- PRODUCTOS DEL PEDIDO -->
            <table border="1" cellpadding="8" width="100%">
                <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unidad</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in order.items" :key="item.id">
                    <td>
                        <img
                            v-if="item.product?.image"
                            :src="'/storage/' + item.product.image"
                            style="width:60px; height:60px; object-fit:cover;"
                        />
                    </td>
                    <td>{{ item.product?.name }}</td>
                    <td>{{ item.quantity }}</td>
                    <td>{{ item.price }} €</td>
                    <td>{{ item.price * item.quantity }} €</td>
                </tr>
                </tbody>
            </table>

        </div>

    </div>
</template>
