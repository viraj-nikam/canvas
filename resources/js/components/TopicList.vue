<script type="text/ecmascript-6">
    export default {
        props: ['models'],

        data() {
            return {
                search: '',
                topicList: this.models ? this.models : []
            }
        },

        computed: {
            /**
             * Filter topics by their name.
             *
             * @source https://codepen.io/AndrewThian/pen/QdeOVa
             */
            filteredList() {
                return this.topicList.filter(topic => {
                    return topic.name.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        },
    }
</script>