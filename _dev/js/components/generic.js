// Paginacion
$(document).on('click', '.btn_inifinitescroll', function(e) {
    //var pag = $(this).data('pag');
    var pag = document.getElementById('btn_inifinitescroll').dataset.pag;
    var path = $("link[rel='canonical']").attr("href");
    //var get_url = path + '?page=' + pag + ''; // No funciona con los filtros

    params = $(location).attr('href').split('?');
    if (typeof params[1] !== 'undefined') {
        page = params[1].split('page=')
        if (typeof page[1] !== 'undefined') {
            var get_url = params[0] + '?' + page[0] + 'page=' + pag + '&from-xhr';
            var url_uri = params[0] + '?' + page[0] + 'page=' + pag;
        } else {
            var get_url = params[0] + '?' + page[0] + '&page=' + pag + '&from-xhr';
            var url_uri = params[0] + '?' + page[0] + '&page=' + pag;
        }
    } else {
        var get_url = params[0] + '?page=' + pag + '&from-xhr';
        var url_uri = params[0] + '?page=' + pag;
    }


    // Efecto cargando
    const template = `<div class="faceted-overlay">
    <div class="overlay__inner">
    <div class="overlay__content"><span class="spinner"></span></div>
    </div>
    </div>`;
    // $('#btn_inifinitescroll .text').hide();
    $('body').append(template);

    $.ajax({
        url: get_url,
        type: 'GET',
        dataType: 'json',

        success: function(json) {

            // Porcentaje de progreso
            items_shown_to = json.pagination.items_shown_to;
            total_items = json.pagination.total_items;
            porcentaje = items_shown_to * 100 / total_items;
            /*$('.pagination .progress .progress-bar').css('width', porcentaje + '%');
            $('.pagination .progress .progress-bar').attr('aria-valuenow', porcentaje + '%');

            // Texto progreso
            $('.pagination .text__infinitescroll').html('Has visto ' + items_shown_to + ' de ' + total_items + 'productos'); */

            // Borramos paginacion e insertamos
            $('.pagination').remove();

            // Insertamos los productos
            $('#js-product-list').append(json.rendered_products);

            // Boton siguiente pagina
            if (porcentaje < 100) {
                pag_next = parseInt(pag) + 1;
                $('#btn_inifinitescroll').attr('data-pag', pag_next);
            } else {
                $('#btn_inifinitescroll').remove();
            }

            // Cambiamos la url
            history.pushState({}, null, url_uri);

            // Recargamos las estrellas antiguas
            //loadProductsData();

        },

        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto de la petición en crudo y código de estatus de la petición
        error: function(xhr, status) {
            alert('Hubo un problema con la carga, intentelo de nuevo');
        },

        // código a ejecutar sin importar si la petición falló o no
        complete: function(xhr, status) {
            // Elinamos Efecto cargando
            // $('#btn_inifinitescroll .text').show();
            $('.faceted-overlay').remove();
        }
    });

});

// Inputs news DEPRECATED
/*
$(document).ready(function () {
    $('.form-control').on("click", function () {
        $(this).prev('label').addClass('has_value');
    });
    $('.form-control').keyup(function () {
        $(this).prev('label').addClass('has_value');
    });
    $('.js-visible-password').keyup(function () {
        $(this).parent('div').prev('label').addClass('has_value');
    });
    $('.form-control').focusout(function () {
        if($(this).val() == '') {
            $(this).prev('label').removeClass('has_value');
        }
    });
});*/

// + info
$(document).ready(function(){
    var $el, $ps, $up, totalHeight;
    $(document).on("click", "#left-column .category-top-menu .read-more .button", function() {

        totalHeight = 0

        $el = $(this);
        $p  = $el.parent();
        $up = $p.parent();
        $ps = $up.find("p:not('.read-more')");

        // measure how tall inside should be by adding together heights of all inside paragraphs (except read-more paragraph)
        $ps.each(function() {
            totalHeight += $(this).outerHeight();
        });

        $up
            .css({
                // Set height to prevent instant jumpdown when max height is removed
                "height": 'auto',
                "max-height": 9999
            })
        /*.animate({
            "height": totalHeight
        });*/

        // fade out read-more
        $p.fadeOut();

        // prevent jump-down
        return false;

    });
});

// Abrir menu mobile default
$(document).ready(function() {
    $('#mobile__menu').on('click', function() {
        $('#mobile_top_menu_wrapper').toggle();
    });
});
