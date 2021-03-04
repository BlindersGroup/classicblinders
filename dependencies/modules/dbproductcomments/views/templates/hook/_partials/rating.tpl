<div class="grade-stars {if $small == true}small-stars{/if}" data-grade="{$grade}">
    {if $page.page_name != 'product'}
        <div class="star-content star-empty clearfix">
            <div class="star" style="visibility: hidden;"></div>
            <div class="star" {if $grade >= 2}style="visibility: hidden;"{/if}></div>
            <div class="star" {if $grade >= 3}style="visibility: hidden;"{/if}></div>
            <div class="star" {if $grade >= 4}style="visibility: hidden;"{/if}></div>
            <div class="star" {if $grade >= 5}style="visibility: hidden;"{/if}></div>
        </div>
        <div class="star-content star-full clearfix">
            <div class="star-on"></div>
            {if $grade >= 2}<div class="star-on"></div>{/if}
            {if $grade >= 3}<div class="star-on"></div>{/if}
            {if $grade >= 4}<div class="star-on"></div>{/if}
            {if $grade >= 5}<div class="star-on"></div>{/if}
        </div>
    {/if}
</div>