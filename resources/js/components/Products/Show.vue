<template>
    <section class="row">
        <div class="card col-md-12">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5 col-sm-12">
                        <img src="https://dummyimage.com/640x640" class="w-100">
                    </div>
                    <div class="col-md-7 col-sm-12">
                        <h2
                            v-for="category in product.categories"
                            v-text="'категория: ' + category.name"
                        ></h2>
                        <h1 class="text-info" v-text="product.name"></h1>
                        <p class="mt-1">{{ product.description }}</p>
                        <div class="text-right">
                            <p class="mt-1 text-info">Цена: <span class="text-success">{{formatCurrency(product.price) }}</span></p>
                            <button class="btn btn-primary"
                                @click="$store.commit('addToCart', product)"
                            >добавить в корзину</button>
                        </div>

                    </div>
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
            return amount.toLocaleString('ru-RU', {style: 'currency', currency: 'RUB'});
        }
    },
    computed: {
        products() {
            return this.$store.state.products;
        },
        product() {
            return this.products.find(product => product.slug === this.$route.params.slug);
        }
    }
}
</script>
