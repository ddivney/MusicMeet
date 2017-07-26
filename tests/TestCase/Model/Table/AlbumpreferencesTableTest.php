<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AlbumpreferencesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AlbumpreferencesTable Test Case
 */
class AlbumpreferencesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AlbumpreferencesTable
     */
    public $Albumpreferences;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.albumpreferences',
        'app.users',
        'app.artistpreferences',
        'app.artists',
        'app.albums',
        'app.songs',
        'app.songpreferences',
        'app.artistgenres',
        'app.genres',
        'app.genrepreferences'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Albumpreferences') ? [] : ['className' => AlbumpreferencesTable::class];
        $this->Albumpreferences = TableRegistry::get('Albumpreferences', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Albumpreferences);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
