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
<nav class="pagination">

    {block name='pagination_summary'}

        <p class="text__infinitescroll">
            {l s='Has visto %to% de %total% productos' sprintf=['%from%' => $pagination.items_shown_from ,'%to%' => $pagination.items_shown_to, '%total%' => $pagination.total_items] d='Shop.Theme.Catalog'}
        </p>
        {*<div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {$pagination.items_shown_to * 100 / $pagination.total_items}%" aria-valuenow="{$pagination.items_shown_to * 100 / $pagination.total_items}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>*}
        {if ($pagination.items_shown_to * 100 / $pagination.total_items) < 100}
            {if isset($smarty.get.page)}
                {assign var="data_pag" value=$smarty.get.page+1}
            {else}
                {assign var="data_pag" value=2}
            {/if}
            <div id="btn_inifinitescroll" class="btn btn-secondary btn_inifinitescroll" data-pag="{$data_pag}">
                <span class="text">{l s='Cargar más' d='Shop.Theme.Catalog'}</span>
            </div>
        {/if}

    {/block}

</nav>
