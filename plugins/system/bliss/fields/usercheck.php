<?php
/**
 * Created by PhpStorm.
 * User: 官方網站
 * Date: 2017/4/22
 * Time: 下午 05:47
 */
JFormHelper::loadFieldType('checkbox');

class JFormFieldUsercheck extends JFormFieldCheckbox {

	protected function getLabel(){
		return '';
	}

	protected function getInput(){

		// Initialize some field attributes.
		$class     = !empty($this->class) ? ' class="' . $this->class . '"' : '';
		$disabled  = $this->disabled ? ' disabled' : '';
		$value     = !empty($this->default) ? $this->default : '1';
		$required  = $this->required ? ' required aria-required="true"' : '';
		$autofocus = $this->autofocus ? ' autofocus' : '';
		$checked   = $this->checked || !empty($this->value) ? ' checked' : '';

		// Initialize JavaScript field attributes.
		$onclick  = !empty($this->onclick) ? ' onclick="' . $this->onclick . '"' : '';
		$onchange = !empty($this->onchange) ? ' onchange="' . $this->onchange . '"' : '';

		// Including fallback code for HTML5 non supported browsers.
		JHtml::_('jquery.framework');
		JHtml::_('script', 'system/html5fallback.js', false, true);

		$description=$this->description;
		//若是遇到「我同意會員條款」：會員條款需加連結，若有更好的辦法再修改
		if($this->getAttribute('name')=='iagree'){
			$link='<a href="'.$this->getAttribute('customlink').'" target="_blank">'.$this->getAttribute('custom').'</a>';
			$description=$description.$link;
		}

		return '<input type="checkbox" name="' . $this->name . '" id="' . $this->id . '" value="'
			. htmlspecialchars($value, ENT_COMPAT, 'UTF-8') . '"' . $class . $checked . $disabled . $onclick . $onchange
			. $required . $autofocus . ' />
			<span>'.$description.'</span>
			';

	}


}