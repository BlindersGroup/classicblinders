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

{block name='page_title'}
  {l s='Order details' d='Shop.Theme.Customeraccount'}
{/block}

{block name='page_content'}

  <h2>{l s='Order details' d='Shop.Theme.Customeraccount'}</h2>
  {block name='order_infos'}

    <div class="order_info">
      <span>
{*        <span class="hidden-sm-down">|</span>*}
        {l
        s='Ref.'
        d='Shop.Theme.Customeraccount'
        sprintf=['%reference%' => $order.details.reference,'%date%' => $order.details.order_date]
        } <span>{$order.details.reference}</span>
      </span>
      &nbsp;&nbsp;
      <span>
        {l
        s='Purchased on %date%'
        d='Shop.Theme.Customeraccount'
        sprintf=['%date%' => $order.details.order_date]
        }
      </span>
      <span class="state">
        {l s='Status' d='Shop.Theme.Checkout'}: <span class="value" style="color:{$order.history.current.color}">{$order.history.current.ostate_name}</span>
      </span>
    </div>

    <div class="order_resume">
      <div class="box">
        <div class="row">

          <div class="col-xs-12 col-md-4">
            <div id="accordion">
              <button class="btn btn-link" data-toggle="collapse" data-target="#collapseDelivery" aria-expanded="true" aria-controls="collapseDelivery">
                {l s='Shipping Address' d='Shop.Theme.Customeraccount'}
                <i class="fa-solid fa-angle-down"></i>
              </button>
              <div id="collapseDelivery" class="collapse show in" aria-labelledby="headingDelivery" data-parent="#accordion" aria-expanded="true">
                <div class="card-body">
                  <address>{$order.addresses.delivery.formatted nofilter}</address>
                </div>
              </div>

              <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseInvoice" aria-expanded="false" aria-controls="collapseTwo">
                {l s='Billing Address' d='Shop.Theme.Customeraccount'}
                <i class="fa-solid fa-angle-down"></i>
              </button>
              <div id="collapseInvoice" class="collapse" aria-labelledby="headingInvoice" data-parent="#accordion">
                <div class="card-body">
                  <address>{$order.addresses.invoice.formatted nofilter}</address>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-md-4">
            <div class="item">
              <span class="title">{l s='Payment method' d='Shop.Theme.Checkout'}</span>
              <span>{$order.details.payment}</span>
            </div>
            <div class="item">
              <span class="title">{l s='Carrier' d='Shop.Theme.Checkout'}</span>
              <span>{$order.carrier.name}</span>
            </div>
            {if isset($line) && $line.tracking}
              <div class="item">
                <span class="title">{l s='Tracking number' d='Shop.Theme.Checkout'}</span>
                <span>{$line.tracking nofilter} {if $order.follow_up}<a href="{$order.follow_up}">{$order.follow_up}</a>{/if}</span>
              </div>
            {/if}
            {if $order.details.recyclable}
              <div class="item">
                <span>{l s='You have given permission to receive your order in recycled packaging.' d='Shop.Theme.Customeraccount'}</span>
              </div>
            {/if}

            {if $order.details.gift_message}
              <div class="item">
                <span class="title">{l s='You have requested gift wrapping for this order.' d='Shop.Theme.Customeraccount'}</span>
                <span>{l s='Message' d='Shop.Theme.Customeraccount'} {$order.details.gift_message nofilter}</span>
              </div>
            {/if}
          </div>

          <div class="col-xs-12 col-md-4">
            <div class="order_summary">
              <span class="title">{l s='Order summary' d='Shop.Theme.Checkout'}</span>
              {foreach $order.subtotals as $line}
                {if $line.value}
                  <div class="line-subtotal line-{$line.type}">
                    <span>{$line.label}</span>
                    <span class="value">{$line.value}</span>
                  </div>
                {/if}
              {/foreach}
              <div class="line-subtotal line-{$order.totals.total.type}">
                <span>{$order.totals.total.label}</span>
                <span class="value">{$order.totals.total.value}</span>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="order_actions">
      <div class="oactions">
        {if $order.details.invoice_url}
          <a class="oaction btn btn-primary" href="{$order.details.invoice_url}">{l s='Download invoice' d='Shop.Theme.Actions'}</a>
        {/if}
        <a class="oaction btn btn-secondary" href="{$order.details.reorder_url}">{l s='Reorder' d='Shop.Theme.Actions'}</a>
        <a class="oaction btn btn-tertiary" href="#order-message">{l s='Report incident' d='Shop.Theme.Actions'}</a>
        {if $order.details.is_returnable}
          <a class="oaction btn btn-tertiary" href="#order-return-form">{l s='Make a refund' d='Shop.Theme.Actions'}</a>
        {/if}
      </div>
    </div>

    {$HOOK_DISPLAYORDERDETAIL nofilter}

    {block name='order_detail'}
      {if $order.details.is_returnable}
        {include file='customer/_partials/order-detail-return.tpl'}
      {else}
        {include file='customer/_partials/order-detail-no-return.tpl'}
      {/if}
    {/block}
  {/block}

  {block name='order_messages'}
    {include file='customer/_partials/order-messages.tpl'}
  {/block}
{/block}
