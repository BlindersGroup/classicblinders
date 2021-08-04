<div class="dbcontactinfo_top hidden-sm-down">
    {if $phone_top == 1}
        <div class="dbcontactinfo_top_phone">
            <i class="material-icons">call</i>
            <span class="phone_data">
                <span class="text">{l s='Pedidos telefónicos' mod='dbcontactinfo'}</span>
                <span class="phone">{$phone}</span>
            </span>
        </div>
    {/if}

    {if $displaytop == 1}
        {if $ofuscador == 1}
            <span class="link_contact datatext" datatext="{$urls.pages.contact|base64_encode}">
        {else}
            <a class="link_contact datatext" href="{$urls.pages.contact}">
        {/if}
            <i class="material-icons">contact_support</i>
        {if $ofuscador == 1}
            </span>
        {else}
            </a>
        {/if}
    {/if}
</div>