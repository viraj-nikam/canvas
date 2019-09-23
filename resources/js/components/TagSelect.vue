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
import Multiselect from "vue-multiselect";
import { store } from "../screens/posts/store";

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

        update() {
            this.$parent.update();
        }
    }
};
</script>

<style scoped>
@import "~vue-multiselect/dist/vue-multiselect.min.css";

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

.multiselect,
.multiselect__input,
.multiselect__single {
    font-size: 14px;
    padding: 0;
    border-radius: 0;
}

.multiselect__input:focus::placeholder,
.multiselect__input:focus::-webkit-input-placeholder,
.multiselect__input::placeholder,
.multiselect__input::-webkit-input-placeholder,
.multiselect__placeholder {
    color: #6c757d;
    opacity: 1;
    padding-top: 0;
    line-height: 1;
}

.multiselect__input {
    line-height: 1;
}

.multiselect__tag {
    padding-bottom: 2px;
}
</style>
