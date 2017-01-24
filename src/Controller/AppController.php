<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

class AppController extends Controller
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'loginAction' => [
                'prefix' => 'admin',
                'controller' => 'Users',
                'action' => 'login',
            ],
            'loginRedirect' => [
                'prefix' => 'admin',
                'controller' => 'Dashboard',
                'action' => 'index',
            ],
            'logoutRedirect' => [
                'prefix' => 'admin',
                'controller' => 'Users',
                'action' => 'login',
            ],
            'unauthorizedRedirect' => false,
            'authError' => __('Você precisa estar logado para acessar esta página'),
            'storage' => 'Session',
        ]);

        $this->loadComponent('Security');
        $this->loadComponent('Csrf');
    }

    public function isAuthorized($user)
    {
        // Admin pode acessar todas as actions
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        // Bloqueia acesso por padrão
        return false;
    }

    public function beforeFilter(Event $event)
    {
        //define qual layout sera exibido para o usuario
        if ($this->request->prefix=='admin') {
            $layout = 'admin';
        } else {
            $layout = 'default';
        }
        $this->viewBuilder()->layout($layout);
    }


    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
}
