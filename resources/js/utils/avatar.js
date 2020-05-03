import md5 from "md5";

const defaultGravatar = (email, size = 200) => {
    let hash = md5(email.trim().toLowerCase());

    return "https://secure.gravatar.com/avatar/" + hash + "?s=" + size;
};

export default {
    defaultGravatar,
};
