<?php
namespace Permissions\Controller\Component;

use Cake\Event\Event;
use Cake\Controller\Component;

class RbacComponent extends Component {

    public $components = ['Auth'];

    //make sure theres a view var for users roles in each controller
    public function beforeRender(Event $event) {
        $controller = $event->subject();
        $controller->set('_authUser', $this->Auth->user());

    }
}