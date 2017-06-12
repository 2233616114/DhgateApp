
{*{if isset($product->id) && !$product->is_virtual}*}
    <div id="product-specs" class="panel product-tab">
        <input type="hidden" name="submitted_tabs[]" value="Specs"/>
        <h3>{l s='Add or modify combinations for this product'}</h3>

        <div class="form-group">
            <label class="control-label col-lg-2">{l s='Combinations'}:</label>
            <div class="col-lg-9">
                <div class="attribute" id="spec_attrs">
                    {foreach $attribute_groups as $k => $attribute_group}
                        <div><span>{$attribute_group['name']|escape:'html':'UTF-8'}:</span></div>
                        <div class="spec_attr_groups" groupId="{$attribute_group['id_attribute_group']}">
                            {foreach $attribute_js[$attribute_group['id_attribute_group']] as $k => $v}
                                {*<span class="choice_btn" style="display: inline-block">*}
                                    {*<input name="attr_group_{$attribute_group['id_attribute_group']}[]" class="spec_attr" attrId="{$k}" attrName="{$v|escape:'html':'UTF-8'}" type="checkbox" {if isset($selectedAttrs[$k]) && $selectedAttrs[$k] == '1'}checked{/if} onchange="javascript:changeSpecs(); ">*}
                                    {*{$v|escape:'html':'UTF-8'}*}
                                {*</span>*}
                                <div class="col-lg-3">
                                    <input name="attr_group_{$attribute_group['id_attribute_group']}[]" class="spec_attr" attrId="{$k}" attrName="{$v|escape:'html':'UTF-8'}" type="checkbox" {if isset($selectedAttrs[$k]) && $selectedAttrs[$k] == '1'}checked{/if} onchange="javascript:changeSpecs(); ">
                                    {$v|escape:'html':'UTF-8'}
                                </div>
                                {*<span>&nbsp;&nbsp;</span>*}
                            {/foreach}
                        </div>
                        <div class="clear"></div>
                    {/foreach}
                </div>
            </div>
            <div class="clear"></div>
        </div>


        <div class="form-group specs_comb_list">
            <label class="control-label col-lg-2">{l s='Add or modify combinations for this product'}:</label>
            <div id="specs_cache" style="display:none;">
                {foreach from=$spec_combs item=spec_comb}
                    <div id="comb_{$spec_comb.comb_id}_ref" value="{$spec_comb.reference}"></div>
                    <div id="comb_{$spec_comb.comb_id}_price" value="{$spec_comb.price}"></div>
                    <div id="comb_{$spec_comb.comb_id}_weight" value="{$spec_comb.weight}"></div>
                    <div id="comb_{$spec_comb.comb_id}_min_qty" value="{$spec_comb.minimal_quantity}"></div>
                    <div id="comb_{$spec_comb.comb_id}_stock_qty" value="{$spec_comb.stock_qty}"></div>
                {/foreach}
            </div>
            <div class="col-lg-9">
                <table id="specs_list" class="table">
                    <colgroup>
                        {*<col class="col-md-2">*}
                        {*<col class="col-md-3">*}
                        {*<col class="col-md-2">*}
                        {*<col class="col-md-2">*}
                        {*<col class="col-md-1">*}
                        {*<col class="col-md-2">*}
                        <col style="width:10%">
                        <col style="width:20%">
                        <col style="width:10%">
                        <col style="width:10%">
                        <col style="width:10%">
                        <col style="width:10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>{l s='Add or modify combinations for this product'}</th>
                            <th>{l s='Reference code'}</th>
                            <th>{l s='Impact on price'}（{$currency->prefix}{$currency->suffix}）</th>
                            <th>{l s='Impact on weight'}（{$weight_unit}）</th>
                            <th>{l s='Minimum quantity'}</th>
                            <th>{l s='Available quantities'}</th>
                        </tr>
                        <tr>
                            {*FIXME: ccc 国际化资源系统*}
                            <th></th>
                            <th><input type="button" class="btn btn-default" value="同步" onclick="javascript:syncData('specs_ref[]')"></th>
                            <th><input type="button" class="btn btn-default" value="同步" onclick="javascript:syncData('specs_price[]')"></th>
                            <th><input type="button" class="btn btn-default" value="同步" onclick="javascript:syncData('specs_weight[]')"></th>
                            <th><input type="button" class="btn btn-default" value="同步" onclick="javascript:syncData('specs_min_qty[]')"></th>
                            <th><input type="button" class="btn btn-default" value="同步" onclick="javascript:syncData('specs_stock_qty[]')"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$spec_combs item=spec_comb}
                            <tr>
                                <td><input type=hidden name="attr_combination[]" value="{$spec_comb.comb_id}">{$spec_comb.comb_desc}</td>
                                <td><input name="specs_ref[]" value="{$spec_comb.reference}" class="form_input" size="12" maxlength="64" type="text"></td>
                                <td><input name="specs_price[]" value="{$spec_comb.price}" class="form_input" size="5" maxlength="10" type="text"></td>
                                <td><input name="specs_weight[]" value="{$spec_comb.weight}" class="form_input" size="5" maxlength="10" type="text"></td>
                                <td><input name="specs_min_qty[]" value="{$spec_comb.minimal_quantity}" class="form_input" size="4" maxlength="6" type="text"></td>
                                <td><input name="specs_stock_qty[]" value="{$spec_comb.stock_qty}" class="form_input" size="4" maxlength="6" type="text"></td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
            <div class="clear"></div>
        </div>

        {*暂时屏蔽不同规格组合选择图片的功能*}
        <div class="form-group specs_comb_image" style="display:none;">
            <label class="control-label col-lg-2">{l s='Images'}:</label>
            <div id="specs_images_cache" style="display:none;">
                {foreach from=$images key=k item=image}
                    <div class="specs_product_images" imageId="{$image.id_image}" imageSrc="{$smarty.const._THEME_PROD_DIR_}{$image.obj->getExistingImgPath()}-{$imageType}.jpg" imageAlt="{$image.legend|escape:'html':'UTF-8'}" imageTitle="{$image.legend|escape:'html':'UTF-8'}"></div>
                {/foreach}
                {foreach from=$spec_combs item=spec_comb}
                    <div id="comb_{$spec_comb.comb_id}_images" value="{$spec_comb.specs_images}"></div>
                {/foreach}
            </div>
            <div class="col-lg-10">
                <table id="specs_images" class="table">
                    <colgroup>
                        <col class="col-md-2">
                        <col class="col-md-10">
                    </colgroup>
                    <tbody>
                    {foreach from=$spec_combs item=spec_comb}
                        {if $images|count}
                        <tr>
                            <td>{$spec_comb.comb_desc}</td>
                            <td>
                                <div>
                                    <ul class="list-inline">
                                        {foreach from=$images key=k item=image}
                                            <li>
                                                {assign var=checked value=""}
                                                {foreach from=$spec_comb.specs_images_array item=selectedImageId}
                                                    {if $selectedImageId==$image.id_image}{$checked="checked"}{/if}
                                                {/foreach}

                                                <input type="checkbox" name="specs_images_{$spec_comb.comb_id}[]" value="{$image.id_image}" id="id_image_attr_{$image.id_image}" {$checked}/>
                                                <label for="id_image_attr_{$image.id_image}">
                                                    <img class="img-thumbnail" src="{$smarty.const._THEME_PROD_DIR_}{$image.obj->getExistingImgPath()}-{$imageType}.jpg" alt="{$image.legend|escape:'html':'UTF-8'}" title="{$image.legend|escape:'html':'UTF-8'}" />
                                                </label>
                                            </li>
                                        {/foreach}
                                    </ul>

                                </div>
                            </td>
                        </tr>
                        {/if}
                    {/foreach}
                    </tbody>
                </table>
            </div>
            <div class="clear"></div>
        </div>

        {*<div class="panel-footer">*}
            {*<a href="{$link->getAdminLink('AdminProducts')|escape:'html':'UTF-8'}{if isset($smarty.request.page) && $smarty.request.page > 1}&amp;submitFilterproduct={$smarty.request.page|intval}{/if}"*}
               {*class="btn btn-default"><i class="process-icon-cancel"></i> {l s='Cancel'}</a>*}
            {*<button type="submit" name="submitAddproduct" class="btn btn-default pull-right" disabled="disabled"><i*}
                        {*class="process-icon-loading"></i> {l s='Save'}</button>*}
            {*<button type="submit" name="submitAddproductAndStay" class="btn btn-default pull-right" disabled="disabled">*}
                {*<i class="process-icon-loading"></i> {l s='Save and stay'}</button>*}
        {*</div>*}
    </div>
{*{/if}*}



