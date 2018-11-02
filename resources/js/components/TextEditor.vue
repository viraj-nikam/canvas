<script type="text/ecmascript-6">
    // Import the editor
    import { Editor } from 'tiptap'

    export default {
        components: {
            Editor,
        },
    }
</script>

<template>
    <editor>
        <!-- Add HTML to the scoped slot called `content` -->
        <div slot="content" slot-scope="props">
            <p>Hi, I'm just a boring paragraph</p>
        </div>
    </editor>
</template>