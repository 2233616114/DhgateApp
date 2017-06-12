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

{if ($showQtyPage == true)}
	<div id="product-quantities" class="panel product-tab">
		<input type="hidden" name="submitted_tabs[]" value="Productstock" />
		<h3>{l s='Available quantities for sale'}</h3>
		<div class="form-group">
			{*<div class="col-lg-1"><span class="pull-right"></span></div>*}
			<label class="control-label col-lg-2" for="productStock">
				{l s='Available quantities'}
			</label>
			<div class="col-lg-9">
				<input type="text" id="productStock" name="productStock" class="form-control fixed-width-sm" maxlength="6" value="{$productStock}" />
			</div>
		</div>

		<div class="form-group">
			{*<div class="col-lg-1"><span class="pull-right">{include file="controllers/products/multishop/checkbox.tpl" field="minimal_quantity" type="default"}</span></div>*}
			<label class="control-label col-lg-2" for="minimal_quantity">
				{l s='Minimum quantity'}
			</label>
			<div class="col-lg-9">
				<input type="text" id="minimal_quantity" name="minimal_quantity" class="form-control fixed-width-sm" maxlength="6" value="{$product->minimal_quantity|default:1}" />
			</div>
		</div>




	</div>
{/if}
