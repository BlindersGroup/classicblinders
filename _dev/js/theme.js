/**
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
 */
import 'expose-loader?Tether!tether'; // 7.2KB
import 'bootstrap/dist/js/bootstrap.min'; // 10.4KB
import 'flexibility'; // 3.6
import 'bootstrap-touchspin'; // 2.1
import 'jquery-touchswipe'; // 3.5

import './responsive';
import './checkout';
import './customer';
import './listing';
import './product';
import './cart';

import prestashop from 'prestashop';
import EventEmitter from 'events';
import DropDown from './components/drop-down'; // 0.1
import Form from './components/form'; // 0.2
import ProductMinitature from './components/product-miniature'; // 0.0
import ProductSelect from './components/product-select'; // 0.0
import TopMenu from './components/top-menu'; // 0.3

import './lib/bootstrap-filestyle.min'; // 1.4
import './lib/jquery.scrollbox.min'; // 3.9

import './components/block-cart'; // 0.1
import $ from 'jquery';

import './components/splidejs'; // 10.2
import './components/generic';

// "inherit" EventEmitter
for (const i in EventEmitter.prototype) {
  prestashop[i] = EventEmitter.prototype[i];
}

$(document).ready(() => {
  const dropDownEl = $('.js-dropdown');
  const form = new Form();
  const topMenuEl = $('.js-top-menu ul[data-depth="0"]');
  const dropDown = new DropDown(dropDownEl);
  const topMenu = new TopMenu(topMenuEl);
  const productMinitature = new ProductMinitature();
  const productSelect = new ProductSelect();
  dropDown.init();
  form.init();
  topMenu.init();
  productMinitature.init();
  productSelect.init();

  $('.carousel[data-touch="true"]').swipe({
    swipe(event, direction, distance, duration, fingerCount, fingerData) {
      if (direction == 'left') {
        $(this).carousel('next');
      }
      if (direction == 'right') {
        $(this).carousel('prev');
      }
    },
    allowPageScroll: 'vertical',
  });
});
