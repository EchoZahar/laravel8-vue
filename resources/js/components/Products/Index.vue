<template>
    <section class="row">
        <div class="mt-5"></div>
        <div class="col-md-4 col-sm-12" v-for="(product, index) in products" :key="product.id">
            <div class="card" style="width: 18rem;">

                <img src="https://dummyimage.com/640x640"
                     class="card-img-top border border-info border-bottom" alt=". test image .">

                <div class="card-body">
                    <h5 class="card-title" v-text="product.name"></h5>
                    <h6 class="card-subtitle mb-2 text-muted" v-for="category in product.categories" >{{ 'категория: ' + category.name }}</h6>
                    <p class="card-text" v-text="formatCurrency(product.price)"></p>
                    <router-link     class="card-link" :to="{name: 'products.show', params: {slug: product.slug}}" >перейти</router-link>

                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    methods: {
        formatCurrency(amount) {
            amount = (amount / 100);
            return amount.toLocaleString('ru-RU', { style: 'currency', currency: 'RUB' });
        }
    },
    computed: {
        products() {
            return this.$store.state.products;
        }
    },
    mounted() {
        console.log('mounted component')
    }
}
</script>
