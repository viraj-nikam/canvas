<media-modal :show.sync="showMediaManager">
    <media-manager
            :is-modal="true"
            :selected-event-name.sync="selectedEventName"
            :show.sync="showMediaManager"
    >
    </media-manager>
</media-modal>

@include('backend.post.partials.modals.help')

<script type="text/javascript">
    $(document).ready(function () {
        new Vue({
            el: 'body',
            data: {
                pageImage: null,
                selectedEventName: null,
                showMediaManager: false,
                simpleMde: null
            },

            ready: function () {
                this.simpleMde = new SimpleMDE({
                    element: document.getElementById("editor"),
                    toolbar: [
                        "bold", "italic", "heading", "|",
                        "quote", "unordered-list", "ordered-list", "|",
                        'link', 'image',
                        {
                            name: 'insertImage',
                            action: function (editor) {
                                this.openFromEditor();
                            }.bind(this),
                            className: "icon-image",
                            title: "Insert Media Browser Image"
                        },
                        "|",
                        {
                            name: "guide",
                            action: function () {
                                $('#guide').modal('show');
                            },
                            className: "fa fa-question-circle",
                            title: "Markdown Guide",
                        },
                        "|",
                        "preview", "side-by-side", "fullscreen", "|"
                    ]
                });
            },

            events: {
                'media-manager-selected-page-image': function (file) {
                    this.pageImage = file.relativePath;
                    this.showMediaManager = false;
                },

                'media-manager-selected-editor': function (file) {
                    var cm = this.simpleMde.codemirror;
                    var output = '[' + file.name + '](' + file.relativePath + ')';

                    if (this.isImage(file)) {
                        output = '!' + output;
                    }

                    cm.replaceSelection(output);
                    this.showMediaManager = false;
                },

                'media-manager-notification' : function(message, type, time)
                {
                    $.growl({
                        message: message
                    },{
                        type: 'inverse',
                        allow_dismiss: false,
                        label: 'Cancel',
                        className: 'btn-xs btn-inverse',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        z_index: 9999,
                        delay: time,
                        animate: {
                            enter: 'animated fadeInRight',
                            exit: 'animated fadeOutRight'
                        },
                        offset: {
                            x: 20,
                            y: 85
                        }
                    });
                }

            },

            methods: {
                openFromEditor: function () {
                    this.showMediaManager = true;
                    this.selectedEventName = 'editor';
                },

                openFromPageImage: function()
                {
                    this.showMediaManager = true;
                    this.selectedEventName = 'page-image';
                }
            }
        });
    });
</script>
