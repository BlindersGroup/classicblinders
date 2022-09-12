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
<div class="pre-footer {if $custom_generic.width_footer == 1}full_width_generic{/if}">
  <div class="container">
    <div class="row">
      {block name='hook_footer_before'}
        {hook h='displayFooterBefore'}
      {/block}
    </div>
  </div>
</div>
<div class="footer-container {if $custom_generic.width_footer == 1}full_width_generic{/if}">
  <div class="container">
    <div class="row">
      {block name='hook_footer'}
        {hook h='displayFooter'}
      {/block}
    </div>
    <div class="row">
      {block name='hook_footer_after'}
        {hook h='displayFooterAfter'}
      {/block}
    </div>
    <div class="row">

    </div>
  </div>
</div>
<div class="copyright">
    <div class="container">
        <div class="copyright_content">
            <ul class="imgs_payment">
                {if $custom_generic.visa == 1}
                    <li><img src="{$js_custom_vars.prestashop.urls.theme_assets}../../classicblinders/assets/img/icons/ico-visa.svg" width="75" height="50" loading="lazy" alt="visa"></li>
                {/if}
                {if $custom_generic.mastercard == 1}
                    <li><img src="{$js_custom_vars.prestashop.urls.theme_assets}../../classicblinders/assets/img/icons/ico-mastercard.svg" width="75" height="50" loading="lazy" alt="mastercard"></li>
                {/if}
                {if $custom_generic.maestro == 1}
                    <li><img src="{$js_custom_vars.prestashop.urls.theme_assets}../../classicblinders/assets/img/icons/ico-maestro.svg" width="75" height="50" loading="lazy" alt="maestro"></li>
                {/if}
                {if $custom_generic.paypal == 1}
                    <li><img src="{$js_custom_vars.prestashop.urls.theme_assets}../../classicblinders/assets/img/icons/ico-paypal.svg" width="75" height="50" loading="lazy" alt="paypal"></li>
                {/if}
                {if $custom_generic.bizum == 1}
                    <li><img src="{$js_custom_vars.prestashop.urls.theme_assets}../../classicblinders/assets/img/icons/ico-bizum.svg" width="75" height="50" loading="lazy" alt="bizum"></li>
                {/if}
            </ul>
            <p class="text_copyright">
                {block name='copyright_link'}
                    {l s='%copyright% %year% - %shop% - All rights reserved' sprintf=['%shop%' => $shop.name, '%year%' => 'Y'|date, '%copyright%' => '©'] d='Shop.Theme.Global'}
                {/block}
            </p>
            <div class="displayFooterCopyright">
                {hook h='displayFooterCopyright'}
            </div>
        </div>
    </div>
</div>
