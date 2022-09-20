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

<div class="dbjointpurchase_product product_card">
    <div class="dbjointpurchase_header">
        <p class="h3 title">{l s='Comprados juntos habitualmente' mod='dbjointpurchase'}</p>
    </div>
    <div class="dbjointpurchase">
        <div class="dbjointpurchase_products">
            <div class="dbjointpurchase_product current_product active">

                <div class="productjoint_content">
                    <span class="name_product">
                        <input id="checkjoint" type="hidden" name="joint[]" value="{$product.id_product}" checked="">
                        {$product.name}
                    </span>
                    <div class="product_prices">
                        <span class="price_product" data-price="{$product.price_amount}">{$product.price}</span>
                        {if $product.has_discount}
                            <span class="old_price">{$product.regular_price}</span>
                            {if $product.discount_type === 'percentage'}
                                <span class="discount discount-percentage">
                                      {$product.discount_percentage_absolute}
                                </span>
                            {else}
                                <span class="discount discount-amount">
                                      {$product.discount_to_display}
                                </span>
                            {/if}
                        {/if}
                    </div>
                </div>
                <div class="productjoint_img">
                    <img src="{$product.cover.bySize.home_default.url}" alt="{$product.name}" loading="lazy" width="{$product.cover.bySize.home_default.width}" height="{$product.cover.bySize.home_default.height}">
                </div>
            </div>
            <div class="icon_more_purchase">
                <i class="fa-solid fa-plus"></i>
            </div>
            {foreach from=$productos item=products key=i}
                {foreach from=$products item=producto}
                    <div class="dbjointpurchase_product joint_product block_joint_{$i} active" data-bestproduct="{$producto.id_product}">
                        {include file='module:dbjointpurchase/views/templates/hook/product_joint.tpl'}
                    </div>
                {/foreach}
            {/foreach}
        </div>
        <div class="dbjointpurchase_footer">
            {*<span class="super_oferta">{l s='¡Oferta!' mod='dbjointpurchase'}</span>*}
            <span class="precio_pack_product">
                <span class="num_products"><span class="num">4</span> {l s='producto(s) por' mod='dbjointpurchase'}</span>
                <span class="precio_pack_product_total">
                    <span class="regular_price">{Tools::displayPrice($total_price)}</span>
                    <span class="iva">{l s='IVA incluido' mod='dbjointpurchase'}</span>
                </span>
            </span>
            <button class="btn btn-primary" id="btn_dbjointpurchase" data-button-action="add-to-cart" type="submit">
                <span class="add_text">{l s='Añadir artículos' mod='dbjointpurchase'}</span>
                <span class="complete_text"><i class="fa-solid fa-check"></i>{l s='Artículos añadidos' mod='dbjointpurchase'}</span>
            </button>
        </div>
    </div>
</div>