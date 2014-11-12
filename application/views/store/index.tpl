{extends file='store/main.tpl'}
{block name=body}	
{include file="store/menu.tpl"}
<div class="grid_9">
<form action="{$base_url}store/index/add/" method="post">
	<fieldset>
	
		<label for="campanies_id">Фирма снабдител <strong><em>*</em></strong></label>
		<select name="campanies_id" id="campanies_id">
			<option value="">-- Изберете фирма --</option>
			{foreach from=$campanies item=item}
			<option value="{$item->id}">{$item->name}</option>
			{/foreach}
		</select>
		<input name="add_campanies" value="Добави нова" type="submit" class="in"/>
		<br/>
		
		<label for="name">Име на продукт <strong><em>*</em></strong></label>
		<input id="name" name="name" value="" type="text" class="in"/><br/>
	
		<label for="barcode">Баркод на продукта <strong><em>*</em></strong></label>
		<input id="barcode" name="barcode" value="" type="text" class="in"/><br/>
		
		<label for="quality_in">Количество <strong><em>*</em></strong></label>
		<input id="quality_in" name="quality_in" value="" type="text" class="in"/><br/>
		
		<label for="delivery_price">Доставна цена <strong><em>*</em></strong></label>
		<input id="delivery_price" name="delivery_price" value="" type="text" class="in"/><br/>
		
		<label for="market_price">Цена в магазина <strong><em>*</em></strong></label>
		<input id="market_price" name="market_price" value="" type="text" class="in"/><br/>
		
		<label for="description">Допълнително описание</label><br/>
		<textarea id="description" rows="10" cols="50" name="description"></textarea><br/>
	
		<input name="add" value="ДОБАВИ ПОКУПА" type="submit" class="bt"/>
	</fieldset>
</form>
</div>
{/block}