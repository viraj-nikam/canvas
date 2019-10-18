<template>
    <multiselect v-model="value"
                 :placeholder="trans.tags.forms.select"
                 :tag-placeholder="trans.tags.forms.tag"
                 :options="options"
                 :multiple="true"
                 :taggable="true"
                 @input="onChange"
                 @tag="addTag"
                 label="name"
                 track-by="slug">
    </multiselect>
</template>

<script>
    import _ from 'lodash';
    import Multiselect from "vue-multiselect";
    import {store} from "../screens/posts/store";

    export default {
        props: {
            tags: {
                type: Array,
                required: false
            },
            tagged: {
                type: Array,
                required: false
            }
        },

        components: {
            Multiselect
        },

        data() {
            const allTags = this.tags.map(obj => {
                let filtered = {};

                filtered["name"] = obj.name;
                filtered["slug"] = obj.slug;

                return filtered;
            });

            return {
                options: allTags,
                value: this.tagged ? this.tagged : [],
                storeState: store.state,
                trans: JSON.parse(Canvas.lang)
            };
        },

        methods: {
            onChange(value, id) {
                store.syncTags(value);
                this.update();
            },

            addTag(searchQuery) {
                const tag = {
                    name: searchQuery,
                    slug: this.slugify(searchQuery)
                };

                this.options.push(tag);
                this.value.push(tag);

                store.syncTags(tag);
                this.update();
            },

            update: _.debounce(function (e) {
                this.$parent.update();
            }, 900)
        }
    };
</script>

