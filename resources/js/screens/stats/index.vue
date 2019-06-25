<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="mt-2">{{ this.$root.i18n.stats.header }}</h1>

                <div v-if="data">
                    <p class="mt-3 mb-4">{{ this.$root.i18n.stats.subtext }}</p>

                    <div class="card-deck mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted small text-uppercase font-weight-bold">{{ this.$root.i18n.stats.cards.views.title }}</h5>
                                <p class="card-text display-4"></p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted small text-uppercase font-weight-bold">{{ this.$root.i18n.stats.cards.posts.title }}</h5>
                                <p class="card-text display-4"></p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted small text-uppercase font-weight-bold">{{ this.$root.i18n.stats.cards.publishing.title }}</h5>
                                <ul>
                                    <li> {{ this.$root.i18n.stats.cards.publishing.details.published }}</li>
                                    <li> {{ this.$root.i18n.stats.cards.publishing.details.drafts }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

<!--                    <line-chart :views=""></line-chart>-->

<!--                    <post-list :models="getData" inline-template>-->
<!--                        <div class="mt-4">-->
<!--                            <div v-cloak>-->
<!--                                <div class="d-flex border-top py-3 align-items-center" v-for="post in filteredList">-->
<!--                                    <div class="mr-auto">-->
<!--                                        <p class="mb-1 mt-2">-->
<!--                                            <a :href="'/' + '{{ router.base }}' + '/stats/' + post.id" class="font-weight-bold lead">@{{ post.title }}</a>-->
<!--                                        </p>-->
<!--                                        <p class="text-muted mb-2">-->
<!--                                            @{{ post.read_time }} ―-->
<!--                                            <a :href="'/' + '{{ router.base }}' + '/posts/' + post.id + '/edit'">{{ this.$root.i18n.buttons.posts.edit }}</a> ―-->
<!--                                            <a :href="'/' + '{{ router.base }}' + '/stats/' + post.id">{{ this.$root.i18n.buttons.stats.show }}</a>-->
<!--                                        </p>-->
<!--                                    </div>-->
<!--                                    <div class="ml-auto d-none d-lg-block">-->
<!--                                        <span class="text-muted mr-3">{{ this.$root.i18n.stats.views }}</span>-->
<!--                                        {{ this.$root.i18n.stats.details.created }} @{{ moment(post.created_at).fromNow() }}-->
<!--                                    </div>-->
<!--                                </div>-->

<!--                                <div class="d-flex justify-content-center">-->
<!--                                    <a href="#!" class="btn btn-link" @click="limit += 7" v-if="load">{{ this.$root.i18n.buttons.general.load }} <i class="fa fa-fw fa-angle-down"></i></a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </post-list>-->
                </div>
                <p v-else class="mt-4">{{ this.$root.i18n.stats.empty }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    import PostList from "../../components/PostList";
    import LineChart from "../../components/LineChart";

    export default {
        name: "stats",

        components: {
            LineChart,
            PostList
        },

        data() {
            return {
                baseURL: '/stats',
                ready: false,
            }
        },

        mounted() {
            document.title = "Canvas";
            this.getData();
        },

        methods: {
            getData() {
                this.http().get(this.baseURL
                ).then(response => {
                    this.data = response.data.data;

                    this.ready = true;
                });
            },
        }
    }
</script>

<style scoped>

</style>
