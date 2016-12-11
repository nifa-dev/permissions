<?php
namespace Permissions\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;

/**
 * Action Entity.
 *
 * @property int $id
 * @property string $prefix
 * @property string $plugin
 * @property string $controller
 * @property string $action
 * @property \Permissions\Model\Entity\Role[] $roles
 */
class Action extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected function _getPrefix($prefix) {
        if($prefix == '') return null;
        else return $prefix;
    }

    protected function _getPlugin($plugin) {
        if($plugin == '') return null;
        else return $plugin;
    }

    protected function _getRouteDisplay()
    {
        $text =  Inflector::humanize($this->_properties['controller']) . '-' .
        Inflector::humanize($this->_properties['action']);

        if(!is_null($this->_properties['prefix'])) {
            $text = Inflector::humanize($this->_properties['prefix']) . "-" . $text;
        }

        if(!is_null($this->_properties['plugin'])) {
            $text = Inflector::humanize($this->_properties['plugin']) . "-" . $text;
        }

        return $text;
    }
}
