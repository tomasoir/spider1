<?php
// module/Spider/src/Spider/Controller/SpiderController.php:
namespace Spider\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Spider\Model\Spider; 
use Spider\Form\SpiderForm; 

class SpiderController extends AbstractActionController
{
	protected $spiderTable;
	private  $_urlspider;
 	public function getSpiderTable(){
		if (!$this->spiderTable) {
			$sm = $this->getServiceLocator();
			$this->spiderTable = $sm->get('Spider\Model\SpiderTable');
		}
		return $this->spiderTable;
	}

	public function indexAction()
	{
		return new ViewModel(array(
			'spiders' => $this->getSpiderTable()->fetchAll(),
			)
		);
	}

	// Add content to this method:
	public function addAction()
	{
		
		
		$form = new SpiderForm();
		$form->get('submit')->setValue('Add');
		$request = $this->getRequest();
		if ($request->isPost()) {
			$spider = new Spider();
			$urlspider=$request->getPost("url");	
			$html=$this->setSpider($urlspider,true);
			preg_match_all("!<a[^>]+href=\"?'?(http://[^ \"'>]+)|([^{$urlspider}]+)\"?'?[^>]*>!is",$html,$linkUrl);
		
			for ($i=0; $i<count($linkUrl[1]); $i++) 
			  $linkUrl[1][$i];
		
			$result = array_unique($linkUrl[1]);
			
			foreach ($result as $i=>$value) {
			  
			   $spiderurl=$this->setSpider($value);
			   if ($spiderurl!=false) 
				   $this->getSpiderTable()->saveSpider($spiderurl);
				
			   
			}
	
		}

		return array('form' => $form,'urlspider'=>$request->getPost("url"));
	}
	
	private function setSpider($url,$html2=false){
   	   $ch = curl_init($url);
	   curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

	   if ($html2==true) {
			$html=curl_exec($ch); 
			 return $html;
		} else {
			curl_exec($ch); 
		}

		$siteinfo=array();
		if(!curl_errno($ch)){
			$info = curl_getinfo($ch);
			$siteinfo['url']=$url;
			$siteinfo['server_response']=$info['pretransfer_time'];
			$siteinfo['page_load_time']=$info['total_time'];
			$siteinfo['page_size']=$info['size_download'];
			$siteinfo['date_scan']=date('Y-m-d H:i:s');
		    return $siteinfo;
		} else {
		 return false;
		 //echo 'Can not conect to site';
		}
	}

	public function editAction(){
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('spider', array(
				'action' => 'add'
				)
			);
		}
		$spider = $this->getSpiderTable()->getSpider($id);
		$form = new SpiderForm();
		$form->bind($spider);
		$form->get('submit')->setAttribute('value', 'Edit');
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$form->setInputFilter($spider->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
					
					$this->getSpiderTable()->editSpider($form->getData());
					// Redirect to list of Spiders
					return $this->redirect()->toRoute('spider');
			}
		}
		return array(
		'id' => $id,
		'form' => $form,
		);
	}

	public function deleteAction(){
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('spider');
		}
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'No');
			if ($del == 'Yes') {
				$id = (int) $request->getPost('id');
				$this->getSpiderTable()->deleteSpider($id);
			}
			// Redirect to list of Spiders
			return $this->redirect()->toRoute('spider');
		}
		return array(
		'id' => $id,
		'spider' => $this->getSpiderTable()->getSpider($id)
		);
	}

}