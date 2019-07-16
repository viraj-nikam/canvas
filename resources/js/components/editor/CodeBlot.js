import Quill from 'quill'

let BlockEmbed = Quill.import('blots/block/embed');

/**
 * Create the HTML blot.
 *
 * @author Mohamed Said <themsaid@gmail.com>
 * @link https://quilljs.com/guides/how-to-customize-quill/#customizing-blots
 */
class CodeBlot extends BlockEmbed {
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

CodeBlot.blotName = 'html';
CodeBlot.tagName = 'div';
CodeBlot.className = 'inline_html';

export default CodeBlot;
