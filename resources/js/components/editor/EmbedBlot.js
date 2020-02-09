import Quill from 'quill'

let BlockEmbed = Quill.import('blots/block/embed')

class EmbedBlot extends BlockEmbed {
    static create(value) {
        let node = super.create()

        node.innerHTML = value.content
        node.setAttribute('contenteditable', false)

        return node
    }

    static value(node) {
        return {
            content: node.innerHTML,
        }
    }
}

EmbedBlot.blotName = 'embed'
EmbedBlot.tagName = 'div'
EmbedBlot.className = 'ql-embed'

export default EmbedBlot
