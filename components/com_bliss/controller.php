<?php

class BlissController extends JControllerLegacy{

	public function display($cachable = false, $urlparams = array()){

		$viewName=$this->input->get('view','payment');

		$viewLayout=$this->input->get('layout');

		$view=$this->getView($viewName,'html');

		$model=$this->getModel($viewName);

		$view->setModel($model,true);

		$view->setLayout($viewLayout);

		$view->display();

	}

	public function spReturn(){

		//CREDIT,WEBATM,return error
		echo '<pre>'.print_r($this->input->post->getArray(),1).'</pre>';

		$status=$this->input->post->get('Status');

		//判斷有無錯誤
		if($status!=='SUCCESS'){
			$this->setRedirect(
				JRoute::_('index.php?option=com_bliss&view=payment'),
				'付款發生錯誤，您的錯誤代碼：'.$status,
				'error'
			);

			return false;
		}

		//validate checkcode
		$merchantID='MS31005804';
		$hashkey='daMrxeY4Dxgvn5AAg6BivBuWPvMbhI1u';
		$hashIV='SOWp2VuGtKbQQMr7';

		$orderId=$this->input->post->get('MerchantOrderNo');
		$tradeNo=$this->input->post->get('TradeNo');
		$amount=$this->input->post->get('Amt');

		$check_code = array(
			'MerchantID' => $merchantID,
			'Amt' => $amount,
			'MerchantOrderNo' => $orderId,
			'TradeNo' => $tradeNo,
		);
		ksort($check_code);
		$check_str = http_build_query($check_code);
		$checkcode = "HashIV=".$hashIV."&$check_str&HashKey=".$hashkey;
		$checkcode = strtoupper(hash("sha256", $checkcode));

		if($checkcode != $this->input->post->get('CheckCode')){
			$this->setRedirect(
				JRoute::_('index.php?option=com_bliss&view=payment'),
				'check code 錯誤',
				'error'
			);

			return false;
		}

		echo 'pay success';

	}

	public function spNotify()
	{

	}

	public function spCustomer(){

	}

	//將驗證拉出來，因為3個function
	public function valudate(){

	}



}

?>