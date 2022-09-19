/**
 * 2007-2020 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

/**
 * This module exposes an extension point through `showModal` function.
 *
 * If you want to customize the way the modal window is displayed, you need to do:
 *
 * prestashop.blockcart = prestashop.blockcart || {};
 * prestashop.blockcart.showModal = function myOwnShowModal (modalHTML) {
 *   // your own code
 *   // please not that it is your responsibility to handle the modal "close" behavior
 * };
 *
 * Warning: your custom JavaScript needs to be included **before** this file.
 * The safest way to do so is to place your "override" inside the theme main JavaScript file.
 *
 */

$(document).ready(function () {
  prestashop.blockcart = prestashop.blockcart || {};

  var showModal = prestashop.blockcart.showModal || function (modal) {
    var $body = $('body');
    $body.append(modal);
    $body.one('click', '#blockcart-modal', function (event) {
      if (event.target.id === 'blockcart-modal') {
        $(event.target).remove();
      }
    });
  };

  prestashop.on(
    'updateCart',
    function (event) {
      var refreshURL = $('.blockcart').data('refresh-url');
      var requestData = {};
      if (event && event.reason && typeof event.resp !== 'undefined' && !event.resp.hasError) {
        requestData = {
          id_customization: event.reason.idCustomization,
          id_product_attribute: event.reason.idProductAttribute,
          id_product: event.reason.idProduct,
          action: event.reason.linkAction
        };
      }
      if (event && event.resp && event.resp.hasError) {
        prestashop.emit('showErrorNextToAddtoCartButton', { errorMessage: event.resp.errors.join('<br/>')});
      }
      $.post(refreshURL, requestData).then(function (resp) {
        var html = $('<div />').append($.parseHTML(resp.preview));
        $('.blockcart').replaceWith($(resp.preview).find('.blockcart'));
        if (resp.modal) {
          showModal(resp.modal);
        }
      }).fail(function (resp) {
        prestashop.emit('handleError', { eventType: 'updateShoppingCart', resp: resp });
      });
    }
  );

  // Up/Down products in modal cart
  $(document).on("click", '#blockcart-modal .btn-touchspin', function () {
    var touchspin = $(this).attr('data-qty');
    var id_product = $(this).parent('.input-group-btn-vertical').attr('data-idproduct');
    var id_product_attribute = $(this).parent('.input-group-btn-vertical').attr('data-idattribute');
    var id_customization = $(this).parent('.input-group-btn-vertical').attr('data-idcustomization');
    var token = prestashop.static_token;

      // Efecto cargando
      const template = `<div class="faceted-overlay">
      <div class="overlay__inner">
      <div class="overlay__content"><span class="spinner"></span></div>
      </div>
      </div>`;
      // $('#btn_inifinitescroll .text').hide();
      $('body').append(template);

      var requestData = {
          token: token,
          id_product: id_product,
          id_product_attribute: id_product_attribute,
          id_customization: id_customization,
          update: 1,
          ajax: 1,
          op: touchspin,
          action: "update"
      };

      $.ajax({
          url: prestashop.urls.pages.cart,
          method: 'POST',
          data: requestData,
          dataType: 'json',
      }).then(function(resp) {
          $('#blockcart-modal .qty_' + id_product + '_' + id_product_attribute).val(resp.quantity);
          $('#blockcart-modal .modal-title span').html(resp.cart.products_count);
          $('#blockcart-modal .product-total .value').html(resp.cart.totals.total.value);
          $('#blockcart-modal .subtotals_modal .value').html(resp.cart.totals.total.value);
          $('#blockcart-modal .product-tax .value').html(resp.cart.subtotals.tax.value);
          $('#blockcart-modal .subtotals_shipping .value').html(resp.cart.subtotals.shipping.value);

          $('.faceted-overlay').remove();
      }).fail(function (resp) {
          prestashop.emit('handleError', { eventType: 'updateShoppingCart', resp: resp });

          $('.faceted-overlay').remove();
      });


  });

    // Remove products in modal cart
  $(document).on("click", '#blockcart-modal .delete_product', function () {
      var id_product = $(this).attr('data-idproduct');
      var id_product_attribute = $(this).attr('data-idattribute');
      var token = prestashop.static_token;

      // Efecto cargando
      const template = `<div class="faceted-overlay">
      <div class="overlay__inner">
      <div class="overlay__content"><span class="spinner"></span></div>
      </div>
      </div>`;
      // $('#btn_inifinitescroll .text').hide();
      $('body').append(template);

      var requestData = {
          token: token,
          id_product: id_product,
          id_product_attribute: id_product_attribute,
          delete: 1,
          ajax: 1,
          action: "update"
      };

      $.ajax({
          url: prestashop.urls.pages.cart,
          method: 'POST',
          data: requestData,
          dataType: 'json',
      }).then(function(resp) {
          $('.modal_product_' + id_product + '_' + id_product_attribute).remove();

          $('#blockcart-modal .qty_' + id_product + '_' + id_product_attribute).val(resp.quantity);
          $('#blockcart-modal .modal-title span').html(resp.cart.products_count);
          $('#blockcart-modal .product-total .value').html(resp.cart.totals.total.value);
          $('#blockcart-modal .subtotals_modal .value').html(resp.cart.totals.total.value);
          $('#blockcart-modal .product-tax .value').html(resp.cart.subtotals.tax.value);
          $('#blockcart-modal .subtotals_shipping .value').html(resp.cart.subtotals.shipping.value);

          $('.faceted-overlay').remove();
      }).fail(function (resp) {
          prestashop.emit('handleError', { eventType: 'updateShoppingCart', resp: resp });
          $('.faceted-overlay').remove();
      });
  });

});
