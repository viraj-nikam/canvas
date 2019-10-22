import moment from "moment";

export const getters = {
    activePost(state) {
        return state.activePost;
    },

    isDraft(state) {
        const date = state.activePost.published_at;

        return date === null || date === "" || date > moment(new Date()).tz(Canvas.timezone).format().slice(0, 19).replace("T", " ");
    }
};

export default {
    getters,
}
