<template>
    <div>
        <page-header></page-header>

        <main class="py-4">
            <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 my-3">
                <div class="d-flex justify-content-between my-3">
                    <h1>Profile</h1>
                </div>
            </div>
        </main>

        <div class="mt-3 d-flex justify-content-center">
            <p class="text-muted">{{ config.version }}</p>
        </div>
    </div>
</template>

<script>
    import PageHeader from '../components/PageHeader';
    import store from '../store';
    import NProgress from "nprogress";

    export default {
        name: 'edit-profile',

        components: {
            PageHeader,
        },

        mounted() {
            NProgress.done();
        },

        data() {
            return {
                isReady: false,
            };
        },

        computed: {
            config() {
                return store.state.config;
            }
        }
    };
</script>
