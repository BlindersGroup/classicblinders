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
{extends file='customer/page.tpl'}

{block name='page_content'}

      <h2>{l s='Order history' d='Shop.Theme.Customeraccount'}</h2>
      <p class="p2">{l s='Here are the orders you\'ve placed since your account was created.' d='Shop.Theme.Customeraccount'}</p>

      {if $orders}
        <div class="orders_history">
          {foreach from=$orders item=order}
            <div class="order_history">
              <div class="history_info">
                <div class="item">
                  <span class="title">{l s='Order reference' d='Shop.Theme.Checkout'}</span>
                  <span class="value">{$order.details.reference}</span>
                </div>
                <div class="item">
                  <span class="title">{l s='Date' d='Shop.Theme.Checkout'}</span>
                  <span class="value">{$order.details.order_date}</span>
                </div>
                <div class="item">
                  <span class="title">{l s='Total price' d='Shop.Theme.Checkout'}</span>
                  <span class="value">{$order.totals.total.value}</span>
                </div>
                <div class="item item_status">
                  <span class="title">{l s='Status' d='Shop.Theme.Checkout'}</span>
                  <span class="value" style="color:{$order.history.current.color}">{$order.history.current.ostate_name}</span>
                </div>
              </div>
              <div class="history_buttons">
                <a class="btn btn-primary" href="{$order.details.details_url}">{l s='Order detail' d='Shop.Theme.Actions'}</a>
                <a class="btn btn-secondary" href="{$order.details.reorder_url}">{l s='Reorder' d='Shop.Theme.Actions'}</a>
                {if $order.details.invoice_url}
                  <a class="btn btn-secondary" href="{$order.details.invoice_url}">{l s='Download invoice' d='Shop.Theme.Actions'}</a>
                {/if}
                <a class="btn btn-tertiary" href="{$order.details.details_url}#order-message">{l s='Report incident' d='Shop.Theme.Actions'}</a>
              </div>
            </div>
          {/foreach}
        </div>
      {/if}

{/block}
