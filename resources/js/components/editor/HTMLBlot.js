import Quill from 'quill'

const BlockEmbed = Quill.import('blots/block/embed');

/**
 * Create the HTML blot.
 *
 * @author Mohamed Said <themsaid@gmail.com>
 * @link https://quilljs.com/guides/how-to-customize-quill/#customizing-blots
 */
class HTMLBlot extends BlockEmbed {
    static create(value) {
        let node = super.edit();

        node.innerHTML = value.content;
        node.setAttribute('contenteditable', false);

        return node;
    }

    static value(node) {
        return {
            content: node.innerHTML
        };
    }
}

HTMLBlot.blotName = 'html';
HTMLBlot.tagName = 'div';
HTMLBlot.className = 'inline_html';

export default HTMLBlot;
