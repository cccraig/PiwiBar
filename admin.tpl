{html_style}
.nice{
    display: inline-block;
    background: white;
    border-radius: 10px;
    font-family: "arial-black";
    font-size: 14px;
    color: black;
    padding: 4px 8px;
}

.parent {
	width: 100%;
	margin: 0 auto;
	align-content: left;
}

.labels {
	width: 200px;
	float: left;
}

.inputs {
	width: 200px;
	margin-left: 200px;
}

.ta {
	border-radius: 10px 10px 0px 10px;
}

{/html_style}

<!-- Show the title of the plugin -->
<div class="titlePage">
  <h2>{'Notification Bar'|translate}</h2>
</div>


 <form method="post" id="notebar" action="{$PLUGIN_ACTION}" class="general">

	<!-- Logo for footer -->
	<fieldset class="mainConf">
		<legend>{'Configuration'|translate}</legend>

		<div align="left" class="parent">
			<div class="labels">
				<label for="msg">{'Message:'|translate}</label>
			</div>
			<div class="inputs">
				<input class="nice" size="70" type="text" name="msg" value="{$msg}" placeholder="Check out our new image gallery!"/>
        <pre>One time message to display</pre>
			</div> <br>
		</div>

		<div align="left" class="parent">
			<div class="labels">
				<label for="url_link">{'Link:'|translate}</label>
			</div>
			<div class="inputs">
				<input class="nice" size="70" type="text" name="url_link" value="{$url_link}" placeholder="www.gallery.com" />
        <pre>Clicking a button will take users to this link</pre>
			</div> <br>
		</div>

		<div align="left" class="parent">
			<div class="labels">
				<label for="btn_color">{'Button Color:'|translate}</label>
			</div>
			<div class="inputs">
				<input class="nice" size="70" type="text" name="btn_color" value="{$btn_color}" placeholder="#22af73" />
			</div> <br>
		</div>

		<div align="left" class="parent">
			<div class="labels">
				<label for="btn_txt_color">{'Button Text Color:'|translate}</label>
			</div>
			<div class="inputs">
				<input class="nice" size="70" type="text" name="btn_txt_color" value="{$btn_txt_color}" placeholder="#ffffff" />
			</div> <br>
		</div>

		<div align="left" class="parent">
			<div class="labels">
				<label for="btn_text">{'Button Text:'|translate}</label>
			</div>
			<div class="inputs">
				<input class="nice" size="70" type="text" name="btn_text" value="{$btn_text}" placeholder="Visit Gallery" />
			</div> <br>
		</div>

		<div align="left" class="parent">
			<div class="labels">
				<label for="link">{'Background Color:'|translate}</label>
			</div>
			<div class="inputs">
				<input class="nice" size="70" type="text" name="bg" value="{$bg}" placeholder="#ff6600" />
        <pre>Background color of the notification bar</pre>
			</div> <br>
		</div>

		<div align="left" class="parent">
			<div class="labels">
				<label for="link">{'Link Color:'|translate}</label>
			</div>
			<div class="inputs">
				<input class="nice" size="70" type="text" name="link_color" value="{$link_color}" placeholder="#ffffff" />
        <pre>Color of the link</pre>
			</div> <br>
		</div>

		<div align="left" class="parent">
			<div class="labels">
				<label for="logo">{'Open in new tab?'|translate}</label>
			</div>
			<div class="inputs">
        {if $newtab}
        <input type="radio" name="newtab" value="1" checked>Yes
        <input type="radio" name="newtab" value="0">No<br>
        {else}
        <input type="radio" name="newtab" value="1">Yes
        <input type="radio" name="newtab" value="0" checked>No<br>
        {/if}
			</div> <br>
		</div>
	</fieldset>


	<input type="submit" value="{'Save'|@translate}" name="save" />
</form>
