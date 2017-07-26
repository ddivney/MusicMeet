<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ArtistpreferencesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ArtistpreferencesTable Test Case
 */
class ArtistpreferencesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ArtistpreferencesTable
     */
    public $Artistpreferences;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.artistpreferences',
        'app.users',
        'app.albumpreferences',
        'app.albums',
        'app.artists',
        'app.artistgenres',
        'app.genres',
        'app.songs',
        'app.songpreferences',
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
        $config = TableRegistry::exists('Artistpreferences') ? [] : ['className' => ArtistpreferencesTable::class];
        $this->Artistpreferences = TableRegistry::get('Artistpreferences', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Artistpreferences);

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
