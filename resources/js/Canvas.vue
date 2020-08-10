<template>
    <main>
        <page-header></page-header>
        <router-view></router-view>
    </main>
</template>

<script>
import PageHeader from './components/PageHeader';

export default {
    name: 'Canvas',

    components: {
        PageHeader,
    }
};
</script>
