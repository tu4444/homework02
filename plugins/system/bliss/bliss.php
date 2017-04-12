<?php
class PlgSystemBliss extends JPlugin
{
	protected $allow_context = [
		'com_users.profile',
		'com_users.user',
		'com_users.registration',
		'com_admin.profile'
	];

	/*public function onContentPrepare($context)
	{
		if($context!='com_content.article'){
			return;

		}
		//echo $context;
		//echo 'QWE';
	}*/

	//移除不要欄位
	public function onContentPrepareForm(JForm $form, $data)
	{
		//因無context,要從jform拿
		$context=$form->getName();
		//echo $context;

		/*if($context!='com_users.registration'){
			return;
		}*/

		//在我們指定的元件run
		if(!in_array($context,$this->allow_context)){
			return;
		}

		//移除username欄位(field)
		$form->removeField('username');

	}

	//拿出,儲存欄位都會呼叫這個funciton順便把資料塞進去
	public function onContentPrepareData($context, $data)
	{
		//在我們指定的元件run
		if(!in_array($context,$this->allow_context)){
			return;
		}

		if(isset($data->email1)){ //因為註冊無email1的值
			$data->username=$data->email1;
		}


		//因為data是物件，可直接修改，所以不用傳回去，不用return

		//print_r($data);

	}

	//因使用者修改email不會同步修改username
	//在網站上只要user儲存就會呼叫此function
	public function onUserAfterSave($data, $isNew, $result, $error)
	{
		if($result){
			$email=$data['email'];
			$id=$data['id'];

			$db=JFactory::getDbo();

			$query=$db->getQuery(true);

			$query->update('#__users')
				->set('username='.$query->q($email))
				->where('id='.$id);

			$db->setQuery($query)->execute();
		}

		return true;
	}
}
?>