<template>
    <multiselect
        v-model="value"
        :options="options"
        :placeholder="trans.select_a_topic"
        :tag-placeholder="trans.add_a_new_topic"
        :multiple="false"
        :taggable="true"
        label="name"
        track-by="slug"
        style="cursor: pointer"
        @input="onChange"
        @tag="addTopic"
    />
</template>

<script>
import { mapGetters, mapState } from 'vuex';
import Multiselect from 'vue-multiselect';
import strings from '../mixins/strings';

export default {
    name: 'topic-select',

    components: {
        Multiselect,
    },

    props: {
        topics: {
            type: Array,
            required: false,
        },
        assigned: {
            type: [Object, Array],
            required: false,
        },
    },

    data() {
        return {
            options: [],
            value: [],
        };
    },

    mixins: [strings],

    created() {
        this.value = this.tagged;
        this.options = this.topics.map((obj) => {
            let filtered = {};
            filtered['name'] = obj.name;
            filtered['slug'] = obj.slug;
            return filtered;
        });
    },

    computed: {
        ...mapState(['profile']),
        ...mapGetters({
            trans: 'settings/trans',
        }),
    },

    methods: {
        onChange(topic) {
            this.$store.dispatch('post/setTopic', topic);
        },

        addTopic(searchQuery) {
            let topic = {
                name: searchQuery,
                slug: strings.methods.slugify(searchQuery),
                user_id: this.profile.id,
            };

            this.options.push(topic);

            this.value = {
                name: topic.name,
                slug: topic.slug,
                user_id: this.profile.id,
            };

            this.$store.dispatch('post/setTopic', this.value);
        },
    },
};
</script>
