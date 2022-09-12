/**
* 2007-2022 PrestaShop
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
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

function saveWishlist(id_product) {
    var active = $('.dbwishlist_checkbox').is(":checked");

    requestData = {
        id_product: id_product,
        active: active,
        action: 'saveWishlist',
    };

    $.ajax({
        url: dbwishlist_ajax,
        type: 'POST',
        data: requestData,
        dataType: 'json',
        success: function(response) {
            $( '#WishlistModal' ).remove();
            $('body').append(response.modal);
            $('#WishlistModal').modal('show');
        }
    });
}

$('.delete_wishlist').on('click', function(){
    var id_product = $(this).data('idproduct');
    // borramos el producto
    $(this).parent('.wishlist_product').remove();

    requestData = {
        id_product: id_product,
        action: 'removeWishlist',
    };

    $.ajax({
        url: dbwishlist_ajax,
        type: 'POST',
        data: requestData,
        dataType: 'json',
        success: function(response) {
            $( '#WishlistModal' ).remove();
            // $('body').append(response.modal);
            // $('#WishlistModal').modal('show');
        }
    });
});

$('.delete_wishlist_cart').on('click', function(){
    var id_product = $(this).data('idproduct');
    // borramos el producto
    // $(this).parent('.product-actions').parent('.product-miniature-horizontal').remove();
    $(this).parent('div').remove();

    requestData = {
        id_product: id_product,
        action: 'removeWishlist',
    };

    $.ajax({
        url: dbwishlist_ajax,
        type: 'POST',
        data: requestData,
        dataType: 'json',
        success: function(response) {
            $( '#WishlistModal' ).remove();
            $('body').append(response.modal);
            $('#WishlistModal').modal('show');
        }
    });
});

$('.fav_list').on('click', function(){
    var hearth = $(this);
    var id_product = $(this).data('idproduct');
    var active = $(this).data('active');

    requestData = {
        id_product: id_product,
        active: active,
        action: 'saveWishlist',
    };

    $.ajax({
        url: dbwishlist_ajax,
        type: 'POST',
        data: requestData,
        dataType: 'json',
        success: function(response) {
            hearth.addClass('hidden');
            if(active == 1){
                hearth.prev('.fav_list').removeClass('hidden');
            } else {
                hearth.next('.fav_list').removeClass('hidden');
            }

            $( '#WishlistModal' ).remove();
            $('body').append(response.modal);
            $('#WishlistModal').modal('show');
        }
    });
});

$('.add_wishlist_itemcart').on('click', function(){
    var id_product = $(this).data('idproduct');
    var id_product_attribute = $(this).data('idproductattribute');
    var active = 1;
    var token = prestashop.static_token;

    requestData = {
        id_product: id_product,
        active: active,
        action: 'saveWishlist',
    };

    $.ajax({
        url: dbwishlist_ajax,
        type: 'POST',
        data: requestData,
        dataType: 'json',
        success: function(response) {
            var link_remove = prestashop.urls.pages.cart + '?delete=1&id_product=' + id_product + '&id_product_attribute=' + id_product_attribute + '&token=' + token;
            window.location.href = link_remove;
        }
    });
});
