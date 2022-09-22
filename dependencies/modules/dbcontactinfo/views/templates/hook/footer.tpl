<div class="dbcontactinfo_footer">
    <div class="footer_contactinfo">
        <p class="pretitle">{l s='Estamos a tu disposición' mod='dbcontactinfo'}</p>
        <p class="title">{l s='¿Alguna pregunta? Contestamos Rápidamente' mod='dbcontactinfo'}</p>

        <div class="content_contactinfo">
            <div>
                <i class="fa-regular fa-envelope-open-text"></i>
                <div class="text_contactingo">
                    <p class="title">{l s='Enviar un email' d='Shop.Theme.Customeraccount'}</p>
                    <p class="value">{$email}</p>
                </div>
            </div>
            {if $phone}
                <div>
                    <i class="fa-regular fa-phone"></i>
                    <div class="text_contactingo">
                        <p class="title">{l s='Llámanos' d='Shop.Theme.Customeraccount'}</p>
                        <p class="value val_phone">{$phone}</p>
                        <p class="postvalue">{$horario}</p>
                    </div>
                </div>
            {/if}
        </div>

    </div>
</div>