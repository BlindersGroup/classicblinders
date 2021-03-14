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
<div class="images-container">

    {block name='product_cover'}

        {if count($product.images) > 1}
            <div id="splide_images_product" class="splide">
                <div class="splide__track">
                    <div class="splide__list">
                        {foreach from=$product.images item=image}
                            <div class="splide__slide product-cover">
                                <img
                                    class="js-qv-product-cover"
                                    src="{$image.bySize.medium_default.url}"
                                    alt="{$image.legend}"
                                    title="{$image.legend}"
                                    itemprop="image"
                                    loading="lazy"
                                    width="{$image.bySize.medium_default.width}"
                                    height="{$image.bySize.medium_default.height}"
                                >
                                <div class="layer hidden-sm-down" data-toggle="modal" data-target="#product-modal">
                                    <i class="material-icons zoom-in">search</i>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener( 'DOMContentLoaded', function () {
                    new Splide( '#splide_images_product', {
                        perPage     : 1,
                        pagination: false,
                        arrows: true,
                    } ).mount();
                } );
            </script>

        {else}
            {foreach from=$product.images item=image}
                <div class="product-cover">
                    <img
                            class="js-qv-product-cover"
                            src="{$image.bySize.medium_default.url}"
                            alt="{$image.legend}"
                            title="{$image.legend}"
                            itemprop="image"
                            loading="lazy"
                            width="{$image.bySize.medium_default.width}"
                            height="{$image.bySize.medium_default.height}"
                    >
                    <div class="layer hidden-sm-down" data-toggle="modal" data-target="#product-modal">
                        <i class="material-icons zoom-in">search</i>
                    </div>
                </div>
            {/foreach}
        {/if}
    {/block}

</div>
{hook h='displayAfterProductThumbs'}
