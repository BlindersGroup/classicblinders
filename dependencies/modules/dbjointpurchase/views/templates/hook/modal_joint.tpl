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

<div class="dbchangeproduct_modal modal fade" id="jointModal" tabindex="-1" role="dialog" aria-labelledby="jointModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="jointModalLabel">{l s='Cambiar producto' mod='dbjointpurchase'}</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {foreach from=$productos item=producto}
                    <div class="jointmodal_product">
                        <img src="{$producto.cover.bySize.small_default.url}">
                        <div class="content_product">
                            <span class="name_product">{$producto.name}</span>
                            <div class="product_prices">
                                <span class="price_product">{$producto.price}</span>
                                {if $producto.has_discount}
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
                                <span data-idproduct="{$producto.id_product}" data-currentproduct="{$current_product}"></span>
                                {if $producto.id_product == $current_product}
                                    <span class="btn btn-selected">{l s='Seleccionado' mod='dbjointpurchase'}</span>
                                {else}
                                    <button class="btn btn-select joint_select" data-key="{$key}" data-idproduct="{$producto.id_product}">{l s='Seleccionar' mod='dbjointpurchase'}</button>
                                {/if}
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-selection" data-dismiss="modal">{l s='Cerrar' mod='dbjointpurchase'}</button>
            </div>
        </div>
    </div>
</div>
