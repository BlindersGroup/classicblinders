{*
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
 *}

{foreach from=$products item=producto}
    <div class="productjoint_content">
        <div class="name_product">
            <div class="productjoint_check">
                <label class="facet-label" for="">
                    <span class="custom-checkbox">
                        <input id="checkjoint" type="checkbox" name="joint[]" value="{$producto.id_product}" checked="">
                        {if $premium == 1}
                        <span class="ps-shown-by-js">
                            <i class="material-icons rtl-no-flip checkbox-checked"></i>
                        </span>
                        {/if}
                    </span>
                </label>
            </div>
            <a href="{$producto.link}">{$producto.name}</a>
        </div>
        <div class="product_prices">
            <span class="price_product" data-price="{$producto.price_amount}">{$producto.price}</span>
            {if $producto.has_discount}
                <span class="old_price">{$producto.regular_price}</span>
                {if $producto.discount_type === 'percentage'}
                    <span class="discount discount-percentage">
                          {$producto.discount_percentage_absolute}
                    </span>
                {else}
                    <span class="discount discount-amount">
                          {$producto.discount_to_display}
                    </span>
                {/if}
            {/if}
        </div>
    </div>
    <div class="productjoint_img">
        <img src="{$producto.cover.bySize.home_default.url}" alt="{$producto.name}" loading="lazy" width="{$product.cover.bySize.home_default.width}" height="{$product.cover.bySize.home_default.height}">
    </div>
    {if $premium == 1}
        <span class="change_product" data-key="{$i}" data-idproduct="{$producto.id_product}" data-idcategory="{$producto.id_category_default}">
            {l s='Cambiar' mod='dbjointpurchase'}
            <i class="material-icons">refresh</i>
        </span>
    {/if}
{/foreach}
