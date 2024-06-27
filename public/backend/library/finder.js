(function($) {
    "use strict";
    var HT = {};

    HT.inputImage = () => {
        $(document).on('click', '.input-image', function(){
            let _this = $(this)
            let fileUpload  = _this.attr('data-upload')
            HT.BrowseServerInput($(this), fileUpload);
        })
    }

   HT.BrowseServerInput = (object, type) => {
       
        if(typeof(type) == 'undefined'){
            type = 'Images';
        }   
        var finder = new CKFinder();
        finder.resourceType = type;
    
        finder.selectActionFunction = function( fileUrl, data ) {
            console.log(fileUrl)
            fileUrl = fileUrl.replace(BASE_URL,"/");
    
            object.val(fileUrl)
        }
        finder.popup();
   }


    $(document).ready(function() {
        HT.inputImage();
    })
})(jQuery);