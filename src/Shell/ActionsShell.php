<?php
namespace Permissions\Shell;

use Cake\Console\Shell;
use ReflectionClass;
use ReflectionMethod;
use Cake\Core\Plugin;


class ActionsShell extends Shell
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Actions');
        //$this->loadModel('Roles');
    }

    public function main()
    {
        $action = $this->Actions->get(67);
        $this->out(json_encode($action));
    }

    
    public function test() {
        $this->out(json_encode($this->listActions('Permissions')));
    }

    public function updateActions($plugins = null) {
        $actions = $this->listActions($plugins);
        //$this->out(json_encode($actions));
        foreach($actions as $action) {
            //$action = $this->createEntity($actions);
            //$this->out(json_encode($action));

            $entity = $this->createEntity($action);
            if($result = $this->Actions->save($entity)) {
                if($entity->isNew()) $this->out("Created " . implode(",", $action));
                else $this->out("Updated " . implode(",", $action));
            } else {
                $this->out("Failed to save " . implode(",", $action));
            }
        }
    }

    private function createEntity($action)
    {
        if(array_key_exists('prefix', $action)) {
            if($action['prefix'] == 'app') $action['prefix'] = null;
        }

        $entity = $this->Actions->find()
                    ->where($action)
                    ->first();
        if($entity) $action = $this->Actions->patchEntity($entity, $action);
        else $action = $this->Actions->newEntity($action);

        return $action;
    }

    private function listActions($plugins = null) {
        $controllers = $this->allControllers($plugins);
        $listActions = [];
        //application controllers
        foreach($controllers['app'] as $prefix => $prefixData) {

            foreach($prefixData  as $appController) {
                //$this->out(sprintf("Looking for prefix %s and controller %s", $prefix, $appController));
                $actions = $this->getActions($appController, $prefix);
                //$this->out(json_encode($actions));
                foreach($actions as $action) {

                    $listActions[] = ['prefix' => $prefix, 'controller' => $appController, 'action' => $action];
                }
            }
        }

        if($plugins) {
            foreach($controllers['plugins'] as $plugin => $pluginData) {
                foreach($pluginData as $pluginController) {
                    $actions = $this->getActions($pluginController, null, $plugin);
                    foreach($actions as $action) {
                        $listActions[] = ['plugin' => $plugin, 'controller' => $pluginController, 'action' => $action];
                    }
                }
            }
        }



        return $listActions;
    }

    private function allControllers($plugins = null) {

        //appActions
        $appResources = $this->getControllers();
        $pluginResources = [];
        $pluginsArray = explode(",", $plugins);

        foreach($pluginsArray as $plugin) {
            $pluginResources[$plugin] = $this->getControllers($plugin);
        }

        return ['app' => $appResources, 'plugins' => $pluginResources];
    }

    
    private function getControllers($pluginName = null)
    {

        $results = [];


        //scan the app controller director
        $files = scandir(APP . "/Controller");

        if($pluginName) $files = scandir(Plugin::classPath($pluginName) . "Controller");
        $appControllers = [];
        $ignoreList = [
            '.',
            '..',
            '',
            'Component',
            'AppController.php',
            '.DS_Store'
        ];

        foreach($files as $file) {
            
            if(!in_array($file, $ignoreList)) {
                if(array_key_exists(1, explode('.', $file))) {
                    //this is a file
                    array_push($appControllers, str_replace('Controller', '', explode('.', $file)[0]));

                } else {
                    //this is a directory

                    $dirFiles = scandir(APP."/Controller/".$file);

                    $results[$file] = [];
                    foreach($dirFiles as $dirFile) {
                        if(!in_array($dirFile, $ignoreList)){
                            array_push($results[$file], str_replace('Controller', '', explode('.', $dirFile)[0]));

                        }

                    }
                }
            }
        }

        if($pluginName) {
            $results = $appControllers;
        } else {
            $results['app'] = $appControllers;
        }
        //($pluginName) ? $key = "plugin" : $key = 'app';
        //$results[$key] = $appControllers;

        return $results;
    }


    private function getActions($controllerName, $prefix, $plugin = null)
    {

            if($plugin) {
                $className = $plugin . '\\Controller\\' . $controllerName . 'Controller';
            } else {
                if($prefix != 'app') $className = 'App\\Controller\\' . $prefix . '\\' . $controllerName . 'Controller';
                else $className = 'App\\Controller\\' . $controllerName . 'Controller';
            }


            $class = new ReflectionClass($className);
            $actions = $class->getMethods(ReflectionMethod::IS_PUBLIC);
            $results = [$prefix => [$controllerName => []]];
            $ignoreList = ['beforeFilter', 'afterFilter', 'initialize'];
            $actionsList = [];
            foreach($actions as $action) {
                if($action->class == $className && !in_array($action->name, $ignoreList)){
                    array_push($actionsList, $action->name);
                }
            }
            return $actionsList;

    }





}