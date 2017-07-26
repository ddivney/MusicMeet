<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Localized\Validation;
/**
 * Users Model
 *
 * @property \App\Model\Table\AlbumpreferencesTable|\Cake\ORM\Association\HasMany $Albumpreferences
 * @property \App\Model\Table\ArtistpreferencesTable|\Cake\ORM\Association\HasMany $Artistpreferences
 * @property \App\Model\Table\GenrepreferencesTable|\Cake\ORM\Association\HasMany $Genrepreferences
 * @property \App\Model\Table\SongpreferencesTable|\Cake\ORM\Association\HasMany $Songpreferences
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Albumpreferences', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Artistpreferences', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Genrepreferences', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Songpreferences', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Relationships1', [
            'foreignKey' => 'user_id1',
            'className'  => 'Relationships'
        ]);
         $this->hasMany('Relationships2', [
            'foreignKey' => 'user_id2',
            'className'  => 'Relationships'
        ]);
            
    }
    
    
    private function phone($string){
        return true;
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->notEmpty('name', 'Por favor ingrese su nombre');

        $validator
            ->requirePresence('username', 'create')
            ->notEmpty('username', 'Por favor ingrese su correo')
            ->add('username', 'validFormat', [
                'rule' => 'email',
                'message' => 'Debe ingresar un correo válido' 
             ]);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', 'Por favor ingrese una contraseña');

        $validator
            ->allowEmpty('refcode');

        $validator
            ->allowEmpty('location');

        $validator
            ->allowEmpty('cellphone')
            ->add('cellphone', 'celLength', [
            'rule' => ['minLength', 8],
            'message' => 'El número de teléfono debe tener por lo menos 8 dígitos',
             ]);

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
        $rules->add($rules->isUnique(['username']));

        return $rules;
    }
}
