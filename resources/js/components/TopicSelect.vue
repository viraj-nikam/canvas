<template>
    <multiselect
        v-model="value"
        :placeholder="trans.select_a_topic"
        :tag-placeholder="trans.add_a_new_topic"
        :options="options"
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

export default {
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
        const allTopics = this.topics.map((obj) => {
            let filtered = {};

            filtered['name'] = obj.name;
            filtered['slug'] = obj.slug;

            return filtered;
        });

        return {
            options: allTopics,
            value: this.assigned ? this.assigned : [],
        };
    },

    computed: {
        ...mapState(['profile']),
        ...mapGetters({
            trans: 'settings/trans',
        }),
    },

    methods: {
        onChange(value) {
            this.$store.dispatch('setPostTopic', value);

            this.update();
        },

        addTopic(searchQuery) {
            const topic = {
                name: searchQuery,
                slug: this.slugify(searchQuery),
            };

            this.options.push(topic);

            this.value = {
                name: topic.name,
                slug: topic.slug,
                user_id: this.profile.id,
            };

            this.$store.dispatch('setPostTopic', this.value);

            this.update();
        },

        update() {
            this.$parent.update();
        },
    },
};
</script>
