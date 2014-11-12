<html lang="bg">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<table width="100%" cellpadding="0">
		<tr>
			<td>
				<h3>{$var.invoice_company_name}</h3><br />
				Град: {$var.invoice_company_city}<br />
				Адрес: {$var.invoice_company_address}<br />
				Идент. номер по ДДС: {$var.invoice_company_ident_number}<br />
				МОЛ: {$var.invoice_company_mol}<br />
				Булстат: {$var.invoice_company_bulstat}
			</td>
			<td align="right"><img src="{$base_url}interface/login.png"/></td>
		</tr>
	</table>
	<hr />
    {if $client && $client.type == 'ch'}
        <table width="100%" cellpadding="0">
            <tr>
                <td>
                    &nbsp;<br />
                    &nbsp;&nbsp;Получател: {$client.company_name}<br />
                    &nbsp;&nbsp;Град: {$client.company_city}<br />
                    &nbsp;&nbsp;Адрес: {$client.company_address_register}<br />
                </td>
            </tr>
        </table>
    {else}
        <table width="100%" cellpadding="0">
            <tr>
                <td>
                    &nbsp;<br />
                    &nbsp;&nbsp;Получател: {$client.company_name}<br />
                    &nbsp;&nbsp;Град: {$client.company_city}<br />
                    &nbsp;&nbsp;Адрес: {$client.company_address_register}<br />
                    &nbsp;&nbsp;Идент. номер по ДДС: {$client.company_ident_num}<br />
                    &nbsp;&nbsp;МОЛ: {$client.company_mol}<br />
                    &nbsp;&nbsp;Булстат: {$client.company_ident}<br />
                </td>
            </tr>
        </table>
    {/if}
 	<table width="100%" style="border-top: 1px solid black;" cellpadding="15">
		<tr>
 			<td>
				<h3 style="margin: 0px;" align="center">ФАКТУРА No: {$accounting_invoice_number} &nbsp; &nbsp;Дата: {$invoice_date|date_format:"%d.%m.%Y"}</h3>
			</td>
		</tr>
		<tr>
			<td style="border-top: 1px solid black;">
				<h2 style="margin: 0px;" align="center" color="#CECECE">{$invoice_type}</h2>
			</td>
		</tr>
	</table>	
	<table border="1" cellpadding="3">
		<tr>
			<th style="width: 315px; text-align: center;"><b>Продукт</b></th>
			<th style="width: 120px; text-align: center;"><b>Ед. цена</b></th>
            <th style="width: 100px; text-align: center;"><b>Количество</b></th>
			<th style="width: 120px; text-align: center;"><b>Стойност</b></th>
		</tr>
        {foreach from=$list item=item}
		<tr>
			<td style="width: 315px; text-align: center;">{$item->name}</td>
			<td style="width: 120px; text-align: right;">{$item->market_price|string_format:"%.2f"}</td>
            <td style="width: 100px; text-align: right;">{$item->quantity}</td>
			<td style="width: 120px; text-align: right;">{$item->total|string_format:"%.2f"}</td>
		</tr>
        {/foreach}
	</table>
	&nbsp;<br />
	<table border="0" cellpadding="3">
		<tr>
			<td style="width: 535px; text-align: right;">Сума:</td>
			<td style="width: 120px; text-align: right;"><b>{$total|string_format:"%.2f"}</b> {$var.unit}</td>
		</tr>
		<tr>
			<td style="width: 535px; text-align: right;">Данъчна основа:</td>
			<td style="width: 120px; text-align: right;"><b>{$total|string_format:"%.2f"}</b> {$var.unit}</td>
		</tr>		
		<tr>
			<td style="width: 535px; text-align: right;">{$var.vat}% ДДС:</td>
			<td style="width: 120px; text-align: right;"><b>{$vat|string_format:"%.2f"}</b> {$var.unit}</td>
		</tr>		
		<tr>
			<td style="width: 535px; text-align: right;">Сума за плащане:</td>
			<td style="width: 120px; text-align: right;"><b>{$grand_total|string_format:"%.2f"}</b> {$var.unit}</td>
		</tr>		
	</table>
	&nbsp;<br />
	<div style="margin: 0px;">
		Словом: {$number_words}  {$var.unit}<br />
		Начин на плащане: В брой
	</div>
	<hr />
	&nbsp;<br />
	<div style="margin: 0px;">
		Дата на данъчно събитие (плащане): {$invoice_date|date_format:"%d.%m.%Y"}<br />
		Място на издаване: {$var.invoice_company_city}
	</div>
	&nbsp;<br />
	<table width="100%">
		<tr>
			<td>
				Получил:<br />
				{$client.company_mol}<br />
				..................................
			</td>
			<td align="right">
				Съставил:<br />
				{$var.invoice_writer}<br />
				..................................
			</td>
		</tr>
	</table>
</body>
</html>