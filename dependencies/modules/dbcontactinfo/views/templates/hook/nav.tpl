<div class="dbcontactinfo_nav">
    <span class="open_contact">
        {l s='Contacta con nosotros' mod='dbcontactinfo'}
        <i class="fa-solid fa-angle-down"></i>
    </span>
    <div class="block_dbcontactinfo">
        <img src="{$dir_module}views/img/imagen_modal.png" alt="{l s='Contactar' mod='dbcontactinfo'}" width="120" height="143" loading="lazy">
        <div class="data_dbcontactinfo">
            <div class="data_email">
{*                <i class="fa-solid fa-envelope"></i>*}
                <div class="text_email">
                    <span class="title">{l s='Enviar un email' mod='dbcontactinfo'}</span>
                    <span class="value"><strong>{$email}</strong></span>
                </div>
            </div>
            <div class="data_phone">
{*                <i class="fa-solid fa-phone"></i>*}
                <div class="text_phone">
                    <span class="title">{l s='Llámanos' mod='dbcontactinfo'}</span>
                    <span class="value"><strong>{$phone}</strong></span>
                    <span class="value horario">{$horario}</span>
                </div>
            </div>
            {if $ofuscador == 1}
                <span datatext="{$urls.pages.contact|base64_encode}" class="btn btn-primary datatext">{l s='Contacto' mod='dbcontactinfo'}</span>
            {else}
                <a href="{$urls.pages.contact}" class="btn btn-primary">{l s='Contacto' mod='dbcontactinfo'}</a>
            {/if}
        </div>
    </div>
</div>
