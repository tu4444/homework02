<?php
/**
 * Created by PhpStorm.
 * User: 官方網站
 * Date: 2017/4/21
 * Time: 下午 03:02
 */

class BlissHelper{

	public static function arrangeDefaultFields($fields){
		//若fieldset為default，field要重新排序
		$arrange=array();
		$indexset=array('jform_spacer','jform_email1','jform_password1','jform_password2','jform_name','jform_captcha');

		foreach ($indexset as $i){
			foreach ($fields as $field){
				if($field->id==$i){array_push($arrange,$field);}
			}
		}

		return $arrange;


	}

}