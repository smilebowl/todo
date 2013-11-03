<?php
App::uses('AppController', 'Controller');
/**
 * Histories Controller
 *
 * @property History $History
 * @property PaginatorComponent $Paginator
 */
class HistoriesController extends AppController {

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
		$this->History->recursive = 0;
		$this->paginate = array('order'=>'completed desc');
		$this->set('histories', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->History->exists($id)) {
			throw new NotFoundException(__('Invalid history'));
		}
		$options = array('conditions' => array('History.' . $this->History->primaryKey => $id));
		$this->set('history', $this->History->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->History->create();
			if ($this->History->save($this->request->data)) {
				$this->Session->setFlashInfo(__('The history has been saved.') . "(#{$this->History->id})" );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlashError(__('The history could not be saved. Please, try again.') );
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
		if (!$this->History->exists($id)) {
			throw new NotFoundException(__('Invalid history'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->History->save($this->request->data)) {
				$this->Session->setFlashInfo(__('The history has been saved.') . "(#$id)");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlashError(__('The history could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('History.' . $this->History->primaryKey => $id));
			$this->request->data = $this->History->find('first', $options);
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
		$this->History->id = $id;
		if (!$this->History->exists()) {
			throw new NotFoundException(__('Invalid history'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->History->delete()) {
			$this->Session->setFlashInfo(__('History deleted.')."(#$id)");
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlashError(__('History was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	// delete all records
	
	public function deleteall() {
		$this->request->onlyAllow('post', 'deleteall');
		if ($this->History->deleteAll(array('1=1'))) {
			$this->Session->setFlashInfo(__('History deleted.'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlashError(__('History was not deleted'));
	}

}