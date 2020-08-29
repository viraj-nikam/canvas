import isEmpty from 'lodash/isEmpty';

export default {
    methods: {
        isScheduled(date) {
            return new Date(date) > new Date();
        },

        isDraft(date) {
            return isEmpty(date) || this.isScheduled(date);
        },

        isPublished(date) {
            return new Date(date) < new Date();
        },
    },
};
