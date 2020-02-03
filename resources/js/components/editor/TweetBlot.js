import Quill from 'quill'

let BlockEmbed = Quill.import('blots/block/embed');
let Link = Quill.import('formats/link');

/**
 * @author Tim Li
 * @link https://github.com/contentco/quill-tweet/blob/master/src/module.js
 */
class TweetBlot extends BlockEmbed {
    static create(value) {
        let node = super.create();
        let url = this.sanitize(value);
        let id = url.substr(url.lastIndexOf('/') + 1);

        node.dataset.url = url;
        node.dataset.id = id;

        // Allow twitter library to modify our contents
        twttr.widgets.createTweet(id, node);

        return node;
    }

    static value(domNode) {
        return domNode.dataset.url;
    }

    static sanitize(url) {
        if (url.indexOf('?') !== -1) {
            url = url.substring(0, url.indexOf('?'));
        }

        return Link.sanitize(url)
    }
}
TweetBlot.blotName = 'tweet';
TweetBlot.tagName = 'div';
TweetBlot.className = 'ql-tweet';

export default TweetBlot
