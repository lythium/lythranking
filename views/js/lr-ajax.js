jQuery(document).ready( function($){
    // Page Add Category
    var $formAddCategory = $('#add-category-form'),
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
            {name: 'action', value: 'category_lr_Process'}
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
    // Page list
    var $formAddUnit = $('#add-unit-form'),
        $btnDisplayForm = $('button#form_unit'),
        $addDetails = $('#icone-add-row'),
        $btnCloseDisplayForm = $('#close_form_unit');

    // Ajax add unit
    $formAddUnit.submit(function(event){
        event.preventDefault();
        $success.parent().css('display', 'none');
        $error.parent().css('display', 'none');

        var $data = $(this).serializeArray();
        $data.push(
            {name: 'action', value: 'unit_lr_Process'}
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
    $btnDisplayForm.on('click', function(event){
        event.stopPropagation();
        $(this).slideToggle(0);
        $('#table_add_unit').slideToggle(250);
    });
    $btnCloseDisplayForm.on('click', function(event){
        event.stopPropagation();
        $('#table_add_unit').slideToggle(0);
        $btnDisplayForm.slideToggle(250);
    });

    $('#upload-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function(e){

            var $upload_image = image.state().get('selection').first();

            console.log($upload_image);
            var $image_url = $upload_image.toJSON().url;

            $('#image_url').val($image_url);
            $('#upload_image').attr('src', $image_url);
            $('.image_group').css('display', 'flex');
            $('#image_url_group').css('display', 'none');
        });
    });
    $('#close_upload').click(function(e) {
        e.preventDefault();
        $('#image_url').val('');
        $('#upload_image').attr('src', '');
        $('.image_group').css('display', 'none');
        $('#image_url_group').css('display', 'block');
    });
    $addDetails.on('click', function(event){
        event.stopPropagation();
        var $count = $("#table_add_unit tr[id^=details_]").length;
        if ($count == null) {
            $count = 0;
        }
        $('<tr id="details_'+$count+'">'+
            '<td colspan="1"></td>'+
            '<td colspan="3">'+
                '<input type="text"  name="positive_details['+$count+']" value=""></input>'+
            '</td>'+
            '<td colspan="3">'+
                '<input type="text"  name="negative_details['+$count+']" value=""></input>'+
            '</td>'+
            '<td colspan="1"><i class="close-row icon-cancel-circled"></i></td>'+
        '</tr>').insertBefore("tr.add-row");
        if ($count >= 1) {
            $('#tbody_details').children('tr#details_'+($count - 1)+'').children('td:last-child').html('');
        }
        $('#details_'+$count+' .close-row').on('click', function(event){
            event.preventDefault();
            event.stopPropagation();
            $(this).parent().parent('tr').remove();
            $('#tbody_details').children('tr#details_'+($count - 1)+'').children('td:last-child').html('<i class="close-row icon-cancel-circled"></i>');
        });
    });
});
