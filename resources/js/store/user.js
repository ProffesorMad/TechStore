import { reactive } from 'vue'
import axios from 'axios'

export const user = reactive({
    data: null,
    loaded: false,

    async load() {
        try {
            const response = await axios.get('/api/user')
            this.data = response.data
        } catch (e) {
            this.data = null
        } finally {
            this.loaded = true
        }
    },

    get isAdmin() {
        return this.data && this.data.role === 'admin'
    }
})
