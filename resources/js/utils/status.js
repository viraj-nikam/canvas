import isEmpty from 'lodash/isEmpty';

export function isDraft(date) {
    return isEmpty(date) || isScheduled(date);
}

export function isScheduled(date) {
    return new Date(date) > new Date();
}

export function isPublished(date) {
    return new Date(date) < new Date();
}
