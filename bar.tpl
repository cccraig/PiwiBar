<div id="piwi-bar" class="regular closable" style="color:{$link_color};background-color:{$bg}">
    <div class="piwi-content-wrapper">
        <div class="piwi-text-wrapper">
            <div class="piwi-headline-text">
                <p><span>{$msg}</span></p>
            </div>
        </div>
				{if $newtab == 1}
        <a href="{$url_link}" target="_blank" class="piwi-cta piwi-cta-button" style="background-color:{$btn_color};border-color:{$btn_color}">
            <div class="piwi-text-holder">
                <p>{$btn_text}</p>
            </div>
        </a>
				{else}
        <a href="{$url_link}" class="piwi-cta piwi-cta-button" style="background-color:{$btn_color};border-color:{$btn_color}">
            <div class="piwi-text-holder">
                <p>{$btn_text}</p>
            </div>
        </a>
				{/if}
    </div>
    <div class="piwi-close-wrapper">
        {if $duration == 0}
          <a onclick="this.parentNode.parentNode.style.display='none';" class="icon-close">&#10006;</a>
        {/if}
    </div>
</div>
