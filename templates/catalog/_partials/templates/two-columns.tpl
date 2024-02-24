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

<div class="block_left">
    {if Context::getContext()->isMobile() == 1}
        {block name='page_header_container'}
            {block name='page_header'}
                <h1 class="h1 product_name">{block name='page_title'}{$product.name}{/block}</h1>
            {/block}
        {/block}
    {/if}
    <div class="sticky_product">
        {block name='page_content_container'}
            <section class="page-content" id="content">
                {block name='page_content'}
                    <div class="product_cover_thumbnails">
                        {block name='product_cover_thumbnails'}
                            {include file='catalog/_partials/product-cover-thumbnails.tpl'}
                        {/block}
                    </div>
                    <div class="scroll-box-arrows">
                        <i class="fa-solid fa-angle-left left"></i>
                        <i class="fa-solid fa-angle-right right"></i>
                    </div>

                {/block}
            </section>
        {/block}

        {if Context::getContext()->isMobile() == 0}
            {hook h='displayBlockLeftFooter'}
        {/if}
    </div>

</div>

<div class="block_right">

    <div class="product-information">
        {if Context::getContext()->isMobile() == 1}
            {if isset($product_manufacturer->id)}
                <div class="product-manufacturer">
                    <a href="{$product_brand_url}" class="brand_centercolumn">{$product_manufacturer->name}</a>
                </div>
            {/if}
            <div class="displayProductCenterColumn">
                {hook h='displayProductCenterColumn' product=$product}
            </div>
            {block name='product_description_short'}
                <div id="product-description-short-{$product.id}" class="product-description" itemprop="description">
                    {$product.description_short nofilter}</div>
            {/block}
            {hook h='displayBlockLeftFooter'}

            {block name='product_pack'}
                {if $packItems}
                    <section class="product-pack">
                        <p class="p2">{l s='This pack contains' d='Shop.Theme.Catalog'}</p>
                        {foreach from=$packItems item="product_pack"}
                            {block name='product_miniature'}
                                {include file='catalog/_partials/miniatures/pack-product.tpl' product=$product_pack showPackProductsPrice=$product.show_price}
                            {/block}
                        {/foreach}
                    </section>
                {/if}
            {/block}

            {if $product.is_customizable && count($product.customizations.fields)}
                <div class="product_customization">
                    {block name='product_customization'}
                        {include file="catalog/_partials/product-customization.tpl" customizations=$product.customizations}
                    {/block}
                </div>
            {/if}

            {block name='product_discounts'}
                {include file='catalog/_partials/product-discounts.tpl'}
            {/block}

            {block name='product_attachments'}
                {if $product.attachments}
                    <div class="attachment_top">
                        {foreach from=$product.attachments item=attachment}
                            {assign var=url_attach value="/index.php?controller=attachment&id_attachment={$attachment.id_attachment}"}
                            <span class="attach datatext" datatext="{$url_attach|base64_encode}">
                                <i class="fa-solid fa-download"></i>
                                {$attachment.name}
                            </span>
                        {/foreach}
                    </div>
                {/if}
            {/block}
        {/if}

        <div class="product-actions price_outstanding">

            {if Context::getContext()->isMobile() == 0}
                {if isset($product_manufacturer->id)}
                    <div class="product-manufacturer">
                        <a href="{$product_brand_url}" class="brand_centercolumn">{$product_manufacturer->name}</a>
                    </div>
                {/if}
                {block name='page_header_container'}
                    {block name='page_header'}
                        <h1 class="h1 product_name">{block name='page_title'}{$product.name}{/block}</h1>
                    {/block}
                {/block}
            {/if}

            {block name='product_prices'}
                {include file='catalog/_partials/product-prices.tpl'}
            {/block}

            <div class="displayProductCenterColumn">
                {hook h='displayProductCenterColumn' product=$product}
            </div>

            {if Context::getContext()->isMobile() == 0}
                {block name='product_description_short'}
                    <div id="product-description-short-{$product.id}" class="product-description" itemprop="description">
                        {$product.description_short nofilter}</div>
                {/block}
            {/if}

            {block name='product_buy'}
                <form action="{$urls.pages.cart}" method="post" id="add-to-cart-or-refresh">
                    <input type="hidden" name="token" value="{$static_token}">
                    <input type="hidden" name="id_product" value="{$product.id}" id="product_page_product_id">
                    <input type="hidden" name="id_customization" value="{$product.id_customization}"
                        id="product_customization_id">

                    <div class="product_variants">
                        {block name='product_variants'}
                            {include file='catalog/_partials/product-variants.tpl'}
                        {/block}
                    </div>

                    {hook h='displayProductCenterColumnBottom' product=$product}

                    {if Context::getContext()->isMobile() == 0}
                        {if $product.is_customizable && count($product.customizations.fields)}
                            <div class="product_customization">
                                {block name='product_customization'}
                                    {include file="catalog/_partials/product-customization.tpl" customizations=$product.customizations}
                                {/block}
                            </div>
                        {/if}

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
                                            <i class="fa-solid fa-download"></i>
                                            {$attachment.name}
                                        </span>
                                    {/foreach}
                                </div>
                            {/if}
                        {/block}
                    {/if}

                    <div class="product_add_to_cart">
                        {block name='product_add_to_cart'}
                            {include file='catalog/_partials/product-add-to-cart.tpl'}
                        {/block}
                    </div>

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