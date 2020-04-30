import md5 from "md5";

/**
 * Return a valid Gravatar URL for a given email.
 *
 * @param email
 * @param size
 * @returns {string}
 */
export const defaultGravatar = (email, size = 200) => {
    let hash = md5(email.trim().toLowerCase());

    return "https://secure.gravatar.com/avatar/" + hash + "?s=" + size;
};

export default {
    defaultGravatar,
};
