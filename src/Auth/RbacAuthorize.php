<?php
namespace Permissions\Auth;

use Cake\Auth\BaseAuthorize;
use Cake\Network\Request;
use Cake\Core\Configure;
use Cake\Utility\Inflector;
use Cake\Network\Exception\ForbiddenException;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Permissions\Auth\AclTrait;

/**
 * RbacAuthorize
 * Role Based Authorization - determine if page authorization is met by request path and user roles
 *
 */
class RbacAuthorize extends BaseAuthorize {

    use AclTrait;
    /**
     * Default config for this object.
     *
     * - `roleField` - The name of the role field in the user data array that is passed to authorize()
     *
     * @var array
     */
    public $_defaultConfig = array(
        'roleField' => 'role',
        'allowEmptyActionMap' => false,
        'allowEmptyPrefixMap' => true,
    );
    /**
     * Authorize a user based on roles
     *
     * @param array $user The user to authorize
     * @param Request $request The request needing authorization.
     * @return boolean
     * @throws RuntimeException when the role field does not exist
     */
    public function authorize($user, Request $request)
    {
        $roleField = $this->_config['roleField'];
        if (!isset($user[$roleField])) {
            throw new \RuntimeException(__d('bz_utils', 'The role field {0} does not exist!', $user[$roleField]));
        }
        if (is_string($user[$roleField])) {
            $user[$roleField] = array($user[$roleField]);
        }
        if ($this->_check($user[$roleField], $this->getRequestUrl($request))) {
            return true;
        }
        throw new ForbiddenException(__('You are not authorized to view this page.'));
        //return false;
    }

    /**
     * Gets the controller, action, prefix, and plugin of the Request
     *
     * @param Request $request
     * @return array
     */
    public function getRequestUrl(Request $request) {
        $controllerObj = $this->_registry->getController();
        $controller = $controllerObj->name;
        $action = $request->action;
        if (!empty($request->params['plugin'])) {
            $plugin = Inflector::camelize($request->params['plugin']);
        } else {
            $plugin = null;
        }
        if (!empty($request->params['prefix'])) {
            $prefix = Inflector::camelize($request->params['prefix']);
        } else {
            $prefix = null;
        }

        return [
            'plugin' => $plugin,
            'prefix' => $prefix,
            'controller' => $controller,
            'action' => $action
        ];

    }


    //get allowed roles for a specific route (prefix, controller, action, plugin)
    /*public function getAllowedRolesByRoute($route) {


        $actions = TableRegistry::get('Permissions.Actions');
        $action = $actions->find()
            ->where([
                'controller' => $route['controller'],
                'action' => $route['action'],
                'plugin IS' => $route['plugin'],
                'prefix IS' => $route['prefix']
            ])
            ->contain(['Roles'])
            ->first();

        Log::write('debug', $action);

        $allowedRoles = [];
        if($action) {
            foreach($action->roles as $role) {
                $allowedRoles[] = $role->role_slug;
            }
        }

        Log::write('debug', $allowedRoles);
        return $allowedRoles;
        //return ['superuser'];
    }*/

}