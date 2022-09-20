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

<div class="block-contact col-md-4 links wrapper">
    <div class="title clearfix hidden-md-up" data-target="#footer_contactinfo" data-toggle="collapse">
        <span class="h3">{l s='Store information' d='Shop.Theme.Global'}</span>
        <span class="float-xs-right">
          <span class="navbar-toggler collapse-icons">
              <i class="fa-solid fa-plus add"></i>
              <i class="fa-solid fa-minus remove"></i>
          </span>
        </span>
    </div>
    <div id="footer_contactinfo" class="collapse">
        <p class="h3 block-contact-title hidden-sm-down">{l s='Store information' d='Shop.Theme.Global'}</p>

        <div class="content_contactinfo">
            <div class="data_contactinfo">
                <i class="fa-solid fa-envelope"></i>
                <div class="data_contact">
                    <span class="text_min">{l s='Enviar un email' d='Shop.Theme.Global'}</span>
                    <span class="value">
                        {$contact_infos.email}
                    </span>
                </div>
            </div>
            {if $contact_infos.phone}
                <div class="data_contactinfo">
                    <i class="fa-solid fa-phone"></i>
                    <div class="data_contact">
                        <span class="text_min">{l s='Llámanos' d='Shop.Theme.Global'}</span>
                        <span class="value phone">{$contact_infos.phone}</span>
                    </div>
                </div>
            {/if}
            {if $contact_infos.address.formatted}
                <div class="data_contactinfo">
                    <i class="fa-solid fa-location-dot"></i>
                    <div class="data_contact">
                        <span class="text_min">
                            {$contact_infos.address.formatted nofilter}
                        </span>
                    </div>
                </div>

            {/if}
        </div>

    </div>
</div>
