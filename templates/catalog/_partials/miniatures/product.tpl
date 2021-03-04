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
{block name='product_miniature_item'}
<div>
  <article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}">
    <div class="thumbnail-container">
      {block name='product_thumbnail'}
        <a href="{$product.url}" class="thumbnail product-thumbnail">
          {if $product.cover}
            <img
              src="{$product.cover.bySize.home_default.url}"
              alt="{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name}{/if}"
              data-full-size-image-url="{$product.cover.large.url}"
              loading="lazy"
              width="{$product.cover.bySize.home_default.width}"
              height="{$product.cover.bySize.home_default.height}"
              />
          {else}
            <img
                src="{$urls.no_picture_image.bySize.home_default.url}"
                loading="lazy"
                width="{$product.cover.bySize.home_default.width}"
                height="{$product.cover.bySize.home_default.height}"
            />
          {/if}

          {block name='product_name'}
            <p class="h3 product-title">{$product.name}</p>
          {/block}
        </a>
      {/block}

      <div class="product-description">


        {block name='product_price_and_shipping'}
          {if $product.show_price}
            <div class="product-price-and-shipping">

              <span class="price" aria-label="{l s='Price' d='Shop.Theme.Catalog'}">{$product.price}</span>

              {if $product.has_discount}
                {hook h='displayProductPriceBlock' product=$product type="old_price"}

                <span class="regular-price" aria-label="{l s='Regular price' d='Shop.Theme.Catalog'}">{$product.regular_price}</span>
                {if $product.discount_type === 'percentage'}
                  <span class="discount-percentage discount-product">{$product.discount_percentage}</span>
                {elseif $product.discount_type === 'amount'}
                  <span class="discount-amount discount-product">{$product.discount_amount_to_display}</span>
                {/if}
              {/if}

              {hook h='displayProductPriceBlock' product=$product type="before_price"}

              {hook h='displayProductPriceBlock' product=$product type='unit_price'}

              {hook h='displayProductPriceBlock' product=$product type='weight'}
            </div>
          {/if}
        {/block}

        {block name='product_reviews'}
          {hook h='displayProductListReviews' product=$product}
        {/block}

          {if !$product.add_to_cart_url}
            <div class="add">
              <button class="btn btn-primary add-to-cart-category datatext" datatext="{$product.url|base64_encode}">
                  {l s='View more' d='Shop.Theme.Actions'}
              </button>
            </div>
          {else}
              <form action="{$urls.pages.cart}" method="post" id="add-to-cart-or-refresh">
                  <input type="hidden" name="token" value="{$static_token}">
                  <input type="hidden" name="id_product" value="{$product.id}" id="product_page_product_id">
                  <input type="hidden" name="id_customization" value="0" id="product_customization_id">
                  <div class="add">
                      <button
                              class="btn btn-primary add-to-cart-category"
                              data-button-action="add-to-cart"
                              type="submit"
                              {if !$product.add_to_cart_url}
                                  disabled
                              {/if}
                      >
                          <i class="material-icons">add_shopping_cart</i>
                          {l s='Add' d='Shop.Theme.Actions'}
                      </button>
                  </div>
              </form>
          {/if}
      </div>

      {include file='catalog/_partials/product-flags.tpl'}


    </div>
  </article>
</div>
{/block}
