{extends file='store/main.tpl'}
{block name=body}
<section class="container_12 claerfix">
<aside id="sidebar" class="grid_12">
    <div class="box">
        <h2>Добавяне на фирма/снабдител</h2>
        
        {include file="store/menu.tpl"}
        <div class="grid_8" style="width:72%;">
            <form action="{$base_url}store/campanies/{$action}/" method="post">
            <fieldset>

            {include file="common/message.tpl"}

                <label for="name">Име на фирмата <strong><em>*</em></strong></label>
                <input id="name" name="name" value="{$edit->name}" type="text" class="in"/><br/>

                <label for="mol">МОЛ <strong><em>*</em></strong></label>
                <input id="mol" name="mol" value="{$edit->mol}" type="text" class="in"/><br/>

                <label for="address">Адрес <strong><em>*</em></strong></label>
                <input id="address" name="address" value="{$edit->address}" type="text" class="in"/><br/>

                <label for="register_address">Адрес на регистрация <strong><em>*</em></strong></label>
                <input id="register_address" name="register_address" value="{$edit->register_address}" type="text" class="in"/><br/>

                <label for="ident">Булстат <strong><em>*</em></strong></label>
                <input id="ident" name="ident" value="{$edit->ident}" type="text" class="in"/><br/>

                <label for="ident_num">Идент. номер по ДДС <strong><em>*</em></strong></label>
                <input id="ident_num" name="ident_num" value="{$edit->ident_num}" type="text" class="in"/><br/>

                <label for="city_id">Място на регистрация <strong><em>*</em></strong></label>
                <select name="city_id" id="city_id">
                {foreach from=$city item=item}
                    <option value="{$item->id}" {if $item->id == $edit->city_id}selected="selected"{/if}>{$item->name}</option>
                {/foreach}
                </select><br/>

                <label for="phone">Телефон за връзка <strong><em>*</em></strong></label>
                <input id="phone" name="phone" value="{$edit->phone}" type="text" class="in"/><br/>

                <label for="email">Email <strong><em>*</em></strong></label>
                <input id="email" name="email" value="{$edit->email}" type="text" class="in"/><br/>

                <input name="add" value="{if $action == 'add'}ДОБАВИ ФИРМА{else}ЗАПАЗИ ПРОМЕНИТЕ{/if}" type="submit" class="button small"/>
            </fieldset>
        </form>
        </div>
    <div class="clear"></div>
    </div>
</aside>
</section>
{/block}