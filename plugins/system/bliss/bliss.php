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

		//移除email2欄位
		$form->removeField('email2');


		//讀取form的xml檔
		$form->loadFile(__DIR__.'/forms/profile.xml');

	}

	//拿出,儲存欄位都會呼叫這個funciton順便把資料塞進去
	public function onContentPrepareData($context, $data)
	{
		//在我們指定的元件run
		if(!in_array($context,$this->allow_context)){
			return;
		}

		//將email1塞給隱藏的欄位：username、email2
		if(isset($data->email1)){ //因為註冊頁無email1的值
			$data->username=$data->email1;
			$data->email2=$data->email1;
		}

		//echo 'onContentPrepareData:';
		//echo '<pre>'.print_r($data,1).'</pre>';

		//die;
		//因為data是物件，可直接修改，所以不用傳回去，不用return

		//修改會員資料頁面，lock email，
		//if()

		//塞profile的內容
		if(isset($data->id)){
			$db=JFactory::getDbo();
			$query=$db->getQuery(true);

			$query->select('*')
				->from('#__bliss_user_profiles')
				->where('user_id='.$data->id);

			$profile=$db->setQuery($query)->loadObject();

			$data->profile=$profile;

		}

	}

	public function onUserBeforeSave($oldUser, $isNew, $newUser)
	{
		$app = JFactory::getApplication();

		//echo 'onUserBeforeSave';
		//echo '<pre>'.print_r($newUser,1).'</pre>';

		//die;
		/*if($newUser['profile']['phone']==''){
			$app->enqueueMessage('phone沒填','error');
			return false;
		}*/

		return true;
	}

	//因使用者修改email不會同步修改username
	//在網站上只要user儲存就會呼叫此function
	public function onUserAfterSave($data, $isNew, $result, $error)
	{
		if($result){
			$email=$data['email'];
			$id=$data['id'];


			//username覆蓋
			$db=JFactory::getDbo();

			$query=$db->getQuery(true);

			$query->update('#__users')
				->set('username='.$query->q($email))
				->where('id='.$id);

			$db->setQuery($query)->execute();


			//儲存profile
			if(isset($data['profile']) && is_array($data['profile'])){
				$profile=$data['profile'];

				$this->saveProfile($data['id'],$profile);
			}

		}


		//print_r($data);
		//die;

		return true;
	}

	protected function saveProfile($id,array $profile){
		$db=JFactory::getDbo();

		$query=$db->getQuery(true);

		$data=(object) $profile;
		$data->user_id=$id;


		//確認這個人的userprofile是否建立了
		$query->select('id')
			->from('#__bliss_user_profiles')
			->where('user_id='.$id);
		$exists=$db->setQuery($query)->loadResult();

		if(!$exists)
		{

			$db->insertObject('#__bliss_user_profiles', $data);
		}
		else
		{
			$db->updateObject('#__bliss_user_profiles',$data,'user_id');
		}


	}
}
?>