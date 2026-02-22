<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const products = ref([])
const categories = ref([])
const editing = ref(null)

const newProduct = ref({
    name: '',
    price: '',
    description: '',
    category_id: '',
    image: null
})

const load = async () => {
    const p = await axios.get('/api/products')
    const c = await axios.get('/api/categories')
    products.value = p.data
    categories.value = c.data
}

const createProduct = async () => {
    const formData = new FormData()

    formData.append('name', newProduct.value.name)
    formData.append('price', newProduct.value.price)
    formData.append('description', newProduct.value.description)
    formData.append('category_id', newProduct.value.category_id)

    if (newProduct.value.image) {
        formData.append('image', newProduct.value.image)
    }

    await axios.post('/api/admin/products', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
    })

    newProduct.value = {
        name: '',
        price: '',
        description: '',
        category_id: '',
        image: null
    }

    load()
}

const updateProduct = async (product) => {
    const formData = new FormData()

    formData.append('name', product.name)
    formData.append('price', product.price)
    formData.append('description', product.description)
    formData.append('category_id', product.category_id)

    if (product.newImage) {
        formData.append('image', product.newImage)
    }

    await axios.post('/api/admin/products/' + product.id + '?_method=PUT', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
    })

    editing.value = null
    load()
}

const deleteProduct = async (id) => {
    if (!confirm('¿Eliminar producto?')) return
    await axios.delete('/api/admin/products/' + id)
    load()
}

onMounted(load)
</script>

<template>
    <div style="padding:40px;">

        <h1>Admin - Productos</h1>

        <!-- FORMULARIO CREAR -->
        <div style="margin-bottom:30px; max-width:400px;">
            <input v-model="newProduct.name" placeholder="Nombre" />
            <input v-model="newProduct.price" type="number" placeholder="Precio" />
            <textarea v-model="newProduct.description" placeholder="Descripción"></textarea>

            <select v-model="newProduct.category_id">
                <option disabled value="">Seleccionar categoría</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                    {{ cat.name }}
                </option>
            </select>

            <input type="file" @change="e => newProduct.image = e.target.files[0]" />

            <button @click="createProduct">Crear</button>
        </div>

        <!-- TABLA -->
        <table border="1" cellpadding="10" style="border-collapse:collapse; width:100%;">
            <thead>
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="p in products" :key="p.id">

                <td>{{ p.id }}</td>

                <td>
                    <img v-if="p.image" :src="'/storage/' + p.image" width="60" />
                    <input v-if="editing === p.id" type="file"
                           @change="e => p.newImage = e.target.files[0]" />
                </td>

                <td>
                    <input v-if="editing === p.id" v-model="p.name" />
                    <span v-else>{{ p.name }}</span>
                </td>

                <td>
                    <textarea v-if="editing === p.id" v-model="p.description"></textarea>
                    <span v-else>{{ p.description }}</span>
                </td>

                <td>
                    <input v-if="editing === p.id" type="number" v-model="p.price" />
                    <span v-else>{{ p.price }} €</span>
                </td>

                <td>
                    <select v-if="editing === p.id" v-model="p.category_id">
                        <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                            {{ cat.name }}
                        </option>
                    </select>
                    <span v-else>{{ p.category?.name }}</span>
                </td>

                <td>
                    <button v-if="editing !== p.id" @click="editing = p.id">
                        Editar
                    </button>

                    <button v-if="editing === p.id" @click="updateProduct(p)">
                        Guardar
                    </button>

                    <button @click="deleteProduct(p.id)">
                        Eliminar
                    </button>
                </td>

            </tr>
            </tbody>
        </table>

    </div>
</template>
