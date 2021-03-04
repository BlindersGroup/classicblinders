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
            <i class="material-icons add">&#xE313;</i>
            <i class="material-icons remove">&#xE316;</i>
          </span>
        </span>
    </div>
    <div id="footer_contactinfo" class="collapse">
        <p class="h3 block-contact-title hidden-sm-down">{l s='Store information' d='Shop.Theme.Global'}</p>

        <div class="content_contactinfo">
            <p>
                <a href="{$urls.pages.contact}">
                    <i class="material-icons">email</i>
                    {l s='Contact Form' d='Shop.Theme.Customeraccount'}
                </a>
            </p>
            {if $contact_infos.phone}
                <p>
                    <i class="material-icons">phone</i>
                    {$contact_infos.phone}
                </p>
            {/if}
            {if $contact_infos.address.formatted}
                <p class="contact_infos_address">
                    <i class="material-icons">location_on</i>
                    <span>{$contact_infos.address.formatted nofilter}</span>
                </p>
            {/if}
            {if $contact_infos.fax}
                <p>
                    {* [1][/1] is for a HTML tag. *}
                    {l
                    s='Fax: [1]%fax%[/1]'
                    sprintf=[
                    '[1]' => '<span>',
                    '[/1]' => '</span>',
                    '%fax%' => $contact_infos.fax
                    ]
                    d='Shop.Theme.Global'
                    }
                </p>
            {/if}
            {*{if $contact_infos.email && $display_email}
                <p>
                    {$contact_infos.email}
                </p>
            {/if}*}
        </div>

    </div>
</div>
