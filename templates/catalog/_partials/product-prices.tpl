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
{if $product.show_price}
  <div class="product_prices">
      <div class="product-prices">
        {block name='product_price'}
          <div
            class="product-price {if $product.has_discount}has-discount{/if}"
          >

            <div class="current-price">

                <span class="price_with_tax price_pvp" content="{$product.price_tax_exc}">{$product.price}</span>

                {if !$configuration.taxes_enabled}
                  <span class="price_tax">{l s='No tax' d='Shop.Theme.Catalog'}</span>
                {elseif $configuration.display_taxes_label}
                  <span class="price_tax">{$product.labels.tax_long}</span>
                {/if}

              {if $product.has_discount}
                  <span class="show_pvp">
{*                    <span class="title">{l s='OLD PRICE' d='Shop.Theme.Catalog'}</span>*}
                    <span class="old_price">{$product.regular_price}</span>
                  </span>

                  <span class="show_discount">
{*                      <span class="title">{l s='DTO.' d='Shop.Theme.Catalog'}</span>*}
                    {if $product.discount_type === 'percentage'}
                      <span class="discount discount-percentage">
                          {$product.discount_percentage_absolute}
                      </span>
                    {else}
                      <span class="discount discount-amount">
                          {$product.discount_to_display}
                      </span>
                    {/if}
                  </span>
              {/if}
            </div>

            {block name='product_unit_price'}
              {if $displayUnitPrice}
                <p class="product-unit-price sub">{l s='Precio %unit_price%' d='Shop.Theme.Catalog' sprintf=['%unit_price%' => $product.unit_price_full]}</p>
              {/if}
            {/block}
          </div>
        {/block}

        {block name='product_without_taxes'}
          {if $priceDisplay == 2}
            <p class="product-without-taxes">{l s='%price% tax excl.' d='Shop.Theme.Catalog' sprintf=['%price%' => $product.price_tax_exc]}</p>
          {/if}
        {/block}

        {block name='product_pack_price'}
          {if $displayPackPrice}
            <p class="product-pack-price"><span>{l s='Instead of %price%' d='Shop.Theme.Catalog' sprintf=['%price%' => $noPackPrice]}</span></p>
          {/if}
        {/block}

        {block name='product_ecotax'}
          {if $product.ecotax.amount > 0}
            <p class="price-ecotax">{l s='Including %amount% for ecotax' d='Shop.Theme.Catalog' sprintf=['%amount%' => $product.ecotax.value]}
              {if $product.has_discount}
                {l s='(not impacted by the discount)' d='Shop.Theme.Catalog'}
              {/if}
            </p>
          {/if}
        {/block}

        {hook h='displayProductPriceBlock' product=$product type="weight" hook_origin='product_sheet'}

        <div class="tax-shipping-delivery-label">

          {hook h='displayProductPriceBlock' product=$product type="price"}
          {hook h='displayProductPriceBlock' product=$product type="after_price"}

          <div class="available_stock {$product.availability}">
            {block name='product_availability'}
                <span id="product-availability">
                    {if $product.show_availability && $product.availability_message}
                        {if $product.availability == 'available'}
                            <i class="fa-regular fa-circle-check"></i>
                        {elseif $product.availability == 'last_remaining_items'}
                            <i class="fa-solid fa-arrow-trend-down"></i>
                        {else}
                            <i class="fa-solid fa-circle-info"></i>
                        {/if}
                        {$product.availability_message}
                    {/if}
                </span>
            {/block}
            {if $product.additional_delivery_times == 1}
                {if $product.delivery_information}
                  <span class="delivery-information">{$product.delivery_information}</span>
                {/if}
            {elseif $product.additional_delivery_times == 2}
                {if $product.quantity > 0}
                  <span class="delivery-information">{$product.delivery_in_stock}</span>
                {* Out of stock message should not be displayed if customer can't order the product. *}
                {elseif $product.quantity <= 0 && $product.add_to_cart_url}
                  <span class="delivery-information">{$product.delivery_out_stock}</span>
                {/if}
            {/if}
          </div>
        </div>

      </div>
  </div>
{/if}
