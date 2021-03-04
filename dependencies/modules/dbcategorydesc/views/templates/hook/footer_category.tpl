{*
* 2007-2019 PrestaShop
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
*  @author    DevBlinders <info@devblinders.com>
*  @copyright 2007-2019 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="card card-block dbcategorydesc mt-2">
    <p class="h4">{l s='Más información sobre' mod='dbcategorydesc'} {$category}</p>
    {$large_desc nofilter}
    <p class="info_eat">
        <span class="content_left">
            {if $editor}
                <span class="cat_editor">
{*                    <img src="{$editor.imagen}" loading="lazy" height="35" width="35" alt="{$editor.name}">*}
                    <span class="font-12">{l s='Redacción' mod='dbcategorydesc'}</span>
                    <a class="underline" href="{$editor.url}">{$editor.name}</a>
                </span>
            {/if}
            <span class="date_upd">
                <span class="font-12">{l s='Actualización'}:</span>
                <span>{$update|date_format:"%d/%m/%Y"}</span>
            </span>
        </span>
        <span class="content_right">
            {if $review}
                <span class="cat_review">
{*                    <img src="{$review.imagen}" loading="lazy" height="35" width="35" alt="{$editor.name}">*}
                    <span class="font-12">{l s='Revisión' mod='dbcategorydesc'}</span>
                    <a class="underline" href="{$review.url}">{$review.name}</a>
                </span>
            {/if}
            {if $tag}
                <span class="cat_tag">
                    <svg viewBox="0 0 24 24" id="verified" xmlns="http://www.w3.org/2000/svg"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"></path></svg>
                    {$tag}
                </span>
            {/if}
        </span>
    </p>
</div>