{extends file='sales/main.tpl'}
{block name=head}
<script type="text/javascript">
$(document).ready(function(){
	animateMessage(5000);
});
</script>
{/block}
{block name=body}
<div class="grid_3">
	<table cellpadding="0" cellspacing="4" border="0" class="calc">
		<tbody>
			<tr>
				<td><a id="num-97" href="#" onclick="entNumber(this);">1</a></td>
				<td><a id="num-98" href="#" onclick="entNumber(this);">2</a></td>
				<td><a id="num-99" href="#" onclick="entNumber(this);">3</a></td>
			</tr>
			<tr>
				<td><a id="num-100" href="#" onclick="entNumber(this);">4</a></td>
				<td><a id="num-101" href="#" onclick="entNumber(this);">5</a></td>
				<td><a id="num-102" href="#" onclick="entNumber(this);">6</a></td>
			</tr>
			<tr>
				<td><a id="num-103" href="#" onclick="entNumber(this);">7</a></td>
				<td><a id="num-104" href="#" onclick="entNumber(this);">8</a></td>
				<td><a id="num-105" href="#" onclick="entNumber(this);">9</a></td>
			</tr>
			<tr>
				<td><a id="num-96" href="#" onclick="entNumber(this);">0</a></td>
				<td><a id="num-110" href="#" onclick="entNumber(this);">.</a></td>
                <td><a id="num-8" href="#" onclick="entNumber(this);" rel="delete"><img src="{$base_url}interface/backspace-128.png" alt="backspace"/></a></td>
			</tr>
		</tbody>
	</table>
</div>

<div class="grid_3 input-info">
	<form action="{$base_url}sales/index/add/" method="post">
		<fieldset>
		<label for="barcode">Баркод</label><br/>
		<input tabindex="1" id="barcode" onclick="addWrite(this);" name="barcode" value="" type="text" class="in write"/><br/>
	
		<label for="quantity">Количество</label><br/>
		<input tabindex="2" id="quantity" onclick="addWrite(this);" name="quantity" value="1" type="text" class="in"/><br/><br/>
	
		<input tabindex="3" name="add" value="ДОБАВИ АРТИКУЛ" type="submit" class="bt"/>
		</fieldset>
	</form>
	<div id="message">{include file="common/message.tpl"}</div>
</div>

<div class="grid_5 cashier-info">
	Касиер: <strong>{$this->session->userdata.user_data->first_name} {$this->session->userdata.user_data->last_name}</strong><br/>
	{*Карта номер: <strong>{$this->session->userdata.user_data->card_number}</strong><br/>*}
    <button class="button" onclick="window.location.href='{$base_url}sales/index/clear/'">ИЗЧИСТИ</button>
    
	<button style="background: #d00710;" class="button" onclick="window.location.href='{$base_url}sales/index/logout/'">ИЗХОД</button>
    
    
</div>

<div class="grid_12">
<form action="{$base_url}sales/index/pay/" method="post">
<fieldset>
<div id="table-pay">
    <div class="overflow-x">
    {if $list}
    <table cellpadding="0" cellspacing="4" border="0" class="list-table">
        <thead>
            <tr>
                <th>Арт.&#x2116;</th>
                <th>Баркод &#x2116;</th>
                <th>Артикул</th>
                <th>Кол.</th>
                <th>Ед. цена</th>
                <th>Стойност</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$list item=item}
            <tr>
                <td style="width: 12%;">
                {$item->product_id}
                <input name="id[]" value="{$item->id}" type="hidden"/>
                </td>
                <td style="width: 29%;">{$item->barcode}</td>
                <td style="width: 25%;">{$item->name}</td>
                <td style="width: 11%;">{$item->quantity}</td>
                <td>{$item->market_price} лв.</td>
                <td>{$item->total} лв.</td>
            </tr>
            {/foreach}
        </tbody>
    </table>
    {/if}
    </div>
</div>
<hr/>
<table cellpadding="0" cellspacing="4" border="0" class="total list-table">
	<tbody>
			<tr>
				<td></td>
				<td></td>
				<td style="width: 30%;">
					СТРОЙНОСТ <br/>
					<input disabled="disabled" value="{$total->total}" type="text" class="big-box"/> лв.
					<input id="total" name="total" value="{$total->total}" type="hidden"/>
				</td>
				<td style="width: 30%;">
					ПЛАТЕНО <br/>
					<input tabindex="4" onkeyup="payMent(this);" name="payment" value="" type="text" class="in big-box"/> лв.
				</td>
				<td style="width: 28%;">
					РЕСТО <br/>
					<input disabled="disabled" id="change-span" value="" type="text" class="big-box"/> лв.
					<input id="change" name="change" value="" type="hidden"/> 
				</td>
				<td style="width: 30%; padding-top: 10px;">
					<input tabindex="5" name="pay" value="ПЛАТИ" type="submit" class="bt pay"/>
				</td>
			</tr>
	</tbody>
</table>
</fieldset>
</form>
</div>
{/block}