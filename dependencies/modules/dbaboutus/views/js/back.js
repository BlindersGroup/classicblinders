/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    DevBlinders <soporte@devblinders.com>
 * @copyright Copyright (c) DevBlinders
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

$(document).ready(function() {
    // Inputs switch PRO
    $(":disabled").parents('.switch').parents('div').parents('.form-group').addClass("group_pro");
    $(":disabled").parents('.switch').parents('div').parents('.form-group').append('<span class="pro_tag">PRO</span>');
    $("input.disabled").parents('.form-group').addClass("group_pro");
    $("input.disabled").parents('.form-group').append('<span class="pro_tag">PRO</span>');
});
