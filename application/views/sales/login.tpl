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
	<br/>
    <input id="cashier" class="in username" type="text" required="" autofocus="" value="" name="cashier" tabindex="1" placeholder="{$lang.username}" pattern="[a-zA-Z0-9]+">
	
	<input id="password" class="in password" type="password" value="" required="" name="password" tabindex="2" placeholder="{$lang.password}">
    
    <input id="login-button" type="image" src="{$base_url}interface/login_button.png" alt="Submit">
	<div id="message">{include file="common/message.tpl"}</div>
</fieldset>
</form>
</div>
{/block}