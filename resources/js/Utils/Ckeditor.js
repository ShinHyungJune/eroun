import MyUploadAdapter from "./MyUploadAdapter";

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

            toolbar: {
                /*items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    'alignment',
                    'imageUpload',
                    'blockQuote',
                    'undo',
                    'redo'
                ]*/
            },
            alignment: {
                options: ['left', 'right', 'center', 'justify']
            },

        }).then((editor) => {
            this.onCreate(editor);
        }).catch((error) => {
            console.error(error);
        });
    }
}

export default Ckeditor
