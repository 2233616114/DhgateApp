<?php
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../header.php');

if (!$cookie->isLogged()) {
	Tools::redirect('authentication.php?back=order.php');
}
$dhpay = new Dhpay();
require_once("lib/$dhpay->interface/dhpay_notify.class.php");

//计算得出通知验证结果
$dhpayNotify = new DhpayNotify($dhpay->getAliConfig());
$verify_result = $dhpayNotify->verifyReturn();
$order = new Order($out_trade_no);
if($verify_result) {//验证成功
    $out_trade_no	= $_GET['out_trade_no'];	//获取订单号
    $trade_no		= $_GET['trade_no'];		//获取支付宝交易号
    $total_fee		= $_GET['price'];			//获取总价格
	if ($dhpay->site_id)
	{
		$out_trade_no = str_replace($dhpay->site_id, "", $out_trade_no);
	}
	$dhpay->saveStatus($out_trade_no, $_GET['trade_status'], $trade_no);
	$history = new OrderHistory();
}
else
{
	error_log("Dhpay notify error!");
}
?>
