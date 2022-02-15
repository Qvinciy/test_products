<template>
    <Head title="Products" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block text-4xl">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-gray-700 underline">
                Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-gray-700 underline">
                    Log in
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-gray-700 underline">
                    Register
                </Link>
            </template>
        </div>
        <div v-if="products">
            <product-list :list-data="products"/>
        </div>
    </div>

</template>

<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import ProductList from "./../Product/ProductList"

    export default defineComponent({
        components: {
            Head,
            Link,
            ProductList
        },
        data(){
            return {
                products: null,
            }
        },
        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
        },

        async beforeCreate() {
              this.products = (await axios.get("/api/list")).data;
        }
    })
</script>

