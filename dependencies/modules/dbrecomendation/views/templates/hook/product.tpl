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

<div class="dbrecommendation product_card">
    <p class="title h3">{l s='Recomendación del experto' d='Shop.Theme.Catalog'}</p>
    <div class="recommend">
        <div class="recommend_author">
            <img src="{$recommendation.img}" width="50" height="50" alt="">
            <div class="recommend_author-info">
                <span class="name">{$recommendation.name_author}</span>
                <span class="profession">{$recommendation.profession}</span>
                <span class="tag">
                    <svg viewBox="0 0 24 24" id="verified" xmlns="http://www.w3.org/2000/svg"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"></path></svg>
                    {$recommendation.tag}
                </span>
            </div>
        </div>
        <div class="recommend_text">
            {$recommendation.recomendation nofilter}
        </div>
    </div>
</div>
