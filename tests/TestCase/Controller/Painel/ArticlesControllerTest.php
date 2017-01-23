<?php
namespace App\Test\TestCase\Controller\Painel;

use App\Controller\Painel\ArticlesControllerTest;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\Painel\ArticlesControllerTest Test Case
 */
class ArticlesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.articles',
        'app.categories'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/painel/articles');
        $this->assertResponseOk();
        // debug($this->_response->body());
        // $this->assertRedirect(['controller' => 'Users', 'action' => 'login','prefix' =>'painel']);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/painel/articles/view/1');
        $this->assertResponseOk();
        // $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
    }

    /**
     * Test add method not loged in
     *
     * @return void
     */
    public function testAddNotLoged()
    {
        $this->get('/painel/articles/add');
        $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function testAddLogged()
    {

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'Admin',
                    'created' => date('Y-m-d'),
                    'modified' => date('Y-m-d')
                ]
            ]
        ]);

        $this->get('/painel/articles/add');
        $this->assertResponseOk();

        $data = [
            'title' => 'Lorem ipsum dolor sit amet',
            'body' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'created' => '2017-01-18 17:45:35',
            'modified' => '2017-01-18 17:45:35'
        ];

        $this->post('/painel/articles/add',$data);
        $this->assertRedirect(['controller' => 'Articles', 'action' => 'index']);
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->get('/painel/articles/edit/1');
        // $this->assertResponseOk();
        $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function testEditLogged()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'Admin',
                    'created' => date('Y-m-d'),
                    'modified' => date('Y-m-d')
                ]
            ]
        ]);

        $this->get('/painel/articles/edit/1');
        $this->assertResponseOk();

        $data = [
            'id' => '1',
            'title' => 'Lorem ipsum dolor sit amet',
            'body' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'created' => '2017-01-18 17:45:35',
            'modified' => '2017-01-18 17:45:35',
            'category_id' => 1,
            'user_id' => 1
        ];

        $this->post('/painel/articles/edit/1',$data);
        $this->assertRedirect(['controller' => 'Articles', 'action' => 'index']);
    }


    public function testEditArticleFromOtherUser()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'username' => 'Admin',
                    'created' => date('Y-m-d'),
                    'modified' => date('Y-m-d')
                ]
            ]
        ]);

        $this->get('/painel/articles/edit/1');
        $this->assertResponseCode(403);

        $data = [
            'id' => '1',
            'title' => 'Lorem ipsum dolor sit amet',
            'body' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'created' => '2017-01-18 17:45:35',
            'modified' => '2017-01-18 17:45:35',
            'category_id' => 1,
            'user_id' => 1
        ];

        $this->post('/painel/articles/edit/1',$data);
        $this->assertResponseCode(403);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDeleteNotLoged()
    {
        $this->post('/painel/articles/delete/1');
        // $this->assertResponseOk();
        $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function testDeleteLoged()
    {

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'Admin',
                    'created' => date('Y-m-d'),
                    'modified' => date('Y-m-d')
                ]
            ]
        ]);

        $this->post('/painel/articles/delete/1');
        $this->assertRedirect(['controller' => 'Articles', 'action' => 'index']);


    }

    public function testDeleteArticleFromOtherUser()
    {

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'username' => 'Admin',
                    'created' => date('Y-m-d'),
                    'modified' => date('Y-m-d')
                ]
            ]
        ]);

        $this->post('/painel/articles/delete/1');
        $this->assertResponseCode(403);


    }


}
