{*
* 2007-2020 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2020 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{extends file='page.tpl'}

{block name='head_microdata'}
{/block}

{block name='hook_extra'}
    {$json_ld nofilter}
{/block}

{block name="content_wrapper"}
    <div id="content-wrapper" class="content-only">
        <div class="authors">
            <h1 class="h2 title">{$title|escape:'htmlall':'UTF-8'}</h1>
            <div class="short_description">
                {$short_desc nofilter}
            </div>
            {if $authors|count > 0}
            <div class="group_authors">
                <ul class="team_authors">
                    {foreach from=$authors item=author}
                        <li>
                            <a href="{DbAboutUsAuthor::getLink($author.link_rewrite|escape:'htmlall':'UTF-8')}" class="link_author">
                                {if $author.image.webp_big == 1}
                                    <picture>
                                        <source srcset="{$path_img}{$author.image.big}.webp" type="image/webp">
                                        <source srcset="{$path_img}{$author.image.big}" type="image/jpeg">
                                        <img src="{$path_img}{$author.image.big}" alt="{$author.name|escape:'htmlall':'UTF-8'}" loading="lazy" width="250" height="250">
                                    </picture>
                                {else}
                                    <img src="{$path_img}{$author.image.big}" alt="{$author.name|escape:'htmlall':'UTF-8'}" loading="lazy" width="250" height="250">
                                {/if}
                                <div class="text_author">
                                    <span class="name">{$author.name|escape:'htmlall':'UTF-8'}</span>
                                    <span class="work">{$author.profession|escape:'htmlall':'UTF-8'}</span>
                                    <span class="btn btn-secondary">
                                        {l s='Ver más' mod='dbaboutus'}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
                                    </span>
                                </div>
                            </a>
                        </li>
                    {/foreach}
                </ul>
            </div>
            {/if}
            <div class="large_description">
                {$large_desc nofilter}
            </div>

        </div>
    </div>
{/block}