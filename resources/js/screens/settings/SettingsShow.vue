<template>
    <div>
        <page-header>
            <template slot="action">
                <router-link :to="{ name: 'posts-create' }" class="btn btn-sm btn-outline-success font-weight-bold">
                    {{ trans.buttons.posts.create }}
                </router-link>
            </template>
        </page-header>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="d-flex justify-content-between">
                            <h1 class="mt-2">
                                Settings
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
    import PageHeader from '../../components/PageHeader'

    export default {
        name: 'settings-show',

        components: {
            PageHeader,
        },

        data() {
            return {
                trans: JSON.parse(Canvas.lang),
            }
        },

        computed: {
            //
        },

        mounted() {
            this.fetchData()
        },

        methods: {
            fetchData() {
                this.request()
                    .get('/api/settings')
                    .then(response => {
                        console.log(response.data)
                    })
                    .catch(error => {
                        // Add any error debugging...
                    })
            },
        },
    }
</script>
