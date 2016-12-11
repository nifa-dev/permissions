<?php
namespace Permissions\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Permissions\Model\Entity\Action;

/**
 * Actions Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Roles
 */
class ActionsTable extends Table
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

        $this->table('actions');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsToMany('Roles', [
            'foreignKey' => 'action_id',
            'targetForeignKey' => 'role_id',
            'joinTable' => 'actions_roles',
            'className' => 'Permissions.Roles'
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
            ->integer('id')
            ->allowEmpty('id', 'create');


        $validator
            ->requirePresence('controller', 'create')
            ->notEmpty('controller');

        $validator
            ->requirePresence('action', 'create')
            ->notEmpty('action');

        return $validator;
    }
}
