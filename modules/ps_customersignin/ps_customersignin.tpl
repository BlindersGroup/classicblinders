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
<div id="_desktop_user_info">
  <div class="user-info">
    {if $logged}
      <span
        class="open_account userinfo_header"
        data-toggle="modal"
        data-target="#userinfo_modal"
      >
          <i class="fa-solid fa-user"></i>
          <span class="icon_name">{l s='Hi %customerName%' sprintf=['%customerName%' => {$customerName}] d='Shop.Theme.Customeraccount'}</span>
      </span>
    {else}
      <span
        datatext="{$my_account_url|base64_encode}"
        class="datatext userinfo_header"
      >
        <i class="fa-solid fa-user"></i>
          <span class="icon_name">{l s='Iniciar sesión' d='Modules.Customersignin.Shop'}</span>
      </span>
    {/if}
  </div>
</div>


{if $logged}
<!-- Modal My Account -->
<div class="modal fade right" id="userinfo_modal" tabindex="-1" role="dialog" aria-labelledby="userinfo_modal_Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="userinfo_modal_Label">{l s='Hi %customerName%' sprintf=['%customerName%' => {$customerName}] d='Shop.Theme.Customeraccount'}</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal_item">
                    <span class="title">{l s='Account summary' d='Shop.Theme.Customeraccount'}</span>
                    <a class="item" href="{$urls.pages.my_account}">
                        <i class="fa-solid fa-user"></i>
                        {l s='My account' d='Shop.Theme.Customeraccount'}
                    </a>
                </div>
                <div class="modal_item">
                    <span class="title">{l s='My orders' d='Shop.Theme.Customeraccount'}</span>
                    <a class="item" href="{$urls.pages.history}">
                        <i class="fa-solid fa-list-ul"></i>
                        {l s='My orders' d='Shop.Theme.Customeraccount'}
                    </a>
                    <a class="item" href="{$urls.pages.discount}">
                        <i class="fa-solid fa-tag"></i>
                        {l s='Discount coupons' d='Shop.Theme.Customeraccount'}
                    </a>
                </div>
                <div class="modal_item">
                    <span class="title">{l s='Personal information' d='Shop.Theme.Customeraccount'}</span>
                    <a class="item" href="{$urls.pages.identity}">
                        <i class="fa-solid fa-address-book"></i>
                        {l s='Personal information' d='Shop.Theme.Customeraccount'}
                    </a>
                    <a class="item" href="{$urls.pages.addresses}">
                        <i class="fa-solid fa-location-dot"></i>
                        {l s='My Addresses' d='Shop.Theme.Customeraccount'}
                    </a>
                </div>
                <a class="btn btn-secondary close_session" href="{$logout_url}">{l s='Sign off' d='Shop.Theme.Customeraccount'}</a>
            </div>
        </div>
    </div>
</div>
{/if}
