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
{if $cart.vouchers.allowed}
  {block name='cart_voucher'}
    <div class="block-promo">
      <div class="cart-voucher">

        <p class="promo-code-button {if $cart.discounts|count > 0} with-discounts{/if}">
          <a class="collapse-button" href="#promo-code">
              {l s='Have a promo code?' d='Shop.Theme.Checkout'}
              <i class="fa-solid fa-angle-down"></i>
          </a>
        </p>

        <div id="promo-code" class="collapse{if $cart.discounts|count > 0} in{/if}">
          <div class="promo-code">
            {block name='cart_voucher_form'}
              <form action="{$urls.pages.cart}" data-link-action="add-voucher" method="post">
                <input type="hidden" name="token" value="{$static_token}">
                <input type="hidden" name="addDiscount" value="1">
                <input class="promo-input" type="text" name="discount_name" placeholder="{l s='Promo code' d='Shop.Theme.Checkout'}">
                <button type="submit" class="btn btn-primary"><span>{l s='Add' d='Shop.Theme.Actions'}</span></button>
              </form>
            {/block}

            {block name='cart_voucher_notifications'}
              <div class="alert alert-danger js-error" role="alert">
                  <span class="ml-1 js-error-text"></span>
              </div>
            {/block}

            {*<a class="collapse-button promo-code-button cancel-promo" role="button" data-toggle="collapse" data-target="#promo-code" aria-expanded="true" aria-controls="promo-code">
              {l s='Close' d='Shop.Theme.Checkout'}
            </a>*}
          </div>
        </div>

        {if $cart.discounts|count > 0}
          {*<p class="block-promo promo-highlighted">
            {l s='Take advantage of our exclusive offers:' d='Shop.Theme.Actions'}
          </p>*}
          <ul class="js-discount card-block promo-discounts">
            {foreach from=$cart.discounts item=discount}
              <li class="cart-summary-line">
                <span class="label">
                    <span class="text">{$discount.name} {l s='Code' d='Shop.Theme.Checkout'}:</span>
                    <span class="code">{$discount.code}</span>
                    <i class="fa-solid fa-plus"></i>
                </span>
              </li>
            {/foreach}
          </ul>
        {/if}
      </div>
    </div>
  {/block}

    <hr class="separator separator_voucher">
{/if}
