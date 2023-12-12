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
        <div class="author_shortinfo">
            <div class="img_author">
                {if $author.image.webp_big == 1}
                    <picture>
                        <source srcset="{$path_img}{$author.image.big}.webp" type="image/webp">
                        <source srcset="{$path_img}{$author.image.big}" type="image/jpeg">
                        <img src="{$path_img}{$author.image.big}" alt="{$author.name|escape:'htmlall':'UTF-8'}" loading="lazy" width="250" height="250">
                    </picture>
                {else}
                    <img src="{$path_img}{$author.image.big}" alt="{$author.name|escape:'htmlall':'UTF-8'}" loading="lazy" width="250" height="250">
                {/if}
            </div>
            <div class="short_info_author">
                <div class="nameandrrss">
                    <h1 class="name">{$author.name|escape:'htmlall':'UTF-8'}</h1>
                    <ul>
                        {if !empty($author.linkedin)}
                            <li>
                                <a href="{$author.linkedin|escape:'htmlall':'UTF-8'}" rel="me" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"/></svg>
                                </a>
                            </li>
                        {/if}
                        {if !empty($author.twitter)}
                            <li>
                                <a href="{$author.twitter|escape:'htmlall':'UTF-8'}" rel="me" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>
                                </a>
                            </li>
                        {/if}
                        {if !empty($author.facebook)}
                            <li>
                                <a href="{$author.facebook|escape:'htmlall':'UTF-8'}" rel="me" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"/></svg>
                                </a>
                            </li>
                        {/if}
                        {if !empty($author.instagram)}
                            <li>
                                <a href="{$author.instagram|escape:'htmlall':'UTF-8'}" rel="me" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                                </a>
                            </li>
                        {/if}
                        {if !empty($author.youtube)}
                            <li>
                                <a href="{$author.youtube|escape:'htmlall':'UTF-8'}" rel="me" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/></svg>
                                </a>
                            </li>
                        {/if}
                        {if !empty($author.web)}
                            <li>
                                <a href="{$author.web|escape:'htmlall':'UTF-8'}" rel="me" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0zM256 464C263.4 464 282.1 456.8 303.6 415.6C312.4 397.9 319.1 376.4 325.6 352H186.4C192 376.4 199.6 397.9 208.4 415.6C229 456.8 248.6 464 256 464zM178.5 304H333.5C335.1 288.7 336 272.6 336 256C336 239.4 335.1 223.3 333.5 208H178.5C176.9 223.3 176 239.4 176 256C176 272.6 176.9 288.7 178.5 304V304zM325.6 160C319.1 135.6 312.4 114.1 303.6 96.45C282.1 55.22 263.4 48 256 48C248.6 48 229 55.22 208.4 96.45C199.6 114.1 192 135.6 186.4 160H325.6zM381.8 208C383.2 223.5 384 239.6 384 256C384 272.4 383.2 288.5 381.8 304H458.4C462.1 288.6 464 272.5 464 256C464 239.5 462.1 223.4 458.4 208H381.8zM342.1 66.61C356.2 92.26 367.4 124.1 374.7 160H440.6C419.2 118.9 384.4 85.88 342.1 66.61zM169.9 66.61C127.6 85.88 92.84 118.9 71.43 160H137.3C144.6 124.1 155.8 92.26 169.9 66.61V66.61zM48 256C48 272.5 49.93 288.6 53.57 304H130.2C128.8 288.5 128 272.4 128 256C128 239.6 128.8 223.5 130.2 208H53.57C49.93 223.4 48 239.5 48 256zM440.6 352H374.7C367.4 387.9 356.2 419.7 342.1 445.4C384.4 426.1 419.2 393.1 440.6 352zM137.3 352H71.43C92.84 393.1 127.6 426.1 169.9 445.4C155.8 419.7 144.6 387.9 137.3 352V352z"/></svg>
                                </a>
                            </li>
                        {/if}
                    </ul>
                </div>
                <div class="work">
                    <span>{$author.profession|escape:'htmlall':'UTF-8'}</span>
                    {if !empty($author.number)}<span class="colegiado">{l s='Nº colegiado' mod='dbaboutus'} {$author.number|escape:'htmlall':'UTF-8'}</span>{/if}
                </div>
                {if !empty($tag) || $total_opiniones > 0}
                    <div class="additional">
                        {if !empty($tag)}
                            <span class="label">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                                {$tag|escape:'htmlall':'UTF-8'}
                            </span>
                        {/if}
                        {if !empty($total_opiniones) && $total_opiniones > 0}
                            {if $c_active == true}
                                {include file='module:dbaboutus/views/templates/front/_partials/comment_mini.tpl'}
                            {/if}
                        {/if}
                    </div>
                {/if}
                <div class="short_description">
                    {$author.short_desc nofilter}
                </div>
            </div>
        </div>

        {if $premium == 1}
            <div class="author_content">
                <div class="{if $posts_more_read|count > 0}content_left{else}content_total{/if}">
                    <div class="body_author">
                        {if $specialities|count >= 1}
                        <div class="specialties">
                            <h2 class="title">{l s='Especialidades' mod='dbaboutus'}</h2>
                            <ul class="tags">
                                {foreach from=$specialities item=spec}
                                    <li>{$spec.name|escape:'htmlall':'UTF-8'}</li>
                                {/foreach}
                            </ul>
                        </div>
                        {/if}

                        <div class="large_descripion">
                            {$author.large_desc nofilter}
                        </div>

                        {if !empty($author.views)}
                        <div class="block_views">
                            <h2 class="title">{l s='Me has podido ver en:' mod='dbaboutus'}</h2>
                            {$author.views nofilter}
                        </div>
                        {/if}
                    </div>

                    {if $posts|count > 0}
                        <div class="posts_author">
                            <span class="title_list">{l s='Últimos posts' mod='dbaboutus'}</span>
                            <div class="dbblog_list">
                                {foreach from=$posts item=post}
                                    {include file='module:dbblog/views/templates/front/_partials/post_mini.tpl' large='l'}
                                {/foreach}
                            </div>
                        </div>
                    {/if}

                    {if $c_active == true}
                        {include file='module:dbaboutus/views/templates/front/_partials/comments.tpl'}
                    {/if}

                </div>

                {if $posts_more_read|count > 0}
                    <div class="content_right">
                        {include file='module:dbblog/views/templates/front/_partials/sidebar_more_views.tpl' more_views=$posts_more_read}
                    </div>
                {/if}

            </div>
        {/if}

    </div>
{/block}