<?php
namespace App\Test\TestCase\Controller;

use App\Controller\AlbumsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AlbumsController Test Case
 */
class AlbumsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.albums',
        'app.artists',
        'app.artistgenres',
        'app.genres',
        'app.artistpreferences',
        'app.users',
        'app.albumpreferences',
        'app.genrepreferences',
        'app.songpreferences',
        'app.songs'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
