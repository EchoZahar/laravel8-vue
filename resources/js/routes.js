module.exports = [
    {
        path: '/',
        name: 'products.index',
        component: () => import('./components/Products/Index.vue')
    },
    {
        path: '/product/:slug',
        name: 'products.show',
        component: () => import('./components/Products/Show.vue')
    },
    {
        path: '/checkout',
        name: 'order.checkout',
        component: () => import('./components/Order/Checkout.vue')
    },
    {
        path: '/summary',
        name: 'order.summary',
        component: () => import('./components/Order/Summary.vue')
    }
]
