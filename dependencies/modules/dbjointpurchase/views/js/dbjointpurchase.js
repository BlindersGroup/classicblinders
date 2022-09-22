/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    DevBlinders <soporte@devblinders.com>
 * @copyright Copyright (c) DevBlinders
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

$( document ).ready(function() {

    // Show products to joint
    $(document).on('click', '.change_product', function(){
        var id_product = $(this).data('idproduct');
        var id_category = $(this).data('idcategory');
        var key = $(this).data('key');
        var best_product = $(this).parent('.productjoint_content').parent('.joint_product').data('bestproduct');

        requestData = {
            id_product: id_product,
            id_category: id_category,
            key: key,
            best_product: best_product,
            action: 'show_products',
        };

        $.ajax({
            url: dbjointpurchase_ajax,
            type: 'POST',
            data: requestData,
            dataType: 'json',
            success: function(response) {
                $( '#jointModal' ).remove();
                $('body').append(response.modal);
                $('#jointModal').modal('show');
            }
        });
    });

    // Change products
    $(document).on('click', '.joint_select', function(){
        var id_product = $(this).data('idproduct');
        var key = $(this).data('key');

        requestData = {
            id_product: id_product,
            key: key,
            action: 'change_product',
        };

        $.ajax({
            url: dbjointpurchase_ajax,
            type: 'POST',
            data: requestData,
            dataType: 'json',
            success: function(response) {
                $('.block_joint_' + key).html(response.product);
                $('#jointModal').modal('toggle');
                var precio = jointPrice();
                $('.dbjointpurchase_footer .regular_price').html(precio);
            }
        });
    });

    // Precio total conjunto
    function jointPrice() {
        var precio = 0;
        $( ".dbjointpurchase_product.active" ).each(function( index ) {
            precio += $(this).find('.price_product').data('price');
        });
        return precio.toFixed(2).toString().replace(".", ",") + ' ' + prestashop.currency.sign;
    }

    // Productos total conjunto
    function jointProducts() {
        var products = 0;
        $( ".dbjointpurchase_product.active" ).each(function( index ) {
            products += 1;
        });
        return products.toFixed(0);
    }

    // Control checkbox product
    $(document).on('click', '.dbjointpurchase_product .custom-checkbox', function() {
        var checked = $(this).children('#checkjoint:checked').length;
        if(checked == 0){
            $(this).parent('.facet-label').parent('.productjoint_check').parent('.name_product').parent('.productjoint_content').parent('.dbjointpurchase_product').removeClass('active');
        } else {
            $(this).parent('.facet-label').parent('.productjoint_check').parent('.name_product').parent('.productjoint_content').parent('.dbjointpurchase_product').addClass('active');
        }

        var products = jointProducts();
        $('.dbjointpurchase_footer .num_products .num').html(products);
        var precio = jointPrice();
        $('.dbjointpurchase_footer .regular_price').html(precio);
    });

    // Add to cart
    $('#btn_dbjointpurchase').click(function() {
        var form = $('#add-to-cart-or-refresh');
        $( ".dbjointpurchase_product.active" ).each(function( index ) {
            var id_product = $(this).find('#checkjoint').val();
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                dataType : 'json',
                data: {
                    token: form.find('input[name="token"]').val(),
                    id_product: id_product,
                    id_customization: 0,
                    qty: 1,
                    add: 1,
                    action: 'update',
                },
                success: function(resp) {
                    prestashop.emit('updatedCart', {eventType: 'updateCart', resp});
                }
            });
        });
        refreshBasket(1);
    });

    // Open modal cart
    function refreshBasket(items) {
        var refreshURL = $('.blockcart').data('refresh-url');
        requestData = {
            id_product_attribute: 0,
            id_product: 0,
            action: 'add-to-cart'
        };
        $.post(refreshURL, requestData).then(function(resp) {

            $('.blockcart').replaceWith($(resp.preview).find('.blockcart'));
            if (resp.modal) {
                // No mostramos el modal por defecto de presta
                // showModal(resp.modal);

                // Cambiamos el boton a añadido
                productsAdd();
            }
        }).fail(function(resp) {
            prestashop.emit('handleError', { eventType: 'updateShoppingCart', resp: resp });
        });
    }
    var showModal = prestashop.blockcart.showModal || function(modal) {
        var $body = $('body');
        $body.append(modal);
        $body.one('click', '#blockcart-modal', function(event) {
            if (event.target.id === 'blockcart-modal') {
                $(event.target).remove();
            }
        });
    };

    // Change button products add
    function productsAdd() {
        $("#btn_dbjointpurchase").addClass("complete");
        $("#btn_dbjointpurchase").attr("disabled","disabled");
    }

});
