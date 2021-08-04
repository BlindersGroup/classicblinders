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

<div class="dbmenu_import {if $premium == 0}card_premium{/if}">
    <div class="row">

        <div class="col-lg-12">
            <div class="box box_info">
                {if $premium == 0}<div class="box_premium"><span class="pro_tag">PRO</span></div>{/if}
                <div class="box_header">
                    <span class="title">{l s='Importar categorías en el menú' mod='dbmenu'}</span>
                </div>
                <div class="box_body">
                    <div class="imports">
                        <p>{l s='Desde este importador puedes importar todo el arbol de categorías y subcategorias en el menú.' mod='dbmenu'}</p>
                        <div class="form-wrapper" style="display: grid;">
                            <div class="form-group">
                                <label class="control-label col-lg-2">
                                    {l s='¿Borrar menú actual?' mod='dbmenu'}
                                </label>
                                <div class="col-lg-10">
                                    <select name="delete" id="delete_menu">
                                        <option value="0">{l s='No' mod='dbmenu'}</option>
                                        <option value="1">{l s='Si' mod='dbmenu'}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <p></p>
                        <p></p>
                        <button id="imports_categories" class="btn btn-default">{l s='Importar' mod='dbmenu'}</button>
                        <p></p>
                        <p class="import_loading blink_me">{l s='Importando las categorías, espere por favor.' mod='dbmenu'}</p>
                        <p class="import_ok">{l s='La importación se ha realizado correctamente.' mod='dbmenu'}</p>
                        <p class="import_ko">{l s='Ha habido un problema en la importación, intentelo de nuevo o contacte con DevBlinders' mod='dbmenu'}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
