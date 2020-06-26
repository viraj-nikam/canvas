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
    </div>
</template>

<script>
import PageHeader from '../components/PageHeader';
import NProgress from 'nprogress';

export default {
    name: 'edit-profile',

    components: {
        PageHeader,
    },

    mounted() {
        NProgress.done();
    },
};
</script>
