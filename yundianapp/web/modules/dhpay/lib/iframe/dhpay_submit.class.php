<?php
/* *
 * 类名：DhpaySubmit
 * 功能：支付宝各接口请求提交类
 * 详细：构造支付宝各接口表单HTML文本，获取远程HTTP数据
 * 版本：3.2
 * 日期：2011-03-25
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
 */
class DhpaySubmit {
    /**
     * 构造提交表单HTML数据
     * @param $para_temp 请求参数数组
     * @param $gateway 网关地址
     * @param $method 提交方式。两个值可选：post、get
     * @param $button_name 确认按钮显示文字
     * @return 提交表单HTML文本
     */
	function buildForm($para_temp, $gateway, $dhpay_config) {
		//待请求参数数组
		$sHtml = "<iframe name='dhpayiframe' src='$gateway' scrolling='no' width='560px' height='540px' frameBorder='0'></iframe>";
				  //<form style='display: none;' id='dhpaysubmit' name='dhpaysubmit' method='POST' target='dhpayiframe'>";
		//while (list ($key, $val) = each ($para_temp)) {
        //    $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        //}

		//submit按钮控件请不要含有name属性
		//注释原始版本中提交按钮和自动提交JS
        //$sHtml = $sHtml."<input type='submit' value='".$button_name."'></form>";

		//$sHtml = $sHtml."<script>document.forms['dhpaysubmit'].submit();</script>";
		
		return $sHtml;
	}
	
}
?>