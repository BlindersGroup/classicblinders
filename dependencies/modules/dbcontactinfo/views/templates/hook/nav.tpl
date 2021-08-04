<div class="dbcontactinfo_nav">
    <span class="open_contact">
        {l s='Contacta con nosotros' mod='dbcontactinfo'}
        <i class="material-icons">keyboard_arrow_down</i>
    </span>
    <div class="block_dbcontactinfo">
        <img src="{$dir_module}views/img/mapamundi.png" width="80" height="80" loading="lazy">
        <div class="data_dbcontactinfo">
            <div class="data_email">
                <i class="material-icons">email</i>
                <div class="text_email">
                    <span class="title">{l s='Enviar un email' mod='dbcontactinfo'}</span>
                    <span class="value"><strong>{$email}</strong></span>
                </div>
            </div>
            <div class="data_phone">
                <i class="material-icons">call</i>
                <div class="text_phone">
                    <span class="title">{l s='Llámanos' mod='dbcontactinfo'}</span>
                    <span class="value"><strong>{$phone}</strong></span>
                    <span class="value">{$horario}</span>
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