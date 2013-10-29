<?php
App::uses('AppController', 'Controller');
/**
 * Events Controller
 *
 * @property Event $Event
 * @property PaginatorComponent $Paginator
 */
class EventsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


	public function ajaxloadevent() {
//		$this->log($this->request);
		
		Configure::write('debug', 0);
		$this->autoRender = false;
		$this->layout = 'ajax';
		
		$start = date("Y-m-d",$this->request->query['start']);
		$end = date("Y-m-d",$this->request->query['end']);
		
		
		$this->Event->recursive = 0;
		$events = $this->Event->find('all', array(
			'conditions'=>array('and'=>array('start >='=>$start, 'start <='=>$end)),
//			'order' => 'position asc',
			'fields' => array('id','title','start','end', 'color')
		));
		
		$json = array();
		foreach ($events as $evt) {
			settype($evt['Event']['id'], 'integer');
			$json[] = $evt['Event'];
		}
		
//		$this->log(json_encode($json));
		echo json_encode($json);
	}
	
	public function ajaxnewevent() {
		
//		$this->log($this->request->data);
		
		Configure::write('debug', 0);
		$this->autoRender = false;
		$this->layout = 'ajax';
		
		$this->Event->save($this->request->data);
		echo $this->Event->id;
	}
	
	public function ajaxupdate() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$this->Event->save($this->request->data);
	}

	// remove event
	
	public function ajaxdelete($id = null) {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$this->Event->delete($id);
	}
	
		
			
	public function eventui() {
//		$this->Event->recursive = 0;
//		$events = $this->Event->find('all', array(
//		));
//		$this->set(compact('events'));
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Event->recursive = 0;
		$this->set('events', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid event'));
		}
		$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
		$this->set('event', $this->Event->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Event->create();
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlashInfo(__('The event has been saved.') . "(#{$this->Event->id})" );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlashError(__('The event could not be saved. Please, try again.') );
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('Invalid event'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlashInfo(__('The event has been saved.') . "(#$id)");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlashError(__('The event could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
			$this->request->data = $this->Event->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Event->delete()) {
			$this->Session->setFlashInfo(__('Event deleted.')."(#$id)");
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlashError(__('Event was not deleted'));
		$this->redirect(array('action' => 'index'));
	}}
