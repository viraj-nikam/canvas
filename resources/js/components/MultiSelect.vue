<script type="text/ecmascript-6">
    import Multiselect from 'vue-multiselect'

    export default {
        props: ['tags'],

        components: {
            Multiselect
        },

        data() {
            return {
                value: [],
                options: [
                    {name: 'Vue.js', slug: 'vu'},
                    {name: 'Javascript', slug: 'js'},
                    {name: 'Open Source', slug: 'os'}
                ]
            }
        },

        methods: {
            addTag(newTag) {
                const tag = {
                    name: newTag,
                    slug: this.slugify(newTag)
                }
                this.options.push(tag)
                this.value.push(tag)
            },

            slugify(text) {
                return text.toString().toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-');
            }
        }
    }
</script>

<template>
    <div>
        <multiselect v-model="value" tag-placeholder="Add a new tag" placeholder="Select some tags..."
                     label="name" track-by="slug" :options="options" :multiple="true" :taggable="true"
                     name="tags" @tag="addTag"></multiselect>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>