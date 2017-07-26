<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ArtistgenresFixture
 *
 */
class ArtistgenresFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'artist_id' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => '', 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'genre_id' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => '', 'collate' => 'latin1_swedish_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['artist_id', 'genre_id'], 'length' => []],
            'fk_artistgenre_artist' => ['type' => 'foreign', 'columns' => ['artist_id'], 'references' => ['artists', 'id'], 'update' => 'restrict', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'artist_id' => 'd1aac46f-5bd8-4f37-ae3d-23d2aa43ab24',
            'genre_id' => '25acf20d-8d9c-4cc6-b281-6c3a224cbbff'
        ],
    ];
}
