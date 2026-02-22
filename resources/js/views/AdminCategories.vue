<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const categories = ref([])
const newCategory = ref('')
const editing = ref(null)

const load = async () => {
    const res = await axios.get('/api/categories')
    categories.value = res.data
}

const createCategory = async () => {
    if (!newCategory.value) return

    await axios.post('/api/admin/categories', {
        name: newCategory.value
    })

    newCategory.value = ''
    load()
}

const updateCategory = async (cat) => {
    await axios.put('/api/admin/categories/' + cat.id, cat)

    editing.value = null
    load()
}

const deleteCategory = async (id) => {
    if (!confirm('¿Eliminar categoría?')) return

    await axios.delete('/api/admin/categories/' + id)
    load()
}

onMounted(load)
</script>

<template>
    <div style="padding:40px;">

        <h1>Admin - Categorías</h1>

        <!-- CONTENEDOR CENTRADO -->
        <div style="max-width:600px; margin:auto;">

            <!-- CREAR -->
            <div style="margin-bottom:20px; display:flex; gap:10px;">
                <input
                    v-model="newCategory"
                    placeholder="Nueva categoría"
                    style="flex:1; padding:6px;"
                />
                <button @click="createCategory">
                    Crear
                </button>
            </div>

            <!-- TABLA -->
            <table border="1" cellpadding="10" width="100%" style="background:white;">
                <thead>
                <tr>
                    <th style="width:80px;">ID</th>
                    <th>Nombre</th>
                    <th style="width:180px;">Acciones</th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="cat in categories" :key="cat.id">

                    <td>{{ cat.id }}</td>

                    <td>
                        <input
                            v-if="editing === cat.id"
                            v-model="cat.name"
                            style="width:100%;"
                        />
                        <span v-else>
                            {{ cat.name }}
                        </span>
                    </td>

                    <td>
                        <button
                            v-if="editing !== cat.id"
                            @click="editing = cat.id"
                        >
                            Editar
                        </button>

                        <button
                            v-if="editing === cat.id"
                            @click="updateCategory(cat)"
                        >
                            Guardar
                        </button>

                        <button
                            @click="deleteCategory(cat.id)"
                        >
                            Eliminar
                        </button>
                    </td>

                </tr>
                </tbody>
            </table>

        </div>

    </div>
</template>
