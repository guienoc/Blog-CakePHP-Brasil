<?php
namespace App\Controller\Painel;

use App\Controller\AppController;

class CategoriesController extends AppController
{

    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentCategories']
        ];
        $categories = $this->paginate($this->Categories);

        $this->set(compact('categories'));
    }

    public function view($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['ParentCategories', 'ChildCategories']
        ]);

        $this->set('category', $category);
    }

    public function add()
    {
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }
        $parentCategories = $this->Categories->ParentCategories->find('list', ['limit' => 200]);
        $this->set(compact('category', 'parentCategories'));
    }

    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }
        $parentCategories = $this->Categories->ParentCategories->find('list', ['limit' => 200]);
        $this->set(compact('category', 'parentCategories'));
    }

    public function moveUp($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $category = $this->Categories->get($id);
        if ($this->Categories->moveUp($category)) {
            $this->Flash->success('The category has been moved Up.');
        } else {
            $this->Flash->error('The category could not be moved up. Please, try again.');
        }
        return $this->redirect($this->referer(['action' => 'index']));
    }

    public function moveDown($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $category = $this->Categories->get($id);
        if ($this->Categories->moveDown($category)) {
            $this->Flash->success('The category has been moved down.');
        } else {
            $this->Flash->error('The category could not be moved down. Please, try again.');
        }
        return $this->redirect($this->referer(['action' => 'index']));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
