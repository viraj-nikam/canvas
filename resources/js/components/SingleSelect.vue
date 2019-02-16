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
                label="name"
                track-by="slug"
                :options="options"
                :taggable="true"
                @tag="addTopic">
        </multiselect>

        <div class="topic">
            <input hidden type="hidden" :name="`topic[0][name]`" :value="this.value.name">
            <input hidden type="hidden" :name="`topic[0][slug]`" :value="this.value.slug">
        </div>
    </div>
</template>

<style rel="stylesheet" type="text/css" src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style type="text/css">
    .multiselect__select {
        display: none;
    }

    .multiselect__tags {
        border: none;
        padding-left: 0;
        padding-right: 0;
    }

    .multiselect__single,
    .multiselect__option--highlight,
    .multiselect__option--highlight::after,
    .multiselect__tag-icon:focus,
    .multiselect__tag-icon:hover {
        background: #3490dc;
        color: #fff;
        padding: 4px 26px 4px 10px;
        line-height: 1;
        margin-right: 10px;
        white-space: nowrap;
    }

    .multiselect__content-wrapper {
        border-top: 1px solid #e8e8e8;
    }

    .multiselect,
    .multiselect__input,
    .multiselect__single {
        font-size: 14px;
    }

    .multiselect__input:focus::-webkit-input-placeholder,
    .multiselect__input::-webkit-input-placeholder,
    .multiselect__placeholder {
        color: #6c757d;
        opacity: 1;
    }

    .multiselect__input {
        padding-top: 3px !important;
    }

    .multiselect--active {
        padding-bottom: 2px !important;
    }
</style>
