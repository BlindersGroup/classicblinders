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

<div id="block_myaccount_infos" class="col-md-4 links wrapper">
  <p class="myaccount-title hidden-sm-down h3">
      {l s='Your account' d='Shop.Theme.Customeraccount'}
  </p>
  <div class="title clearfix hidden-md-up" data-target="#footer_account_list" data-toggle="collapse">
    <span class="h3">{l s='Your account' d='Shop.Theme.Customeraccount'}</span>
    <span class="float-xs-right">
      <span class="navbar-toggler collapse-icons">
        <i class="fa-solid fa-plus add"></i>
        <i class="fa-solid fa-minus remove"></i>
      </span>
    </span>
  </div>
  <ul class="account-list collapse" id="footer_account_list">
    {*{foreach from=$my_account_urls item=my_account_url}
        <li>
          <a href="{$my_account_url.url}" title="{$my_account_url.title}" rel="nofollow">
            {$my_account_url.title}
          </a>
        </li>
    {/foreach}*}
    <li>
      <span class="item datatext" datatext="{$urls.pages.my_account|base64_encode}">
        <i class="fa-solid fa-user"></i>
        {l s='My account' d='Shop.Theme.Customeraccount'}
      </span>
    </li>
    <li>
      <span class="item datatext" datatext="{$urls.pages.history|base64_encode}">
        <i class="fa-solid fa-list-ul"></i>
        {l s='My orders' d='Shop.Theme.Customeraccount'}
      </span>
    </li>
    <li>
      <span class="item datatext" datatext="{$urls.pages.discount|base64_encode}">
        <i class="fa-solid fa-tag"></i>
        {l s='Discount coupons' d='Shop.Theme.Customeraccount'}
      </span>
    </li>
    <li>
      <span class="item datatext" datatext="{$urls.pages.identity|base64_encode}">
        <i class="fa-solid fa-address-book"></i>
        {l s='Personal information' d='Shop.Theme.Customeraccount'}
      </span>
    </li>
    <li>
      <span class="item datatext" datatext="{$urls.pages.addresses|base64_encode}">
        <i class="fa-solid fa-location-dot"></i>
        {l s='My Addresses' d='Shop.Theme.Customeraccount'}
      </span>
    </li>
    {hook h='displayMyAccountBlock'}
	</ul>
</div>
