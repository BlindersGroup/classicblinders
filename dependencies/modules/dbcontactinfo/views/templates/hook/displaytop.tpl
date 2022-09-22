<div class="dbcontactinfo_top hidden-sm-down">
    {if $phone_top == 1}
        <div class="dbcontactinfo_top_phone">
            <i class="fa-solid fa-phone"></i>
            <span class="phone_data">
                <span class="text">{l s='Pedidos telefónicos' mod='dbcontactinfo'}</span>
                <span class="phone">{$phone}</span>
            </span>
        </div>
    {/if}

    {if $wishlist == 1}
        {if $ofuscador == 1}
            <span class="link_wishlist datatext" datatext="{$link->getModuleLink('blockwishlist', 'lists', array(), true)|escape:'html':'UTF-8'|base64_encode}">
        {else}
            <a class="link_wishlist" href="{$link->getModuleLink('blockwishlist', 'lists', array(), true)|escape:'html':'UTF-8'}">
        {/if}
            <i class="fa-solid fa-heart"></i>
            <span class="icon_name">{l s='Favoritos' mod='dbcontactinfo'}</span>
        {if $ofuscador == 1}
            </span>
        {else}
            </a>
        {/if}
    {/if}
</div>
