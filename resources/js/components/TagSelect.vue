<template>
    <multiselect
        v-model="value"
        :options="options"
        :placeholder="trans.select_some_tags"
        :tag-placeholder="trans.add_a_new_tag"
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
import strings from '../mixins/strings';

export default {
    name: 'tag-select',

    components: {
        Multiselect,
    },

    mixins: [strings],

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
            options: [],
            value: [],
        };
    },

    computed: {
        ...mapState(['settings']),
        ...mapGetters({
            trans: 'settings/trans',
        }),
    },

    created() {
        this.value = this.tagged;
        this.options = this.tags.map((obj) => {
            let filtered = {};
            filtered['name'] = obj.name;
            filtered['slug'] = obj.slug;
            return filtered;
        });
    },

    methods: {
        onChange(tags) {
            this.$store.dispatch('post/setTags', tags);
        },

        addTag(searchQuery) {
            let tag = {
                name: searchQuery,
                slug: strings.methods.slugify(searchQuery),
                user_id: this.settings.user.id,
            };
            this.options.push(tag);
            this.value.push(tag);
            this.$store.dispatch('post/setTags', this.value);
        },
    },
};
</script>
