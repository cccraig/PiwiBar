<div id="hellobar-bar" class="regular closable" style="color:{$link_color};background-color:{$bg}">
    <div class="hb-content-wrapper">
        <div class="hb-text-wrapper">
            <div class="hb-headline-text">
                <p><span>{$msg}</span></p>
            </div>
        </div>
				{if $newtab == 1}
        <a href="{$url_link}" target="_blank" class="hb-cta hb-cta-button" style="background-color:{$btn_color};border-color:{$btn_color}">
            <div class="hb-text-holder">
                <p>{$btn_text}</p>
            </div>
        </a>
				{else}
        <a href="{$url_link}" class="hb-cta hb-cta-button" style="background-color:{$btn_color};border-color:{$btn_color}">
            <div class="hb-text-holder">
                <p>{$btn_text}</p>
            </div>
        </a>
				{/if}
    </div>
    <div class="hb-close-wrapper">
        {if $duration == 0}
          <a onclick="this.parentNode.parentNode.style.display='none';" class="icon-close">&#10006;</a>
        {/if}
    </div>
</div>
