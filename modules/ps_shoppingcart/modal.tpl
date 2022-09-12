{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}
<div id="blockcart-modal" class="modal fade right" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="{l s='Close' d='Shop.Theme.Global'}">
          <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
        </button>
        <h4 class="modal-title h6" id="myModalLabel">
          <i class="fa-solid fa-cart-shopping"></i>
          {l s='Mi carrito' d='Shop.Theme.Checkout'}
          <span class="total_products">({$cart.summary_string})</span>
        </h4>
      </div>
      <div class="modal-body">
        {hook h='displayShoppingCart'}
        <div class="modal_products">
          {foreach from=$cart.products item=product}
            <div class="modal_product modal_product_{$product.id}_{$product.id_product_attribute}">
              <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3 modal_products_image">
                  {if $product.default_image}
                    <img class="product-image" src="{$product.default_image.medium.url}" alt="{$product.cover.legend}" title="{$product.cover.legend}" itemprop="image">
                  {else}
                    <img class="product-image" src="{$product.cover.medium.url}" alt="{$product.cover.legend}" title="{$product.cover.legend}" itemprop="image">
                  {/if}
                </div>
                <div class="col-md-9 col-sm-9 col-xs-9 modal_products_info">
                  <div class="product-name">
                    <span class="product-name-value">{$product.name}</span>
                    {foreach from=$product.attributes key="attribute" item="value"}
                      <div class="product-attributes">
                        <span class="label">{$attribute}:</span>
                        <span class="value">{$value}</span>
                      </div>
                    {/foreach}
                  </div>
                  <div class="delete_product" data-idproduct="{$product.id}" data-idattribute="{$product.id_product_attribute}"><i class="fa-regular fa-trash-can"></i></div>
                  <div class="product_action">
                    <div class="input-group bootstrap-touchspin">
                      <span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span>
                      <input type="number" name="qty" id="quantity_wanted" value="{$product.cart_quantity}" class="input-group form-control qty_{$product.id}_{$product.id_product_attribute}" min="1" aria-label="Cantidad" style="display: block;" disabled>
                      <span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span>
                      <span class="input-group-btn-vertical" data-idproduct="{$product.id}" data-idattribute="{$product.id_product_attribute}" data-idcustomization="{$product.id_customization}">
                        <button class="btn btn-touchspin js-touchspin bootstrap-touchspin-up" type="button" data-qty="up"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn btn-touchspin js-touchspin bootstrap-touchspin-down" type="button" data-qty="down"><i class="fa-solid fa-minus"></i></button>
                      </span>
                    </div>
                    <span class="product-price">{$product.price}</span>
                  </div>
                </div>
              </div>
            </div>
          {/foreach}
        </div>
        <div class="modal_totals">
          <div class="cart-content">
            <p class="subtotals_modal">
              <span class="label">{l s='Subtotal:' d='Shop.Theme.Checkout'}</span>&nbsp;
              <span class="value">{$cart.subtotals.products.value}</span>
            </p>
            {if $cart.subtotals.shipping.value}
              <p class="subtotals_shipping"><span>{l s='Shipping:' d='Shop.Theme.Checkout'}</span>&nbsp;<span class="value">{$cart.subtotals.shipping.value} {hook h='displayCheckoutSubtotalDetails' subtotal=$cart.subtotals.shipping}</span></p>
            {/if}

            {if $cart.subtotals.tax}
              <p class="product-tax">{l s='%label%:' sprintf=['%label%' => $cart.subtotals.tax.label] d='Shop.Theme.Global'}&nbsp;<span class="value">{$cart.subtotals.tax.value}</span></p>
            {/if}

            {if !$configuration.display_prices_tax_incl && $configuration.taxes_enabled}
              <p><span>{$cart.totals.total.label}&nbsp;{$cart.labels.tax_short}</span>&nbsp;<span>{$cart.totals.total.value}</span></p>
              <p class="product-total"><span class="label">{$cart.totals.total_including_tax.label}</span>&nbsp;<span class="value">{$cart.totals.total_including_tax.value}</span></p>
            {else}
              <p class="product-total"><span class="label">{$cart.totals.total.label}&nbsp;{if $configuration.taxes_enabled}<span class="small">{$cart.labels.tax_short}</span>{/if}</span>&nbsp;<span class="value">{$cart.totals.total.value}</span></p>
            {/if}

            <div class="cart-content-btn">
              <a href="{$urls.pages.order}" class="btn btn-primary">{l s='Checkout' d='Shop.Theme.Actions'}</a>
              <a href="{$cart_url}" class="btn btn-secondary btn-view-cart">{l s='View cart' d='Shop.Theme.Actions'}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
