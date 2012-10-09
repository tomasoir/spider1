<?php
// module/Spider/src/Spider/Form/SpiderForm.php:
namespace Spider\Form;
use Zend\Form\Form;
class SpiderForm extends Form
{
	public function __construct($name = null){
		// we want to ignore the name passed
		parent::__construct('Spider');
		$this->setAttribute('method', 'post');
		$this->add(array(
			'name' => 'id',
			'attributes' => array(	
				'type' => 'hidden',
			),
		));
		$this->add(array(
			'name' => 'url',
			'attributes' => array(
				'type' => 'text',
			),
			'options' => array(
				'label' => 'url',
			),
		));
		$this->add(array(
			'name' => 'server_response',
			'attributes' => array(
				'type' => 'Integer',
			),
			'options' => array(
				'label' => 'server response',
			),
		));
		$this->add(array(
			'name' => 'page_load_time',
			'attributes' => array(
				'type' => 'Time',
			),
			'options' => array(
				'label' => 'page load time',
			),
		));
		$this->add(array(
			'name' => 'page_size',
			'attributes' => array(
				'type' => 'Integer',
			),
			'options' => array(
				'label' => 'page_size',
			),
		));
		$this->add(array(
			'name' => 'url',
			'attributes' => array(
				'type' => 'text',
			),
			'options' => array(
				'label' => 'url',
			),
		));
		
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
			'type' => 'submit',
			'value' => 'Go',
			'id' => 'submitbutton',
			),
			));
		}
}