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
{extends file=$layout}

{block name='head_seo' prepend}
  <link rel="canonical" href="{$product.canonical_url}">
{/block}

{block name='head' append}
  <meta property="og:type" content="product">
  <meta property="og:url" content="{$urls.current_url}">
  <meta property="og:title" content="{$page.meta.title}">
  <meta property="og:site_name" content="{$shop.name}">
  <meta property="og:description" content="{$page.meta.description}">
  <meta property="og:image" content="{$product.cover.large.url}">
  {if $product.show_price}
    <meta property="product:pretax_price:amount" content="{$product.price_tax_exc}">
    <meta property="product:pretax_price:currency" content="{$currency.iso_code}">
    <meta property="product:price:amount" content="{$product.price_amount}">
    <meta property="product:price:currency" content="{$currency.iso_code}">
  {/if}
  {if isset($product.weight) && ($product.weight != 0)}
  <meta property="product:weight:value" content="{$product.weight}">
  <meta property="product:weight:units" content="{$product.weight_unit}">
  {/if}
{/block}

{block name='content'}

</div>
</div>
    <div class="product_topview">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    {if Context::getContext()->isMobile() == 1}
                        {block name='page_header_container'}
                            {block name='page_header'}
                                <h1 class="h1 product_name" >{block name='page_title'}{$product.name}{/block}</h1>
                            {/block}
                        {/block}
                    {/if}
                    {block name='page_content_container'}
                        <section class="page-content" id="content">
                            {block name='page_content'}
                                {include file='catalog/_partials/product-flags.tpl'}

                                {block name='product_cover_thumbnails'}
                                    {include file='catalog/_partials/product-cover-thumbnails.tpl'}
                                {/block}
                                <div class="scroll-box-arrows">
                                    <i class="material-icons left">&#xE314;</i>
                                    <i class="material-icons right">&#xE315;</i>
                                </div>

                            {/block}
                        </section>
                    {/block}
                </div>
                <div class="col-md-5">
                    {if Context::getContext()->isMobile() == 0}
                        {block name='page_header_container'}
                            {block name='page_header'}
                                <h1 class="h1 product_name" >{block name='page_title'}{$product.name}{/block}</h1>
                            {/block}
                        {/block}
                    {/if}
                    {if isset($product_manufacturer->id)}
                        <div class="product-manufacturer">
                            {if isset($manufacturer_image_url)}
                                <a href="{$product_brand_url}" class="brand_centercolumn">
                                    <img src="{$manufacturer_image_url}" class="img img-thumbnail manufacturer-logo" alt="{$product_manufacturer->name}" loading="lazy" width="32" height="32">
                                </a>
                            {else}
                                <a href="{$product_brand_url}" class="brand_centercolumn">{$product_manufacturer->name}</a>
                            {/if}
                        </div>
                    {/if}
                    {hook h='displayProductCenterColumn' product=$product}
                    {block name='product_description_short'}
                        <div id="product-description-short-{$product.id}" class="product-description" itemprop="description">{$product.description_short nofilter}</div>
                    {/block}
                    {if $product.is_customizable && count($product.customizations.fields)}
                        {block name='product_customization'}
                            {include file="catalog/_partials/product-customization.tpl" customizations=$product.customizations}
                        {/block}
                    {/if}

                    {hook h='displayProductCenterColumnBottom' product=$product}

                    {block name='product_discounts'}
                        {include file='catalog/_partials/product-discounts.tpl'}
                    {/block}

                    {block name='product_pack'}
                        {if $packItems}
                            <section class="product-pack">
                                <p class="h4">{l s='This pack contains' d='Shop.Theme.Catalog'}</p>
                                {foreach from=$packItems item="product_pack"}
                                    {block name='product_miniature'}
                                        {include file='catalog/_partials/miniatures/pack-product.tpl' product=$product_pack showPackProductsPrice=$product.show_price}
                                    {/block}
                                {/foreach}
                            </section>
                        {/if}
                    {/block}

                    {block name='product_attachments'}
                        {if $product.attachments}
                            <div class="attachment_top">
                                {foreach from=$product.attachments item=attachment}
                                    {assign var=url_attach value="/index.php?controller=attachment&id_attachment={$attachment.id_attachment}"}
                                    <span class="attach datatext" datatext="{$url_attach|base64_encode}">
                                        <i class="material-icons">file_download</i>
                                        {$attachment.name}
                                    </span>
                                {/foreach}
                            </div>
                        {/if}
                    {/block}
                </div>
                <div class="col-md-3">
                    <div class="product-information">
                        <div class="product-actions price_outstanding">

                            {block name='product_prices'}
                                {include file='catalog/_partials/product-prices.tpl'}
                            {/block}

                            {block name='product_buy'}
                                <form action="{$urls.pages.cart}" method="post" id="add-to-cart-or-refresh">
                                    <input type="hidden" name="token" value="{$static_token}">
                                    <input type="hidden" name="id_product" value="{$product.id}" id="product_page_product_id">
                                    <input type="hidden" name="id_customization" value="{$product.id_customization}" id="product_customization_id">

                                    {block name='product_variants'}
                                        {include file='catalog/_partials/product-variants.tpl'}
                                    {/block}

                                    {block name='product_add_to_cart'}
                                        {include file='catalog/_partials/product-add-to-cart.tpl'}
                                    {/block}

                                    {* Input to refresh product HTML removed, block kept for compatibility with themes *}
                                    {block name='product_refresh'}{/block}
                                </form>
                            {/block}

                            {block name='product_additional_info'}
                                {include file='catalog/_partials/product-additional-info.tpl'}
                            {/block}
                        </div>

                        {block name='hook_display_reassurance'}
                            {hook h='displayReassurance'}
                        {/block}
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="container">
<div id="content-wrapper">
  <section id="main">

    <div class="row product-container">

      <div class="col-md-12">

      </div>

        {* Parte inferior del producto*}

        {* ACORDEON *}
        <div class="col-md-12">
            <div class="product-information">
                <div id="accordion">
                    {block name='product_tabs'}
                        {if $product.description}
                            <div class="card">
                                <div id="description-info">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#description" aria-expanded="true" aria-controls="description">
                                        {l s='Description' d='Shop.Theme.Catalog'}
                                        <i class="material-icons collapse_down">keyboard_arrow_down</i>
                                        <i class="material-icons collapse_up">keyboard_arrow_up</i>
                                    </button>
                                </div>

                                <div id="description" class="info_content collapse {if $product.description}show in{/if}" aria-labelledby="description-info" data-parent="#accordion">
                                    {block name='product_description'}
                                        <div class="product-description">{$product.description nofilter}</div>
                                    {/block}
                                </div>
                            </div>
                        {/if}
                        <div class="card">
                            <div id="product-details-info">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#product-details" aria-expanded="false" aria-controls="product-details">
                                    {l s='Product Details' d='Shop.Theme.Catalog'}
                                    <i class="material-icons collapse_down">keyboard_arrow_down</i>
                                    <i class="material-icons collapse_up">keyboard_arrow_up</i>
                                </button>
                            </div>
                            <div id="product-details" class="info_content collapse {if !$product.description}show in{/if}" aria-labelledby="product-details-info" data-parent="#accordion">
                                {block name='product_details'}
                                    {include file='catalog/_partials/product-details.tpl'}
                                {/block}
                            </div>
                        </div>
                        {foreach from=$product.extraContent item=extra key=extraKey}
                            <div class="card">
                                <div id="extra-info-{$extraKey}">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#extra-{$extraKey}" aria-expanded="false" aria-controls="extra-{$extraKey}">
                                        {$extra.title}
                                        <i class="material-icons collapse_down">keyboard_arrow_down</i>
                                        <i class="material-icons collapse_up">keyboard_arrow_up</i>
                                    </button>
                                </div>
                                <div id="extra-{$extraKey}" class="info_content collapse" aria-labelledby="extra-info-{$extraKey}" data-parent="#accordion">
                                    {$extra.content nofilter}
                                </div>
                            </div>
                        {/foreach}

                    {/block}
                </div>
            </div>
        </div>
        {* ACORDEON *}


      </div>
    </div>

    {block name='product_accessories'}
      {if $accessories}
        <section class="product-accessories clearfix">
          <p class="h5 text-uppercase">{l s='You might also like' d='Shop.Theme.Catalog'}</p>
          <div class="products">
            {foreach from=$accessories item="product_accessory" key="position"}
              {block name='product_miniature'}
                {include file='catalog/_partials/miniatures/product.tpl' product=$product_accessory position=$position}
              {/block}
            {/foreach}
          </div>
        </section>
      {/if}
    {/block}

    {block name='product_footer'}
      {hook h='displayFooterProduct' product=$product category=$category}
    {/block}

    {block name='product_images_modal'}
      {include file='catalog/_partials/product-images-modal.tpl'}
    {/block}

    {block name='page_footer_container'}
      <footer class="page-footer">
        {block name='page_footer'}
          <!-- Footer content -->
        {/block}
      </footer>
    {/block}
  </section>

{/block}
