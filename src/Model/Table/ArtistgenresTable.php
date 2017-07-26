<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Artistgenres Model
 *
 * @property \App\Model\Table\ArtistsTable|\Cake\ORM\Association\BelongsTo $Artists
 * @property \App\Model\Table\GenresTable|\Cake\ORM\Association\BelongsTo $Genres
 *
 * @method \App\Model\Entity\Artistgenre get($primaryKey, $options = [])
 * @method \App\Model\Entity\Artistgenre newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Artistgenre[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Artistgenre|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Artistgenre patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Artistgenre[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Artistgenre findOrCreate($search, callable $callback = null, $options = [])
 */
class ArtistgenresTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('artistgenres');
        $this->setDisplayField('artist_id');
        $this->setPrimaryKey(['artist_id', 'genre_id']);

        $this->belongsTo('Artists', [
            'foreignKey' => 'artist_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['artist_id'], 'Artists'));
        return $rules;
    }
}
