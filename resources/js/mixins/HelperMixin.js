import md5 from 'md5'
import truncate from 'lodash/truncate'
import isEmpty from 'lodash/isEmpty'
import numeral from 'numeral'
import moment from "moment";

export default {
    computed: {
        Canvas() {
            return window.Canvas
        },
    },

    methods: {
        isDraft(date) {
            return (isEmpty(date) || this.isScheduled(date))
        },

        isScheduled(date) {
            return moment(date).isAfter(
                moment(new Date()).format().slice(0, 19).replace('T', ' ')
            )
        },

        isPublished(date) {
            return moment(date).isBefore(
                moment(new Date()).format().slice(0, 19).replace('T', ' '))
        },

        slugify(text) {
            return text
                .toString()
                .toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/--+/g, '-')
        },

        suffixedNumber(number) {
            if (number < 999) {
                return number
            } else {
                return numeral(number).format('0.[0]a')
            }
        },

        trim(string, length = 70) {
            return truncate(string, {
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
