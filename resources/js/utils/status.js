import isEmpty from "lodash/isEmpty";

const isDraft = (date) => {
    return isEmpty(date) || isScheduled(date);
};

const isScheduled = (date) => {
    return new Date(date) > new Date();
};

const isPublished = (date) => {
    return new Date(date) < new Date();
};

export default {
    isDraft,
    isScheduled,
    isPublished,
};
