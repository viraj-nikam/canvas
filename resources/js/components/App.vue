<template>
    <div id="canvas">
        <page-header></page-header>
    </div>
</template>

<script>
import PageHeader from './PageHeader';
import NProgress from 'nprogress';

export default {
    components: {
        PageHeader,
    },

    data() {
        return {
            trans: JSON.parse(window.Canvas.locale.translations),
        };
    },

    mounted() {
        NProgress.done();
    },
};
</script>
