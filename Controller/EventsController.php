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
	public $components = array('Paginator', 'Search.Prg');
	public $presetVars = true;


	// fullcalendar loading query(json)
	public function ajaxloadevent() {
		
		Configure::write('debug', 0);
		$this->autoRender = false;
		$this->layout = 'ajax';
		
		$start = date("Y-m-d",$this->request->query['start']);
		$end = date("Y-m-d",$this->request->query['end']);
		$cond = array('and'=>array('start >='=>$start, 'start <='=>$end));
	
		if (!empty($this->request->query['calendar_id'])) {
			$cond['and']['calendar_id'] =$this->request->query['calendar_id'];
		}
		
		$this->Event->recursive = 0;
		$events = $this->Event->find('all', array(
			'conditions'=>$cond,
		));

		// return json
				
		$json = array();
		foreach ($events as $evt) {
			settype($evt['Event']['id'], 'integer');
			$json[] = $evt['Event'];
		}
		echo json_encode($json);
	}

	// new event
		
	public function ajaxnewevent() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		$this->layout = 'ajax';
		
		$this->Event->save($this->request->data);
		echo $this->Event->id;
	}

	// update event
		
	public function ajaxupdate() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$this->Event->save($this->request->data);
	}

	// get detail field
	
	public function ajaxgetdetail() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$this->Event->id = $this->request->data['id'];
		echo $this->Event->field('detail');
	}

	// get calendar_id field
	
	public function ajaxgetcid() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$this->Event->id = $this->request->data['id'];
		echo $this->Event->field('calendar_id');
	}

	// remove event
	
	public function ajaxdelete($id = null) {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$this->Event->delete($id);
	}
	
	// event ui
			
	public function eventui($calendarid=null) {
		$calendars = $this->Event->Calendar->find('list',array('order'=>'position'));
		$this->set(compact('calendars'));
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Prg->commonProcess();
        $this->Paginator->settings['conditions'] = $this->Event->parseCriteria($this->Prg->parsedParams());
		
		$this->Event->recursive = 0;
		$this->set('events', $this->paginate());

		$this->set('calendars', $this->Event->Calendar->find('list'));
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
		$calendars = $this->Event->Calendar->find('list');
		$this->set(compact('calendars'));
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
		$calendars = $this->Event->Calendar->find('list');
		$this->set(compact('calendars'));
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
