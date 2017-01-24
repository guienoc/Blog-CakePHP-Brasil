<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
class ArticlesController extends AppController
{


    public function isAuthorized($user)
    {
        // Todos os usuários registrados podem adicionar artigos
        if ($this->request->action === 'add') {
            return true;
        }

        // Apenas o proprietário do artigo pode editar e excluí
        if (in_array($this->request->action, ['edit', 'delete'])) {
            $articleId = (int)$this->request->params['pass'][0];
            if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
                return true;
            }
        }
        return parent::isAuthorized($user);
    }

    public function index()
    {
        $articles = $this->paginate($this->Articles);

        $this->set(compact('articles'));
    }

    public function view($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => []
        ]);

        $this->set('article', $article);
        $this->set('_serialize', ['article']);
    }

    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->data);
            $article->user_id = $this->Auth->user('id');
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The article has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Articles->Categories->find('treeList');
        $this->set(compact('article','categories'));
        $this->set('_serialize', ['article']);
    }

    public function edit($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => []
        ]);
        if ($this->isAuthorized($this->Auth->user())) {
            if ($this->request->is(['patch', 'post', 'put'])) {
                $article = $this->Articles->patchEntity($article, $this->request->data);
                if ($this->Articles->save($article)) {
                    $this->Flash->success(__('The article has been saved.'));

                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The article could not be saved. Please, try again.'));
                }
            }
        } else {
            $this->Flash->error(__('Usuário não autorizado!'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('article'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->isAuthorized($this->Auth->user())) {
            if ($this->Articles->delete($article)) {
                $this->Flash->success(__('The article has been deleted.'));
            } else {
                $this->Flash->error(__('The article could not be deleted. Please, try again.'));
            }
        } else {
            $this->Flash->error(__('Usuário não autorizado!'));
            return $this->redirect(['action' => 'index']);
        }

        return $this->redirect(['action' => 'index']);
    }
}
