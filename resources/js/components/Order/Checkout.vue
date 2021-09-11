<template>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead class="thead-dark">
                <th scope="col"># item</th>
                <th scope="col">Quantity</th>
                <th scope="col">price</th>
                <th scope="col">actions</th>
                </thead>
                <tbody>
                <tr v-for="(item, index) in cart" :key="item.id">
                    <th scope="row">{{ item.name }}</th>
                    <td>{{ item.quantity }}</td>
                    <td>{{ cartLineTotal(item) }}</td>
                    <td class="text-right">
                        <button class="btn btn-outline-primary"
                                @click="$store.commit('removeFromCart', index)"
                        >удалить
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>Total Amount</td>
                    <td v-text="cartQuantity"></td>
                    <td v-text="cartTotal"></td>
                    <td class="text-right"></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12 mt-2">
            <p>данные по карте</p>
            <div class="row">
                <div class="mt-1 col-md-4 col-sm-12">
                    <label for="first_name" class="text-info">First Name</label>
                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        class="form-control"
                        v-model="customer.first_name"
                        :disabled="paymentProcessing">
                </div>
                <div class="mt-1 col-md-4 col-sm-12">
                    <label for="last_name" class="text-info">Last Name</label>
                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        class="form-control"
                        v-model="customer.last_name"
                        :disabled="paymentProcessing">
                </div>
                <div class="mt-1 col-md-4 col-sm-12">
                    <label for="email" class="text-info">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        v-model="customer.email"
                        :disabled="paymentProcessing">

                </div>
                <div class="mt-1 col-md-3 col-sm-12">
                    <label for="address" class="text-info">Street Address</label>
                    <input
                        type="text"
                        id="address"
                        name="address"
                        class="form-control"
                        v-model="customer.address"
                        :disabled="paymentProcessing"
                    >
                </div>
                <div class="mt-1 col-md-3 col-sm-12">

                    <label for="city" class="text-info">City</label>
                    <input
                        type="text"
                        id="city"
                        name="city"
                        class="form-control"
                        v-model="customer.city"
                        :disabled="paymentProcessing"
                    >

                </div>
                <div class="mt-1 col-md-3 col-sm-12">
                    <label for="state" class="text-info">State</label>
                    <input
                        type="email"
                        id="state"
                        name="state"
                        class="form-control"
                        v-model="customer.state"
                        :disabled="paymentProcessing"
                    >
                </div>
                <div class="mt-1 col-md-3 col-sm-12">
                    <label for="zip_code" class="text-info">Code</label>
                    <input
                        type="email"
                        id="zip_code"
                        name="zip_code"
                        class="form-control"
                        v-model="customer.code"
                        :disabled="paymentProcessing"
                    >
                </div>
            </div>
            <div class="col-md-12 col-sm-12 text-center">

                <label for="card-element" class="text-info">Credit Card Info</label>
                <div id="card-element"></div>

                <div class="text-center">
                    <button
                        class="btn btn-outline-primary"
                        @click="processPayment"
                        :disabled="paymentProcessing"
                        v-text="paymentProcessing ? 'Processing' : 'Pay Now'"
                    ></button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { loadStripe } from '@stripe/stripe-js';
export default {
    data() {
        return {
            stripe: {},
            cardElement: {},
            customer: {
                first_name: '',
                last_name: '',
                email: '',
                address: '',
                city: '',
                state: '',
                code: ''
            },
            paymentProcessing: false
        }
    },
    async mounted() {
        this.stripe = await loadStripe('pk_test_51JYJ5WAG6uB5L7cz5OfK6gFFbOTD7wTbPRenC0pHyW4dif2cmcNL139q9vjCFvLgcGqxe1XjQxtYdQAMgszQeBQ800aEsX8Sti');

        const elements = this.stripe.elements();
        this.cardElement = elements.create('card', {
            classes: {
                base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 p-3 leading-8 transition-colors duration-200 ease-in-out'
            }
        });

        this.cardElement.mount('#card-element');
    },
    methods: {
        cartLineTotal(item) {
            let amount = item.price * item.quantity;
            amount = (amount / 100);

            return amount.toLocaleString('ru-RU', {style: 'currency', currency: 'RUB'});
        },
        async processPayment() {
            this.paymentProcessing = true;

            const {paymentMethod, error} = await this.stripe.createPaymentMethod(
                'card', this.cardElement, {
                    billing_details: {
                        name: this.customer.first_name + ' ' + this.customer.last_name,
                        email: this.customer.email,
                        address: {
                            line1: this.customer.address,
                            city: this.customer.city,
                            state: this.customer.state,
                            postal_code: this.customer.code
                        }
                    }
                }
            );

            if (error) {
                this.paymentProcessing = false;
                console.error(error);
            } else {
                console.log(paymentMethod);
                this.customer.payment_method_id = paymentMethod.id;
                this.customer.amount = this.$store.state.cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);
                this.customer.cart = JSON.stringify(this.$store.state.cart);

                axios.post('/api/purchase', this.customer)
                    .then((response) => {
                        this.paymentProcessing = false;
                        console.log(response);

                        this.$store.commit('updateOrder', response.data);
                        this.$store.dispatch('clearCart');

                        this.$router.push({name: 'order.summary'});
                    })
                    .catch((error) => {
                        this.paymentProcessing = false;
                        console.error(error);
                    });
            }
        }
    },
    computed: {
        cart() {
            return this.$store.state.cart;
        },
        cartQuantity() {
            return this.$store.state.cart.reduce((acc, item) => acc + item.quantity, 0);
        },
        cartTotal() {
            let amount = this.$store.state.cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);
            amount = (amount / 100);

            return amount.toLocaleString('ru-RU', {style: 'currency', currency: 'RUB'});
        }
    }
}
</script>
