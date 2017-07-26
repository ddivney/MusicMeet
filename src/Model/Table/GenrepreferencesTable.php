<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Genrepreferences Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\GenresTable|\Cake\ORM\Association\BelongsTo $Genres
 *
 * @method \App\Model\Entity\Genrepreference get($primaryKey, $options = [])
 * @method \App\Model\Entity\Genrepreference newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Genrepreference[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Genrepreference|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Genrepreference patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Genrepreference[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Genrepreference findOrCreate($search, callable $callback = null, $options = [])
 */
class GenrepreferencesTable extends Table
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

        $this->setTable('genrepreferences');
        $this->setDisplayField('user_id');
        $this->setPrimaryKey(['user_id', 'genre_id']);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
       // $this->belongsTo('Genres', [
       //     'foreignKey' => 'genre_id',
       //     'joinType' => 'INNER'
       // ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('preference')
            ->allowEmpty('preference');

        return $validator;
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
       // $rules->add($rules->existsIn(['genre_id'], 'Genres'));

        return $rules;
    }
}
