<script type="text/ecmascript-6">
    import Multiselect from 'vue-multiselect'

    export default {
        props: ['topics', 'topic'],

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
                value: this.topic ? this.topic : [],
                options: allTopics
            }
        },

        methods: {
            addTopic(newTopic) {
                const topic = {
                    name: newTopic,
                    slug: this.slugify(newTopic)
                };
                this.options.push(topic);
                this.value.push(topic);
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

<template>
    <div>
        <multiselect
                v-model="value"
                placeholder="Select a topic..."
                tag-placeholder="Add this as new topic"
                label="name"
                track-by="slug"
                :options="options"
                :taggable="true"
                @tag="addTopic">
        </multiselect>

        <div class="topics">
            <input hidden type="hidden" :name="`topic[0][name]`" :value="value.name">
            <input hidden type="hidden" :name="`topic[0][slug]`" :value="value.slug">
        </div>
    </div>
</template>

<style rel="stylesheet" type="text/css" src="vue-multiselect/dist/vue-multiselect.min.css"></style>
