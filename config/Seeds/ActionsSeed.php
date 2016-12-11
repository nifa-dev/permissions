<?php
use Migrations\AbstractSeed;

/**
 * Actions seed.
 */
class ActionsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'controller' => 'Registrations',
                'action' => 'home'
            ],
            [
                'id' => 2,
                'prefix' => 'admin',
                'controller' => 'Roles',
                'action' => 'add'
            ],
            [
                'id' => 3,
                'prefix' => 'admin',
                'controller' => 'Roles',
                'action' => 'edit'
            ],
            [
                'id' => 4,
                'prefix' => 'admin',
                'controller' => 'Roles',
                'action' => 'index'
            ],
            [
                'id' => 5,
                'controller' => 'Users',
                'action' => 'registrations'
            ]
        ];

        $table = $this->table('actions');
        $table->insert($data)->save();
    }
}