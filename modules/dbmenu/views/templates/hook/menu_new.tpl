{*
* 2007-2021 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author    DevBlinders <soporte@devblinders.com>
* @copyright Copyright (c) DevBlinders
* @license   Commercial license
*}

<div class="dbmenu">

    {if Context::getContext()->getDevice() < 4}
        <nav class="container dbmenu_navigation hidden-sm-down">
            <div class="element_nav">
            <span class="open_dbmenu" data-toggle="modal" data-target="#dbmenu_burger">
                <i class="fa-solid fa-bars"></i> {l s='Nuestro catálogo' mod='dbmenu'}
            </span>
            </div>
        </nav>
    {/if}

    <div class="modal fade left" id="dbmenu_burger" tabindex="-1" role="dialog" aria-labelledby="dbmenu_burger_Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-body">

                    {* Header *}
                    <div class="menu_header">
                        <span class="modal-title" id="dbmenu_burger_Label">
                             {if $customer.firstname}
                                 {l s='Hola %customerName%' sprintf=['%customerName%' => {$customer.firstname}] d='Shop.Theme.Customeraccount'}
                             {else}
                                 {l s='Bienvenido' mod='dbmenu'}
                             {/if}
                        </span>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    {* Items secundarios *}
                    {foreach from=$menus item=$menu}
                        {include file='module:dbmenu/views/templates/hook/subitems.tpl' linkback=$menu.title}
                    {/foreach}

                    {* Items primarios *}
                    <div class="dbmenu_primary">
                        <div class="dbmenu_category">
                            <span class="title">{l s='Categorias' mod='dbmenu'}</span>
                            {foreach from=$menus item=$menu}
                                <div class="item">

                                    {* Items principales *}
                                    {if !isset($menu.childrens)}
                                        {if $menu.ofuscate == 0}
                                            <a href="{$menu.url}" class="item_primary" title="{$menu.alt}" {if !empty($menu.color)}style="color:{$menu.color};"{/if}>
                                                {if $menu.img_menu != ''}
                                                    <img class="img_menu" src="{$menu.img_menu}" alt="{$menu.title}" loading="lazy" height="25" width="25">
                                                {/if}
                                                {if $menu.strong == 1}<strong>{/if}
                                                    {$menu.title}
                                                    {if $menu.strong == 1}</strong>{/if}
                                                {if isset($menu.childrens)}
                                                    <i class="fa-solid fa-angle-right"></i>
                                                {/if}
                                            </a>
                                        {else}
                                            <span datatext="{$menu.url|base64_encode}" class="item_primary datatext" {if !empty($menu.color)}style="color:{$menu.color};"{/if}>
                                                {if $menu.img_menu != ''}
                                                    <img class="img_menu" src="{$menu.img_menu}" alt="{$menu.title}" loading="lazy" height="25" width="25">
                                                {/if}
                                                {if $menu.strong == 1}<strong>{/if}
                                                    {$menu.title}
                                                    {if $menu.strong == 1}</strong>{/if}
                                                {if isset($menu.childrens)}
                                                    <i class="fa-solid fa-angle-right"></i>
                                                {/if}
                                            </span>
                                        {/if}
                                    {else}
                                        <span class="item_primary open_subitems" data-subitem="subitems_{$menu.id_dbmenu_list}" {if !empty($menu.color)}style="color:{$menu.color};"{/if}>
                                            {if $menu.img_menu != ''}
                                                <img class="img_menu" src="{$menu.img_menu}" alt="{$menu.title}" loading="lazy" height="25" width="25">
                                            {/if}
                                            {if $menu.strong == 1}<strong>{/if}
                                                {$menu.title}
                                                {if $menu.strong == 1}</strong>{/if}
                                            {if isset($menu.childrens)}
                                                <i class="fa-solid fa-angle-right"></i>
                                            {/if}
                                        </span>
                                    {/if}


                                </div>
                            {/foreach}
                        </div>

                        {if $show_account}
                            <div class="dbmenu_personal">
                                <span class="title">{l s='Personal area' mod='dbmenu'}</span>
                                <ul class="items">
                                    <li class="item">
                                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="chalkboard-user" class="svg-inline--fa fa-chalkboard-user fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M192 352H128c-70.69 0-128 57.3-128 128c0 17.67 14.33 32 32 32h256c17.67 0 32-14.33 32-32C320 409.3 262.7 352 192 352zM49.61 464C57.04 427.5 89.37 400 128 400h64c38.63 0 70.96 27.53 78.39 64H49.61zM160 320c53.02 0 96-42.98 96-96c0-53.02-42.98-96-96-96C106.1 128 64 170.1 64 224C64 277 106.1 320 160 320zM160 176c26.47 0 48 21.53 48 48S186.5 272 160 272S112 250.5 112 224S133.5 176 160 176zM584 0H216C185.1 0 160 25.12 160 56V80c0 13.25 10.75 24 24 24S208 93.25 208 80V56c0-4.406 3.594-8 8-8h368c4.406 0 8 3.594 8 8v304c0 4.406-3.594 8-8 8H528v-32c0-17.67-14.33-32-32-32H416c-17.67 0-32 14.33-32 32v32h-32c-13.25 0-24 10.75-24 24S338.8 416 352 416h232c30.88 0 56-25.12 56-56v-304C640 25.12 614.9 0 584 0z"></path></svg>
                                        <span class="datatext" datatext="{$urls.pages.my_account|base64_encode}">{l s='Mi cuenta' mod='dbmenu'}</span>
                                    </li>
                                    <li class="item">
                                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="list-check" class="svg-inline--fa fa-list-check fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M216 120h272C501.3 120 512 109.3 512 96c0-13.26-10.75-24-24-24h-272C202.7 72 192 82.74 192 96C192 109.3 202.7 120 216 120zM48.06 384C30.4 384 16 398.3 16 416c0 17.67 14.4 32 32.06 32S80 433.7 80 416C80 398.3 65.73 384 48.06 384zM488 232h-272C202.7 232 192 242.7 192 256c0 13.25 10.75 24 24 24h272C501.3 280 512 269.3 512 256C512 242.7 501.3 232 488 232zM488 392h-304C170.7 392 160 402.7 160 416c0 13.25 10.75 24 24 24h304c13.25 0 24-10.75 24-24C512 402.7 501.3 392 488 392zM118.2 39.94L63.09 101.1l-22.12-22.11c-9.375-9.375-24.56-9.375-33.94 0s-9.375 24.56 0 33.94l40 40C51.53 157.5 57.66 160 63.1 160c.2187 0 .4065 0 .6253-.0156c6.594-.1719 12.81-3.031 17.22-7.922l72-80c8.875-9.859 8.062-25.03-1.781-33.91C142.2 29.31 127.1 30.09 118.2 39.94zM118.2 199.9L63.09 261.1l-22.12-22.11c-9.375-9.375-24.56-9.375-33.94 0s-9.375 24.56 0 33.94l40 40C51.53 317.5 57.66 320 63.1 320c.2187 0 .4065 0 .6253-.0156c6.594-.1719 12.81-3.031 17.22-7.922l72-80c8.875-9.859 8.062-25.03-1.781-33.91C142.2 189.3 127.1 190.1 118.2 199.9z"></path></svg>
                                        <span class="datatext" datatext="{$urls.pages.history|base64_encode}">{l s='Mis pedidos' mod='dbmenu'}</span>
                                    </li>
                                    <li class="item">
                                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="location-arrow" class="svg-inline--fa fa-location-arrow fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M433.9 46.08C424.8 36.89 412.5 32 399.1 32c-6.115 0-12.28 1.172-18.14 3.584L29.83 179.6c-21.23 8.688-33.36 31.19-28.92 53.69c4.422 22.53 24.16 38.75 47.09 38.75h159.1v159.1c0 24 19.18 47.1 48.02 47.1c19.17 0 36.92-11.53 44.41-29.81L444.4 98.21C451.8 80.3 447.6 59.74 433.9 46.08zM399.1 80.01L256 432V224L48.01 224L399.1 80.01z"></path></svg>
                                        <span class="datatext" datatext="{$urls.pages.addresses|base64_encode}">{l s='Direcciones' mod='dbmenu'}</span>
                                    </li>
                                    <li class="item">
                                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="square-user" class="svg-inline--fa fa-square-user fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M384 32H64C28.65 32 0 60.65 0 96v320c0 35.35 28.65 64 64 64h320c35.35 0 64-28.65 64-64V96C448 60.65 419.3 32 384 32zM113.6 432C121 395.5 153.4 368 192 368h64c38.63 0 70.96 27.53 78.39 64H113.6zM400 416c0 8.822-7.178 16-16 16h-1.613C374.4 368.9 321.2 320 256 320H192c-65.21 0-118.4 48.95-126.4 112H64c-8.822 0-16-7.178-16-16V96c0-8.822 7.178-16 16-16h320c8.822 0 16 7.178 16 16V416zM224 112c-48.6 0-88 39.4-88 88C136 248.6 175.4 288 224 288c48.6 0 88-39.4 88-88C312 151.4 272.6 112 224 112zM224 240c-22.05 0-40-17.95-40-40C184 177.9 201.9 160 224 160c22.06 0 40 17.94 40 40C264 222.1 246.1 240 224 240z"></path></svg>
                                        <span class="datatext" datatext="{$urls.pages.identity|base64_encode}">{l s='Datos personales' mod='dbmenu'}</span>
                                    </li>
                                    <li class="item">
                                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="envelope-open-text" class="svg-inline--fa fa-envelope-open-text fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M476.8 214.2c-8.244 0-16.23 2.891-22.56 8.168l-156.9 130.8c-22.68 18.9-59.8 18.91-82.49 .002L57.8 222.3c-6.332-5.277-14.32-8.168-22.56-8.168C15.78 214.2 0 229.9 0 249.4v198.6C0 483.3 28.65 512 64 512h384c35.35 0 64-28.67 64-64.01V249.4C512 229.9 496.2 214.2 476.8 214.2zM464 448c0 8.822-7.178 16-16 16H64c-8.822 0-16-7.178-16-16V276.7l136.1 113.4C204.3 406.8 229.8 416.1 256 416.1s51.75-9.224 71.97-26.02L464 276.7V448zM112 225.9V56c0-4.406 3.594-8 8-8h272c4.406 0 8 3.594 8 8v169.8l33.72-28.1C438.1 194.1 442.9 191.3 448 188.9V56C448 25.12 422.9 0 392 0h-272C89.13 0 64 25.12 64 56v132.9c5.064 2.41 9.941 5.23 14.3 8.863L112 225.9zM328 96h-144C170.7 96 160 106.7 160 120C160 133.3 170.7 144 184 144h144C341.3 144 352 133.3 352 120C352 106.7 341.3 96 328 96zM328 176h-144C170.7 176 160 186.7 160 200C160 213.3 170.7 224 184 224h144C341.3 224 352 213.3 352 200C352 186.7 341.3 176 328 176z"></path></svg>
                                        <span class="datatext" datatext="{$urls.pages.contact|base64_encode}">{l s='Contact' mod='dbmenu'}</span>
                                    </li>
                                </ul>
                            </div>
                        {/if}

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
