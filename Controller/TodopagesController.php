<?php
App::uses('AppController', 'Controller');
/**
 * Todopages Controller
 *
 * @property Todopage $Todopage
 * @property PaginatorComponent $Paginator
 */
class TodopagesController extends AppController {

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
		$this->Todopage->recursive = 0;
		$this->set('todopages', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Todopage->exists($id)) {
			throw new NotFoundException(__('Invalid todopage'));
		}
		$options = array('conditions' => array('Todopage.' . $this->Todopage->primaryKey => $id));
		$this->set('todopage', $this->Todopage->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Todopage->create();
			if ($this->Todopage->save($this->request->data)) {
				$this->Session->setFlashInfo(__('The todopage has been saved.') . "(#{$this->Todopage->id})" );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlashError(__('The todopage could not be saved. Please, try again.') );
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
		if (!$this->Todopage->exists($id)) {
			throw new NotFoundException(__('Invalid todopage'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Todopage->save($this->request->data)) {
				$this->Session->setFlashInfo(__('The todopage has been saved.') . "(#$id)");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlashError(__('The todopage could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Todopage.' . $this->Todopage->primaryKey => $id));
			$this->request->data = $this->Todopage->find('first', $options);
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
		$this->Todopage->id = $id;
		if (!$this->Todopage->exists()) {
			throw new NotFoundException(__('Invalid todopage'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Todopage->delete($id, true)) {
			$this->Session->setFlashInfo(__('Todopage deleted.')."(#$id)");
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlashError(__('Todopage was not deleted'));
		$this->redirect(array('action' => 'index'));
	}}
