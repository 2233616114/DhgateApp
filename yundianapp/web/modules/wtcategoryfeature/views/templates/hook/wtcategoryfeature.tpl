{*
* 2007-2015 PrestaShop
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
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<div id="wt_category_feature" class="wt_category_feature clearfix">
	<div class="container">
		<div class="title_tab_hide_show">
			
				{l s='Featured Categories' mod='wtcategoryfeature'}
			
		</div>
		{if isset($wt_categories) && $wt_categories|@count > 0}
			<div class="list_carousel responsive">
			<a id="wt_cat_prev" class="btn prev" href="#">&lt;</a>
				<a id="wt_cat_next" class="btn next" href="#">&gt;</a>
				<ul id="wt_cat_carousel" class="product-list">
				{foreach from=$wt_categories item=item_category name=wt_categories}
				{assign var=category value=$item_category.category}
				
					 <li class="item {if $smarty.foreach.item_category.first|intval}first_item{elseif $smarty.foreach.item_category.last|intval}last_item{/if}">
						<div class="content">
						{if isset($wtconfig->showimg) && $wtconfig->showimg == 1}
						<div class="cat-img">
							<a href="{$link->getCategoryLink($category->id_category, $category->link_rewrite)|escape:'html':'UTF-8'}" title="{$category->name|escape:'html':'UTF-8'}">
								<img src="{$link->getCatImageLink($category->link_rewrite, $category->id_image, 'category_default')|escape:'html':'UTF-8'}"/>
							</a>
						</div>
						{/if}
						<h4 class="title">
							<a href="{$link->getCategoryLink($category->id_category, $category->link_rewrite)|escape:'html':'UTF-8'}">
								{$category->name|escape:'html':'UTF-8'}
							</a>
						</h4>
						{if count($item_category.sub_cat > 0) && isset($wtconfig->showsub) && $wtconfig->showsub == 1}
						<div class="sub-cat">	
							<ul>
							{if isset($wtconfig->numbersub)}
								{$nb_sub = $wtconfig->numbersub}
							{else}
								{$nb_sub = 5}
							{/if}
							{$i = 0}
							{foreach from = $item_category.sub_cat item=sub_cat name=sub_cat_info}
								{$i = $i+1}
								{if $i <= $nb_sub}
								<li>
									<a href="{$link->getCategoryLink($sub_cat.id_category, $sub_cat.link_rewrite)|escape:'html':'UTF-8'}" title="{$sub_cat.name|escape:'html':'UTF-8'}">{$sub_cat.name|escape}</a>
								</li>
								{/if}
							{/foreach}
							</ul>
						</div>
						{/if}
						</div>
					 </li>
					
				 {/foreach}
				 </ul>
			</div>
		{else}
			<p class="alert alert-warning">{l s='There is no category' mod='wtcategoryfeature'}</p>
		{/if}
		
	</div>
	{if isset($wtconfig->used_slider) && $wtconfig->used_slider == 1}
	<script type="text/javascript">
	$(window).load(function() {
		runSliderFeatureCat();
	});

	$(window).resize(function() {
			runSliderFeatureCat();
	});
	
	function runSliderFeatureCat(){
	
	var item_feature_cat = 4;
		
		if(getWidthBrowser() > 1180)
		{	
			item_feature_cat = 4; 
		}
		else
		if(getWidthBrowser() > 991)
		{	
			item_feature_cat = 3; 
		}
		else
		if(getWidthBrowser() > 767)
		{	
			item_feature_cat = 3; 
		}		
		else
		if(getWidthBrowser() > 540)
		{	
			item_feature_cat = 2; 
		}
		else
		if(getWidthBrowser() > 340)
		{	
			item_feature_cat = 2; 
		}			
		
		
			$('#wt_cat_carousel').carouFredSel({
				responsive: true,
				width: '100%',
				height: 'variable',
				onWindowResize: 'debounce',
				prev: '#wt_cat_prev',
				next: '#wt_cat_next',
				auto: false,
				swipe: {
					onTouch : true
				},
				items: {
					width:160,
					height: 'auto',
					visible: {
						min: 2,
						max: item_feature_cat
					}
				},
				scroll: {
					items:2,
					direction : 'left',    
					duration  : 500 ,  
					onBefore: function(data) {  
					},
					onAfter	: function(data) {
					var n=5;
						n=data.items.visible.length;
						$("#carousel1{$smarty.foreach.tabs.iteration|intval} li").removeClass("first_item");
						$("#carousel1{$smarty.foreach.tabs.iteration|intval} li:nth-child(1)").addClass("first_item");
				   }
				}
			});
		
	}
	
</script>
	{/if}
</div>