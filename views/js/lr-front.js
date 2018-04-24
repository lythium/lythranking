jQuery(document).ready(function($){
    var $mainNav = $('.lr-nav li'),
        $subNav = $('.lr-sub-nav li');

    $mainNav.on('click', function(){
        var $id = $(this).attr('id'),
            $thisSection = $('.lythranking section#'+$id),
            $childrenId = $('.lythranking section#'+$id+' .lr-sub-nav li:first-child').attr('id');
        $mainNav.removeClass('active-menu');
        $(this).addClass('active-menu');
        $('.lythranking section').removeClass('active');
        $thisSection.addClass('active');
        $('.lr-sub-nav li#'+$childrenId).click();
    });
    $subNav.on('click', function(){
        var $id = $(this).attr('id'),
            $thisContent = $('.lythranking .lr-content #'+$id);
        $subNav.removeClass('active-menu');
        $(this).addClass('active-menu');
        $('.lythranking .lr-content div').removeClass('active');
        $thisContent.addClass('active');
        iconPos($(this));
    })

    var $firstChildActive = $('.lr-sub-nav li.active-menu');

    function iconPos($childActive) {
        var $childIcon = $('section.active .icon-section'),
            $childWidth = $childActive.width(),
            $indexInList = $('section.active .lr-sub-nav li').index($childActive);

        $childIcon.css({'left': (($childWidth/2 - 23) + ($childWidth * $indexInList))+'px'})
    }

    iconPos($firstChildActive);
});
