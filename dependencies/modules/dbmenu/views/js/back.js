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

$(document).ready(function() {
    var opt = jQuery("#type_selected").val();
    if ( opt == "category" ) {
        $('#fieldset_0 .form-wrapper').children('.form-group').slice(4,5).show();
        $('#fieldset_0 .form-wrapper').children('.form-group').slice(5,6).hide();
        $('#fieldset_0 .form-wrapper').children('.form-group').slice(6,7).show();
        $('#fieldset_0 .form-wrapper').children('.form-group').slice(7,8).show();
        $('#fieldset_0 .form-wrapper').children('.form-group').slice(9,10).show();
    } else if(opt == "url") {
        $('#fieldset_0 .form-wrapper').children('.form-group').slice(4,5).hide();
        $('#fieldset_0 .form-wrapper').children('.form-group').slice(5,6).show();
        $('#fieldset_0 .form-wrapper').children('.form-group').slice(6,7).show();
        $('#fieldset_0 .form-wrapper').children('.form-group').slice(7,8).show();
        $('#fieldset_0 .form-wrapper').children('.form-group').slice(9,10).show();
    } else if(opt == "separator") {
        $('#fieldset_0 .form-wrapper').children('.form-group').slice(4,5).hide();
        $('#fieldset_0 .form-wrapper').children('.form-group').slice(5,6).hide();
        $('#fieldset_0 .form-wrapper').children('.form-group').slice(6,7).hide();
        $('#fieldset_0 .form-wrapper').children('.form-group').slice(7,8).hide();
        $('#fieldset_0 .form-wrapper').children('.form-group').slice(9,10).hide();
    }


    $("#type_selected").on('change', function(e) {
        opt = jQuery("#type_selected").val();
        if ( opt == "category" ) {
            $('#fieldset_0 .form-wrapper').children('.form-group').slice(4,5).show();
            $('#fieldset_0 .form-wrapper').children('.form-group').slice(5,6).hide();
            $('#fieldset_0 .form-wrapper').children('.form-group').slice(6,7).show();
            $('#fieldset_0 .form-wrapper').children('.form-group').slice(7,8).show();
            $('#fieldset_0 .form-wrapper').children('.form-group').slice(9,10).show();
        } else if(opt == "url") {
            $('#fieldset_0 .form-wrapper').children('.form-group').slice(4,5).hide();
            $('#fieldset_0 .form-wrapper').children('.form-group').slice(5,6).show();
            $('#fieldset_0 .form-wrapper').children('.form-group').slice(6,7).show();
            $('#fieldset_0 .form-wrapper').children('.form-group').slice(7,8).show();
            $('#fieldset_0 .form-wrapper').children('.form-group').slice(9,10).show();
        } else if(opt == "separator") {
            $('#fieldset_0 .form-wrapper').children('.form-group').slice(4,5).hide();
            $('#fieldset_0 .form-wrapper').children('.form-group').slice(5,6).hide();
            $('#fieldset_0 .form-wrapper').children('.form-group').slice(6,7).hide();
            $('#fieldset_0 .form-wrapper').children('.form-group').slice(7,8).hide();
            $('#fieldset_0 .form-wrapper').children('.form-group').slice(9,10).hide();
        }
    });

    // Importar categorias
    $(document).on('click', '#imports_categories', function () {
        var del = $('#delete_menu option:selected').val()
        importCategory(del);
    });

    // Inputs switch PRO
    $(":disabled").parents('.switch').parents('div').parents('.form-group').addClass("group_pro");
    $(":disabled").parents('.switch').parents('div').parents('.form-group').append('<span class="pro_tag">PRO</span>');
    // Inputs color PRO
    /*$("input.disabled").parents('.input-group').parents('div').parents('div').parents('div').parents('div').parents('.form-group').addClass("group_pro");
    $("input.disabled").parents('.input-group').parents('div').parents('div').parents('div').parents('div').parents('.form-group').append('<span class="pro_tag">PRO</span>');*/
    // Inputs text lang PRO
    /*$("input.disabled").parents('div').parents('div').parents('div').parents('div').parents('div').parents('.form-group').addClass("group_pro");
    $("input.disabled").parents('div').parents('div').parents('div').parents('div').parents('div').parents('.form-group').append('<span class="pro_tag">PRO</span>');*/
    // Inputs text PRO
    $("input.disabled").parents('.form-group').addClass("group_pro");
    $("input.disabled").parents('.form-group').append('<span class="pro_tag">PRO</span>');

});


// Importar
function importCategory(del) {
    $('#imports_categories').prop("disabled", true);
    $('.import_loading').css('display', 'block');
    requestData = {
        action: 'import_category',
        borrar: del,
    };
    $.ajax({
        url: dbmenu_ajax,
        type: 'POST',
        data: requestData,
        dataType: 'json',
        success: function (response) {
            if(response.success == true){
                $('#imports_categories').prop("disabled", false);
                $('.import_loading').css('display', 'none');
                $('.import_ok').css('display', 'block');
            } else {
                $('#imports_categories').prop("disabled", false);
                $('.import_loading').css('display', 'none');
                $('.import_ko').css('display', 'block');
            }
        }
    });
}