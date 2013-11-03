<?php
App::uses('AppController', 'Controller');
/**
 * Calendars Controller
 *
 * @property Calendar $Calendar
 * @property PaginatorComponent $Paginator
 */
class CalendarsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Calendar->recursive = 0;
		$this->set('calendars', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Calendar->exists($id)) {
			throw new NotFoundException(__('Invalid calendar'));
		}
		$options = array('conditions' => array('Calendar.' . $this->Calendar->primaryKey => $id));
		$this->set('calendar', $this->Calendar->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Calendar->create();
			if ($this->Calendar->save($this->request->data)) {
				$this->Session->setFlashInfo(__('The calendar has been saved.') . "(#{$this->Calendar->id})" );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlashError(__('The calendar could not be saved. Please, try again.') );
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
		if (!$this->Calendar->exists($id)) {
			throw new NotFoundException(__('Invalid calendar'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Calendar->save($this->request->data)) {
				$this->Session->setFlashInfo(__('The calendar has been saved.') . "(#$id)");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlashError(__('The calendar could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Calendar.' . $this->Calendar->primaryKey => $id));
			$this->request->data = $this->Calendar->find('first', $options);
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
		$this->Calendar->id = $id;
		if (!$this->Calendar->exists()) {
			throw new NotFoundException(__('Invalid calendar'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Calendar->delete($id, true)) {
			$this->Session->setFlashInfo(__('Calendar deleted.')."(#$id)");
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlashError(__('Calendar was not deleted'));
		$this->redirect(array('action' => 'index'));
	}}
