import Quill from 'quill'

let BlockEmbed = Quill.import('blots/block/embed')

class VideoBlot extends BlockEmbed {
    static create(url) {
        let node = super.create();
        let iframe = document.createElement('iframe');

        node.setAttribute('class', 'ql-video');

        let videoObj = parseVideo(url);

        if (videoObj.type === 'youtube') {
            iframe.setAttribute('src', '//www.youtube.com/embed/' + videoObj.id);
        } else if (videoObj.type === 'vimeo') {
            iframe.setAttribute('src', '//player.vimeo.com/video/' + videoObj.id);
        }

        iframe.setAttribute('frameborder', 0);
        iframe.setAttribute('allowfullscreen', true);

        node.appendChild(iframe);

        return node;
    }
}

/**
 * Parse a url to determine the source.
 *
 * Supported YouTube URL formats:
 *      http://www.youtube.com/watch?v=jNQXAC9IVRw
 *      http://youtu.be/jNQXAC9IVRw
 *      https://youtube.googleapis.com/v/jNQXAC9IVRw
 *
 *  Supported Vimeo URL formats:
 *      http://vimeo.com/47996961
 *      http://player.vimeo.com/video/47996961
 *
 * Also supports relative URLs:
 *      //player.vimeo.com/video/47996961
 *
 * @param url
 * @returns {{id: string, type: (string)}}
 * @link https://gist.github.com/yangshun/9892961
 */
function parseVideo(url) {
    url.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);

    if (RegExp.$3.indexOf('youtu') > -1) {
        var type = 'youtube';
    } else if (RegExp.$3.indexOf('vimeo') > -1) {
        var type = 'vimeo';
    }

    return {
        type: type,
        id: RegExp.$6
    };
}

VideoBlot.blotName = 'video';
VideoBlot.tagName = 'div';

export default VideoBlot
