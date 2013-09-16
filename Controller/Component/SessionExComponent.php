<?php

App::uses('SessionComponent', 'Controller/Component');

class SessionExComponent extends SessionComponent {
 
	public function setFlashError($message) {
		$params = array('plugin' => 'BoostCake','class' => 'alert-danger');
		parent::setFlash($message, 'alert', $params, 'flash');
	}
	public function setFlashInfo($message) {
		$params = array('plugin' => 'BoostCake','class' => 'alert-success');
		parent::setFlash($message, 'alert', $params, 'flash');
	}
}
