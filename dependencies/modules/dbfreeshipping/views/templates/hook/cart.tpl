<div class="dbfreeshipping_cart">
    <p class="dbfreeshipping is_free {if !$is_free}hide{/if}">{l s='Ya tienes el' mod='dbfreeshipping'} <strong>{l s='envío gratuito' mod='dbfreeshipping'}</strong></p>
    <p class="dbfreeshipping is_not_free {if $is_free}hide{/if}">
        {l s='Te quedan' mod='dbfreeshipping'}
        <strong class="price_remain">{$remains}</strong>
        {l s='para el' mod='dbfreeshipping'}
        <strong>{l s='envío gratis' mod='dbfreeshipping'}</strong>
    </p>
    <div class="free_pogress">
        <span>{Tools::displayPrice(0)}</span>
        <div class="progress">
            <div id="barra-progreso" class="progress-bar" role="progressbar" style="width: {$porcent}%" aria-valuenow="{$porcent}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <span>{$free}</span>
    </div>
</div>
