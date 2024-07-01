(function($) {
    "use strict";
    var HT = {};

    HT.seoPreview = () => {
        $('input[name=meta_title]').on('keyup', function(){
            let input = $(this)
            let value = input.val()
            $('.meta-title').html(value)
        })

        $('input[name=canonical]').css({
            'padding-left': parseInt($('.baseUrl').outerWidth()) + 10
        })

        $('input[name=canonical]').on('keyup', function(){
            let input = $(this)
            let value = HT.removeUtf8(input.val())
            $('.canonical').html(BASE_URL + value + SUFFIX) 
        })

        $('textarea[name=meta_description]').on('keyup', function(){
            let input = $(this)
            let value = input.val()
            $('.meta_description').html(value)
        })
    }

    HT.removeUtf8 = (str) => {
        str = str.toLowerCase(); // Chuyển về kí tự thường
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ã|ă|ằ|ắ|ặ|ả|å/g, "a");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ồ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/đ/g, "d");
        str = str.replace(/[!@%^*()+=<>?1,]/g, ""); // Thay thế các ký tự đặc biệt
        str = str.replace(/-+/g, "-"); // Loại bỏ dấu gạch ngang liên tiếp
        str = str.replace(/\s+/g, "-"); // Thay thế khoảng trắng bằng dấu gạch ngang
        str = str.replace(/^-+|-+$/g, ""); // Loại bỏ dấu gạch ngang ở đầu và cuối chuỗi
        return str;
    };
        
    $(document).ready(function(){
        HT.seoPreview();
    });
        
})(jQuery);