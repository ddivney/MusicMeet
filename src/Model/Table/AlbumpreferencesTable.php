<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Albumpreferences Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\AlbumsTable|\Cake\ORM\Association\BelongsTo $Albums
 *
 * @method \App\Model\Entity\Albumpreference get($primaryKey, $options = [])
 * @method \App\Model\Entity\Albumpreference newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Albumpreference[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Albumpreference|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Albumpreference patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Albumpreference[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Albumpreference findOrCreate($search, callable $callback = null, $options = [])
 */
class AlbumpreferencesTable extends Table
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

        $this->setTable('albumpreferences');
        $this->setDisplayField('user_id');
        $this->setPrimaryKey(['user_id', 'album_id']);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Albums', [
            'foreignKey' => 'album_id',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['album_id'], 'Albums'));

        return $rules;
    }
}
