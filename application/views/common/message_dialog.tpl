{if $message && !$message->form}
<div id="message-item" title="{$message->title}">
    <p><span class="ui-icon ui-icon-{$message->type}" style="float:left; margin:0 7px 20px 0;">
    </span>{$message->body}</p>
</div>
{elseif $message->form && $message->type == 'check'}
<div id="form-item" title="{$message->title}" class="container_12 claerfix">
    <form id="form">
        
        <div class="grid_3 green-line-right">
            <h5>Задължителни полета</h5>
            <input name="type" value="0" type="hidden"/>
            <label for="company_name">Получател (име на фирмата) *</label><br/>
            <input required="true" type="text" name="client[company_name]" id="company_name" value="" class="text ui-widget-content ui-corner-all"><br/>

            <label for="company_city">Място на регистрация *</label><br/>
            <select name="client[company_city]" id="company_city">
            {foreach from=$city item=item}
                <option value="{$item->id}" {if $item->id == $edit->city_id}selected="selected"{/if}>{$item->name}</option>
            {/foreach}
            </select><br/>

            {*<label for="company_city">Град *</label><br/>
            <input required="true" type="text" name="client[company_city]" id="company_city" value="" class="text ui-widget-content ui-corner-all"><br/>*}

            <label for="company_address_register">Адрес (на регистрация) *</label><br/>
            <input required="true" type="text" name="client[company_address_register]" id="company_address_register" value="" class="text ui-widget-content ui-corner-all"><br/>

            <label for="company_ident_num">Идент. номер по ДДС *</label><br/>
            <input required="true" type="text" name="client[company_ident_num]" id="company_ident_num" value="" class="text ui-widget-content ui-corner-all"><br/>

            <label for="company_mol">МОЛ *</label><br/>
            <input required="true" type="text" name="client[company_mol]" id="company_mol" value="" class="text ui-widget-content ui-corner-all"><br/>

            <label for="company_ident">Булстат *</label><br/>
            <input required="true" type="text" name="client[company_ident]" id="company_ident" value="" class="text ui-widget-content ui-corner-all"><br/>

        </div>
        <div class="grid_3">
            <h5>Допълнителни полета</h5>
            <label for="phone">Телфон (за контакти)</label><br/>
            <input type="text" name="client[phone]" id="phone" value="" class="text ui-widget-content ui-corner-all"><br/>

            <label for="email">Email (за контакти)</label><br/>
            <input type="text" name="client[email]" id="email" value="" class="text ui-widget-content ui-corner-all"><br/>
        </div>
        
        <div class="clear"></div>
        <input name="client[save]" value="1" type="checkbox" style="width: 16px;"/>
        <span>Направи запис на тази фирма в база данни.</span><br/>
        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </form>
</div>
{elseif $message->form && $message->type == 'check_member'}
<div id="form-item" title="{$message->title}" class="container_12 claerfix">
    <form id="form">
        <h5>Задължителни полета</h5>
        <input name="type" value="ch" type="hidden"/>
        <label for="company_name">Получател (име, през име и фамилия) *</label><br/>
        <input required="true" type="text" name="client[company_name]" id="company_name" value="" class="text ui-widget-content ui-corner-all"><br/>

        <label for="company_city">Град *</label><br/>
        <input required="true" type="text" name="client[company_city]" id="company_city" value="" class="text ui-widget-content ui-corner-all"><br/>

        <label for="company_address_register">Адрес (ул. ,кв. ,бл./вх./ет./ап. ,пощенски код, община) *</label><br/>
        <input required="true" type="text" name="client[company_address_register]" id="company_address_register" value="" class="text ui-widget-content ui-corner-all"><br/>
        
        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </form>
</div>
{/if}