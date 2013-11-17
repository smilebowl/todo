<?php
App::uses('AppController', 'Controller');
/**
 * Todos Controller
 *
 * @property Todo $Todo
 * @property PaginatorComponent $Paginator
 */
class TodosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	// list 

	public function todoui() {
		$todopages = $this->Todo->Todopage->find('list', array('order'=>'ord'));
		if (empty($this->request->data['todopage_id'])) {
			$id=key($todopages);
		} else {
			$id = $this->request->data['todopage_id'];
		}
		
		$this->Todo->recursive = -1;
		$todos = $this->Todo->find('all', array(
			'conditions'=>array('todopage_id'=>$id),
			'order' => 'Todo.position asc',
//			'fileds' => array('id','name')
		));
		$this->set(compact('todos', 'todopages'));
	}
	
	// history
	
	public function ajax2allhistory() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		debug($this->request->data);
		
		$pageid = $this->request->data['todopage_id'];
		
		$this->Todo->query("insert into histories select * from todos where (todos.todopage_id={$pageid}) and (todos.completed is not null);");
		$this->Todo->query("delete from todos where (todos.todopage_id={$pageid}) and (todos.completed is not null);");
		echo 1;
	}

	// history
	
	public function ajax2history($id = null) {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$this->Todo->query("insert into histories select * from todos where todos.id = $id;");
		$this->Todo->query("delete from todos where todos.id = $id;");
		echo 1;
	}

	// edit 
	
	public function ajaxedit() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$this->Todo->save($this->request->data);
	}
	
	// add
	
	public function ajaxadd() {
		Configure::write('debug', 0);
		// $this->layout = 'ajax';
		// $this->autoRender = false;
		
		$min = $this->Todo->find('first',array(
			'order' => 'position asc'
		));
		
		$this->Todo->create();
		$this->request->data['position'] = $min['Todo']['position']-1;
		$this->Todo->save($this->request->data);
		$todo = $this->Todo->read();
		$this->set(compact('todo'));
		$this->render('todo_element', 'ajax');
	}
	
	// complete task
	 
	public function ajaxcomplete($id = null) {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$this->Todo->save($this->request->data);
	}
	
	// delete
	 
	public function ajaxdelete($id = null) {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$this->Todo->delete($id);
	}
	
	
	public function ajaxremovechecks() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		$removes = $this->request->data['removes'];
		foreach ($removes as $key) {
			$this->Todo->delete($key);
		}
	}
	
	// re-arrange
	
	public function ajaxrearrange() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		$pos = $this->request->data['pos'];
		$curpos = 0;
		foreach ($pos as $key) {
			// $this->Todo->save(array('id'=>$key,'position'=>$curpos++));
			// ������UI�œ�����s���Ă����ꍇ�̑Ή�
			if ($this->Todo->exists($key)) {
				$this->Todo->save(array('id'=>$key,'position'=>$curpos++),false,array('position'));
			}
		}
	}


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Todo->recursive = 0;
		$this->set('todos', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Todo->exists($id)) {
			throw new NotFoundException(__('Invalid todo'));
		}
		$options = array('conditions' => array('Todo.' . $this->Todo->primaryKey => $id));
		$this->set('todo', $this->Todo->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Todo->create();
			if ($this->Todo->save($this->request->data)) {
				$this->Session->setFlashInfo(__('The todo has been saved.') . "(#{$this->Todo->id})" );
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlashError(__('The todo could not be saved. Please, try again.') );
			}
		}
		$todopages = $this->Todo->Todopage->find('list');
		$this->set(compact('todopages'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Todo->exists($id)) {
			throw new NotFoundException(__('Invalid todo'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Todo->save($this->request->data)) {
				$this->Session->setFlashInfo(__('The todo has been saved.') . "(#$id)");
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlashError(__('The todo could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Todo.' . $this->Todo->primaryKey => $id));
			$this->request->data = $this->Todo->find('first', $options);
		}
		$todopages = $this->Todo->Todopage->find('list');
		$this->set(compact('todopages'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Todo->id = $id;
		if (!$this->Todo->exists()) {
			throw new NotFoundException(__('Invalid todo'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Todo->delete()) {
			$this->Session->setFlashInfo(__('Todo deleted.')."(#$id)");
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlashError(__('Todo was not deleted'));
		$this->redirect(array('action' => 'index'));
	}}
