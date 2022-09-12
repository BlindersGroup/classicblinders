{if $is_free}
    <p class="dbfreeshipping">{l s='Ya tienes el' mod='dbfreeshipping'} <strong>{l s='envío gratuito' mod='dbfreeshipping'}</strong></p>
{else}
    {if $product_free_shipping}
        <p class="dbfreeshipping">
            {l s='Recibe este producto sin gastos de envío' mod='dbfreeshipping'}
        </p>
    {else}
        <p class="dbfreeshipping">
            {l s='Te quedan' mod='dbfreeshipping'}
            <strong>{$remains}</strong>
            {l s='para el envío gratis' mod='dbfreeshipping'}
        </p>
    {/if}
{/if}
