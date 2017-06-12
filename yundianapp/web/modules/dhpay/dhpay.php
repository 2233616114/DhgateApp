<?php

class dhpay extends PaymentModule
{
    private $_html = '';
    private $_postErrors = array();

    public $checkout_method;
    public $private_key;
    public $merchant_id;
    public $dhpay_title = 'Dhpay';
    public $input_charset = "utf-8";
    public $sign_type = "MD5";
    public $transport = "http";
    public $notify_url = "payment_notify.php";
    public $return_url = "payment_return.php";
    public $show_url = "";
    public $goods_confirm = 0;
    public $interface;
    public $logistics_type;
    public $payment_gateway = "";

    public $page_layout;
    public $page_title_style;
    public $page_body_style;
    public $page_button_style;
    public $test_mode;

    const CREATE_ORDER = "CREATE_ORDER";
    const VALIDATED_ORDER = "VALIDATED_ORDER";
    const WAIT_SELLER_SEND_GOODS = "WAIT_SELLER_SEND_GOODS";
    const NOTIFY_VERIFY_ERROR = "NOTIFY_VERIFY_ERROR";

    public function __construct()
    {
        $this->name = 'dhpay';
        $this->tab = 'payments_gateways';
        $this->version = '1.0';
        $this->author = 'Dhpay.com';

        $this->currencies = true;
        $this->currencies_mode = 'checkbox';

        $config = Configuration::getMultiple(array('DHPAY_CHECKOUT_METHOD', 'DHPAY_PRIVATE_KEY', 'DHPAY_MERCHANT_ID', 'DHPAY_TEST_MODE', 'DHPAY_PAGE_LAYOUT', 'DHPAY_PAGE_BODY_STYLE', 'DHPAY_PAGE_TITLE_STYLE', 'DHPAY_PAGE_BUTTON_STYLE', 'DHPAY_TITLE'));
        if (isset($config['DHPAY_CHECKOUT_METHOD']))
            $this->checkout_method = $config['DHPAY_CHECKOUT_METHOD'];
        if (isset($config['DHPAY_PRIVATE_KEY']))
            $this->private_key = $config['DHPAY_PRIVATE_KEY'];
        if (isset($config['DHPAY_MERCHANT_ID']))
            $this->merchant_id = $config['DHPAY_MERCHANT_ID'];
        if (isset($config['DHPAY_TEST_MODE']))
            $this->test_mode = $config['DHPAY_TEST_MODE'];
        if (isset($config['DHPAY_PAGE_LAYOUT']))
            $this->page_layout = $config['DHPAY_PAGE_LAYOUT'];
        if (isset($config['DHPAY_PAGE_TITLE_STYLE']))
            $this->page_title_style = $config['DHPAY_PAGE_TITLE_STYLE'];
        if (isset($config['DHPAY_PAGE_BODY_STYLE']))
            $this->page_body_style = $config['DHPAY_PAGE_BODY_STYLE'];
        if (isset($config['DHPAY_PAGE_BUTTON_STYLE']))
            $this->page_button_style = $config['DHPAY_PAGE_BUTTON_STYLE'];
        if (isset($config['DHPAY_TITLE']))
            $this->dhpay_title = $config['DHPAY_TITLE'];

        $this->return_url = 'modules/dhpay/' . $this->return_url;
        $this->notify_url = 'modules/dhpay/' . $this->notify_url;

        parent::__construct(); /* The parent construct is required for translations */

        $this->page = basename(__FILE__, '.php');
        $this->displayName = $this->l('Dhpay');
        $this->description = $this->l('Accept payments by Dhpay');
        $this->confirmUninstall = $this->l('Are you sure you want to delete your details ?');
        if (!isset($this->checkout_method) OR !isset($this->private_key) OR !isset($this->merchant_id) OR !isset($this->input_charset) OR !isset($this->sign_type) OR !isset($this->transport) OR !isset($this->notify_url) OR !isset($this->return_url))
            $this->warning = $this->l('Account owner and details must be configured in order to use this module correctly');

        $this->transport = Configuration::get('PS_SSL_ENABLED') ? 'https' : 'http';
    }

    public function install()
    {
        if (!parent::install() OR
            !$this->registerHook('payment') OR
            !$this->registerHook('paymentReturn') OR
            !$this->createTable() OR
            !$this->_createDhpayOrderState()
        )
            return false;

        return true;
    }

    public function uninstall()
    {
        if (!Configuration::deleteByName('DHPAY_CHECKOUT_METHOD')
            || !Configuration::deleteByName('DHPAY_MERCHANT_ID')
            || !Configuration::deleteByName('DHPAY_PRIVATE_KEY')
            || !Configuration::deleteByName('DHPAY_TEST_MODE')
            || !Configuration::deleteByName('DHPAY_PAGE_LAYOUT')
            || !Configuration::deleteByName('DHPAY_PAGE_TITLE_STYLE')
            || !Configuration::deleteByName('DHPAY_PAGE_BODY_STYLE')
            || !Configuration::deleteByName('DHPAY_PAGE_BUTTON_STYLE')
            || !Configuration::deleteByName('DHPAY_TITLE')
            || !Configuration::deleteByName('PS_OS_DHPAY_AWATING')
            || !$this->removeTable()
            || !parent::uninstall()
        )
            return false;
        return true;
    }

    private function _postValidation()
    {
        if (isset($_POST['btnSubmit'])) {
            if (empty($_POST['merchant_id']))
                $this->_postErrors[] = $this->l('Merchant ID is required.');
            elseif (empty($_POST['private_key']))
                $this->_postErrors[] = $this->l('Private Key is required.');
        }
    }

    private function _postProcess()
    {
        if (isset($_POST['btnSubmit'])) {
            Configuration::updateValue('DHPAY_CHECKOUT_METHOD', $_POST['checkout_method']);
            Configuration::updateValue('DHPAY_MERCHANT_ID', $_POST['merchant_id']);
            Configuration::updateValue('DHPAY_TEST_MODE', $_POST['test_mode']);
            Configuration::updateValue('DHPAY_PRIVATE_KEY', $_POST['private_key']);
            Configuration::updateValue('DHPAY_PAGE_LAYOUT', $_POST['page_layout']);
            Configuration::updateValue('DHPAY_CHECKOUT_METHOD', $_POST['checkout_method']);
            Configuration::updateValue('DHPAY_PAGE_BODY_STYLE', $_POST['page_body_style']);
            Configuration::updateValue('DHPAY_PAGE_TITLE_STYLE', $_POST['page_title_style']);
            Configuration::updateValue('DHPAY_PAGE_BUTTON_STYLE', $_POST['page_button_style']);
            Configuration::updateValue('DHPAY_TITLE', $_POST['dhpay_title']);
        }
        $this->_html .= '<div class="conf confirm"><img src="../img/admin/ok.gif" alt="' . $this->l('ok') . '" /> ' . $this->l('Settings updated') . '</div>';
    }

    private function _displayForm()
    {
        $page_layout = Tools::getValue('page_layout', $this->page_layout);
        $checkout_method = Tools::getValue('checkout_method', $this->checkout_method);
        $test_mode = Tools::getValue('test_mode', $this->test_mode);
        $goods_confim = intval(Tools::getValue('goods_confirm', $this->goods_confirm));
        $this->_html .=
            '
		<script type="text/javascript">
			function switchDhpayAdd()
			{
				$("#dhpay_options").slideToggle("slow");
			}
		</script>
		
		<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
			<fieldset>
			<legend><img src="../img/admin/contact.gif" />' . $this->l('Configuration information') . '</legend>
				<label>' . $this->l('Dhpay Title') . '</label>
				<div class="margin-form">
					<input type="text" name="dhpay_title" value="' . htmlentities(Tools::getValue('dhpay_title', $this->dhpay_title), ENT_COMPAT, 'UTF-8') . '" style="width: 300px;" />
					<p class="clear"></p>
				</div>
				<label>' . $this->l('Merchant ID') . '</label>
				<div class="margin-form">
					<input type="text" name="merchant_id" value="' . htmlentities(Tools::getValue('merchant_id', $this->merchant_id), ENT_COMPAT, 'UTF-8') . '" style="width: 300px;" />
					<p class="clear"></p>
				</div>
				<label>' . $this->l('Private Key') . '</label>
				<div class="margin-form">
					<input type="text" name="private_key" value="' . htmlentities(Tools::getValue('private_key', $this->private_key), ENT_COMPAT, 'UTF-8') . '" style="width: 300px;" />
					<p class="clear"></p>
				</div>
				<label>' . $this->l('Test Mode') . '</label>
				<div class="margin-form">
					<select name="test_mode" style="width:100px;">
						<option value="Live" ' . (($test_mode == 'Live') ? 'selected="selected"' : '') . '>' . $this->l('Live') . '</option>';
        $this->_html .= '
						<option value="Test" ' . (($test_mode == 'Test') ? 'selected="selected"' : '') . '>' . $this->l('Test') . '</option>
					</select>
					<p class="clear"></p>
				</div>
				<label>' . $this->l('Checkout Method') . '</label>
				<div class="margin-form">
					<select name="checkout_method" style="width:100px;">
						<option value="Redirect" ' . (($checkout_method == 'Redirect') ? 'selected="selected"' : '') . '>' . $this->l('Redirect') . '</option>';
        $this->_html .= '
						<option value="Iframe" ' . (($checkout_method == 'Iframe') ? 'selected="selected"' : '') . '>' . $this->l('Iframe') . '</option>
					</select>
					<p class="clear"></p>
				</div>
				<label>' . $this->l('Page Layout') . '</label>
				<div class="margin-form">
					<select name="page_layout" style="width:100px;">
						<option value="Vertical" ' . (($page_layout == 'Vertical') ? 'selected="selected"' : '') . '>' . $this->l('Vertical') . '</option>';
        $this->_html .= '
						<option value="Horizontal" ' . (($page_layout == 'Horizontal') ? 'selected="selected"' : '') . '>' . $this->l('Horizontal') . '</option>
					</select>
					<p class="clear"></p>
				</div>
				<label>' . $this->l('Page Body Style') . '</label>
				<div class="margin-form">
					<input type="text" name="page_body_style" value="' . htmlentities(Tools::getValue('page_body_style', $this->page_body_style), ENT_COMPAT, 'UTF-8') . '" style="width: 300px;" />
					<p class="clear"></p>
				</div>
				<label>' . $this->l('Page Title Style') . '</label>
				<div class="margin-form">
					<input type="text" name="page_title_style" value="' . htmlentities(Tools::getValue('page_title_style', $this->page_title_style), ENT_COMPAT, 'UTF-8') . '" style="width: 300px;" />
					<p class="clear"></p>
				</div>
				<label>' . $this->l('Page Button Style') . '</label>
				<div class="margin-form">
					<input type="text" name="page_button_style" value="' . htmlentities(Tools::getValue('page_button_style', $this->page_button_style), ENT_COMPAT, 'UTF-8') . '" style="width: 300px;" />
					<p class="clear"></p>
				</div>
				<center><input class="button" name="btnSubmit" value="' . $this->l('Update settings') . '" type="submit" /></center>
			</fieldset>
		</form>';
    }

    public function createTable()
    {
        return Db::getInstance()->Execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dhpay_order` (
			`id_order` int(10) unsigned NOT NULL auto_increment,
			`status` varchar(255) NOT NULL,
			`trade_no` varchar(20),
			PRIMARY KEY (`id_order`)
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8');
    }

    private function _createDhpayOrderState()
    {
        if (!Configuration::get('PS_OS_DHPAY_AWATING'))
        {
            $os = new OrderState();
            $os->name = array();
            foreach (Language::getLanguages(false) as $language)
                if (Tools::strtolower($language['iso_code']) == 'fr')
                    $os->name[(int)$language['id_lang']] = 'Awaiting Dhpay payment';
                else
                    $os->name[(int)$language['id_lang']] = 'Awaiting Dhpay payment';
            $os->color = '#4169E1';
            $os->hidden = false;
            $os->send_email = false;
            $os->delivery = false;
            $os->logable = false;
            $os->invoice = false;
            if ($os->add())
            {
                Configuration::updateValue('PS_OS_DHPAY_AWATING', $os->id);
                copy(dirname(__FILE__).'/logo.png', dirname(__FILE__).'/../../img/os/'.(int)$os->id.'.gif');
            }
            else
                return false;
        }
        return true;
    }

    public function removeTable()
    {
        return Db::getInstance()->Execute('
			DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'dhpay_order`');
    }

    public function getContent()
    {
        $this->_html = '<h2>' . $this->displayName . '</h2>';

        if (!empty($_POST)) {
            $this->_postValidation();
            if (!sizeof($this->_postErrors))
                $this->_postProcess();
            else
                foreach ($this->_postErrors AS $err)
                    $this->_html .= '<div class="alert error">' . $err . '</div>';
        } else
            $this->_html .= '<br />';

        //$this->_displayBankWire();
        $this->_displayForm();

        return $this->_html;
    }

    public function execPayment($cart)
    {
        global $cookie, $smarty;
        $currencies = $this->getCurrency();

        //如果购物车不是RMB，将其进行转换
        $convert_ccy = false;
        $cart_ccy = new Currency($cart->id_currency);

        $errors = array();
        $form_content = $this->generateOrder($cart, $errors);

        $params = array(
            'page_layout' => $this->page_layout,
            'form_content' => $form_content,
            'this_path' => $this->_path
        );
        if ($convert_ccy) {
            $params['cart_ccy'] = $cart_ccy;
        }
        $smarty->assign($params);

        return $this->display(__FILE__, 'payment_execution.tpl');
    }

    public function generateOrder($cart, &$errors)
    {
        global $cookie, $smarty;

        if ($cart->id_customer != $cookie->id_customer) {
            die("Invalid request");
        }

        $currency_order = new Currency(intval($cart->id_currency));
        $currency_module = $this->getCurrency();
        $assign_values['currency_order'] = $currency_order->iso_code;
        //$assign_values['currency_module'] = $currency_module->iso_code;
        //generate order before send to dhpay
        $v_amount = Tools::ps_round(floatval($cart->getOrderTotal(true, 3)), 2);
        $assign_values['v_amount'] = $v_amount;

        //必填参数//
        $v_body = $this->getBody($cart);
        $v_logistics_fee = $cart->getOrderTotal(true, Cart::ONLY_SHIPPING);                //物流费用，即运费。

        $delivery_addr = new Address(intval($cart->id_address_delivery));

        $id_order = Order::getOrderByCartId($cart->id);
        if ($id_order) {
            $order = new Order($id_order);
        } else {
            $this->validateOrder($cart->id, Configuration::get('PS_OS_DHPAY_AWATING'), $v_amount, $this->displayName, $this->l("Waiting for payment"));
            $order = new Order($this->currentOrder);
            $id_order = $this->currentOrder;
        }
        $this->saveStatus($id_order, Dhpay::CREATE_ORDER);

        $assign_values['id_order'] = $id_order;
        $smarty->assign($assign_values);

        //必填参数//
        $v_out_trade_no = $id_order;        //请与贵网站订单系统中的唯一订单号匹配
        $v_subject = $id_order;        //订单名称，显示在支付宝收银台里的“商品名称”里，显示在支付宝的交易管理的“商品名称”的列表里。
        $v_quantity = "1";                    //商品数量，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品。


        //选填参数//

        //买家收货信息（推荐作为必填）
        //该功能作用在于买家已经在商户网站的下单流程中填过一次收货信息，而不需要买家在支付宝的付款流程中再次填写收货信息。
        //若要使用该功能，请至少保证receive_name、receive_address有值
        //收货信息格式请严格按照姓名、地址、邮编、电话、手机的格式填写
        $customer = new Customer(intval($cart->id_customer));
        //$v_moneytype = $this->getPayeaseMoneyType($currency_order->iso_code);
        $v_receive_address = $delivery_addr->address1 . $delivery_addr->address2; //收货人地址，如：XX省XXX市XXX区XXX路XXX小区XXX栋XXX单元XXX号
        $v_receive_zip = $delivery_addr->postcode;        //收货人邮编，如：123456
        $v_receive_phone = $delivery_addr->phone;        //收货人电话号码，如：0571-81234567
        $v_receive_mobile = $delivery_addr->phone_mobile;        //收货人手机号码，如：13312341234

        $billing_addr = new Address(intval($cart->id_address_invoice));

        $order_product = $cart->getProducts();
        $v_pay_mode = "directPay";
        $parameter = array(
            'merchant_id' => $this->merchant_id,
            'invoice_id' => $v_out_trade_no,
            'order_no' => $v_out_trade_no,//
            'currency' => $currency_order->iso_code,
            'amount' => sprintf("%.2f", $cart->getOrderTotal(true, Cart::BOTH)),
            'buyer_email' => $customer->email,
            'shipping_country' => Country::getIsoById($delivery_addr->id_country),
            'first_name' => $billing_addr->firstname,
            'last_name' => $billing_addr->lastname,
            'country' => Country::getIsoById($billing_addr->id_country),
            'state' => State::getNameById($billing_addr->id_state),
            'city' => $billing_addr->city,
            'address_line' => $billing_addr->address1 . $billing_addr->address2,
            'zipcode' => $billing_addr->postcode,
            'product_name' => $order_product[0]['name'],
            'product_price' => sprintf("%.2f", $order_product[0]['price']),
            'product_quantity' => $order_product[0]['quantity'],
            'return_url' => Tools::getHttpHost(true, true) . __PS_BASE_URI__ . $this->return_url,
            'remark' => '',
            'hash' => '',

            'shipping_first_name' => $delivery_addr->firstname,
            'shipping_last_name' => $delivery_addr->lastname,
            'shipping_state' => State::getNameById($delivery_addr->id_state),
            'shipping_city' => $delivery_addr->city,
            'shipping_address_line' => $v_receive_address,
            'shipping_zipcode' => $v_receive_zip,
            'shipping_email' => $customer->email,
            'shipping_phone' => $v_receive_mobile,

            'body_style' => $this->page_body_style,
            'title_style' => $this->page_title_style,
            'layout' => strtolower($this->page_layout),
            'button_style' => $this->page_button_style,

        );

        $parameter['hash'] = $this->request_hash($parameter, $this->private_key);

        if ($this->checkout_method == "Redirect") {
            require_once("lib/redirect/dhpay_service.class.php");
            //构造要请求的参数数组

            //"notify_url"		=> Tools::getHttpHost(true, true).__PS_BASE_URI__.$this->notify_url,

            //构造担保交易接口
            $dhpayService = new DhpayService($this->getAliConfig());

            $payflow_url = 'https://www.dhpay.com/merchant/web/cashier';

            if ($this->test_mode == 'Test') {
                $payflow_url .= '?env=dhpaysandbox';
            }
            $this->payment_gateway = $payflow_url;
            $dhpayService->payment_gateway = $this->payment_gateway;
            $html_text = $dhpayService->dhpay_redirect($parameter);
            return $html_text;
        } else {
            require_once("lib/iframe/dhpay_service.class.php");
            //构造请求函数
            $dhpayService = new DhpayService($this->getAliConfig());

            $payflow_url = 'https://www.dhpay.com/merchant/web/cashier/iframe/before';

            if ($this->test_mode == 'Test') {
                $payflow_url .= '?env=dhpaysandbox';
            }

            $parameter['return_url'] .= '?return_type=2';
            $payflow_url = $payflow_url . ($this->test_mode == 'Test' ? '&' : '?') . http_build_query($parameter, '', "&");
            $this->payment_gateway = $payflow_url;
            $dhpayService->payment_gateway = $this->payment_gateway;
            $html_text = $dhpayService->dhpay_iframe($parameter);
            return $html_text;
        }

    }

    public function getAliConfig()
    {
        //合作身份者id
        $dhpay_config['checkout_method'] = $this->checkout_method;
        //安全检验码
        $dhpay_config['private_key'] = $this->private_key;
        $dhpay_config['test_mode'] = $this->test_mode;
        //签约支付宝账号或卖家支付宝帐户
        $dhpay_config['merchant_id'] = $this->merchant_id;
        //页面跳转同步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
        //return_url的域名不能写成http://localhost/trade_create_by_buyer_php_utf8/return_url.php ，否则会导致return_url执行无效
        $dhpay_config['return_url'] = Tools::getHttpHost(true, true) . __PS_BASE_URI__ . $this->return_url;
        //服务器异步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
        $dhpay_config['notify_url'] = Tools::getHttpHost(true, true) . __PS_BASE_URI__ . $this->notify_url;
        $dhpay_config['sign_type'] = $this->sign_type;
        //字符编码格式 目前支持 gbk 或 utf-8
        $dhpay_config['input_charset'] = $this->input_charset;

        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        //$dhpay_config['transport'] = $this->transport;

        return $dhpay_config;
    }

    public function hookPayment($params)
    {
        global $smarty;

        if (is_null($this->test_mode) || is_null($this->checkout_method) || is_null($this->return_url)){
            return false;
        }

        $smarty->assign(array(
            'this_dhpay_title' => $this->dhpay_title,
            'this_path' => $this->_path,
            'this_path_ssl' => (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://') . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__ . 'modules/' . $this->name . '/'));
        return $this->display(__FILE__, 'payment.tpl');
    }

    public function hookPaymentReturn($params)
    {
        global $smarty;
        $state = $params['objOrder']->getCurrentState();
        if ($state == _PS_OS_PAYMENT_)
            $smarty->assign(array(
                'status' => 'ok',
                'id_order' => $params['objOrder']->id
            ));
        else
            $smarty->assign('status', 'failed');

        return $this->display(__FILE__, 'confirmation.tpl');
    }

    public function getBody($cart)
    {
        $products = $cart->getProducts(true);
        $prod_desc = array();
        foreach ($products AS $product) {
            $prod_desc[] = $product['description_short'] . ' ' . $product['quantity'];
        }
        $body = implode(",", $prod_desc);
        if ($this->getStrLength($body) > 256) {
            $body = $this->utf8_substr($body, 0, 256);
        }
        return strip_tags($body);
    }

    public function saveStatus($id_order, $status, $trade_no = null)
    {
        $result = Db::getInstance()->getRow('SELECT * FROM `' . _DB_PREFIX_ . 'dhpay_order`');
        if (count($result))
            Db::getInstance()->Execute('
				UPDATE `' . _DB_PREFIX_ . 'dhpay_order`
				SET `status` = \'' . $status . '\', `trade_no` = \'' . $trade_no . '\' WHERE `id_order` = ' . $id_order);
        else
            Db::getInstance()->Execute('
				INSERT INTO `' . _DB_PREFIX_ . 'dhpay_order` (`id_order`, `status`)
				VALUES (' . (int)($id_order) . ', \'' . $status . '\')');
    }

    function getStrLength($value)
    {
        return strlen(str_replace('/[^\x00-\xFF]/g', '**', $value));
    }

    function utf8_substr($str, $start, $length)
    {
        if (function_exists('mb_substr')) {
            return mb_substr($str, $start, $length, 'UTF-8');
        }
        preg_match_all("/./u", $str, $arr);
        return implode("", array_slice($arr[0], $start, $length));
    }

    public function request_hash($data, $private_key)
    {
        // 签名的表单字段名
        $hash_src = '';
        $hash_key = array('amount', 'currency', 'invoice_id', 'merchant_id');
        // 按 key 名进行顺序排序
        sort($hash_key);
        foreach ($hash_key as $key) {
            $hash_src .= $data[$key];
        }
        // 密钥放最前面
        $hash_src = $private_key . $hash_src;
        // sha256 算法
        $hash = hash('sha256', $hash_src);

        return $hash;
    }

}

?>