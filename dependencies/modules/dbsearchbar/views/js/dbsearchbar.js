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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2021 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

$(document).ready(function () {
    $(".dbsearchbar-input").on("keyup", function(e) {
        var $searchWidget = $('#search_widget');
        var $searchBox    = $searchWidget.find('input[type=text]');
        var searchURL     = $searchWidget.attr('data-search-controller-url');

        var query = $(this).val();
        if(query.length >= 3){
            $.ajax({
                data: {s: query, resultsPerPage: 10},
                type: "POST",
                dataType: "json",
                url: searchURL,
            })
                .done(function( data, textStatus, jqXHR ) {
                    if (parseInt(data.pagination.total_items) >= parseInt(data.pagination.items_shown_to)){
                        var link_search = '<a href="' + data.current_url + '?controller=search&s=' + query + '">Ver todos</a>';
                        var btn_search = '<a class="btn btn-secondary" href="' + data.current_url + '?controller=search&s=' + query + '">Ver todos</a>';

                        $('#content_search').addClass('open');
                        $('#search_widget.search-widget form').addClass('open_mobile');
                        $('#content_search .header_searchbar .searchbar_items .items_show').html(data.pagination.items_shown_to);
                        $('#content_search .header_searchbar .searchbar_items .total_items').html(data.pagination.total_items);
                        $('#content_search .header_searchbar .searchbar_items .link_allresult').html(link_search);
                        $('#content_search .allresult_searchbar').html(btn_search);
                        $('#content_search .result_searchbar').html(data.rendered_products);
                    } else {
                        $('#content_search').removeClass('open');
                        $('#search_widget.search-widget form').removeClass('open_mobile');
                    }
                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    $('#content_search').removeClass('open');
                    $('#search_widget.search-widget form').removeClass('open_mobile');
                });
        }

    });

    $("#content_search .header_searchbar .close").click(function(e) {
        $("#search_widget .dbsearchbar-input").val("");
        $('#content_search').removeClass('open');
        $('#search_widget.search-widget form').removeClass('open_mobile');
    });
});