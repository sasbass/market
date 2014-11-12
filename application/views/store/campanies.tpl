{extends file='store/main.tpl'}
{block name=body}
<section class="container_12 claerfix">
<aside id="sidebar" class="grid_12">
    <div class="box">
        <h2>Списък с фирми/снабдители</h2>
        
        {include file="store/menu.tpl"}
        <div class="grid_8" style="width:72%;">
            {if $list}
            <table cellpadding="4" cellspacing="0" border="0" class="tbl">
                <thead>
                    <tr>
                        <th>Фирма</td>
                        <th>Телефон</td>
                        <th>Адрес</td>
                        <th>МОЛ</td>
                        <th>Email</td>
                        <th></td>
                    </tr>
                </thead>
                <tbody>
                {foreach from=$list item=item}
                    <tr>
                        <td>{$item->name}</td>
                        <td>{$item->phone}</td>
                        <td>{$item->address}</td>
                        <td>{$item->mol}</td>
                        <td>{$item->email}</td>
                        <td>
                            <a title="Редактирай" href="{$base_url}store/campanies/edit/{$item->id}/">
                            <img alt="Редактирай" src="{$base_url}interface/icons/edit.gif">
                            </a>
                            <a title="Изтрий" href="{$base_url}store/campanies/delete/{$item->id}/">
                            <img alt="Изтрий" src="{$base_url}interface/icons/trash.gif">
                            </a>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
            {else}
            <h4>Списъка с фирми е празен!</h4>
            {/if}
        </div>
        <div class="clear"></div>
    </div>
</aside>
</section>
{/block}