{if $displaytop == 1}
    <div class="dbcontactinfo_top_center hidden-sm-down">
        {if $phone != ''}
            <span>{l s='Teléfono de contacto:'} {$phone}</span>
        {/if}

        {if $horario != ''}
            <span>{$horario}</span>
        {/if}
    </div>
{/if}
