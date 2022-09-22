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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2021 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="dbnewproducts mt-3">
    <div class="new_text">
        <p class="h3 title">{l s ="Novedades en %name_category%" sprintf=['%name_category%' => $name_category] mod="dbnewproducts"}</p>
    </div>

    <div id="splide_newproducts_category" class="splide">
        <div class="splide__track">
            <div class="splide__list">
                {foreach from=$products item="product"}
                    <div class="splide__slide">
                        {include file="catalog/_partials/miniatures/product.tpl" product=$product}
                    </div>
                {/foreach}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener( 'DOMContentLoaded', function () {
            new Splide( '#splide_newproducts_category', {
                perPage     : 5,
                pagination: false,
                lazyLoad: 'sequential',
                arrows: true,
                gap: '16px',
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

</div>
