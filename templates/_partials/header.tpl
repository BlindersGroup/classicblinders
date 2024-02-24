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
{block name='header_banner'}
    <div class="header-banner">
        {hook h='displayBanner'}
    </div>
{/block}

{block name='header_nav'}
    {if $custom_generic.show_displaynav == 1}
        {if Context::getContext()->getDevice() < 4}
            <nav class="header-nav {if $custom_generic.width_header == 1}full_width_generic{/if}">
                <div class="container">
                    <div class="headernav_flex">

                        <div class="displayNav1">
                            {hook h='displayNav1'}
                        </div>
                        <div class="displayNavCenter">
                            {hook h='displayNavCenter'}
                        </div>
                        <div class="displayNav2">
                            {hook h='displayNav2'}
                        </div>

                        {* Cabecera en Mobile *}
                        <div class="hidden-md-up text-sm-center mobile">
                            <div class="top-logo" id="_mobile_logo"></div>
                            <div id="_mobile_user_info"></div>
                            <div id="_mobile_cart"></div>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                </div>
            </nav>
        {/if}
    {/if}
{/block}

{block name='header_top'}
    <div
        class="header-top {if $custom_generic.width_header == 1}full_width_generic{/if} {if $custom_generic.show_displaynav == 0}notdisplaynav{/if}">
        <div class="container">
            {if Context::getContext()->getDevice() < 4}
                <div class="header__flex">
                    <div class="displayLogo hidden-sm-down" id="_desktop_logo">
                        {if $page.page_name == 'index'}
                            <img class="logo img-responsive" src="{$shop.logo}" alt="{$shop.name}" loading="lazy"
                                height="{$custom_generic.logo_height}" width="{$custom_generic.logo_width}">
                        {else}
                            <a href="{$urls.pages.index}">
                                <img class="logo img-responsive" src="{$shop.logo}" alt="{$shop.name}" loading="lazy"
                                    height="{$custom_generic.logo_height}" width="{$custom_generic.logo_width}">
                            </a>
                        {/if}
                    </div>
                    <div class="displayTopCenter">
                        {hook h='displayTopCenter'}
                        <div class="clearfix"></div>
                    </div>
                    <div class="position-static displayTop">
                        {hook h='displayTop'}
                        <div class="clearfix"></div>
                    </div>
                </div>
            {else}
                <div class="header__flex mobile">
                    <div class="mobile_top">
                        <div class="displayLogo" id="_desktop_logo">
                            {if $page.page_name == 'index'}
                                <img class="logo img-responsive" src="{$shop.logo}" alt="{$shop.name}" loading="lazy"
                                    height="{$custom_generic.logo_height}" width="{$custom_generic.logo_width}">
                            {else}
                                <a href="{$urls.pages.index}">
                                    <img class="logo img-responsive" src="{$shop.logo}" alt="{$shop.name}" loading="lazy"
                                        height="{$custom_generic.logo_height}" width="{$custom_generic.logo_width}">
                                </a>
                            {/if}
                        </div>
                        <div class="position-static displayTop">
                            {hook h='displayTop'}
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <div class="mobile_middle mobile">
                        {*<div id="mobile__menu" data-toggle="modal" data-target="#dbmenu_burger">
                            <i class="fa-solid fa-bars d-inline"></i>
                        </div>*}
                        <div class="float-xs-left" id="menu-icon">
                            <i class="fa-solid fa-bars d-inline"></i>
                        </div>



                        <div class="displayTopCenter">
                            {hook h='displayTopCenter'}
                            <div class="clearfix"></div>
                        </div>

                        <div id="mobile_top_menu_wrapper" class="row hidden-md-up" style="display:none;">
                            <div class="js-top-menu mobile" id="_mobile_top_menu"></div>
                            <div class="js-top-menu-bottom">
                                <div id="_mobile_currency_selector"></div>
                                <div id="_mobile_language_selector"></div>
                                <div id="_mobile_contact_link"></div>
                            </div>
                        </div>
                    </div>

                </div>
            {/if}

        </div>
    </div>
    {hook h='displayNavFullWidth'}
{/block}