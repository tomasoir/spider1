<?php
// module/Spider/src/Spider/Model/Spider.php:
namespace Spider\Model;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
class Spider implements InputFilterAwareInterface
{
	public $id;
	public $url;
	public $server_response;
	public $page_load_time;
	public $page_size;
	public $date_scan;
	protected $inputFilter;
	
	public function exchangeArray($data)
	{
		$this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->url = (isset($data['url'])) ? $data['url'] : null;
		$this->server_response = (isset($data['server_response'])) ? $data['server_response'] : null;
		$this->page_load_time = (isset($data['page_load_time'])) ? $data['page_load_time'] : null;
		$this->page_size = (isset($data['page_size'])) ? $data['page_size'] : null;
		$this->date_scan = (isset($data['date_scan'])) ? $data['date_scan'] : null;
	}
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory();
			$inputFilter->add($factory->createInput(array(
				'name' => 'id',
				'required' => true,
				'filters' => array(
					array('name' => 'Int'),
				),
			)));
			$inputFilter->add($factory->createInput(array(
				'name' => 'url',
				'required' => true,
				'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 1,
							'max' => 150,
						),
					),
				),
			)));
			
	
		
		
		$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
	// Add the following method:
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}