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

{if $products|count > 0}
<section class="featured-products clearfix mt-3">
  <p class="h3 products-section-title">
    {l s='New products' d='Shop.Theme.Catalog'}
  </p>

  <div id="splide_newproducts" class="splide">
    <div class="splide__track">
      <div class="splide__list">
        {foreach from=$products item=product}
          <div class="splide__slide">
            {include file="catalog/_partials/miniatures/product.tpl" product=$product}
          </div>
        {/foreach}
      </div>
    </div>
  </div>

    <script>
        document.addEventListener( 'DOMContentLoaded', function () {
            new Splide( '#splide_newproducts', {
                perPage     : 5,
                pagination: false,
                lazyLoad: 'sequential',
                arrows: true,
                breakpoints: {
                    600: {
                        perPage: 2,
                        padding: {
                          right: '2rem',
                        },
                        arrows: false,
                    },
                    800: {
                        perPage: 2,
                        padding: {
                          right: '2rem',
                        },
                        arrows: false,
                    },
                    1200: {
                        perPage: 4,
                    }
                }
            } ).mount();
        } );
    </script>

</section>
{/if}

