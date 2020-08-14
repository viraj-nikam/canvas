<template>
    <multiselect
        v-model="value"
        :placeholder="i18n.select_some_tags"
        :tag-placeholder="i18n.add_a_new_tag"
        :options="options"
        :multiple="true"
        :taggable="true"
        label="name"
        track-by="slug"
        style="cursor: pointer;"
        @input="onChange"
        @tag="addTag"
    />
</template>

<script>
import Multiselect from 'vue-multiselect';
import i18n from '../mixins/i18n';

export default {
    components: {
        Multiselect,
    },

    mixins: [i18n],
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
                user_id: window.Canvas.user.id,
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
