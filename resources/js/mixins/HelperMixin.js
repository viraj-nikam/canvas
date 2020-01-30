import md5 from 'md5'

export default {
    computed: {
        Canvas() {
            return window.Canvas
        },
    },

    methods: {
        slugify(text) {
            return text
                .toString()
                .toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/--+/g, '-')
        },

        suffixedNumber(number) {
            let formatted = ''
            let suffix = ''

            if (number < 900) {
                formatted = number
                suffix = ''
            } else if (number < 900000) {
                let n_total = number / 1000
                formatted = parseFloat(n_total.toFixed(1))
                suffix = 'K'
            } else if (number < 900000000) {
                let n_total = number / 1000000
                formatted = parseFloat(n_total.toFixed(1))
                suffix = 'M'
            } else if (number < 900000000000) {
                let n_total = number / 1000000000
                formatted = parseFloat(n_total.toFixed(1))
                suffix = 'B'
            } else {
                let n_total = number / 1000000000000
                formatted = parseFloat(n_total.toFixed(1))
                suffix = 'T'
            }

            return formatted + suffix
        },

        plural(string, count) {
            if (count > 1 || count === 0) {
                return ' ' + string + 's'
            } else {
                return ' ' + string
            }
        },

        trim(string, length = 70) {
            return _.truncate(string, {
                length: length,
            })
        },

        defaultGravatar(email, size = 200) {
            let hash = md5(email.trim().toLowerCase())

            return 'https://secure.gravatar.com/avatar/' + hash + '?s=' + size
        },

        mediaUploadPath() {
            return '/' + Canvas.path + '/api/media/uploads'
        }
    },
}
