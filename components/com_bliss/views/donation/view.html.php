<?php
class BlissViewDonation extends JViewLegacy{

	public function display($tpl = NULL){

		//登入，寫在task，用ajax呼叫網址&task=登入function
		$app=JFactory::getApplication();
		$app->login([
			'username' => 'login',
			'password' => '1234'
		]);

		//印出錯誤訊息
		if($result===false){
			$messages=$app->getMessageQueue();
		}

		parent::display();
	}


}

?>