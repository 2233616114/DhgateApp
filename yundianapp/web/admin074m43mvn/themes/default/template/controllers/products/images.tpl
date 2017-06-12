{*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{*{if isset($id_product) && isset($product)}*}
<div id="product-images" class="panel product-tab">
	<input type="hidden" name="submitted_tabs[]" value="Images" />
	<div class="panel-heading tab" >
		{l s='Images'}
		<span class="badge" id="countImage">{$countImages}</span>
	</div>
	<div class="row">
		<div class="form-group">
			<label class="control-label col-lg-3 file_upload_label">
				<span class="label-tooltip" data-toggle="tooltip"
					  title="{l s='Format:'} JPG, GIF, PNG. {l s='Filesize:'} {$max_image_size|string_format:"%.2f"} {l s='MB max.'}">
					{if isset($id_image)}{l s='Edit this product\'s image:'}{else}{l s='Add a new image to this product'}{/if}
				</span>
			</label>
			<div class="col-lg-9">
				{$image_uploader}
			</div>
		</div>
		<div class="form-group" style="display: none">
			<label class="control-label col-lg-3">
				<span class="label-tooltip" data-toggle="tooltip"
					  title="{l s='Update all captions at once, or select the position of the image whose caption you wish to edit. Invalid characters: %s' sprintf=['<>;=#{}']}">
					{l s='Caption'}
				</span>
			</label>
			<div class="col-lg-4">
				{foreach from=$languages item=language}
					{if $languages|count > 1}
						<div class="translatable-field row lang-{$language.id_lang}">
						<div class="col-lg-8">
					{/if}
					<input type="text" id="legend_{$language.id_lang}"{if isset($input_class)} class="{$input_class}"{/if} name="legend_{$language.id_lang}" value="{if $images|count}{$images[0]->legend[$language.id_lang]|escape:'html':'UTF-8'}{else}{$product->name[$language.id_lang]|escape:'html':'UTF-8'}{/if}"{if !$product->id} disabled="disabled"{/if}/>
					{if $languages|count > 1}
						</div>
						<div class="col-lg-2">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" tabindex="-1">
								{$language.iso_code}
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								{foreach from=$languages item=language}
									<li>
										<a href="javascript:hideOtherLanguage({$language.id_lang});">{$language.name}</a>
									</li>
								{/foreach}
							</ul>
						</div>
						</div>
					{/if}
				{/foreach}
			</div>
			<div class="col-lg-2{if $images|count <= 1} hidden{/if}" id="caption_selection">
				<select name="id_caption">
					<option value="0">{l s='All captions'}</option>
					{foreach from=$images item=image}
						<option value="{$image->id_image|intval}">
							{l s='Position %d' sprintf=$image->position|intval}
						</option>
					{/foreach}
				</select>
			</div>
			<div class="col-lg-2">
				<button type="submit" class="btn btn-default" name="submitAddproductAndStay" value="update_legends"><i class="icon-random"></i> {l s='Update'}</button>
			</div>
		</div>
	</div>
	<table class="table tableDnD col-lg-offset-1" id="imageTable" style="width:80%">
		<!-- 去除表格的头部 -->
		<!-- <thead>
			<tr class="nodrag nodrop">
				<th class="fixed-width-lg"><span class="title_box">{l s='Image'}</span></th>
				<th class="fixed-width-lg"><span class="title_box">{l s='Caption'}</span></th>
				<th class="fixed-width-xs"><span class="title_box">{l s='Position'}</span></th>
				{if $shops}
					{foreach from=$shops item=shop}
						<th class="fixed-width-xs"><span class="title_box">{$shop.name}</span></th>
					{/foreach}
				{/if}
				<th class="fixed-width-xs"><span class="title_box">{l s='Cover'}</span></th>
				<th></th> 
			</tr>
		</thead> -->
		<tbody id="imageList">
		<tr></tr>
		</tbody>
	</table>
	<!-- 上传图片的文件显示区域 -->
	<!-- 编辑产品显示图片 -->
	<table id="lineType" style="display:none;">
		<!-- 添加浮动元素 -->
		<tr id="image_id" class="draggable" style="float:left;position:relative;padding:0px 0px 15px 0px;" >
			<input type="hidden" name="imageIds[]" value="image_id">

			<td  id="td_image_id" style="width:128px;border-bottom: solid 0px #EAEDEF;padding:3px;" class="pointer dragHandle positionImage">
				<a href="{$smarty.const._THEME_PROD_DIR_}image_path.jpg" class="fancybox" style="display:block;">

					<img style="width:100%;cursor:move;"
						 src="{$smarty.const._THEME_PROD_DIR_}{$iso_lang}-default-{$imageType}.jpg"
						 alt="legend"
						 class="img-thumbnail" />
				</a>
			</td>
			<!-- 删除文件的部分 -->
			<td style="width:122px;height:18px;position:absolute;bottom:0px;left:3px;background-color: #ddd;border-bottom: solid 0px #EAEDEF;padding:3px;">
				<!-- <a class="deleteimg delete_product_image" href=""  style="width:115px;height:20px;position:absolute;">

                    <img class="delete_img" src="../img/delete.png" alt="delete" title="delete" style="width:17px;height:17px;position:absolute;left:44%;"  />
                </a> -->
				<i class="icon-trash deleteimg delete_product_image" href="" style="position:absolute;left:48%;">
				</i>
			</td>
			<!-- <td>legend</td>
			<td id="td_image_id" class="pointer dragHandle center positionImage">
				<div class="dragGroup">
					<div class="positions">
						image_position
                                        </div>
                                </div>
			</td>
			{if $shops}
				{foreach from=$shops item=shop}
				<td>
					<input
						type="checkbox"
						class="image_shop"
						name="id_image"
						id="{$shop.id_shop}image_id"
						value="{$shop.id_shop}" />
				</td>
				{/foreach}
			{/if}
			<td class="cover">
				<a href="#">
					<i class="icon-check-empty icon-2x covered"></i>
				</a>
			</td>
			<td>
				<a href="#" class="deleteimg delete_product_image pull-right btn btn-default" >
					<i class="icon-trash"></i> {l s='Delete this image'}
				</a>
			</td> -->
		</tr>
		<!-- 清除浮动 -->
		<div style="clear:both;"></div>
	</table>
	<!-- 新增产品时新增图片 -->

	<table id="lineTypeNew" style="display:none;">
		<!-- <tr class="dragGroup" style="float:left;" ondrop="drop(event,this)" ondragover="allowDrop(event)" draggable="true" ondragstart="drag(event, this)" > -->
		<!-- 新增并保存图片 -->
		<tr class="draggable" style="float:left;position:relative;padding:0px 0px 15px 0px;" >
			<input type="hidden" name="imageNames[]" value="image_path">
			<td id="td_image_id" style="width:128px;border-bottom: solid 0px #EAEDEF;padding:3px;" class="pointer dragHandle positionImage">
				<a href="{$smarty.const._PS_TMP_UUPLOAD_IMG_}image_path" class="fancybox" style="display:block;">

					<img style="width:100%;cursor:move;"
						 src="{$smarty.const._PS_TMP_UUPLOAD_IMG_}image_name"
						 alt="legend"
						 class="img-thumbnail" />
				</a>
			</td>
			<!-- 删除文件的部分 -->
			<td style="width:122px;height:18px;position:absolute;bottom:0px;left:3px;background-color: #ddd;border-bottom: solid 0px #EAEDEF;padding:3px;">

				<!-- <a class="deleteimg delete_temp_product_image" href="" style="display: block;width:115px;height:20px;position:absolute;" imagePath="{$smarty.const._PS_TMP_UUPLOAD_IMG_}image_path" >
				
					<img class="delete_img" src="../img/delete.png" alt="delete" title="delete" style="width:17px;height:17px;position:absolute;left:44%;" />
				</a> -->
				<i class="icon-trash deleteimg delete_temp_product_image" href="" style="position:absolute;left:48%;">
				</i>
			</td>
			<!-- <td>legend</td>
			<td id="td_image_id" class="pointer dragHandle center positionImage">
				<div class="dragGroup">
					<div class="positions">
						image_position
					</div>
				</div>
			</td>
			<td class="cover">
				<a href="#">
					<i class="icon-check-empty icon-2x covered"></i>
				</a>
			</td>
			<td>
				<a href="#" imagePath="{$smarty.const._PS_TMP_UUPLOAD_IMG_}image_path" class="delete_temp_product_image pull-right btn btn-default" >
					<i class="icon-trash"></i> {l s='Delete this image'}
				</a>
			</td>  -->
		</tr>
		<!-- 清除浮动 -->
		<div style="clear:both;"></div>
	</table>

	{*<div class="panel-footer">*}
	{*<a href="{$link->getAdminLink('AdminProducts')|escape:'html':'UTF-8'}{if isset($smarty.request.page) && $smarty.request.page > 1}&amp;submitFilterproduct={$smarty.request.page|intval}{/if}" class="btn btn-default"><i class="process-icon-cancel"></i> {l s='Cancel'}</a>*}
	{*<button type="submit" name="submitAddproduct" class="btn btn-default pull-right" disabled="disabled"><i class="process-icon-loading"></i> {l s='Save'}</button>*}
	{*<button type="submit" name="submitAddproductAndStay" class="btn btn-default pull-right" disabled="disabled"><i class="process-icon-loading"></i> {l s='Save and stay'}</button>*}
	{*</div>*}
	<script type="text/javascript">
		var upbutton = '{l s='Upload an image'}';
		var come_from = '{$table}';
		var success_add =  '{l s='The image has been successfully added.'}';
		var id_tmp = 0;
		var current_shop_id = {$current_shop_id|intval};
		{literal}
		//Ready Function

		// 编辑产品
		function imageLine(id, path, position, cover, shops, legend)
		{
			line = $("#lineType").html();
			line = line.replace(/image_id/g, id);
			line = line.replace(/(\/)?[a-z]{0,2}-default/g, function($0, $1){
				return $1 ? $1 + path : $0;
			});
			line = line.replace(/image_path/g, path);
			line = line.replace(/\.jpg"\s/g, '.jpg?time=' + new Date().getTime() + '" ');
			line = line.replace(/image_position/g, position);
			line = line.replace(/legend/g, legend);
			line = line.replace(/icon-check-empty/g, cover);
			line = line.replace(/<tbody>/gi, "");
			line = line.replace(/<\/tbody>/gi, "");
			if (shops != false)
			{
				$.each(shops, function(key, value){
					if (value == 1)
						line = line.replace('id="' + key + '' + id + '"','id="' + key + '' + id + '" checked=checked');
				});
			}
			$("#imageList").append(line).find('.draggable').draggable();
		}


		// 新增产品时新增图片
		function imageLineTemp(path, imageName, position)
		{
			line = $("#lineTypeNew").html();
			line = line.replace(/image_path/g, path);
			line = line.replace(/image_name/g, imageName);
//			line = line.replace(/\.jpg"\s/g, '.jpg?time=' + new Date().getTime() + '" ');
			line = line.replace(/image_position/g, position);
			line = line.replace(/<tbody>/gi, "");
			line = line.replace(/<\/tbody>/gi, "");
			$("#imageList").append(line).find('.draggable').draggable();
		}

		$(document).ready(function(){
			{/literal}
			{foreach from=$images item=image}
			assoc = {literal}"{"{/literal};
			{if $shops}
			{foreach from=$shops item=shop}
			assoc += '"{$shop.id_shop}" : {if $image->isAssociatedToShop($shop.id_shop)}1{else}0{/if},';
			{/foreach}
			{/if}
			if (assoc != {literal}"{"{/literal})
			{
				assoc = assoc.slice(0, -1);
				assoc += {literal}"}"{/literal};
				assoc = jQuery.parseJSON(assoc);
			}
			else
				assoc = false;
			imageLine({$image->id}, "{$image->getExistingImgPath()}", {$image->position}, "{if $image->cover}icon-check-sign{else}icon-check-empty{/if}", assoc, "{$image->legend[$default_language]|escape:'htmlall'}");
			{/foreach}
			{literal}
			var originalOrder = false;

			// jquery中的dragsort实现拖拽
			$("#imageList").dragsort({
				dragSelector: "tr",
				dragBetween: true,
				dragEnd: saveOrder,
				placeHolderTemplate: "<tr class='placeHolder'><td></td><td></td></tr>"
			});

			function saveOrder() {

				//新增图片和编辑图片时进行不同逻辑处理
				//
				/*编辑图片*/
				{/literal}
				{if isset($id_product) && isset($product)}
				{literal}
				image_up = "{";
				$("#imageList tr.draggable").each(function(i) {
					image_up += '"' + $(this).attr("id") + '" : ' + (i + 1) + ',';
				});//使用get处理返回的对象以得到基础的数组
				image_up = image_up.slice(0, -1);//把最后一个逗号去掉
				image_up += "}";
				console.log(image_up);
				updateImagePosition(image_up);//更新图片的位置
				//更新图片的位置之后将第一张图片的id设置为封面
				/*
				 doAdminAjax({
				 "action":"UpdateCover",
				 //将第一个图片的id作为封面
				 "id_image":$("#imageList tr.draggable").eq(0).attr("id"),
				 "id_product" : {/literal}{$id_product}{literal},
				 "token" : "{/literal}{$token|escape:'html':'UTF-8'}{literal}",
				 "controller" : "AdminProducts",
				 "ajax" : 1 }
				 );
				 */
				{/literal}
				{/if}
				{literal}
			};
			/**
			 * on success function
			 */
			function afterDeleteProductImage(data)
			{
				data = $.parseJSON(data);
				if (data)
				{
					cover = 0;
					id = data.content.id;
					if (data.status == 'ok')
					{
						if ($("#" + id + ' .covered').hasClass('icon-check-sign'))
							cover = 1;
						$("#" + id).remove();
					}
					if (cover)
						$("#imageTable tr").eq(1).find(".covered").addClass('icon-check-sign');
					$("#countImage").html(parseInt($("#countImage").html()) - 1);
					//refreshImagePositions($("#imageTable"));
					showSuccessMessage(data.confirmations);

					if (parseInt($("#countImage").html()) <= 1)
						$('#caption_selection').addClass('hidden');
				}
			}

			/**
			 * ccc
			 * @param data
			 */
			function afterDeleteProductImageTemp(data) {
				// do nothing
			}

			$('.delete_product_image').die().live('click', function(e)
			{
				e.preventDefault();//阻止事件的默认行为
				id = $(this).parent().parent().attr('id');
				console.log(id);
				if (confirm("{/literal}{l s='Are you sure?' js=1}{literal}"))
					doAdminAjax({
						"action":"deleteProductImage",
						"id_image":id,
						"id_product" : {/literal}{$id_product}{literal},
						"id_category" : {/literal}{$id_category_default}{literal},
						"token" : "{/literal}{$token|escape:'html':'UTF-8'}{literal}",
						"tab" : "AdminProducts",
						"ajax" : 1 }, afterDeleteProductImage
					);
			});

			/**
			 * ccc
			 */
			// 添加商品时上传图片
			$('.delete_temp_product_image').die().live('click', function(e)
			{
				e.preventDefault();//阻止事件的默认行
				imagePath = $(this).attr('imagePath');
				console.log(imagePath);
				doAdminAjax({
					"action":"deleteProductImageTemp",//删除文件目录
					"imagePath":imagePath,
					"token" : "{/literal}{$token|escape:'html':'UTF-8'}{literal}",
					"tab" : "AdminProducts",
					"ajax" : 1 }, afterDeleteProductImageTemp
				);
				// 无论服务器文件删除成功与否，客户端界面的图片删除
				$(this).parent().parent().remove();
				$("#countImage").html(parseInt($("#countImage").html()) - 1);
				if (parseInt($("#countImage").html()) <= 1)
					$('#caption_selection').addClass('hidden');
			});

			$('.covered').die().live('click', function(e)
			{
				e.preventDefault();
				id = $(this).parent().parent().parent().attr('id');
				$("#imageList .cover i").each( function(i){
					$(this).removeClass('icon-check-sign').addClass('icon-check-empty');
				});
				$(this).removeClass('icon-check-empty').addClass('icon-check-sign');

				if (current_shop_id != 0)
					$('#' + current_shop_id + id).attr('check', true);
				else
					$(this).parent().parent().parent().children('td input').attr('check', true);
				doAdminAjax({
					"action":"UpdateCover",
					"id_image":id,
					"id_product" : {/literal}{$id_product}{literal},
					"token" : "{/literal}{$token|escape:'html':'UTF-8'}{literal}",
					"controller" : "AdminProducts",
					"ajax" : 1 }
				);
			});

			$('.image_shop').die().live('click', function()
			{
				active = false;
				if ($(this).attr("checked"))
					active = true;
				id = $(this).parent().parent().attr('id');
				id_shop = $(this).attr("id").replace(id, "");
				doAdminAjax(
						{
							"action":"UpdateProductImageShopAsso",
							"id_image":id,
							"id_product":id_product,
							"id_shop": id_shop,
							"active":active,
							"token" : "{/literal}{$token|escape:'html':'UTF-8'}{literal}",
							"tab" : "AdminProducts",
							"ajax" : 1
						});
			});

			function updateImagePosition(json)
			{
				doAdminAjax(
						{
							"action":"updateImagePosition",
							"json":json,
							"token" : "{/literal}{$token|escape:'html':'UTF-8'}{literal}",
							"tab" : "AdminProducts",
							"ajax" : 1
						});
			}

			function delQueue(id)
			{
				$("#img" + id).fadeOut("slow");
				$("#img" + id).remove();
			}
			$('.fancybox').fancybox();
		});
		if (tabs_manager.allow_hide_other_languages)
			hideOtherLanguage(default_language);
		{/literal}
	</script>
</div>
{*{/if}*}
