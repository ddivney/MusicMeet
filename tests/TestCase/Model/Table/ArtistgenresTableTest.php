<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ArtistgenresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ArtistgenresTable Test Case
 */
class ArtistgenresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ArtistgenresTable
     */
    public $Artistgenres;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.artistgenres',
        'app.artists',
        'app.albums',
        'app.albumpreferences',
        'app.songs',
        'app.songpreferences',
        'app.artistpreferences',
        'app.genres'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Artistgenres') ? [] : ['className' => ArtistgenresTable::class];
        $this->Artistgenres = TableRegistry::get('Artistgenres', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Artistgenres);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
