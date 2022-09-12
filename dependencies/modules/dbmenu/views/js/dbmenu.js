/**
 * 2007-2021 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    DevBlinders <soporte@devblinders.com>
 * @copyright Copyright (c) DevBlinders
 * @license   Commercial license
 */

$(document).ready(function(){
    //the trigger on hover when cursor directed to this class
    /*$(".core-menu li").hover(
        function(){
            //i used the parent ul to show submenu
            $(this).children('ul').slideDown('fast');
        },
        //when the cursor away
        function () {
            $('ul', this).slideUp('fast');
        });*/
    $(".core-menu .menu-parent").click(function(){
        var open = $(this).data('open');
        if(open == 0) {
            $(this).children('ul').slideDown('fast');
            $(this).data('open', 1);
        } else {
            $('ul', this).slideUp('fast');
            $(this).data('open', 0);
        }
    });
    $(".core-menu li.dropdown-item").hover(
        function(){
            //i used the parent ul to show submenu
            $(this).children('ul').slideDown('fast');
            $(this).children('ul').find('.dropdown3').css('display', 'block');
        },
        //when the cursor away
        function () {
            $('ul', this).slideUp('fast');
        }
    );
    //this feature only show on 600px device width
    $(".hamburger-menu").click(function(){
        $(".burger-1, .burger-2, .burger-3").toggleClass("open");
        $(".core-menu").slideToggle("fast");
    });
});


/* Mobile */
$(document).ready(function() {

    // Abrimos el modal con el boton default
    $('#header .header-nav #menu-icon').replaceWith('<span class="open_dbmenu" data-toggle="modal" data-target="#dbmenu_burger">\n' +
        '                <i class="material-icons">menu</i>' +
        '            </span>');

    // Variable declaration...
    var left, width, newLeft;

    // Add the "top-menu" class to the top level ul...
    $('.dbmobile-menu').children('ul').addClass('top-menu');

    // Add buttons to items that have submenus...
    $('.has_child_menu').append('<button class="arrow principal"><i class="material-icons">chevron_right</i></button>');
    //$('.has_child_menu').append('<button class="arrow principal"><i class="material-icons"></i></button>');

    // Mobile menu toggle functionality
    $('#mobile__menu').on('click', function() {

        // Cambiamos la hamburguesa
        $(this).toggleClass('open');

        // Modificamos el alto del menu ajustandolo al alto del dispositivo
        $('.dbmenu-complete').css('height', $(window).height());

        // Modificamos el alto y ancho del fondo del menu
        //$('.dbmobile').css("min-height", "1500");
        $('.dbmobile').css({ 'min-height': '1500px', 'width': '100%' });

        // Detect whether the mobile menu is being displayed...
        display = $('.dbmobile-menu').css("display");

        if (display === 'none') {

            // Bloqueamos el body para que no se pueda hacer scroll
            $('body').css('overflow', 'hidden');

            // Mostramos el boton de cerrar
            $('.dbmobile-controls').show();

            // Display the menu...
            $('.dbmobile-menu').css("display", "block");
            $('.dbmobile__info').css("display", "block");
            $('.dbmobile__title').css("display", "none");
            $('.menu-toggle i').css("background", "transparent");

            $('.dbmobile-controls').addClass("right");
            $('.dbmobile').addClass("open");

        } else {

            // Desbloqueamos el body para que se pueda hacer scroll
            $('body').css('overflow', '');

            // Mostramos el boton de cerrar
            $('.dbmobile-controls').hide();

            // Hide the mobile menu...
            $('.dbmobile-menu').css("display", "none");
            $('.dbmobile__info').css("display", "none");
            $('.dbmobile__title').css("display", "block");
            $('.menu-toggle i').css("background", "#999");

            // and reset the mobile menu...
            $('.current-menu').removeClass('current-menu');
            $('.top-menu').css("left", "0");
            $('.back-button').css("display", "none");
            $('.dbmobile-controls').removeClass("right");
            $('.dbmobile').removeClass("open");

            $('.dbmobile').css({ 'min-height': '', 'width': '' });
        }
    });

    // Cerramos el menu
    $('.menu-toggle').on('click', function() {

        // Cambiamos la hamburguesa
        $(this).toggleClass('open');

        // Modificamos el alto del menu ajustandolo al alto del dispositivo
        $('.dbmenu-complete').css('height', $(window).height());

        // Modificamos el alto y ancho del fondo del menu
        //$('.dbmobile').css("min-height", "1500");
        $('.dbmobile').css({ 'min-height': '1500px', 'width': '100%' });

        // Detect whether the mobile menu is being displayed...
        display = $('.dbmobile-menu').css("display");

        if (display === 'none') {

            // Bloqueamos el body para que no se pueda hacer scroll
            $('body').css('overflow', 'hidden');

            // Mostramos el boton de cerrar
            $('.dbmobile-controls').show();

            // Display the menu...
            $('.dbmobile-menu').css("display", "block");
            $('.dbmobile__info').css("display", "block");
            $('.dbmobile__title').css("display", "none");
            $('.menu-toggle i').css("background", "transparent");

            $('.dbmobile-controls').addClass("right");
            $('.dbmobile').addClass("open");

        } else {

            // Desbloqueamos el body para que se pueda hacer scroll
            $('body').css('overflow', '');

            // Mostramos el boton de cerrar
            $('.dbmobile-controls').hide();

            // Hide the mobile menu...
            $('.dbmobile-menu').css("display", "none");
            $('.dbmobile__info').css("display", "none");
            $('.dbmobile__title').css("display", "block");
            $('.menu-toggle i').css("background", "#999");

            // and reset the mobile menu...
            $('.current-menu').removeClass('current-menu');
            $('.top-menu').css("left", "0");
            $('.back-button').css("display", "none");
            $('.dbmobile-controls').removeClass("right");
            $('.dbmobile').removeClass("open");

            $('.dbmobile').css({ 'min-height': '', 'width': '' });
        }
    });

    // Functionality to reveal the submenus...
    $('.arrow').on('click', function() {

        // The .current-menu will no longer be current, so remove that class...
        $('.current-menu').removeClass('current-menu');
        //$("#current-menu").remove();



        // Turn on the display property of the child menu
        $(this).siblings('ul').css("display", "block").addClass('current-menu');
        $(this).siblings('ul').attr('id', 'current-menu');


        left = parseFloat($('.dbmobile div > ul').css("left"));
        width = Math.round($('.dbmobile div > ul').width());
        newLeft = left - width;

        // Slide the new menu leftwards (into the .dbmobile viewport)...
        $('.top-menu').css("left", newLeft);

        // Also display the "back button" (if it is hidden)...
        if ($('.back-button').css("display") === "none") {
            $('.back-button').css("display", "inline-block");
        }

        setTimeout(function() {
            //alto = document.getElementById('current-menu').offsetHeight;
            $('#dbmobile-menu').find('ul').each(function() {
                activoo = $(this).attr('style');
                if (activoo == 'left: 0px;') {
                    alto = $(this).height();
                } else if (activoo == 'display: block;') {
                    alto = $(this).height();
                }
            });
            $('.dbmobile-menu').css("height", alto);
            //console.log(alto);
        }, 500);

    });

    // Functionality to return to parent menus...
    $('.back-button').on('click', function() {

        // Hide the back button (if the current menu is the top menu)...
        if ($('.current-menu').parent().parent().hasClass('top-menu')) {
            $('.back-button').css("display", "none");
        }

        // Ponemos min-with auto
        var element = document.getElementById('dbmobile-menu');
        element.style.removeProperty("min-height");
        document.getElementById('current-menu').setAttribute('id', 'atras');

        left = parseFloat($('.dbmobile div > ul').css("left"));
        width = Math.round($('.dbmobile div > ul').width());
        newLeft = left + width;

        // Allow 0.25 seconds for the css transition to finish...
        /*  window.setTimeout(function () {

            // Hide the out-going .current-menu...
            $('.current-menu').css("display", "none");

            // Add the .current-menu to the new current menu...
            $('.current-menu').parent().parent().addClass('current-menu');

            // Remove the .current-menu class from the out-going submenu...
            $('.current-menu .current-menu').removeClass('current-menu');

          }, 0); */

        // Hide the out-going .current-menu...
        $('.current-menu').css("display", "none");

        // Add the .current-menu to the new current menu...
        $('.current-menu').parent().parent().addClass('current-menu');

        // Remove the .current-menu class from the out-going submenu...
        $('.current-menu .current-menu').removeClass('current-menu');

        // Slide the new menu leftwards (into the .dbmobile viewport)...
        $('.top-menu').css("left", newLeft);


        $('#dbmobile-menu').find('ul').each(function() {
            activoo = $(this).attr('style');
            if (activoo == 'left: 0px;') {
                alto = $(this).height();
            } else if (activoo == 'display: block;') {
                alto = $(this).height();
            }
        });

        $('.dbmobile-menu').css("height", alto);

    });


    /* Menu new */
    $('.open_subitems').on("click", function(){
       var subitem = $(this).attr('data-subitem');
       $('.' + subitem).css("transform", "initial");
       $('.dbmenu_primary').css('display', 'none');
    });

    $('.dbmenu_back').on("click", function(){
        var subitem = $(this).attr('data-subitem');
        $('.' + subitem).css("transform", "translateX(-100vw)");
        //$('.dbmenu_primary').css('display', 'block');
        $(this).parent('.subitems').parent('.modal-body').children('.dbmenu_primary').css('display', 'block');
    });

});