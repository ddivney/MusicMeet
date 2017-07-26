<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GenrepreferencesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GenrepreferencesTable Test Case
 */
class GenrepreferencesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\GenrepreferencesTable
     */
    public $Genrepreferences;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.genrepreferences',
        'app.users',
        'app.albumpreferences',
        'app.albums',
        'app.artists',
        'app.artistgenres',
        'app.genres',
        'app.artistpreferences',
        'app.songs',
        'app.songpreferences'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Genrepreferences') ? [] : ['className' => GenrepreferencesTable::class];
        $this->Genrepreferences = TableRegistry::get('Genrepreferences', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Genrepreferences);

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
