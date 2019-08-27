import Quill from 'quill';

const BlockEmbed = Quill.import('blots/block/embed');

/**
 * Create the divider blot.
 *
 * @author Mohamed Said <themsaid@gmail.com>
 * @link https://quilljs.com/guides/how-to-customize-quill/#customizing-blots
 */
class DividerBlot extends BlockEmbed {
    //
}

DividerBlot.blotName = 'divider';
DividerBlot.tagName = 'hr';

export default DividerBlot;
