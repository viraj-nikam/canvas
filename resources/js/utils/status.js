import isEmpty from "lodash/isEmpty";

export const isDraft = (date) => {
    return isEmpty(date) || isScheduled(date);
};

export const isScheduled = (date) => {
    return new Date(date) > new Date();
};

export const isPublished = (date) => {
    return new Date(date) < new Date();
};

export default {
    isDraft,
    isScheduled,
    isPublished,
};
