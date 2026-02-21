import { reactive, watch } from 'vue'

const savedCart = JSON.parse(localStorage.getItem('cart'))

export const cart = reactive({
    items: savedCart || [],

    add(product) {
        const existing = this.items.find(item => item.id === product.id)

        if (existing) {
            existing.quantity++
        } else {
            this.items.push({
                ...product,
                quantity: 1
            })
        }
    },

    remove(productId) {
        this.items = this.items.filter(item => item.id !== productId)
    },

    increase(productId) {
        const item = this.items.find(item => item.id === productId)
        if (item) {
            item.quantity++
        }
    },

    decrease(productId) {
        const item = this.items.find(item => item.id === productId)

        if (!item) return

        if (item.quantity > 1) {
            item.quantity--
        } else {
            this.remove(productId)
        }
    },

    get totalItems() {
        return this.items.reduce((sum, item) => sum + item.quantity, 0)
    },

    get totalPrice() {
        return this.items.reduce((sum, item) => sum + item.price * item.quantity, 0)
    }
})

watch(
    () => cart.items,
    (items) => {
        localStorage.setItem('cart', JSON.stringify(items))
    },
    { deep: true }
)
