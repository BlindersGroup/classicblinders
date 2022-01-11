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

{if isset($menu.childrens)}
    <div class="subitems subitems_{$menu.id_dbmenu_list}">
        <p class="dbmenu_back" data-subitem="subitems_{$menu.id_dbmenu_list}">
            <i class="fa-solid fa-angle-left"></i>
            {$linkback}
        </p>
        {if !empty($menu.url) && $menu.url != '#'}
            {if $menu.ofuscate == 1}
                <span class="item_viewall datatext" datatext="{$menu.url|base64_encode}">
                    {l s='Ver todos' mod='dbmenu'} {$menu.title}
                </span>
            {else}
                <a class="item_viewall" href="{$menu.url}" title="{$menu.alt}">
                    {l s='Ver todos' mod='dbmenu'} {$menu.title}
                </a>
            {/if}
        {/if}
        {foreach from=$menu.childrens key=$tipo item=dropdown}
            {if isset($dropdown.childrens)}
                <span class="item_primary open_subitems" data-subitem="subitems_{$tipo}">
                    {$dropdown.title|truncate:50:'...'}
                    <i class="fa-solid fa-angle-right"></i>
                </span>
                {assign var=menu value=$dropdown}
                {include file='module:dbmenu/views/templates/hook/subitems.tpl' linkback=$dropdown.title}
            {else}

                {if $dropdown.ofuscate == 0}
                    <a class="subitem" href="{$dropdown.url}" title="{$dropdown.alt}" {if !empty($dropdown.color)}style="color:{$dropdown.color};"{/if}>
                        {if $dropdown.strong == 1}<strong>{/if}
                            {$dropdown.title|truncate:50:'...'}
                        {if $dropdown.strong == 1}</strong>{/if}
                    </a>
                {else}
                    <span class="subitem datatext" datatext="{$dropdown.url|base64_encode}" {if !empty($dropdown.color)}style="color:{$dropdown.color};"{/if}>
                        {if $dropdown.strong == 1}<strong>{/if}
                            {$dropdown.title|truncate:50:'...'}
                        {if $dropdown.strong == 1}</strong>{/if}
                    </span>
                {/if}

            {/if}
        {/foreach}
    </div>
{/if}
