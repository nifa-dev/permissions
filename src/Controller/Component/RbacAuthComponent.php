<?php
namespace Permissions\Controller\Component;

use Cake\Controller\Component;

class RbacAuthComponent extends Component {



    public static function authorizeByUrl($url) {

        //$userRoles = $this->Auth->user('user_roles');

        return false;
    }

}