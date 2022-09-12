$(document).ready(function() {
    // EVENTO EN CARRITO
    prestashop.on('updateCart', function (event) {
        updateAjaxFreeShipping();
    });

    // EVENTOS EN CART MODAL
    $(document).on("click", '#blockcart-modal .btn-touchspin', function () {
        setTimeout(updateAjaxFreeShipping, 200);
    });

    $(document).on("click", '#blockcart-modal .delete_product', function () {
        setTimeout(updateAjaxFreeShipping, 200);
    });


    function updateAjaxFreeShipping(){
        requestData = {
            action: 'update_cart',
        }

        $.ajax({
            url: dbfreeshipping_ajax,
            type: 'POST',
            data: requestData,
            dataType: 'json',
        })
            .then(function (response) {

                if(response.cart.is_free == false){
                    $('.dbfreeshipping.is_free').removeClass('hide');
                    $('.dbfreeshipping.is_not_free').removeClass('hide');
                    $('.dbfreeshipping.is_free').addClass('hide');

                    $('.dbfreeshipping.is_not_free .price_remain').html(response.cart.remains);

                    document.getElementById('barra-progreso').setAttribute("aria-valuenow", response.cart.porcent);
                    document.getElementById('barra-progreso').style.width = response.cart.porcent + "%";

                }else{
                    $('.dbfreeshipping.is_free').removeClass('hide');
                    $('.dbfreeshipping.is_not_free').removeClass('hide');
                    $('.dbfreeshipping.is_not_free').addClass('hide');

                    fijar_maximo = document.getElementById('barra-progreso').getAttribute("aria-valuenow");
                    if (fijar_maximo != 100) {
                        document.getElementById('barra-progreso').setAttribute("aria-valuenow", 100);
                        document.getElementById('barra-progreso').style.width = 100 + "%";
                    }
                }
            });
    }
});
