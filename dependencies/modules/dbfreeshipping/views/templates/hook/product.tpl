{if $is_free}
    <p class="dbfreeshipping">{l s='Ya tienes el' mod='dbfreeshipping'} <strong>{l s='envío gratuito' mod='dbfreeshipping'}</strong></p>
{else}
    <p class="dbfreeshipping">
        {l s='Te quedan' mod='dbfreeshipping'}
        <strong>{$remains}</strong>
        {l s='para el envío gratis' mod='dbfreeshipping'}
    </p>
{/if}