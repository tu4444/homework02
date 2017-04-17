<?php
class BlissViewPayment extends JViewLegacy{

	public function display($tpl = NULL){

		$orderId='0001_'.uniqid();
		$version='1.2';
		$amount='2500';
		$timestamp= time();
		$merchantID='MS31005804';
		$hashkey='daMrxeY4Dxgvn5AAg6BivBuWPvMbhI1u';
		$hashIV='SOWp2VuGtKbQQMr7';

		$mer_array = array(
			'MerchantID' => $merchantID,
			'TimeStamp' => $timestamp,
			'MerchantOrderNo'=> $orderId,
			'Version' => $version,
			'Amt' => $amount,
		);
		ksort($mer_array);
		$check_merstr = http_build_query($mer_array);
		$CheckValue_str = "HashKey=".$hashkey."&$check_merstr&HashIV=".$hashIV;
		$CheckValue = strtoupper(hash("sha256", $CheckValue_str));

		$this->merchantID=$merchantID;
		$this->hashKey=$hashkey;
		$this->hashIV=$hashIV;
		$this->version=$version;
		$this->amount=$amount;
		$this->orderId=$orderId;
		$this->timestamp=$timestamp;
		$this->checkvalue=$CheckValue;

		parent::display();
	}


}

?>