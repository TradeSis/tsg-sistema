var quill = new Quill('.quill-textarea', {
    //placeholder: 'Enter Detail',
    theme: 'snow',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'], // toggled buttons
            ['blockquote'],
           /*  [{
                'header': 1
            }, {
                'header': 2
            }], */ // custom button values
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            /* [{
                'script': 'sub'
            }, {
                'script': 'super'
            }], */ // superscript/subscript
            [{
                'indent': '-1'
            }, {
                'indent': '+1'
            }], // outdent/indent
            [{
                'direction': 'rtl'
            }], // text direction
            [{
                'size': ['small', false, 'large', 'huge']
            }], // custom dropdown
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            ['link', 'image', 'video', 'formula'], // add's image support
            [{
                'color': []
            }, {
                'background': []
            }], // dropdown with defaults from theme
            [{
                'font': []
            }],
            [{
                'align': []
            }],
            /* ['clean'] */
        ]
    }
});

quill.on('text-change', function(delta, oldDelta, source) {
    //console.log(quill.container.firstChild.innerHTML)
    $('#detail').val(quill.container.firstChild.innerHTML);
});