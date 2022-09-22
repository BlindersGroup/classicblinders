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
<section class="featured-products clearfix --mt-16">
    <p class="h1 products-section-title">
        {*{if $products|@count == 1}
          {l s='%s producto de la misma categoria' sprintf=[$products|@count] d='Shop.Theme.Catalog'}
        {else}
          {l s='%s productos de la misma categoria' sprintf=[$products|@count] d='Shop.Theme.Catalog'}
        {/if}*}
        {l s='Productos que quizás te interesen' sprintf=[$products|@count] d='Shop.Theme.Catalog'}
    </p>
    <div id="splide_categoryproducts" class="splide">
        <div class="splide__track">
            <div class="splide__list">
                {foreach from=$products item="product" key="position"}
                    <div class="splide__slide">
                        {include file="catalog/_partials/miniatures/product.tpl" product=$product position=$position}
                    </div>
                {/foreach}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener( 'DOMContentLoaded', function () {
            new Splide( '#splide_categoryproducts', {
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
