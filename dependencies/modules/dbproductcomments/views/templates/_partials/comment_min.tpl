<div class="opinion">
    <div class="opinion_header">
        {include file='module:dbproductcomments/views/templates/_partials/ratings.tpl' rating="{math equation="x * 100 / 5" x=$comment.grade}" width='med'}
        <span class="author">{l s='Por' mod='dbproductcomments'} {$comment.customer_name}</span>
        <span class="date">{l s='el' mod='dbproductcomments'} {$comment.date_add|date_format:"%d-%m-%Y"}</span>
        <span class="verificado">
            <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.3101 7.89868L10.0581 11.1799L8.65186 9.77368C8.35889 9.51001 7.91943 9.51001 7.65576 9.77368C7.36279 10.0667 7.36279 10.5061 7.65576 10.7698L9.53076 12.6448C9.67725 12.7913 9.85303 12.8499 10.0581 12.8499C10.2339 12.8499 10.4097 12.7913 10.5269 12.6448L14.2769 8.89478C14.5698 8.6311 14.5698 8.19165 14.2769 7.92798C14.0132 7.63501 13.5737 7.63501 13.3101 7.89868ZM10.9956 2.77173C6.83545 2.77173 3.49561 6.14087 3.49561 10.2717C3.49561 14.4319 6.83545 17.7717 10.9956 17.7717C15.1265 17.7717 18.4956 14.4319 18.4956 10.2717C18.4956 6.14087 15.1265 2.77173 10.9956 2.77173ZM10.9956 16.3655C7.62646 16.3655 4.90186 13.6409 4.90186 10.2717C4.90186 6.93188 7.62646 4.17798 10.9956 4.17798C14.3354 4.17798 17.0894 6.93188 17.0894 10.2717C17.0894 13.6409 14.3354 16.3655 10.9956 16.3655Z" fill="#179942"/>
            </svg>
            <span>{l s='Opinión verificada' mod='dbproductcomments'}</span>
        </span>
    </div>
    <span class="title_opinion">{$comment.title}</span>
    <div class="text">
        <p>{$comment.content}</p>
    </div>

    {if $premium == 1}
        <div class="recomendation">
            {if $comment.recommend == 1}
                <span class="recommend">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.04166 10C1.04166 5.05835 5.05832 1.04169 9.99999 1.04169C14.9417 1.04169 18.9583 5.05835 18.9583 10C18.9583 14.9417 14.9417 18.9584 9.99999 18.9584C5.05832 18.9584 1.04166 14.9417 1.04166 10ZM2.29166 10C2.29166 14.25 5.74999 17.7084 9.99999 17.7084C14.25 17.7084 17.7083 14.25 17.7083 10C17.7083 5.75002 14.25 2.29169 9.99999 2.29169C5.74999 2.29169 2.29166 5.75002 2.29166 10Z" fill="#318000"/>
                        <path d="M8.37454 12.8001L6.01621 10.4417C5.77454 10.2001 5.77454 9.80008 6.01621 9.55842C6.25788 9.31675 6.65788 9.31675 6.89954 9.55842L8.81621 11.4751L13.0995 7.19175C13.3412 6.95008 13.7412 6.95008 13.9829 7.19175C14.2245 7.43341 14.2245 7.83341 13.9829 8.07508L9.25788 12.8001C9.14121 12.9167 8.98288 12.9834 8.81621 12.9834C8.64954 12.9834 8.49121 12.9167 8.37454 12.8001Z" fill="#318000"/>
                    </svg>
                    {l s='Recomendaría la compra de este producto' mod='dbproductcomments'}
                </span>
            {else}
                <span class="recommend">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.04166 10C1.04166 5.05834 5.05832 1.04167 9.99999 1.04167C14.9417 1.04167 18.9583 5.05834 18.9583 10C18.9583 14.9417 14.9417 18.9583 9.99999 18.9583C5.05832 18.9583 1.04166 14.9417 1.04166 10ZM2.29166 10C2.29166 14.25 5.74999 17.7083 9.99999 17.7083C14.25 17.7083 17.7083 14.25 17.7083 10C17.7083 5.75001 14.25 2.29167 9.99999 2.29167C5.74999 2.29167 2.29166 5.75001 2.29166 10Z" fill="#BB0628"/>
                        <path d="M7.19947 12.8001C6.9578 12.5584 6.9578 12.1584 7.19947 11.9168L11.9161 7.20009C12.1578 6.95843 12.5578 6.95843 12.7995 7.20009C13.0411 7.44176 13.0411 7.84176 12.7995 8.08343L8.0828 12.8001C7.96614 12.9251 7.79947 12.9834 7.64114 12.9834C7.4828 12.9834 7.32447 12.9251 7.19947 12.8001Z" fill="#BB0628"/>
                        <path d="M11.9161 12.8001L7.19947 8.08343C6.9578 7.84176 6.9578 7.44176 7.19947 7.20009C7.44114 6.95843 7.84114 6.95843 8.0828 7.20009L12.7995 11.9168C13.0411 12.1584 13.0411 12.5584 12.7995 12.8001C12.6745 12.9251 12.5161 12.9834 12.3578 12.9834C12.1995 12.9834 12.0411 12.9251 11.9161 12.8001Z" fill="#BB0628"/>
                    </svg>
                    {l s='No recomendaría la compra de este producto' mod='dbproductcomments'}
                </span>
            {/if}
        </div>
        <div class="characteristics">
            <span class="title">{l s='Características' mod='dbproductcomments'}</span>
            <div class="characteristic">
                <span class="name">{$charact1}</span>
                <div class="rating">
                    <span class="charact active"></span>
                    <span class="charact {if $comment.characteristic1 >= 2}active{/if}"></span>
                    <span class="charact {if $comment.characteristic1 >= 3}active{/if}"></span>
                    <span class="charact {if $comment.characteristic1 >= 4}active{/if}"></span>
                    <span class="charact {if $comment.characteristic1 >= 5}active{/if}"></span>
                </div>
            </div>
            <div class="characteristic">
                <span class="name">{$charact2}</span>
                <div class="rating">
                    <span class="charact active"></span>
                    <span class="charact {if $comment.characteristic2 >= 2}active{/if}"></span>
                    <span class="charact {if $comment.characteristic2 >= 3}active{/if}"></span>
                    <span class="charact {if $comment.characteristic2 >= 4}active{/if}"></span>
                    <span class="charact {if $comment.characteristic2 >= 5}active{/if}"></span>
                </div>
            </div>
            <div class="characteristic">
                <span class="name">{$charact3}</span>
                <div class="rating">
                    <span class="charact active"></span>
                    <span class="charact {if $comment.characteristic3 >= 2}active{/if}"></span>
                    <span class="charact {if $comment.characteristic3 >= 3}active{/if}"></span>
                    <span class="charact {if $comment.characteristic3 >= 4}active{/if}"></span>
                    <span class="charact {if $comment.characteristic3 >= 5}active{/if}"></span>
                </div>
            </div>
        </div>
    {/if}
</div>
