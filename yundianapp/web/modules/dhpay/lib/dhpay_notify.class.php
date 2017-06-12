<?php
/* *
 * 类名：DhpayNotify
 * 功能：支付宝通知处理类
 * 详细：处理支付宝各接口通知返回
 * 版本：3.2
 * 日期：2011-03-25
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考

 *************************注意*************************
 * 调试通知返回时，可查看或改写log日志的写入TXT里的数据，来检查通知返回是否正常
 */

require_once("dhpay_core.function.php");

class DhpayNotify {
	var $dhpay_config;

	function __construct($dhpay_config){
		$this->dhpay_config = $dhpay_config;
	}
    function DhpayNotify($dhpay_config) {
    	$this->__construct($dhpay_config);
    }
    /**
     * 针对notify_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
	function verifyNotify(){
		if(empty($_GET)) {//判断POST来的数组是否为空
			return false;
		}
		else {
			//生成签名结果
			$mysign = $this->getMysign($_POST);
			//获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
			$responseTxt = 'true';
			if (! empty($_POST["notify_id"])) {$responseTxt = $this->getResponse($_POST["notify_id"]);}
			
			//写日志记录
			//$log_text = "responseTxt=".$responseTxt."\n notify_url_log:sign=".$_POST["sign"]."&mysign=".$mysign.",";
			//$log_text = $log_text.createLinkString($_POST);
			//logResult($log_text);
			
			//验证
			//$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
			//mysign与sign不等，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
			if (preg_match("/true$/i",$responseTxt) && $mysign == $_POST["sign"]) {
				return true;
			} else {
				return false;
			}
		}
	}
	
    /**
     * 针对return_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
	function verifyReturn(){
		if(empty($_GET)) {//判断POST来的数组是否为空
			return false;
		}
		else {
			//生成签名结果
			$mysign = $this->response_hash($_GET, $this->dhpay_config['private_key']);
			if ($mysign == $_GET['hash']) {
				return true;
			}else{
				return false;
			}
		}
	}

	public function response_hash($data, $private_key)
	{
		// 签名的表单字段名
        $hash_src = '';
        $hash_key = array('amount','currency', 'invoice_id', 'merchant_id',
            'trans_time', 'trans_date', 'status', 'ref_no', 'order_no');
        if ($data['status'] == '02') {
            $hash_key[] = 'failure_reason';
        }
        // 按 key 名进行顺序排序
        sort($hash_key);
        foreach ($hash_key as $key) {
            $hash_src .= $data[$key];
        }
        // 密钥放最前面
        $hash_src = $private_key . $hash_src;
        // sha256 算法
        $hash = hash('sha256', $hash_src);
        return strtoupper($hash);
	}
}
?>
