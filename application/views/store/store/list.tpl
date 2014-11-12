{extends file='store/main.tpl'}
{block name=js}
    <link rel="stylesheet" href="{$base_url}css/jquery-ui.css">
    <script src="{$base_url}js/jquery-ui.js"></script>
{/block}
{block name=body}
<section class="container_12 claerfix">
<aside id="sidebar" class="grid_12">
    <div class="box">
        <h2>Списък със стока</h2>
        
        {include file="store/menu.tpl"}
        <div class="grid_8" style="width:72%;">
        {if $list}
            
            <form action="{$base_url}store/" method="post">
                <fieldset>
                    <div class="grid_4 alpha">
                        <label for="search">Търси</label>
                        <input id="search" name="search[result]" value="" type="text" class="in short"/>
                        <input name="search[go]" value="Търси" type="submit" class="button small"/>
                    </div>
                    <div class="grid_4 push_1 omega">
                        <label>По колко на куп.</label>
                        <input style="width: 30px; text-align: center;" name="per_page" value="{$per_page}" type="text" class="in short"/>
                        <input name="filter" value="избери" type="submit" class="button small"/>
                    </div>
                </fieldset>
            </form>
            <table cellpadding="4" cellspacing="0" border="0" class="tbl" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Арт. &#x2116;</th>
                        <th>Име</td>
                        <th>Баркод</td>
                        <th>Приет от</td>
                        <th>Кол</td>
                        <th>Дост. цена</td>
                        <th>Прод. цена</td>
                        <th>Дата</td>
                        <th></td>
                    </tr>
                </thead>
                <tbody>
                {foreach from=$list item=item}
                    <tr>
                        <td>{$item->id}</td>
                        <td>{$item->name}</td>
                        <td>{$item->barcode}</td>
                        <td>{$item->first_name} {$item->last_name}</td>
                        <td>{$item->quantity_current}</td>
                        <td>{$item->delivery_price}</td>
                        <td>{$item->market_price}</td>
                        <td>{$item->added_date}</td>
                        <td>
                            <a title="Редактирай" href="{$base_url}store/index/edit/{$item->id}/">
                            <img alt="edit" src="{$base_url}interface/icons/edit.gif">
                            </a>
                            <a title="Изтрий" href="#!" onclick="deleteItem('{$base_url}store/index/delete/{$item->id}/');">
                                <img alt="Изтрий" src="{$base_url}interface/icons/trash.gif">
                            </a>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
            {$pagination}
            {else}
            <h4>Списъка с артикули е празен!</h4>
            {/if}
        </div>
        <div class="clear"></div>
    </div>
</aside>
</section>

<div class="hidden" id="dialog-confirm" title="Изтриване на стова?">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;">
    </span>Наистина ли желаете да изтриете тази стока?</p>
</div>
{/block}