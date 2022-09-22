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

{*      <h1>{l s='Your account' d='Shop.Theme.Customeraccount'}</h1>*}
      <h2>{l s='Hi %customerName%' sprintf=['%customerName%' => {$customer.firstname}] d='Shop.Theme.Customeraccount'}:</h2>
      <p class="p2">{l s='In the "My account" section you can edit your personal data, addresses and review your latest orders.' d='Shop.Theme.Customeraccount'}</p>

      <div class="row">
        <p class="subtitle col-md-12 col-xs-12">{l s='Orders' d='Shop.Theme.Customeraccount'}</p>
        {if !$configuration.is_catalog}
          <a class="col-lg-6 col-md-6 col-sm-6 col-xs-12 link_item" id="history-link" href="{$urls.pages.history}">
            <span class="link-item">
              <i class="fa-solid fa-list-ul"></i>
              <div class="history-content">
                <p class="title">{l s='My orders' d='Shop.Theme.Customeraccount'}</p>
                <p class="desc">{l s='Track, return products, repeat orders or request invoices.' d='Shop.Theme.Customeraccount'}</p>
              </div>
            </span>
          </a>
        {/if}

        {if $configuration.voucher_enabled && !$configuration.is_catalog}
          <a class="col-lg-6 col-md-6 col-sm-6 col-xs-12 link_item" id="discounts-link" href="{$urls.pages.discount}">
            <span class="link-item">
              <i class="fa-solid fa-tag"></i>
              <div class="history-content">
                <p class="title">{l s='Vouchers' d='Shop.Theme.Customeraccount'}</p>
                <p class="desc">{l s='Discover the discounted vouchers we have for you.' d='Shop.Theme.Customeraccount'}</p>
              </div>
            </span>
          </a>
        {/if}

        {if !$configuration.is_catalog}
          <a class="col-lg-6 col-md-6 col-sm-6 col-xs-12 link_item" id="order-slips-link" href="{$urls.pages.order_slip}">
            <span class="link-item">
              <i class="fa-solid fa-file-invoice"></i>
              <div class="history-content">
                <p class="title">{l s='Credit slips' d='Shop.Theme.Customeraccount'}</p>
                <p class="desc">{l s='Accede y descarga las facturas de devoluciones recibidas por devoluciones o cancelaciones de pedidos.' d='Shop.Theme.Customeraccount'}</p>
              </div>
            </span>
          </a>
        {/if}

        {if $configuration.return_enabled && !$configuration.is_catalog}
          <a class="col-lg-6 col-md-6 col-sm-6 col-xs-12 link_item" id="returns-link" href="{$urls.pages.order_follow}">
            <span class="link-item">
              <i class="fa-solid fa-arrow-rotate-left"></i>
              <div class="history-content">
                <p class="title">{l s='Merchandise returns' d='Shop.Theme.Customeraccount'}</p>
                <p class="desc">{l s='Seguimiento del estado de sus devoluciones y albaranes de envío.' d='Shop.Theme.Customeraccount'}</p>
              </div>
            </span>
          </a>
        {/if}

        <p class="subtitle col-md-12 col-xs-12">{l s='Account summary' d='Shop.Theme.Customeraccount'}</p>
        <a class="col-lg-6 col-md-6 col-sm-6 col-xs-12 link_item" id="identity-link" href="{$urls.pages.identity}">
          <span class="link-item">
            <i class="fa-solid fa-address-book"></i>
            <div class="history-content">
              <p class="title">{l s='Personal information' d='Shop.Theme.Customeraccount'}</p>
              <p class="desc">{l s='Edit your personal data such as name, password, email ...' d='Shop.Theme.Customeraccount'}</p>
            </div>
          </span>
        </a>

        {if $customer.addresses|count}
          <a class="col-lg-6 col-md-6 col-sm-6 col-xs-12 link_item" id="addresses-link" href="{$urls.pages.addresses}">
            <span class="link-item">
              <i class="fa-solid fa-location-dot"></i>
              <div class="history-content">
                <p class="title">{l s='Addresses' d='Shop.Theme.Customeraccount'}</p>
                <p class="desc">{l s='Edit, create or delete your shipping and billing addresses.' d='Shop.Theme.Customeraccount'}</p>
              </div>
            </span>
          </a>
        {else}
          <a class="col-lg-6 col-md-6 col-sm-6 col-xs-12 link_item" id="address-link" href="{$urls.pages.address}">
            <span class="link-item">
              <i class="fa-solid fa-location-dot"></i>
              <div class="history-content">
                <p class="title">{l s='Add first address' d='Shop.Theme.Customeraccount'}</p>
                <p class="desc">{l s='Edit, create or delete your shipping and billing addresses.' d='Shop.Theme.Customeraccount'}</p>
              </div>
            </span>
          </a>
        {/if}

        <p class="subtitle col-md-12 col-xs-12">{l s='Contact' d='Shop.Theme.Customeraccount'}</p>
        <a class="col-lg-12 col-md-12 col-sm-12 col-xs-12 link_item" id="link_contact" href="{$urls.pages.contact}">
            <span class="link-item">
              <i class="fa-solid fa-envelope"></i>
              <div class="history-content">
                <p class="title">{l s='Contact Form' d='Shop.Theme.Customeraccount'}</p>
                <p class="desc">{l s='For any questions, contact our customer service team' d='Shop.Theme.Customeraccount'}</p>
              </div>
              <span class="btn_contact">{l s='Contact' d='Shop.Theme.Customeraccount'}</span>
            </span>
        </a>

        <p class="subtitle col-md-12 col-xs-12">{l s='Others' d='Shop.Theme.Customeraccount'}</p>
        {block name='display_customer_account'}
          {hook h='displayCustomerAccount'}
        {/block}

      </div>

{/block}


{block name='page_footer'}
  {block name='my_account_links'}
    <div class="text-sm-center">
      <a href="{$logout_url}" >
        {l s='Sign out' d='Shop.Theme.Actions'}
      </a>
    </div>
  {/block}
{/block}
