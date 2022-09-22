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
{extends file=$layout}

{block name='head' append}
  <meta property="og:type" content="product">
  <meta property="og:url" content="{$urls.current_url}">
  <meta property="og:title" content="{$page.meta.title}">
  <meta property="og:site_name" content="{$shop.name}">
  <meta property="og:description" content="{$page.meta.description}">
  <meta property="og:image" content="{$product.cover.large.url}">
  {if $product.show_price}
    <meta property="product:pretax_price:amount" content="{$product.price_tax_exc}">
    <meta property="product:pretax_price:currency" content="{$currency.iso_code}">
    <meta property="product:price:amount" content="{$product.price_amount}">
    <meta property="product:price:currency" content="{$currency.iso_code}">
  {/if}
  {if isset($product.weight) && ($product.weight != 0)}
  <meta property="product:weight:value" content="{$product.weight}">
  <meta property="product:weight:units" content="{$product.weight_unit}">
  {/if}
{/block}

{block name='content'}

    <div class="product_topview product_columns_{$product_columns}">
        {if $product_columns == 2}
            {include file='catalog/_partials/templates/two-columns.tpl'}
        {else}
            {include file='catalog/_partials/templates/three-columns.tpl'}
        {/if}
    </div>

    <div class="product-container">

        <div class="displayProductFullWidth">
            {hook h='displayProductFullWidth' product=$product category=$category}
        </div>

        {* Parte inferior del producto*}
        {if $product_block_down == 1}
            {include file='catalog/_partials/templates/product-down-open.tpl'}
        {else}
            {include file='catalog/_partials/templates/product-down-tab.tpl'}
        {/if}

      </div>
    </div>

    {block name='product_accessories'}
      {if $accessories}
        <section class="product-accessories clearfix mt-3">
            <p class="h1 products-section-title">{l s='You might also like' d='Shop.Theme.Catalog'}</p>
            <div id="splide_productaccessories" class="splide">
              <div class="splide__track">
                  <div class="splide__list products">
                    {foreach from=$accessories item="product_accessory" key="position"}
                      <div class="splide__slide">
                          {block name='product_miniature'}
                            {include file='catalog/_partials/miniatures/product.tpl' product=$product_accessory position=$position}
                          {/block}
                      </div>
                    {/foreach}
                  </div>
              </div>
          </div>
            <script>
                document.addEventListener( 'DOMContentLoaded', function () {
                    new Splide( '#splide_productaccessories', {
                        perPage     : 5,
                        pagination: false,
                        lazyLoad: 'sequential',
                        arrows: true,
                        breakpoints: {
                            575: {
                                perPage: 1,
                                padding: {
                                    right: '30%',
                                },
                                arrows: false,
                                gap: '16px',
                            },
                            767: {
                                perPage: 2,
                                padding: {
                                    right: '15%',
                                },
                                arrows: false,
                                gap: '16px',
                            },
                            992: {
                                perPage: 3,
                                padding: {
                                    right: '10%',
                                },
                                arrows: false,
                                gap: '16px',
                            },
                            1200: {
                                perPage: 5,
                            }
                        },
                    } ).mount();
                } );
            </script>
        </section>
      {/if}
    {/block}

    {block name='product_footer'}
      {hook h='displayFooterProduct' product=$product category=$category}
    {/block}

    {block name='product_images_modal'}
      {include file='catalog/_partials/product-images-modal.tpl'}
    {/block}

    {block name='page_footer_container'}
      <footer class="page-footer">
        {block name='page_footer'}
          <!-- Footer content -->
        {/block}
      </footer>
    {/block}
  </section>

{/block}
