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
<div class="dbproductcomments full_width">
    <div class="container">
        <div class="dbcomments_category">
            <div class="info_total">
                <span class="num_comments">{$total_comments} {l s='opiniones verificadas' mod='dbproductcomments'}</span>
                <span class="category">{l s='en' mod='dbproductcomments'} {$name}</span>
                <span class="media_comments">{$media_comments}/5</span>
                {include file='module:dbproductcomments/views/templates/_partials/ratings.tpl' rating=$average_media_comments width='med'}
            </div>

            {foreach from=$last_comments item=comment}
                <div class="info_comment">
                    <span><img src="//{$comment.img}" loading="lazy" height="98" width="98" alt="{$comment.product_name}"></span>
                    <span class="date_comment">{$comment.date_add|date_format:"%d/%m/%Y"} {$comment.title} {l s='en' mod='dbproductcomments'}</span>
                    <span><a href="{$comment.url}">{$comment.product_name}</a></span>
                    {include file='module:dbproductcomments/views/templates/_partials/ratings.tpl' rating=$comment.average width='min'}
                </div>
            {/foreach}
        </div>
    </div>
</div>
