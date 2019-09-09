<template>
    <multiselect
        v-model="value"
        :placeholder="trans.topics.forms.select"
        :tag-placeholder="trans.topics.forms.tag"
        :options="options"
        :multiple="false"
        :taggable="true"
        @input="onChange"
        @tag="addTopic"
        label="name"
        track-by="slug"
    >
    </multiselect>
</template>

<script>
import Multiselect from "vue-multiselect";
import { store } from "../screens/posts/store";

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

            filtered["name"] = obj.name;
            filtered["slug"] = obj.slug;

            return filtered;
        });

        return {
            options: allTopics,
            value: this.assigned ? this.assigned : [],
            trans: JSON.parse(this.Canvas.lang)
        };
    },

    methods: {
        onChange(value, id) {
            store.syncTopic(value);
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

            store.syncTopic(topic);
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
