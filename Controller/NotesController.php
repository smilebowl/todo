<?php
App::uses('AppController', 'Controller');
/**
 * Notes Controller
 *
 * @property Note $Note
 * @property PaginatorComponent $Paginator
 */
class NotesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


	// ajax interface
	
	public function noteui() {
		$categories = $this->Note->Category->find('list',array('order'=>'position'));
		$this->set(compact('categories'));
		if (empty($this->request->data['category_id'])) {
			$id=key($categories);
		} else {
			$id = $this->request->data['category_id'];
		}
		
		$this->Note->recursive = 0;
		$notes = $this->Note->find('all', array(
			'conditions'=>array('category_id'=>$id)
//			'order' => 'position asc',
//			'fileds' => array('id','name')
		));
		$this->set(compact('notes'));
	}

	// text update
	
	public function ajaxupdate() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$this->Note->save($this->request->data);
	}

	// new note
	
	public function ajaxnewnote() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
//		$this->Note->save($this->request->data);
		
		$this->Note->create();
		if (empty($this->request->data['name'])) $this->request->data['name']='New note.';
		if (empty($this->request->data['text'])) $this->request->data['text']='note.';
		$this->request->data['xyz'] = '0.0.5';
		$this->request->data['wh'] = '200.200';
		$this->Note->save($this->request->data);
		
		$note = $this->Note->read();
		$this->set(compact('note'));
		$this->render('note_element', 'ajax');		
		
		
	}
	
	// remove note
	
	public function ajaxdelete($id = null) {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$this->Note->delete($id);
	}
	
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Note->recursive = 0;
		$this->set('notes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Note->exists($id)) {
			throw new NotFoundException(__('Invalid note'));
		}
		$options = array('conditions' => array('Note.' . $this->Note->primaryKey => $id));
		$this->set('note', $this->Note->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Note->create();
			if ($this->Note->save($this->request->data)) {
				$this->Session->setFlashInfo(__('The note has been saved.') . "(#{$this->Note->id})" );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlashError(__('The note could not be saved. Please, try again.') );
			}
		}
		$categories = $this->Note->Category->find('list');
		$this->set(compact('categories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Note->exists($id)) {
			throw new NotFoundException(__('Invalid note'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Note->save($this->request->data)) {
				$this->Session->setFlashInfo(__('The note has been saved.') . "(#$id)");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlashError(__('The note could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Note.' . $this->Note->primaryKey => $id));
			$this->request->data = $this->Note->find('first', $options);
		}
		$categories = $this->Note->Category->find('list');
		$this->set(compact('categories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Note->id = $id;
		if (!$this->Note->exists()) {
			throw new NotFoundException(__('Invalid note'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Note->delete()) {
			$this->Session->setFlashInfo(__('Note deleted.')."(#$id)");
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlashError(__('Note was not deleted'));
		$this->redirect(array('action' => 'index'));
	}}
