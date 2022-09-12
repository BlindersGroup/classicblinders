{*
* 2007-2014 PrestaShop
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
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{extends file='customer/page.tpl'}

{block name="page_content_container"}

    <div class="card card_account opiniones">
        <h1 class="title">{l s='Mis opiniones' mod='dbproductcomments'}</h1>
        <div class="separator"></div>


        <ul class="nav nav-inline nav_opinion" role="tablist">
            <li class="nav-item">
                <a
                        class="nav-link active"
                        data-link-action="show-sin-valorar"
                        data-toggle="tab"
                        href="#opinion-sin-valorar"
                        role="tab"
                        aria-controls="opinion-sin-valorar"
                        aria-selected="true"
                >
                    <span>{l s="Sin valorar" mod='dbproductcomments'}
                        {if isset($products.not_bought)}
                            <span class="number red">{$products.not_bought|count}</span>
                        {else}
                            <span class="number red">0</span>
                        {/if}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a
                        class="nav-link"
                        data-toggle="tab"
                        href="#opinion-valorados"
                        role="tab"
                        aria-controls="opinion-valorados"
                >
                    <span>{l s="Valorados" mod='dbproductcomments'}
                        {if isset($products.bought)}
                            <span class="number">{$products.bought|count}</span>
                        {else}
                            <span class="number">0</span>
                        {/if}
                    </span>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="opinion-sin-valorar" role="tabpanel">
                <div class="products_sin">
                    {if isset($products.not_bought)}
                        {foreach from=$products.not_bought item=$product}
                            <div class="product">
                                <img src="{$product.img_product}" loading="lazy" width="222" height="222">
                                <div class="content">
                                    <span class="name">{$product.name_product}</span>
                                    <a href="{$product.url_product}" target="_blank" class="btn btn-secondary btn_comment">{l s='Dar mi opinión' mod='dbproductcomments'}</a>
                                </div>
                            </div>
                        {/foreach}
                    {/if}
                </div>
            </div>

            <div class="tab-pane" id="opinion-valorados" role="tabpanel" aria-hidden="true">
                <div class="products_con row_opinions">
                    {if isset($products.bought)}
                        {foreach from=$products.bought item=$product}
                            <div class="product">
                                <img src="{$product.product.img_product}" loading="lazy" width="222" height="222">
                                <div class="content">
                                    <span class="name">{$product.product.name_product}</span>
                                    {foreach from=$product.comment item=comment}
                                        {include file='module:dbproductcomments/views/templates/_partials/comment_min.tpl' comment=$comment}
                                    {/foreach}
                                </div>
                            </div>
                        {/foreach}
                    {/if}
                </div>
            </div>
            </div>
        </div>


    </div>
{/block}

{block name='page_footer_container'}
    <div class="wishlist-footer-links">
        <a href="{$link->getPageLink('my-account', true)|escape:'html'}" class="text-primary"><i class="material-icons">chevron_left</i>{l s='Return to your account' d='Modules.Blockwishlist.Shop'}</a>
        <a href="{$urls.base_url}" class="text-primary"><i class="material-icons">home</i>{l s='Home' d='Shop.Theme.Global'}</a>
    </div>
{/block}