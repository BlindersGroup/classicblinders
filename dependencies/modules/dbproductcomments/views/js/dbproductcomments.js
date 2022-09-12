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
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2021 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 *
 * Don't forget to prefix your containers with your own identifier
 * to avoid any conflicts with others containers.
 */


$( document ).ready(function() {

    $('.dbproductcomments_product_centercolumn').on('click', function (){
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#product-comments-list").offset().top
        }, 1000);
    });

    // Show form comment
    $(document).on('click', '.btn_opinion', function(){
        var id_product = $(this).data('idproduct');

        requestData = {
            id_product: id_product,
            action: 'form_comment',
        };

        $.ajax({
            url: dbproductcomments_ajax,
            type: 'POST',
            data: requestData,
            dataType: 'json',
            success: function(response) {
                $( '#CommentModal' ).remove();
                $('body').append(response.modal);
                $('#CommentModal').modal('show');
            }
        });
    });

    // Show form comment
    $(document).on('click', '.btn_createcomment', function(){
        var id_product = $(this).data('idproduct');
        var id_customer = $(this).data('idcustomer');
        var rate_global = $('input[name=rate_global]:checked').val();
        var charact1 = $('input[name=charact1]:checked').val();
        var charact2 = $('input[name=charact2]:checked').val();
        var charact3 = $('input[name=charact3]:checked').val();
        var recomendacion = $('input[name=recomendacion]:checked').val();
        var title = $('input[name=title_comment]').val();
        var content = $('#CommentModalContent').val();

        if (!title.length) {
            $('.error_title_comment').text('Campo obligatorio');
            return false;
        }
        if (!content.length) {
            $('.error_content_comment').text('Campo obligatorio');
            return false;
        }

        requestData = {
            id_product: id_product,
            id_customer: id_customer,
            rate_global: rate_global,
            charact1: charact1,
            charact2: charact2,
            charact3: charact3,
            recomendacion: recomendacion,
            title: title,
            content: content,
            action: 'create_comment',
        };

        $.ajax({
            url: dbproductcomments_ajax,
            type: 'POST',
            data: requestData,
            dataType: 'json',
            success: function(response) {
                $( '#CommentModal' ).remove();
                $('.modal-backdrop.fade.in').remove();
                $('body').append(response.modal);
                $('#CommentModal').modal('show');
            }
        });
    });

});
