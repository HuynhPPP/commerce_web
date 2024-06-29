(function($) {
    "use strict";
    var HT = {};

    // CKEDITOR
    HT.setupCkeditor = () => {
        if($('.ck-editor')){
            $('.ck-editor').each(function() {
                let editor = $(this);
                let elementId = editor.attr('id');
                let elementHeight = editor.attr('data-height');
                HT.ckeditor4(elementId, elementHeight)
            })
        }
    }

    HT.ckeditor4 = (elementId, elementHeight) => {
        if(typeof(elementHeight) == 'undefined'){
            elementHeight = 500;
        }
        CKEDITOR.replace( elementId, {
            height: elementHeight,
            removeButtons: '',
            entities: true,
            allowedContent: true,
            toolbarGroups: [
                { name: 'clipboard',    groups: [ 'clipboard', 'undo' ] },
                { name: 'editing',      groups: [ 'find', 'selection', 'spellchecker' ] },
                { name: 'links' },
                { name: 'insert' },
                { name: 'forms' },
                { name: 'tools' },
                { name: 'document',     groups: [ 'mode', 'document', 'doctools' ] },
                { name: 'colors' },
                { name: 'others' },
                '/',
                { name: 'basicstyles',  groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'paragraph',    groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ]},
                { name: 'styles' }
            ],
        });
    }

    HT.uploadImageToInput = () => {
        $('.upload-image').click(function(){
            let input = $(this)
            let type = input.attr('data-type')
            HT.setupCkFinder2(input, type);
        })
    }

    HT.uploadImageAvatar = () => {
        $('.image-target').click(function(){
            let input = $(this)
            let type = 'Images';
            HT.browseServerAvartar(input, type);
        })
    }

    HT.setupCkFinder2 = (object, type) => {
        if(typeof(type) == 'undefined'){
            type = 'Images';
        }
            
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function( fileUrl, data ) {
            const substring = "public/";
            const outputString = fileUrl.replace(substring, "");
            console.log(outputString);
            object.val(outputString)
        }
        
        finder.popup();
        
    }

    HT.browseServerAvartar = (object, type) => {
        if(typeof(type) == 'undefined'){
            type = 'Images';
        }
            
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function( fileUrl, data ) {
            // const substring = "public/";
            // const outputString = fileUrl.replace(substring, "");
            console.log(fileUrl);
            object.find('img').attr('src', fileUrl)
            object.siblings('input').val(fileUrl)
        }
        
        finder.popup();
    }
        
    $(document).ready(function(){
        HT.uploadImageToInput();
        HT.setupCkeditor();
        HT.uploadImageAvatar();
    });
        
})(jQuery);