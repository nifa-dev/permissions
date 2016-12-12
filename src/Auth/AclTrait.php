<?php
namespace Permissions\Auth;

use Cake\Network\Request;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;


/**
 * AclTrait
 * AclTrait - functions supporting Role Based Authorization
 *
 */

trait AclTrait {


    /*
     *  _check method
     *
     * @param array $userRoles
     * @param array $url
     */
    protected function _check($userRoles, $url) {
        if($this->_isAllowedRole($userRoles, $this->_getAllowedRolesByUrl($url))) return true;
        else return false;
    }

    /**
     * _isAllowedRole method
     * Checks if a role is allowed.
     *
     * @param array|string $userRoles
     * @param array $allowedRoles
     * @return boolean
     */
    protected function _isAllowedRole($userRoles, array $allowedRoles) {

        if (is_string($userRoles)) {
            $userRoles = [$userRoles];
        }
        foreach ($userRoles as $userRole) {
            if (in_array($userRole, $allowedRoles)) {
                return true;
            }
        }
        return false;
    }

    /**
     * _getAllowedRolesByUrl method
     * gets allowed roles for specific request url
     *
     * @param array $url
     * @return array $allowedRoles
     */

    //get allowed roles for a specific url (prefix, controller, action, plugin)
    protected function _getAllowedRolesByUrl($url) {

        if(!array_key_exists('plugin', $url)) $url['plugin'] = null;
        if(!array_key_exists('prefix', $url)) $url['prefix'] = null;

        $actions = TableRegistry::get('Permissions.Actions');
        $action = $actions->find()
            ->where([
                'controller' => $url['controller'],
                'action' => $url['action'],
                'plugin IS' => $url['plugin'],
                'prefix IS' => $url['prefix']
            ])
            ->contain(['Roles'])
            ->first();

        //Log::write('debug', $action);

        $allowedRoles = [];
        if($action) {
            foreach($action->roles as $role) {
                $allowedRoles[] = $role->id;
            }
        }

        //Log::write('debug', $allowedRoles);
        return $allowedRoles;
        //return ['superuser'];
    }

}
