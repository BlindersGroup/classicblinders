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
<div class="images-container {if $show_product_imgs == 2 && Context::getContext()->isMobile() != 1}images_lateral{/if}" data-numimgs="{count($product.images)}">

    {block name='product_cover'}

        {if count($product.images) > 1}

            {if $show_product_imgs == 1}
                {* Con miniaturas abajo *}
                <div id="splide_images_product_miniature" class="splide">
                    <div class="splide__track">
                        <div class="splide__list">
                            {foreach from=$product.images item=image}
                                <div class="splide__slide product-cover">
                                    <img
                                            class="js-qv-product-cover"
                                            src="{$image.bySize.medium_default.url}"
                                            {if $image.legend}
                                                alt="{$image.legend}"
                                            {else}
                                                alt="{$product.name}"
                                            {/if}
                                            title="{$image.legend}"
                                            itemprop="image"
                                            loading="lazy"
                                            width="{$image.bySize.medium_default.width}"
                                            height="{$image.bySize.medium_default.height}"
                                    >
                                    <div class="layer hidden-sm-down" data-toggle="modal" data-target="#product-modal">
                                        <i class="fa-solid fa-magnifying-glass zoom-in"></i>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    </div>

                    <div class="product_flags">
                        {include file='catalog/_partials/product-flags.tpl'}
                    </div>
                </div>

                <div id="splide_images_product_secundary" class="splide">
                    <div class="splide__track">
                        <div class="splide__list">
                            {foreach from=$product.images item=image}
                                <div class="splide__slide">
                                    <img
                                            class="thumb js-thumb {if $image.id_image == $product.cover.id_image} selected {/if}"
                                            data-image-medium-src="{$image.bySize.medium_default.url}"
                                            data-image-large-src="{$image.bySize.large_default.url}"
                                            src="{$image.bySize.home_default.url}"
                                            {if $image.legend}
                                                alt="{$image.legend}"
                                            {else}
                                                alt="{$product.name}"
                                            {/if}
                                            title="{$image.legend}"
                                            itemprop="image"
                                            loading="lazy"
                                            width="{$image.bySize.small_default.width}"
                                            height="{$image.bySize.small_default.height}"
                                    >
                                </div>
                            {/foreach}
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener( 'DOMContentLoaded', function () {
                        var secondarySlider = new Splide( '#splide_images_product_secundary', {
                            fixedWidth  : 70,
                            height      : 70,
                            gap         : 10,
                            cover       : true,
                            isNavigation: true,
                            focus       : 'left',
                            pagination: false,
                            arrows: false,
                            breakpoints : {
                                '991': {
                                    fixedWidth: 50,
                                    height    : 50,
                                }
                            },
                        } ).mount();

                        var primarySlider = new Splide( '#splide_images_product_miniature', {
                            perPage     : 1,
                            pagination: false,
                            arrows: true,
                        } );

                        primarySlider.sync( secondarySlider ).mount();
                    } );
                </script>

            {elseif $show_product_imgs == 2}
                {if Context::getContext()->isMobile() == 1}
                    {* En mobile por defecto sin miniaturas *}
                    <div id="splide_images_product" class="splide">
                        <div class="splide__track">
                            <div class="splide__list">
                                {foreach from=$product.images item=image}
                                    <div class="splide__slide product-cover">
                                        <img
                                                class="js-qv-product-cover"
                                                src="{$image.bySize.medium_default.url}"
                                                {if $image.legend}
                                                    alt="{$image.legend}"
                                                {else}
                                                    alt="{$product.name}"
                                                {/if}
                                                title="{$image.legend}"
                                                itemprop="image"
                                                loading="lazy"
                                                width="{$image.bySize.medium_default.width}"
                                                height="{$image.bySize.medium_default.height}"
                                        >
                                        <div class="layer hidden-sm-down" data-toggle="modal" data-target="#product-modal">
                                            <i class="fa-solid fa-magnifying-glass zoom-in"></i>
                                        </div>
                                    </div>
                                {/foreach}
                            </div>
                        </div>

                        <div class="product_flags">
                            {include file='catalog/_partials/product-flags.tpl'}
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
                    {* Con miniaturas lateral *}
                    <div id="splide_images_product_secundary_lateral" class="splide">
                        <div class="splide__track">
                            <ul class="splide__list">
                                {foreach from=$product.images item=image}
                                    <li class="splide__slide">
                                        <img
                                                class="thumb js-thumb {if $image.id_image == $product.cover.id_image} selected {/if}"
                                                data-image-medium-src="{$image.bySize.medium_default.url}"
                                                data-image-large-src="{$image.bySize.large_default.url}"
                                                src="{$image.bySize.home_default.url}"
                                                {if $image.legend}
                                                    alt="{$image.legend}"
                                                {else}
                                                    alt="{$product.name}"
                                                {/if}
                                                title="{$image.legend}"
                                                itemprop="image"
                                                loading="lazy"
                                                width="{$image.bySize.small_default.width}"
                                                height="{$image.bySize.small_default.height}"
                                        >
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                        <div class="hook_thumbnail">
                            {hook h='displayThumbnailProduct' product=$product category=$category}
                        </div>
                    </div>

                    <div id="splide_images_product_miniature_lateral" class="splide">
                        <div class="splide__track">
                            <div class="splide__list">
                                {foreach from=$product.images item=image}
                                    <div class="splide__slide product-cover">
                                        <img
                                                class="js-qv-product-cover"
                                                src="{$image.bySize.medium_default.url}"
                                                {if $image.legend}
                                                    alt="{$image.legend}"
                                                {else}
                                                    alt="{$product.name}"
                                                {/if}
                                                title="{$image.legend}"
                                                itemprop="image"
                                                loading="lazy"
                                                width="{$image.bySize.medium_default.width}"
                                                height="{$image.bySize.medium_default.height}"
                                        >
                                        <div class="layer hidden-sm-down" data-toggle="modal" data-target="#product-modal">
                                            <i class="fa-solid fa-magnifying-glass zoom-in"></i>
                                        </div>
                                    </div>
                                {/foreach}
                            </div>
                        </div>

                        <div class="product_flags">
                            {include file='catalog/_partials/product-flags.tpl'}
                        </div>
                    </div>

                    <script>
                        document.addEventListener( 'DOMContentLoaded', function () {
                            var secondarySlider = new Splide( '#splide_images_product_secundary_lateral', {
                                direction: 'ttb',
                                height   : '310px',
                                perPage     : 4,
                                pagination: false,
                                arrows: false,
                                gap         : 10,
                                cover       : true,
                                isNavigation: true,
                                fixedWidth  : 70,
                                breakpoints : {
                                    '991': {
                                        fixedWidth: 50,
                                        height    : 50,
                                        height   : '245px',
                                    }
                                },
                            } ).mount();

                            var primarySlider = new Splide( '#splide_images_product_miniature_lateral', {
                                perPage     : 1,
                                pagination: false,
                                arrows: true,
                            } ).mount();

                            primarySlider.sync( secondarySlider ).mount();
                        } );
                    </script>
                {/if}

            {else}
                {* Por defecto sin miniaturas *}
                <div id="splide_images_product" class="splide">
                    <div class="splide__track">
                        <div class="splide__list">
                            {foreach from=$product.images item=image}
                                <div class="splide__slide product-cover">
                                    <img
                                        class="js-qv-product-cover"
                                        src="{$image.bySize.medium_default.url}"
                                            {if $image.legend}
                                                alt="{$image.legend}"
                                            {else}
                                                alt="{$product.name}"
                                            {/if}
                                        title="{$image.legend}"
                                        itemprop="image"
                                        loading="lazy"
                                        width="{$image.bySize.medium_default.width}"
                                        height="{$image.bySize.medium_default.height}"
                                    >
                                    <div class="layer hidden-sm-down" data-toggle="modal" data-target="#product-modal">
                                        <i class="fa-solid fa-magnifying-glass zoom-in"></i>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    </div>

                    <div class="product_flags">
                        {include file='catalog/_partials/product-flags.tpl'}
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
            {/if}

        {else}
            {foreach from=$product.images item=image}
                <div class="product-cover">
                    <img
                            class="js-qv-product-cover"
                            src="{$image.bySize.medium_default.url}"
                            {if $image.legend}
                                alt="{$image.legend}"
                            {else}
                                alt="{$product.name}"
                            {/if}
                            title="{$image.legend}"
                            itemprop="image"
                            loading="lazy"
                            width="{$image.bySize.medium_default.width}"
                            height="{$image.bySize.medium_default.height}"
                    >
                    <div class="layer hidden-sm-down" data-toggle="modal" data-target="#product-modal">
                        <i class="fa-solid fa-magnifying-glass zoom-in"></i>
                    </div>
                </div>
            {/foreach}
        {/if}

    {/block}

</div>
{hook h='displayAfterProductThumbs'}
