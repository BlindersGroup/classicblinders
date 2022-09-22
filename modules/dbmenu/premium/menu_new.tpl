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
        {if count($additional) > 0}
            <div class="element_nav additional">
                {foreach from=$additional item=addi}
                    <span datatext="{$addi.url|base64_encode}" class="datatext">{$addi.title}</span>
                {/foreach}
            </div>
        {/if}
        {if count($featured) > 0}
            <div class="element_nav featured">
                {foreach from=$featured item=featur}
                    <span datatext="{$featur.url|base64_encode}" class="datatext">{$featur.title}</span>
                {/foreach}
            </div>
        {/if}
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
                            <span class="title">{l s='Categories' mod='dbmenu'}</span>
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

                        <div class="dbmenu_inside">
                            {hook h='displayMenuInside'}
                        </div>

                        {if $show_contact}
                            <div class="dbmenu_contact">
                                <span class="title">{l s='Contacta con nosotros' mod='dbmenu'}</span>
                                {if $show_email}
                                    <div class="data_line">
                                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="envelope-open-text" class="svg-inline--fa fa-envelope-open-text fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M476.8 214.2c-8.244 0-16.23 2.891-22.56 8.168l-156.9 130.8c-22.68 18.9-59.8 18.91-82.49 .002L57.8 222.3c-6.332-5.277-14.32-8.168-22.56-8.168C15.78 214.2 0 229.9 0 249.4v198.6C0 483.3 28.65 512 64 512h384c35.35 0 64-28.67 64-64.01V249.4C512 229.9 496.2 214.2 476.8 214.2zM464 448c0 8.822-7.178 16-16 16H64c-8.822 0-16-7.178-16-16V276.7l136.1 113.4C204.3 406.8 229.8 416.1 256 416.1s51.75-9.224 71.97-26.02L464 276.7V448zM112 225.9V56c0-4.406 3.594-8 8-8h272c4.406 0 8 3.594 8 8v169.8l33.72-28.1C438.1 194.1 442.9 191.3 448 188.9V56C448 25.12 422.9 0 392 0h-272C89.13 0 64 25.12 64 56v132.9c5.064 2.41 9.941 5.23 14.3 8.863L112 225.9zM328 96h-144C170.7 96 160 106.7 160 120C160 133.3 170.7 144 184 144h144C341.3 144 352 133.3 352 120C352 106.7 341.3 96 328 96zM328 176h-144C170.7 176 160 186.7 160 200C160 213.3 170.7 224 184 224h144C341.3 224 352 213.3 352 200C352 186.7 341.3 176 328 176z"></path></svg>
                                        <div class="text_line">
                                            <span class="title">{l s='Enviar un email' mod='dbmenu'}</span>
                                            <span class="value"><strong>{$email}</strong></span>
                                        </div>
                                    </div>
                                {/if}
                                {if $show_phone}
                                <div class="data_line">
                                    <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="phone" class="svg-inline--fa fa-phone fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M480.3 320.3L382.1 278.2c-21.41-9.281-46.64-3.109-61.2 14.95l-27.44 33.5c-44.78-25.75-82.29-63.25-108-107.1l33.55-27.48c17.91-14.62 24.09-39.7 15.02-61.05L191.7 31.53c-10.16-23.2-35.34-35.86-59.87-30.19l-91.25 21.06C16.7 27.86 0 48.83 0 73.39c0 241.9 196.7 438.6 438.6 438.6c24.56 0 45.53-16.69 50.1-40.53l21.06-91.34C516.4 355.5 503.6 330.3 480.3 320.3zM463.9 369.3l-21.09 91.41c-.4687 1.1-2.109 3.281-4.219 3.281c-215.4 0-390.6-175.2-390.6-390.6c0-2.094 1.297-3.734 3.344-4.203l91.34-21.08c.3125-.0781 .6406-.1094 .9531-.1094c1.734 0 3.359 1.047 4.047 2.609l42.14 98.33c.75 1.766 .25 3.828-1.25 5.062L139.8 193.1c-8.625 7.062-11.25 19.14-6.344 29.14c33.01 67.23 88.26 122.5 155.5 155.5c9.1 4.906 22.09 2.281 29.16-6.344l40.01-48.87c1.109-1.406 3.187-1.938 4.922-1.125l98.26 42.09C463.2 365.2 464.3 367.3 463.9 369.3z"></path></svg>
                                    <div class="text_line">
                                        <span class="title">{l s='Llámanos' mod='dbmenu'}</span>
                                        <span class="value"><strong>{$phone}</strong></span>
                                        {if $show_schedule}
                                            <span class="schedule">{$schedule}</span>
                                        {/if}
                                    </div>
                                </div>
                                {/if}
                                {if $show_whatsapp}
                                    <div class="btn_whatsapp">
                                        <span class="btn btn-primary datatext" datatext="{$link_whatsapp|base64_encode}" datatarget="blank">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="whatsapp" class="svg-inline--fa fa-whatsapp fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path></svg>
                                            {l s='WhatsApp' mod='dbmenu'}
                                        </span>
                                    </div>
                                {/if}
                            </div>
                        {/if}

                        {if $show_opinions}
                            <div class="dbmenu_opinions">
                                <span class="title">{l s='Opiniones verificadas' mod='dbmenu'}</span>
                                <div class="block_productcomments">
                                    <div class="comments">
                                        <div class="comments_data">
                                            {*<span class="title_menu">{l s='Opiniones verificadas' mod='dbmenu'}</span>*}
                                            <div class="comments_stars">
                                                <span class="comments_total">{$productcomments.avg_comment}/5</span>
                                                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M316.7 17.8l65.43 132.4l146.4 21.29c26.27 3.796 36.79 36.09 17.75 54.59l-105.9 102.1l25.05 145.5c4.508 26.31-23.23 45.9-46.49 33.7L288 439.6l-130.9 68.7C133.8 520.5 106.1 500.9 110.6 474.6l25.05-145.5L29.72 226.1c-19.03-18.5-8.516-50.79 17.75-54.59l146.4-21.29l65.43-132.4C271.1-6.083 305-5.786 316.7 17.8z"></path></svg>
                                            </div>
                                            <span class="resume_stars">
                                                {l s='De más de %total_comment% opiniones.' sprintf=['%total_comment%' => $productcomments.total_comment] mod='dbmenu'}
                                            </span>
                                        </div>
                                        {*<div class="comment_img">
                                            <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="comments-question-check" class="svg-inline--fa fa-comments-question-check fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M208 220c-11.04 0-20 8.953-20 20c0 11.04 8.955 20 20 20S228 251 228 240C228 228.1 219 220 208 220zM221.8 88H191.1c-24.39 0-44.23 19.84-44.23 44.23c0 8.844 7.156 16 16 16s16-7.156 16-16C178.8 125.5 184.3 120 191.1 120h30.7c8.5 0 15.41 6.906 15.41 15.41c0 5.875-3.266 11.16-8.516 13.78L200.8 163.1C195.4 165.8 192 171.3 192 177.4V192c0 8.844 7.156 16 16 16S224 200.8 224 192V187.3l18.95-9.484C259.1 169.8 269.2 153.5 269.2 135.4C269.2 109.3 247.9 88 221.8 88zM599.6 443.7C624.8 413.9 640 376.6 640 336C640 238.8 554 160 448 160c-.3145 0-.6191 .041-.9336 .043C447.5 165.3 448 170.6 448 176c0 98.62-79.68 181.2-186.1 202.5C282.7 455.1 357.1 512 448 512c33.69 0 65.32-8.008 92.85-21.98C565.2 502 596.1 512 632.3 512c3.059 0 5.76-1.725 7.02-4.605c1.229-2.879 .6582-6.148-1.441-8.354C637.6 498.7 615.9 475.3 599.6 443.7zM542.5 317.8l-84 88c-3.719 3.891-8.859 6.125-14.23 6.188c-5.297 0-10.62-2.109-14.38-5.859l-40-40c-7.812-7.812-7.812-20.47 0-28.28s20.47-7.812 28.28 0l25.53 25.53l69.86-73.2c7.656-8 20.3-8.297 28.28-.6562C549.8 297.2 550.1 309.8 542.5 317.8zM416 176C416 78.8 322.9 0 208 0S0 78.8 0 176c0 41.63 17.18 79.81 45.73 109.9c-16.34 31.43-38.47 55.57-38.99 55.96c-6.746 7.15-8.635 17.81-4.721 26.98C5.93 378.1 14.97 384 24.95 384c54.18 0 98.32-19.24 128.1-38.22C171.2 349.7 189.3 352 208 352C322.9 352 416 273.2 416 176zM208 304c-14.16 0-28.77-1.689-43.41-5.021L145.4 294.6l-16.72 10.35c-17 10.52-34.42 18.39-52.14 23.57c4.184-6.668 8.191-13.57 11.77-20.45l15.78-30.34L80.57 252.9C65.71 237.3 48 211.2 48 176c0-70.58 71.78-128 160-128s160 57.42 160 128S296.2 304 208 304z"></path></svg>
                                        </div>*}
                                    </div>
                                </div>
                            </div>
                        {/if}

                        {if $show_rrss && (!empty($rrss.facebook) || !empty($rrss.twitter) || !empty($rrss.linkedin)
                        || !empty($rrss.instagram) || !empty($rrss.youtube))}
                            <div class="dbmenu_follow">
                                <span class="title">{l s='Follow us' mod='dbmenu'}</span>
                                <ul class="items">
                                    {if !empty($rrss.facebook)}
                                        <li class="item">
                                            <a href="{$rrss.facebook}" target="_blank" rel="me follow">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" class="svg-inline--fa fa-facebook-f fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M279.1 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.4 0 225.4 0c-73.22 0-121.1 44.38-121.1 124.7v70.62H22.89V288h81.39v224h100.2V288z"></path></svg>
                                            </a>
                                        </li>
                                    {/if}
                                    {if !empty($rrss.twitter)}
                                        <li class="item">
                                            <a href="{$rrss.twitter}" target="_blank" rel="me follow">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter" class="svg-inline--fa fa-twitter fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M459.4 151.7c.325 4.548 .325 9.097 .325 13.65 0 138.7-105.6 298.6-298.6 298.6-59.45 0-114.7-17.22-161.1-47.11 8.447 .974 16.57 1.299 25.34 1.299 49.06 0 94.21-16.57 130.3-44.83-46.13-.975-84.79-31.19-98.11-72.77 6.498 .974 12.99 1.624 19.82 1.624 9.421 0 18.84-1.3 27.61-3.573-48.08-9.747-84.14-51.98-84.14-102.1v-1.299c13.97 7.797 30.21 12.67 47.43 13.32-28.26-18.84-46.78-51.01-46.78-87.39 0-19.49 5.197-37.36 14.29-52.95 51.65 63.67 129.3 105.3 216.4 109.8-1.624-7.797-2.599-15.92-2.599-24.04 0-57.83 46.78-104.9 104.9-104.9 30.21 0 57.5 12.67 76.67 33.14 23.72-4.548 46.46-13.32 66.6-25.34-7.798 24.37-24.37 44.83-46.13 57.83 21.12-2.273 41.58-8.122 60.43-16.24-14.29 20.79-32.16 39.31-52.63 54.25z"></path></svg>
                                            </a>
                                        </li>
                                    {/if}
                                    {if !empty($rrss.linkedin)}
                                        <li class="item">
                                            <a href="{$rrss.linkedin}" target="_blank" rel="me follow">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="linkedin-in" class="svg-inline--fa fa-linkedin-in fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M100.3 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.6 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.3 61.9 111.3 142.3V448z"></path></svg>
                                            </a>
                                        </li>
                                    {/if}
                                    {if !empty($rrss.instagram)}
                                        <li class="item">
                                            <a href="{$rrss.instagram}" target="_blank" rel="me follow">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="instagram" class="svg-inline--fa fa-instagram fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>
                                            </a>
                                        </li>
                                    {/if}
                                    {if !empty($rrss.youtube)}
                                        <li class="item">
                                            <a href="{$rrss.youtube}" target="_blank" rel="me follow">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="youtube" class="svg-inline--fa fa-youtube fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M549.7 124.1c-6.281-23.65-24.79-42.28-48.28-48.6C458.8 64 288 64 288 64S117.2 64 74.63 75.49c-23.5 6.322-42 24.95-48.28 48.6-11.41 42.87-11.41 132.3-11.41 132.3s0 89.44 11.41 132.3c6.281 23.65 24.79 41.5 48.28 47.82C117.2 448 288 448 288 448s170.8 0 213.4-11.49c23.5-6.321 42-24.17 48.28-47.82 11.41-42.87 11.41-132.3 11.41-132.3s0-89.44-11.41-132.3zm-317.5 213.5V175.2l142.7 81.21-142.7 81.2z"></path></svg>
                                            </a>
                                        </li>
                                    {/if}
                                </ul>
                            </div>
                        {/if}

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
