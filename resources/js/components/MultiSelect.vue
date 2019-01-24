<script type="text/ecmascript-6">
    import Multiselect from 'vue-multiselect'

    export default {
        props: ['tags', 'tagged'],

        components: {
            Multiselect
        },

        data() {
            const allTags = this.tags.map(obj => {
                let filtered = {};
                filtered['name'] = obj.name;
                filtered['slug'] = obj.slug;

                return filtered;
            });

            return {
                value: this.tagged ? this.tagged : [],
                options: allTags
            }
        },

        methods: {
            addTag(newTag) {
                const tag = {
                    name: newTag,
                    slug: this.slugify(newTag)
                };
                this.options.push(tag);
                this.value.push(tag)
            },

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
                tag-placeholder="Add a new tag"
                placeholder="Select some tags..."
                label="name"
                track-by="slug"
                :options="options"
                :multiple="true"
                :taggable="true"
                @tag="addTag">
        </multiselect>

        <div class="tags">
            <template v-for="tags,index in value">
                <input hidden type="hidden" :name="`tags[${index}][name]`" :value="tags.name">
                <input hidden type="hidden" :name="`tags[${index}][slug]`" :value="tags.slug">
            </template>
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

    .multiselect__tag,
    .multiselect__option--highlight,
    .multiselect__option--highlight::after,
    .multiselect__tag-icon:focus,
    .multiselect__tag-icon:hover {
        background: #3490dc;
    }

    .multiselect__content-wrapper {
        border-top: 1px solid #e8e8e8;
    }

    .multiselect,
    .multiselect__input,
    .multiselect__single {
        font-size: 14px;
        padding: 0;
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
