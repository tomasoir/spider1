<?php
// module/Spider/src/Spider/Model/SpiderTable.php:
namespace Spider\Model;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
class SpiderTable extends AbstractTableGateway
{
	protected $table ='spider';
	public function __construct(Adapter $adapter){
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet();
		$this->resultSetPrototype->setArrayObjectPrototype(new Spider());
		$this->initialize();
	}
	public function fetchAll(){
		$resultSet = $this->select();
		return $resultSet;
	}
	public function getSpider($id){
		$id = (int) $id;
		$rowset = $this->select(array('id' => $id,));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}


	public function saveSpider($data)
	{

		$id = (int) $spider->id;
		if ($id == 0) {
			$this->insert($data);
		} elseif ($this->getSpider($id)) {
				$this->update(
							$data,
							array(
								'id' => $id,
								)
							);
		} else {
		throw new \Exception('Form id does not exist');
		}
	}
	public function editSpider(Spider $spider)
	{
		$data = array(
					'url' => $spider->url,
					'server_response' => $spider->server_response,
					'page_load_time'=> $spider->page_load_time,
					'page_size'=>$spider->page_size,
					'date_scan'=>date('Y-m-d H:i:s'),
				);

		$id = (int) $spider->id;
		if ($id != 0) {
			$this->getSpider($id);
			
			$this->update(
				$data,
				array(
					'id' => $id,
				)
			);
		} else {
		throw new \Exception('Form id does not exist');
		}
	}
	
	public function deleteSpider($id)
	{
		$this->delete(array(
							'id' => $id,
							));
	}
	
	
}