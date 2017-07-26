<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Relationships Model
 *
 * @method \App\Model\Entity\Relationship get($primaryKey, $options = [])
 * @method \App\Model\Entity\Relationship newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Relationship[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Relationship|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Relationship patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Relationship[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Relationship findOrCreate($search, callable $callback = null, $options = [])
 */
class RelationshipsTable extends Table
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

        $this->setTable('relationships');
        $this->setDisplayField('user_id1');
        $this->setPrimaryKey(['user_id1', 'user_id2']);
        
        $this->belongsTo('Users1', [
            'foreignKey' => 'user_id1',
            'className' => 'Users',
            'joinType' => 'INNER'
        ]);
        
         
        $this->belongsTo('Users2', [
            'foreignKey' => 'user_id2',
            'className' => 'Users',
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
            ->integer('user_id1')
            ->allowEmpty('user_id1', 'create');

        $validator
            ->integer('user_id2')
            ->allowEmpty('user_id2', 'create');

        $validator
            ->integer('status')
            ->allowEmpty('status');

        return $validator;
    }
}
