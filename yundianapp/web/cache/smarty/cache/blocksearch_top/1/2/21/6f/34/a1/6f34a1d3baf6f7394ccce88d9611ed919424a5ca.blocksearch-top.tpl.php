<?php /*%%SmartyHeaderCode:321358c251ce597981-21386537%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f34a1d3baf6f7394ccce88d9611ed919424a5ca' => 
    array (
      0 => 'E:\\wamp64\\www\\themes\\es_mobile_wish\\modules\\blocksearch\\blocksearch-top.tpl',
      1 => 1484131642,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '321358c251ce597981-21386537',
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_58c252153d6607_25443176',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c252153d6607_25443176')) {function content_58c252153d6607_25443176($_smarty_tpl) {?><!-- Block search module TOP -->
<div id="search_block_top" class="col-xs-8 col-sm-4 clearfix">
	<form id="searchbox" method="get" action="//base_debug.s.yundianapp.com/index.php?controller=search" >
		<input type="hidden" name="controller" value="search" />
		<input type="hidden" name="orderby" value="position" />
		<input type="hidden" name="orderway" value="desc" />
		<input class="search_query form-control" type="text" id="search_query_top" name="search_query" placeholder="Search" value="" />
		<button type="submit" name="submit_search" class="hidden-xs btn btn-default button-search">
			<span>Search</span>
		</button>
	</form>
</div>
<!-- /Block search module TOP --><?php }} ?>
