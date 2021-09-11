<template>
    <div class="row">
        <div class="col-md-12">
            <h2 v-text="'Transaction ID: ' + order.transaction_id"
            ></h2>
            <h1>Thank you for your purchase</h1>
            <table class="table table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in order.products" :key="item.id">
                    <td class="p-4" v-text="item.name"></td>
                    <td class="p-4" v-text="item.pivot.quantity"></td>
                    <td class="p-4" v-text="cartLineTotal(item)"></td>
                </tr>
                <tr>
                    <td class="p-4 font-bold">Total Amount</td>
                    <td class="p-4 font-bold" v-text="orderQuantity"></td>
                    <td class="p-4 font-bold" v-text="orderTotal"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    methods: {
        cartLineTotal(item) {
            let amount = item.price * item.pivot.quantity;
            amount = (amount / 100);

            return amount.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
        }
    },
    computed: {
        order() {
            return this.$store.state.order;
        },
        orderQuantity() {
            return this.$store.state.order.products.reduce((acc, item) => acc + item.pivot.quantity, 0);
        },
        orderTotal() {
            let amount = this.$store.state.order.products.reduce((acc, item) => acc + (item.price * item.pivot.quantity), 0);
            amount = (amount / 100);

            return amount.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
        }
    }
}
</script>
