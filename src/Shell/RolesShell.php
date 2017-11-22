<?php
namespace Permissions\Shell;

use Cake\Console\Shell;



class RolesShell extends Shell
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Permissions.Actions');
        $this->loadModel('Permissions.Roles');
        $this->loadModel('Permissions.ActionsRoles');
    }

    public function assignAllToSuperuser() {
        $actions = $this->Actions->find()->toArray();
        $superuserId = 1;


        foreach($actions as $action) {
            $actionRole['action_id'] = $action->id;
            $actionRole['role_id'] = $superuserId;

            if($aR = $this->ActionsRoles->find()->where($actionRole)->first()) {
                $entity = $this->ActionsRoles->patchEntity($aR, $actionRole);
            } else {
                $entity = $this->ActionsRoles->newEntity($actionRole);
            }

            if($this->ActionsRoles->save($entity)) {
                $this->out("Action was added to Superuser Role");
            } else {
                $this->out("Failed to add action to Superuser Role");
            }
        }
    }

    public function createRoles() {

        $roles = [
            [
                'name' => 'Superuser',
                'system_role' => true
            ],
            [
                'name' => 'User',
                'system_role' => true
            ]
        ];

        foreach($roles as $role) {
            if(!$this->Roles->exists($role)) {
                $role = $this->Roles->newEntity($role);
                if($this->Roles->save($role)) {
                    $this->out(sprintf("%s was saved", $role->name));
                } else {
                    $this->out(sprintf("%s failed to save", $role->name));
                }
            } else {
                $this->out(sprintf("%s already existed", $role['name']));
            }

        }
    }




}
