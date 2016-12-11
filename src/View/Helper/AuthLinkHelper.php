<?php
namespace Permissions\View\Helper;

use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\View\Helper;
use Cake\View\Helper\HtmlHelper;
use Cake\Log\Log;
use Permissions\Auth\AclTrait;
use Cake\Routing\Router;

/**
 * AuthLink helper
 */
class AuthLinkHelper extends Helper
{

    public $helpers = ['Html', 'Form'];
    use AclTrait;

    /**
     * Generate a link if the target url is authorized for the logged in user
     *
     * @param string $title link's title.
     * @param string|array|null $url url that the user is making request.
     * @param array $options Array with option data.
     * @return string
     */
    public function link($title, $url = null, array $options = [])
    {
        $urlParsed = $this->parse($url);
        if ($this->isAuthorized($urlParsed)) {
            $linkOptions = $options;
            return $this->Html->link($title, $url, $linkOptions);;
        }
        return false;
    }

    public function postLink($title, $url = null, array $options = []) {
        $urlParsed = $this->parse($url);
        if ($this->isAuthorized($urlParsed)) {
            $linkOptions = $options;
            return $this->Form->postLink($title, $url, $linkOptions);;
        }
        return false;
    }

    /**
     * Returns true if the target url is authorized for the logged in user
     *
     * @param |array|null $url url that the user is making request.
     * @return bool
     */
    public function isAuthorized($url = null)
    {
        return $this->_check($this->_View->viewVars['_authUser']['active_roles'], $url);
    }

    private function parse($url) {

        Log::write('debug', Router::parse(Router::normalize(Router::url($url))));
        //return $url;

        $fullUrl = Router::parse(Router::normalize(Router::url($url)));
        //Log::write('debug', $fullUrl);
        return $fullUrl;
    }


}
