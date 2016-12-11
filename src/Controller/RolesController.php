<?php
namespace Permissions\Controller;

use Permissions\Controller\AppController;

class RolesController extends AppController {


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
        ];
        $roles = $this->paginate($this->Roles);

        $this->set(compact('roles'));
        $this->set('_serialize', ['roles']);
    }

    /**
     * Add method
     *
     *
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function add($id = null)
    {
        $role = $this->Roles->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->data);
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The Role has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The Role could not be saved. Please, try again.'));
            }
        }
        $actions = $this->Roles->Actions->find('list', ['keyField' => 'id', 'valueField' => 'route_display',
                            'order' => [
                                'prefix' => 'ASC',
                                'plugin' => 'ASC',
                                'controller' => 'ASC',
                                'action' => 'ASC'
                            ]]);
        $this->set(compact('role', 'actions'));
        $this->set('_serialize', ['role']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => ['Actions']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->data);
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The Role has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The Role could not be saved. Please, try again.'));
            }
        }
        $actions = $this->Roles->Actions->find('list', ['keyField' => 'id', 'valueField' => 'route_display',
            'order' => [
                'prefix' => 'ASC',
                'plugin' => 'ASC',
                'controller' => 'ASC',
                'action' => 'ASC'
            ]]);
        $this->set(compact('role', 'actions'));
        $this->set('_serialize', ['role']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $card = $this->Roles->get($id);
        if ($this->Roles->delete($card)) {
            $this->Flash->success(__('The role has been deleted.'));
        } else {
            $this->Flash->error(__('The role could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
