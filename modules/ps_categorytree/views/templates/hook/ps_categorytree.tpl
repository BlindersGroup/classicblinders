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

{if $db_subcategories == 0}
  {function name="categories" nodes=[] depth=0}
    {strip}
      {if $nodes|count}
        <ul class="category-sub-menu">
          {foreach from=$nodes item=node}
            <li data-depth="{$depth}">
              {if $depth===0}
                <a href="{$node.link}">{$node.name}</a>
                {if $node.children}
                  <div class="navbar-toggler collapse-icons" data-toggle="collapse" data-target="#exCollapsingNavbar{$node.id}">
                    <i class="fa-solid fa-plus add"></i>
                    <i class="fa-solid fa-minus remove"></i>
                  </div>
                  <div class="collapse" id="exCollapsingNavbar{$node.id}">
                    {categories nodes=$node.children depth=$depth+1}
                  </div>
                {/if}
              {else}
                <a class="category-sub-link" href="{$node.link}">{$node.name}</a>
                {if $node.children}
                  <span class="arrows" data-toggle="collapse" data-target="#exCollapsingNavbar{$node.id}">
                    <i class="fa-solid fa-angle-right arrow-right"></i>
                    <i class="fa-solid fa-angle-down arrow-down"></i>
                  </span>
                  <div class="collapse" id="exCollapsingNavbar{$node.id}">
                    {categories nodes=$node.children depth=$depth+1}
                  </div>
                {/if}
              {/if}
            </li>
          {/foreach}
        </ul>
      {/if}
    {/strip}
  {/function}

  {if $categories.children|count > 0}
    <div class="block-categories hidden-sm-down">
      <ul class="category-top-menu">
        <li><span class="h6">{l s='Subcategories' d='Shop.Theme.Actions'}</span></li>
        <li>{categories nodes=$categories.children}</li>
        {*{if $categories.children|count > 5}
          <p class="read-more"><span class="button">{l s='Ver más' d='Shop.Theme.Actions'} <i class="fa-solid fa-angle-down"></i></span></p>
        {/if}*}
      </ul>
      <hr>
    </div>
  {/if}
{/if}