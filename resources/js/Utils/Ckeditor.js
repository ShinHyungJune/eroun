import MyUploadAdapter from "./MyUploadAdapter";
import {Alignment} from "@ckeditor/ckeditor5-alignment";
function SimpleUploadAdapterPlugin(editor) {
    editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader);
    };
}

class Ckeditor {
    constructor(target = "#editor", onCreate = () => {}) {
        this.target = target;

        this.onCreate = onCreate;
    }

    create(){
        return ClassicEditor.create(document.querySelector(this.target), {
            extraPlugins: [SimpleUploadAdapterPlugin],
            alignment: {
                options: [ 'left', 'right' ]
            },
            toolbar: [
                'heading', '|', 'bulletedList', 'numberedList', 'alignment', 'undo', 'redo'
            ]
        }).then((editor) => {
            this.onCreate(editor);
        }).catch((error) => {
            console.error(error);
        });
    }
}

export default Ckeditor
