jQuery(document).ready( function($){
    var $formAddCategory = $('#add-category'),
        $closeMessage = $('.alert .icon-cancel-circled'),
        $success = $('#lythranking_success p'),
        $error = $('#lythranking_error p'),
        $dropdwon = $('.btn-drop');
        $url_page_add = $('#url_page').val();

    $dropdwon.on('click', function(e){
        e.stopPropagation();
        $(this).parent().children('.dropdown').slideToggle(250);
    });

    $closeMessage.on('click', function(e){
        e.preventDefault();
        $(this).parent().css('display', 'none');
        $(this).parent().children('p').html('');
    });

    $formAddCategory.submit(function(event){
        event.preventDefault();
        $success.parent().css('display', 'none');
        $error.parent().css('display', 'none');

        var $data = $(this).serializeArray();
        $data.push(
            {name: 'action', value: 'add_lr_Process'}
        );
        console.log($data);

        toggleSpin(true);
        setTimeout(function(){
            $.ajax({
                url: ajax_object.ajaxurl,
                type: 'POST',
                dataType: 'JSON',
                data: $data,
                success: function(data){
                    if (data.return) {
                        console.log(data.message);
                        $success.html(data.message);
                        $success.parent().css('display', 'block');
                        setTimeout(function(){
                            $(location).attr('href', $url_page_add);
                        }, 1500);
                    } else {
                        console.log(data.error);
                        $error.html(data.error);
                        $error.parent().css('display', 'block');
                    };
                    toggleSpin(false);
                },
                error: function(XHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    toggleSpin(false);
                }
            });
        }, 2000);
    });
    function toggleSpin(mode) {
        var $spin = $('#btn-form .icon-spin5'),
            $text = $('#btn-form .icon_text');
        switch (mode) {
            case true:
                $text.css('display', 'none');
                $spin.css('display', 'block');
                break;
            case false:
                $spin.css('display', 'none');
                $text.css('display', 'block');
                break;

        }
    }
});
