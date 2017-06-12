<?php
/* *
 * 类名：DhpayService
 * 功能：支付宝各接口构造类
 * 详细：构造支付宝各接口请求参数
 * 版本：3.2
 * 日期：2011-03-25
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
 */

require_once("dhpay_submit.class.php");
class DhpayService {
	
	var $dhpay_config;

	public  $payment_gateway;

	function __construct($dhpay_config){
		$this->dhpay_config = $dhpay_config;
	}
    function DhpayService($dhpay_config) {
    	$this->__construct($dhpay_config);
    }
	/**
     * 构造即时到帐接口
     * @param $para_temp 请求参数数组
     * @return 表单提交HTML信息
     */
	function dhpay_redirect($para_temp) {
		//设置按钮名称
		$button_name = "Confirm";
		//生成表单提交HTML文本信息
		$dhpaySubmit = new DhpaySubmit();
		$html_text = $dhpaySubmit->buildForm($para_temp, $this->payment_gateway, $button_name,$this->dhpay_config);

		return $html_text;
	}
}
?>