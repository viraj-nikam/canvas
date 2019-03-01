<script type="text/ecmascript-6">
    export default {
        props: ['entity'],

        data() {
            return {
                name: this.entity ? this.entity.name : ''
            }
        },

        computed: {
            slug() {
                return this.slugify(this.name);
            }
        },

        methods: {
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