<script type="text/ecmascript-6">
    export default {
        props: ['tag'],

        data() {
            return {
                name: this.tag ? this.tag.name : ''
            }
        },

        computed: {
            slug() {
                return this.slugify(this.name);
            }
        },

        methods: {
            slugify(text) {
                return text.toString().toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-');
            }
        }
    }
</script>