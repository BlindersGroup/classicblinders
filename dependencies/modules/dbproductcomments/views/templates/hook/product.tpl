<div class="dbproductcomments_product mt-3" id="dbproductcomments_product">
    <span class="title h3">{l s='Opiniones del producto' mod='dbproductcomments'}</span>
    <div class="general_rating">

        {if $stars.grade > 0}

            <div class="opinion_left">
                <div class="comment_circle">
                    <span class="rate">{$stars.grade}</span>
                    {include file='module:dbproductcomments/views/templates/_partials/ratings.tpl' rating="{$stars.average}" width='max'}
                    <span class="total_stars">{$stars.total} {l s='Opiniones' mod='dbproductcomments'}</span>
                    <button type="button" class="btn btn-primary btn_opinion" data-idproduct="{$product.id}">{l s='Opinar sobre este producto' mod='dbproductcomments'}</button>
                </div>
            </div>
            <div class="opinion_right">
                <div class="comment_breakdown">
                    <div class="breakdown_star">
                        <span>{l s='5 estrellas' mod='dbproductcomments'}</span>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {$progress[5]}%" aria-valuenow="4" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="breakdown_star">
                        <span>{l s='4 estrellas' mod='dbproductcomments'}</span>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {$progress[4]}%" aria-valuenow="4" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="breakdown_star">
                        <span>{l s='3 estrellas' mod='dbproductcomments'}</span>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {$progress[3]}%" aria-valuenow="4" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="breakdown_star">
                        <span>{l s='2 estrellas' mod='dbproductcomments'}</span>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {$progress[2]}%" aria-valuenow="4" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="breakdown_star">
                        <span>{l s='1 estrella' mod='dbproductcomments'}</span>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {$progress[1]}%" aria-valuenow="4" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

        {else}

            <div class="opinion_no">
                <p class="no_opinion">{l s='Este producto no tiene opiniones ¡Sé el primero!' mod='dbproductcomments'}</p>
                <button type="button" class="btn_opinion btn btn-primary" data-idproduct="{$product.id}">{l s='Opinar sobre este producto' mod='dbproductcomments'}</button>
            </div>

        {/if}

    </div>

    <div class="row_opinions">
        {foreach from=$comments item=comment}
            {include file='module:dbproductcomments/views/templates/_partials/comment_min.tpl' comment=$comment}
        {/foreach}
    </div>

</div>
