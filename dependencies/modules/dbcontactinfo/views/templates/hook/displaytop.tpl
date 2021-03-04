<div class="dbcontactinfo_top hidden-sm-down">
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
</div>