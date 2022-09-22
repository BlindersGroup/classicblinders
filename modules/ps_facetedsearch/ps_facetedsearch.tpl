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

{if Context::getContext()->getDevice() == 4}
    {if isset($listing.rendered_facets)}

        <div class="modal fade right" id="filters_category" tabindex="-1" role="dialog" aria-labelledby="filters_category_Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title" id="filters_category_Label">{l s='Filter' d='Shop.Theme.Actions'}</span>
                        {*<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>*}
                    </div>
                    <div class="modal-body">
                        {$listing.rendered_facets nofilter}
                        <div id="search_filter_controls">
                            <span id="_mobile_search_filters_clear_all"></span>
                            <button class="btn btn-secondary ok" data-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-check"></i>
                                {l s='Filter' d='Shop.Theme.Actions'}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {/if}

{else}

    {if isset($listing.rendered_active_filters)}
        {$listing.rendered_active_filters nofilter}
    {/if}

    {if isset($listing.rendered_facets)}
        {$listing.rendered_facets nofilter}
    {/if}

{/if}
