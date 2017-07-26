<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SongpreferencesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SongpreferencesTable Test Case
 */
class SongpreferencesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SongpreferencesTable
     */
    public $Songpreferences;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.songpreferences',
        'app.users',
        'app.albumpreferences',
        'app.albums',
        'app.artists',
        'app.artistgenres',
        'app.genres',
        'app.artistpreferences',
        'app.songs',
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
        $config = TableRegistry::exists('Songpreferences') ? [] : ['className' => SongpreferencesTable::class];
        $this->Songpreferences = TableRegistry::get('Songpreferences', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Songpreferences);

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
