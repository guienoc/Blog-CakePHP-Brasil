<?php
namespace App\Test\TestCase\Controller;

use App\Controller\ArticlesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\ArticlesController Test Case
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
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/articles');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->get('/articles/view/1');
        $this->assertResponseOk();
    }


    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->get('/articles/add');
        $this->assertResponseError();
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->get('/articles/edit/1');
        $this->assertResponseError();
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {

        $this->post('/articles/delete/1');
        $this->assertResponseError();
    }

}
