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

{* ACORDEON *}
<div class="product-information">
    <p class="title_info_product">{l s='Información del producto' d='Shop.Theme.Catalog'}</p>
    <div class="card card_product_info">
        {block name='product_tabs'}
            {if $product.description}
                <div id="description" class="info_content">
                    {block name='product_description'}
                        <div class="product-description">{$product.description nofilter}</div>
                    {/block}

                    {block name='product_reference'}
                        {if isset($product.reference_to_display) && $product.reference_to_display neq ''}
                            <div class="product-reference">
                                <label class="label">{l s='Reference' d='Shop.Theme.Catalog'} </label>
                                <span itemprop="sku">{$product.reference_to_display}</span>
                            </div>
                        {/if}
                    {/block}
                    {block name='product_quantities'}
                        {if $product.show_quantities}
                            <div class="product-quantities">
                                <label class="label">{l s='In stock' d='Shop.Theme.Catalog'}</label>
                                <span data-stock="{$product.quantity}" data-allow-oosp="{$product.allow_oosp}">{$product.quantity} {$product.quantity_label}</span>
                            </div>
                        {/if}
                    {/block}
                </div>
            {/if}
            <div id="accordion">
                <div id="product-details-info">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#product-details" aria-expanded="false" aria-controls="product-details">
                        {l s='Información adicional' d='Shop.Theme.Catalog'}
                        <i class="fa-solid fa-angle-down collapse_down"></i>
                        <i class="fa-solid fa-angle-up collapse_up"></i>
                    </button>
                </div>
                <div id="product-details" class="info_content collapse {if !$product.description}show in{/if}" aria-labelledby="product-details-info" data-parent="#accordion">
                    {block name='product_details'}
                        {include file='catalog/_partials/product-details.tpl'}
                    {/block}
                </div>

                {foreach from=$product.extraContent item=extra key=extraKey}
                    <div class="card">
                        <div id="extra-info-{$extraKey}">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#extra-{$extraKey}" aria-expanded="false" aria-controls="extra-{$extraKey}">
                                {$extra.title}
                                <i class="fa-solid fa-angle-down collapse_down"></i>
                                <i class="fa-solid fa-angle-up collapse_up"></i>
                            </button>
                        </div>
                        <div id="extra-{$extraKey}" class="info_content collapse" aria-labelledby="extra-info-{$extraKey}" data-parent="#accordion">
                            {$extra.content nofilter}
                        </div>
                    </div>
                {/foreach}
            </div>

        {/block}
    </div>

</div>
{* ACORDEON *}
