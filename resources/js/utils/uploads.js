/**
 * Return the media upload path.
 *
 * @returns {string}
 */
export const uploadPath = () => {
    return "/" + window.Canvas.path + "/api/media/uploads";
};

export default {
    uploadPath,
};
