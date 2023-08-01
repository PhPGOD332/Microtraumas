$(document).ready(() => {
    const 
        menu = $(document).find('.menu-col'),
        sectionMain = $(document).find('.section-main'),
        sectionTitle = $(document).find('.section-title'),
        wrapper = $(document).find('.wrapper-block');
        // modalMessage = $(document).find('#modal-message'),
        // modalConfirm = $(document).find('#modal-confirm');

    const menuHeight = function menuHeight() {
        if(menu) {
            if(menu.outerHeight() < $(document).outerHeight()) {
                menu.outerHeight($(document).outerHeight() - sectionTitle.outerHeight() - (sectionMain.outerHeight() - sectionMain.height()));
            } else {
                menu.outerHeight($(document).outerHeight());
            }
        }
    }

    menuHeight();

    $.ajax({
        url: '/assets/php/user/nickname.php',
        cache: false,
        method: 'GET',
        success: (res) => {
            $(document).find('#nickname').html(res);
        }
    })

    if(wrapper) {
        wrapper.css('min-height', $(window).height());
        wrapper.find('.section').css('min-height', $(window).height() - 45);
    }

    $(document).on('click', '#user-exit', () => {
        $.ajax({
            url: '/assets/php/connect/exit.php',
            cache: false,
            method: 'GET',
            success: () => {
                location.reload();
            }
        })
    })

    if(sectionTitle.length > 0) {
        // $(window).on('scroll', () => {
        //     if($(this).scrollTop(100)) {
        //         sectionTitle.addClass('fixed-menu');
        //     } else {
        //         sectionTitle.removeClass('fixed-menu');
        //     }
            
        // })
    }
})