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
<div id="blockcart-modal" class="modal fade right" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
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
                    <img class="product-image" src="{$product.default_image.medium.url}" alt="{$product.cover.legend}"
                      title="{$product.cover.legend}" itemprop="image">
                  {else}
                    <img class="product-image" src="{$product.cover.medium.url}" alt="{$product.cover.legend}"
                      title="{$product.cover.legend}" itemprop="image">
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
                  <div class="product_action">
                    <span class="product-quantity">{l s='Cant' d='Shop.Theme.Global'}: {$product.cart_quantity}</span>
                    <span class="product-price">{$product.price}</span>
                  </div>
                </div>
              </div>
            </div>
          {/foreach}
        </div>
        <div class="modal_totals">
          <div class="cart-content">
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