<script>
    // @TODO: Remove this component

    export default {
        props: {
            model: {
                type: Object,
                required: false
            }
        },

        data() {
            return {
                name: this.model ? this.model.name : ''
            }
        },

        computed: {
            slug() {
                return this.slugify(this.name);
            }
        }
    }
</script>
