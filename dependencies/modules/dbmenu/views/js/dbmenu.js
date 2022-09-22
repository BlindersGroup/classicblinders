/**
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
 */

/* Cuando cargamos la web, preparamos el menú    */
$(document).ready(function() {
    /* Definimos el array de dondeEstoy */
    var dondeEstoy = ["MenuPrincipal"];
    /* Definimos los distintos selectores del menú */
    var menuPrincipalTitulo = "#dbmenu_burger .modal-body .menu_header";
    var menuPrincipalCuerpo = "#dbmenu_burger .modal-body .dbmenu_primary";
    var categoriasPrincipales = "#dbmenu_burger .modal-body .dbmenu_primary .item_primary";
    var categoriasPrincipales2 = "#dbmenu_burger .modal-body .item_primary";
    var categoriasHijas = "#dbmenu_burger .modal-body .subitems";
    var principalEntrarACategoriasHijas = "#dbmenu_burger .modal-body .open_subitems";
    var categoriasSelTxt = "#dbmenu_burger .modal-body .";   // Le falta la 2ª clase -> .subitems_1
    var categoriasBack = "#dbmenu_burger .modal-body .dbmenu_back"; // Ir a categoria Padre
    var subCategoriasPadre = " .open_subitems"

    // Adaptamos el dbmenu para que se abra en mobile en todas las plantillas
    $('#header .header-nav #menu-icon').replaceWith('<span class="open_dbmenu" data-toggle="modal" data-target="#dbmenu_burger">\n' +
        '<i class="material-icons">menu</i>' +
        '</span>');

    /* Sobre las categorias padres del menú */
    var MenuPrincipal = function(accion){
        if (accion == "mostrar"){
            /* Mostramos el menú Principal */
            $(menuPrincipalTitulo).show('400');
            $(menuPrincipalCuerpo).show('400');
        } else if (accion =="ocultar") {
            $(menuPrincipalTitulo).hide('400');
            $(menuPrincipalCuerpo).hide('400');
        }
    }

    var MenuHijoOcultar = function(selector) {
        $(selector).css("height", "0px");
        $(selector).css("overflow-y", "hidden");
    };

    var MenuHijoMostrar = function(selector) {
        $(selector).css("height", "100vh");
        $(selector).css("overflow-y", "scroll");
    };

    var MenusHijos = function(accion, esteObjeto){
        claseOcultar = dondeEstoy[dondeEstoy.length - 1];
        if (accion == "irAtras") {
            // Mostramos el padre o el menu principal si procede
            selectorOcultar = categoriasSelTxt + claseOcultar;
            MenuHijoOcultar(selectorOcultar);
            if ( dondeEstoy.length == 2){
                // Si el padre es el menu principal
                MenuPrincipal("mostrar");
            } else {
                // el padre es otro hijo, por lo que lo abrimos
                claseMostrar = dondeEstoy[dondeEstoy.length - 2];
                selectorMostrar = categoriasSelTxt + claseMostrar;
                MenuHijoMostrar(selectorMostrar);
            }
            dondeEstoy.pop();
        } else if (accion == "irAHijo") {
            // Mostramos el menu hijo de este
            var categoriaMostrar = $(esteObjeto).attr('data-subitem');
            selectorMostrar = categoriasSelTxt + categoriaMostrar;
            selectorOcultar = categoriasSelTxt + claseOcultar;

            if ( dondeEstoy.length == 1){
                MenuPrincipal("ocultar");
            } else {
                MenuHijoOcultar(selectorOcultar);
            }
            MenuHijoMostrar(selectorMostrar);
            dondeEstoy.push(categoriaMostrar);
        }
    };

    /* *****************************
              Acciones
    ******************************** */
    $("#dbmenu_burger .modal-body .open_subitems").click(function() {
        /* Vamos a una categoría hija */
        MenusHijos("irAHijo", this);
        return false;
    });
    $(categoriasBack).click(function(){
        /* Vamos a la Categoría Padre */
        MenusHijos("irAtras", this);
        return false;
    });
});
/* foco  */

$("#header .open_dbmenu").click(function(){
    setTimeout(function(){
        $("#dbmenu_burger .modal-body") }, 300);
});