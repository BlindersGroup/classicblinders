{*<div class="dbfreeshipping_cart">
    {if $is_free}
        <p class="dbfreeshipping">{l s='Ya tienes el' mod='dbfreeshipping'} <strong>{l s='envío gratuito' mod='dbfreeshipping'}</strong></p>
    {else}
        <p class="dbfreeshipping">
            {l s='Te quedan' mod='dbfreeshipping'}
            <strong>{$remains}</strong>
            {l s='para el envío gratis' mod='dbfreeshipping'}
        </p>
    {/if}
    <div class="free_pogress">
        <span>{Tools::displayPrice(0)}</span>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {$porcent}%" aria-valuenow="{$porcent}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <span>{$free}</span>
    </div>
</div>*}

<div class="dbfreeshipping_cart">
    <span class="dbfreeshipping">
        <i class="material-icons">local_shipping</i>
        {l s='Envios gratis a partir de'} {$free}
    </span>
</div>