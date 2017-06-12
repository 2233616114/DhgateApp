<?php
include(dirname(__FILE__).'/../../config/config.inc.php');

include(dirname(__FILE__).'/dhpay.php');
$dhpay = new Dhpay();
require_once("lib/dhpay_notify.class.php");

//计算得出通知验证结果
$dhpayNotify = new DhpayNotify($dhpay->getAliConfig());
$verify_result = $dhpayNotify->verifyReturn();

$out_trade_no	= $_GET['order_no'];	//获取订单号

$order = new Order($out_trade_no);
if($verify_result) {//验证成功
	$trade_no		= $_GET['ref_no'];		//获取交易号
	$total_fee		= $_GET['amount'];			//获取总价格
	if($_GET['status'] == '01')
	{
		$dhpay->saveStatus($out_trade_no, Dhpay::WAIT_SELLER_SEND_GOODS, $trade_no);

		$history = new OrderHistory();
		$history->id_order = (int)($out_trade_no);
		$history->changeIdOrderState(_PS_OS_PAYMENT_, intval($out_trade_no));
		$history->add();
	}
	else
	{
		$dhpay->saveStatus($out_trade_no, $_GET['trade_status'], $trade_no);
		$history = new OrderHistory();
		$history->id_order = $out_trade_no;
		$history->changeIdOrderState(_PS_OS_ERROR_, intval($out_trade_no));
		$history->add();
	}
}
else {
	echo $dhpay->l("验证失败");
}

echo 'success';exit;

