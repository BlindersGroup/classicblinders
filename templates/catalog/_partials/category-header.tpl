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
<div id="js-product-list-header">
    {if $listing.pagination.items_shown_from == 1}
        <div class="block-category card card-block">
            <div class="block-category-inner">
                <div>
                    <h1 class="h1">{$category.name}</h1>
                    {if $category.description}
                        <div id="category-description" class="text-muted">{$category.description nofilter}</div>
                    {/if}
                </div>
                {if $category.image.bySize.category_default.url}
                    <div class="category-cover">
                        <img
                            src="{$category.image.bySize.category_default.url}"
                            alt="{if !empty($category.image.legend)}{$category.image.legend}{else}{$category.name}{/if}"
                            loading="lazy"
                            width="141"
                            height="180"
                        >
                    </div>
                {/if}
            </div>
        </div>

        {if Context::getContext()->isMobile() == 1 || Context::getContext()->isTablet() == 1}
            <div id="subcategories">
                <ul class="clearfix">
                    {foreach from=$subcategories item=subcategory}
                        <li>
                            <a class="subcategory-name" href="{$link->getCategoryLink($subcategory.id_category, $subcategory.link_rewrite)|escape:'html':'UTF-8'}">{$subcategory.name|truncate:25:'...'|escape:'html':'UTF-8'}</a>
                        </li>
                    {/foreach}
                </ul>
            </div>
        {/if}
    {/if}

    {hook h='displayBeforeProductList' category=$category}
</div>
