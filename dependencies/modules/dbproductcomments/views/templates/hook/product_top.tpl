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
* @author    DevBlinders <soporte@devblinders.com>
* @copyright Copyright (c) DevBlinders
* @license   Commercial license
*}
<div class="dbproduct_list_reviews">
    {include file='module:dbproductcomments/views/templates/_partials/ratings.tpl' rating=$stars.average width='min'}
    {if $stars.total > 0}
        <span class="total_stars text_small">({$stars.total} {l s='opiniones' mod='dbproductcomments'})</span>
    {/if}
</div>
