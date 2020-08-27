<template>
    <multiselect
        v-model="value"
        :placeholder="trans.select_some_tags"
        :tag-placeholder="trans.add_a_new_tag"
        :options="options"
        :multiple="true"
        :taggable="true"
        label="name"
        track-by="slug"
        style="cursor: pointer"
        @input="onChange"
        @tag="addTag"
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
        tags: {
            type: Array,
            required: false,
        },
        tagged: {
            type: Array,
            required: false,
        },
    },

    data() {
        return {
            options: this.fetchTags(),
            value: this.tagged ? this.tagged : [],
        };
    },

    computed: {
        ...mapState(['profile']),
        ...mapGetters({
            trans: 'settings/trans',
        }),
    },

    methods: {
        fetchTags() {
            return this.tags.map((obj) => {
                let filtered = {};

                filtered['name'] = obj.name;
                filtered['slug'] = obj.slug;

                return filtered;
            });
        },

        onChange(value) {
            this.$store.dispatch('setPostTags', value);

            this.update();
        },

        addTag(searchQuery) {
            const tag = {
                name: searchQuery,
                slug: this.slugify(searchQuery),
                user_id: this.profile.id,
            };

            this.options.push(tag);
            this.value.push(tag);

            this.$store.dispatch('setPostTags', this.value);

            this.update();
        },

        update() {
            this.$parent.update();
        },
    },
};
</script>
