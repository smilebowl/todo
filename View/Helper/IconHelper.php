<?php
// kyo
App::uses('HtmlHelper', 'View/Helper');
class IconHelper extends AppHelper {
	
	public $helpers = array('Html', 'Form');
	
	private $icon_white = false;

	public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);
        if (isset($settings['icon-white']) && $settings['icon-white'] === true)
        	$this->icon_white = true;
    }
    
	public function link( $title , $url = null , $options = array() , $confirmMessage = false ) {
		
		$icon_color = ($this->icon_white) ? " icon-white" : "";
		switch ($title) {
			case __('View'):
				//$title = "<i class=\"icon-search{$icon_color}\"></i>";
				$title = "<button class=\"btn btn-info btn-xs\"><i class=\"glyphicon glyphicon-th{$icon_color}\"></i></button>";
				$options['escape'] = false;
				$options['title'] = __('View');
				break;
			case __('Edit'):
				$title = "<button class=\"btn btn-info btn-xs\"><i class=\"glyphicon glyphicon-pencil{$icon_color}\"></i></button>";
				$options['escape'] = false;
				$options['title'] = __('Edit');
				break;
		}
		return $this->Html->link($title, $url, $options, $confirmMessage);
	}

	public function postLink($title , $url = null , $options = array() , $confirmMessage = false) {
		$icon_color = ($this->icon_white) ? " icon-white" : "";
		if ($title == __('Delete')) {
			$title = "<button class=\"btn btn-danger btn-xs\"><i class=\"glyphicon glyphicon-remove{$icon_color}\"></i></button>";
			$options['escape'] = false;
			$options['title'] = __('Delete');
		}
		return $this->Form->postLink($title, $url, $options, $confirmMessage);
	}
}
