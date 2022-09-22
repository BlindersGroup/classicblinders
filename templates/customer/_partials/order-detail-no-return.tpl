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
{block name='order_products_table'}

  <div class="order-items box">
    {foreach from=$order.products item=product}
      <div class="order-item">
        <div class="row">
          <div class="col-sm-6 desc">
            <img
              class="order-item-img"
              src="{$product.cover.bySize.small_default.url}"
              width="{$product.cover.bySize.small_default.width}"
              height="{$product.cover.bySize.small_default.height}"
            />
            <div class="name">{$product.name}</div>
            {if $product.product_reference}
              <div class="ref">{l s='Reference' d='Shop.Theme.Catalog'}: {$product.product_reference}</div>
            {/if}
            {if $product.customizations}
              {foreach $product.customizations as $customization}
                <div class="customization">
                  <a href="#" data-toggle="modal" data-target="#product-customizations-modal-{$customization.id_customization}">{l s='Product customization' d='Shop.Theme.Catalog'}</a>
                </div>
                <div id="_mobile_product_customization_modal_wrapper_{$customization.id_customization}">
                </div>
              {/foreach}
            {/if}
            <div class="quantity">
              {l s='Quantity' d='Shop.Theme.Catalog'}:
              {if $product.customizations}
                {foreach $product.customizations as $customization}
                  {$customization.quantity}
                {/foreach}
              {else}
                {$product.quantity}
              {/if}
            </div>
          </div>

          <div class="col-sm-6 order_priceproduct">
            <div class="row">
              <div class="col-xs-4 text-sm-left text-xs-left">
                <span class="title">{l s='Unit price' d='Shop.Theme.Catalog'}</span>
                <span class="value">{$product.price}</span>
              </div>
              <div class="col-xs-4 text-xs-left">
                <span class="title">{l s='Total price' d='Shop.Theme.Catalog'}</span>
                <span class="value">{$product.total}</span>
              </div>
              <div class="col-xs-4 col-md-4">
                <a href="{$urls.pages.cart}?add=1&id_product={$product.product_id}&id_product_attribute={$product.product_attribute_id}&token={$static_token}" class="product_reorder"><i class="fa-solid fa-rotate-right"></i> {l s='Reorder' d='Shop.Theme.Actions'}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    {/foreach}
  </div>
{/block}
