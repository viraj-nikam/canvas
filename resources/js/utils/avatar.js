import md5 from 'md5';

export function defaultGravatar(email, size = 200) {
    let hash = md5(email.trim().toLowerCase());

    return 'https://secure.gravatar.com/avatar/' + hash + '?s=' + size;
}
