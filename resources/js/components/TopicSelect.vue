<template>
    <div v-cloak>
        <multiselect
                v-model="value"
                :placeholder="this.trans.topics.forms.select"
                :tag-placeholder="this.trans.topics.forms.tag"
                label="name"
                track-by="slug"
                :options="options"
                :taggable="true"
                @input="onChange"
                @tag="addTopic">
        </multiselect>

        <div class="topics">
            <template v-if="value.length != 0">
                <input hidden type="hidden" :name="`topic[name]`" :value="value.name">
                <input hidden type="hidden" :name="`topic[slug]`" :value="value.slug">
            </template>
        </div>
    </div>
</template>

<script type="text/ecmascript-6">
    import Multiselect from 'vue-multiselect'

    export default {
        props: {
            topics: {
                type: Array,
                required: false
            },
            assigned: {
                type: Array,
                required: false
            }
        },

        components: {
            Multiselect
        },

        data() {
            const allTopics = this.topics.map(obj => {
                let filtered = {};

                filtered['name'] = obj.name;
                filtered['slug'] = obj.slug;

                return filtered;
            });

            return {
                value: this.assigned ? this.assigned : [],
                options: allTopics,
                trans: i18n
            }
        },

        methods: {
            onChange(value, id) {
                if (this.value == null) {
                    this.value = [];
                }
            },

            addTopic(searchQuery) {
                const topic = {
                    name: searchQuery,
                    slug: this.slugify(searchQuery)
                };

                this.options.push(topic);

                this.value = {
                    name: topic.name,
                    slug: topic.slug
                };
            },

            /**
             * Convert a string to a slug.
             *
             * @source https://gist.github.com/mathewbyrne/1280286
             */
            slugify(text) {
                return text.toString().toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/--+/g, '-')
            }
        }
    }
</script>

<style rel="stylesheet" type="text/css" src="vue-multiselect/dist/vue-multiselect.min.css"></style>
