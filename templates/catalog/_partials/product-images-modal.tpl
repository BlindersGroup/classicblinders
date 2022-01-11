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
<div class="modal fade js-product-images-modal" id="product-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        {assign var=imagesCount value=$product.images|count}
        <figure>
            <img
                class="js-modal-product-cover product-cover-modal"
                src="{$product.images[0].bySize.large_default.url}"
                alt="{$product.images[0].legend}"
                title="{$product.images[0].legend}"
                itemprop="image"
                loading="lazy"
                width="{$product.images[0].bySize.large_default.width}"
                height="{$product.images[0].bySize.large_default.height}"
            >
        </figure>
        <aside id="thumbnails" class="thumbnails js-thumbnails text-sm-center">
          {block name='product_images'}
            <div class="js-modal-mask mask {if $imagesCount <= 5} nomargin {/if}">
              <ul class="product-images js-modal-product-images">
                {foreach from=$product.images item=image}
                  <li class="thumb-container">
                    <img
                        data-image-large-src="{$image.large.url}"
                        class="thumb js-modal-thumb"
                        src="{$image.medium.url}"
                        alt="{$image.legend}"
                        title="{$image.legend}"
                        width="{$image.medium.width}"
                        height="{$image.medium.height}"
                        itemprop="image"
                        loading="lazy"
                    >
                  </li>
                {/foreach}
              </ul>
            </div>
          {/block}
          {if $imagesCount > 5}
            <div class="arrows js-modal-arrows">
                <i class="fa-solid fa-angle-up arrow-up js-modal-arrow-up"></i>
                <i class="fa-solid fa-angle-down arrow-down js-modal-arrow-down"></i>
            </div>
          {/if}
        </aside>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
