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

<link rel="preload" href="{$route_module}assets/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{$route_module}assets/webfonts/fa-regular-400.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{$route_module}assets/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{$route_module}assets/webfonts/fa-v4compatibility.woff2" as="font" type="font/woff2" crossorigin>

{if $custom_css.material_icon == 1}
    <link rel="preload" href="{$urls.theme_assets}fonts/material-icons.woff2" as="font" type="font/woff2" crossorigin>
{/if}

{if !empty($custom_css.google_font)}
    <link rel="dns-prefetch" href="//fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family={$custom_css.google_font_url}:wght@400;500;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family={$custom_css.google_font_url}:wght@400;500;700&display=swap"></noscript>
{/if}

<style>
    :root {
        {if !empty($custom_css.google_font)}
        --font_primary: "{$custom_css.google_font}", sans-serif;
        --font_second: "{$custom_css.google_font}", sans-serif;
        {else}
        --font_primary: sans-serif;
        --font_second: sans-serif;
        {/if}
        --primary_color: {$custom_css.primary_color};
        --second_color: {$custom_css.second_color};
        --background: {$custom_css.background};
        --color_font: {$custom_css.color_font};
        --color_link: {$custom_css.color_link};
        --color_hover: {$custom_css.color_hover};

        --button_p_bk: {$custom_css.button_p_bk};
        --button_p_color: {$custom_css.button_p_color};
        --button_p_border: {$custom_css.button_p_border};
        --button_p_bk_hover: {$custom_css.button_p_bk_hover};
        --button_p_color_hover: {$custom_css.button_p_color_hover};
        --button_p_border_hover: {$custom_css.button_p_border_hover};
        --button_s_bk: {$custom_css.button_s_bk};
        --button_s_color: {$custom_css.button_s_color};
        --button_s_border: {$custom_css.button_s_border};
        --button_s_bk_hover: {$custom_css.button_s_bk_hover};
        --button_s_color_hover: {$custom_css.button_s_color_hover};
        --button_s_border_hover: {$custom_css.button_s_border_hover};
        --button_t_bk: {$custom_css.button_t_bk};
        --button_t_color: {$custom_css.button_t_color};
        --button_t_border: {$custom_css.button_t_border};
        --button_t_bk_hover: {$custom_css.button_t_bk_hover};
        --button_t_color_hover: {$custom_css.button_t_color_hover};
        --button_t_border_hover: {$custom_css.button_t_border_hover};
        --button_bk: {$custom_css.button_bk};
        --button_color: {$custom_css.button_color};
        --button_border: {$custom_css.button_border};
        --button_bk_hover: {$custom_css.button_bk_hover};
        --button_color_hover: {$custom_css.button_color_hover};
        --button_border_hover: {$custom_css.button_border_hover};

        --topbar_bk: {$custom_css.topbar_bk};
        --topbar_color: {$custom_css.topbar_color};
        --topbar_link: {$custom_css.topbar_link};
        --topbar_hover: {$custom_css.topbar_hover};
        --header_bk: {$custom_css.header_bk};
        --header_color: {$custom_css.header_color};
        --header_link: {$custom_css.header_link};
        --header_hover: {$custom_css.header_hover};
        --search_bk: {$custom_css.search_bk};
        --seach_color: {$custom_css.seach_color};
        --color_icons_header: {$custom_css.color_icons_header};

        --prefooter_bk: {$custom_css.prefooter_bk};
        --prefooter_color: {$custom_css.prefooter_color};
        --prefooter_link: {$custom_css.prefooter_link};
        --prefooter_hover: {$custom_css.prefooter_hover};
        --footer_bk: {$custom_css.footer_bk};
        --footer_color: {$custom_css.footer_color};
        --footer_link: {$custom_css.footer_link};
        --footer_hover: {$custom_css.footer_hover};
        --footercopy_bk: {$custom_css.footercopy_bk};
        --footercopy_color: {$custom_css.footercopy_color};
    }
</style>
