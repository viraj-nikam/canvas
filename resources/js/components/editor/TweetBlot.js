import Quill from 'quill'

let BlockEmbed = Quill.import('blots/block/embed')

class TweetBlot extends BlockEmbed {
    static create(id) {
        let node = super.create();

        node.dataset.id = id;

        // Allow twitter library to modify our contents
        twttr.widgets.createTweet(id, node);

        return node;
    }

    static value(domNode) {
        return domNode.dataset.id;
    }
}

TweetBlot.blotName = 'tweet';
TweetBlot.tagName = 'div';
TweetBlot.className = 'tweet';

export default TweetBlot
