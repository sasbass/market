{extends file='sales/main.tpl'}
{block name=head}
<script type="text/javascript">
$(document).ready(function(){
	animateMessage(3000);
	$("#cashier").focus();
});
</script>
{/block}
{block name=body}
<div class="grid_4" id="login">
<form action="{$base_url}sales/index/login/" method="post">
<fieldset>
    <h1 style="visibility: hidden;">ВХОД КАСИЕР</h1>
	{*<label for="cashier">ПОТРЕБИТЕЛ / КАРТА</label><br/>
	<input tabindex="1" id="cashier" name="cashier" value="" type="text" class="in username"/> <br/>*}
    <input id="cashier" class="in username" type="text" required="" autofocus="" value="" name="cashier" tabindex="1" placeholder="Потребител" pattern="[a-zA-Z0-9]+">
	
	{*<label for="password">ПАРОЛА</label><br/>
	<input tabindex="2" id="password" name="password" value="" type="password" class="in password"/> <br/>*}
	<input id="password" class="in password" type="password" value="" required="" name="password" tabindex="2" placeholder="Парола">
    
	{*<input id="login-button" tabindex="3" name="login" value="" type="submit" class="bt"/>*}
    <input id="login-button" type="image" src="{$base_url}interface/login_button.png" alt="Submit">
	<div id="message">{include file="common/message.tpl"}</div>
</fieldset>
</form>
</div>
{/block}