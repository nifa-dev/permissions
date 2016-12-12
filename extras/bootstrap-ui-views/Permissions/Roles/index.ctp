<?php
/* @var $this \Cake\View\View */
$this->extend('Layout/TwitterBootstrap/dashboard');
$this->start('tb_actions');
?>
<li><?= $this->Html->link('Add Role', ['controller' => 'Roles', 'action' => 'add']); ?></li>
<?php
$this->end();
$this->start('tb_sidebar');
?>
<?= $this->Html->link('Add Role', ['controller' => 'Roles', 'action' => 'add']); ?>
<?php
$this->end();
?>
<?php $this->assign('tb_sidebar', '<ul class="nav nav-sidebar">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped">
    <thead>
    <tr>

        <th><?= $this->Paginator->sort('name') ?></th>
        <th><?= $this->Paginator->sort('system_role') ?></th>
        <th class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($roles as $role): ?>
        <tr>

            <td><?= h($role->name) ?></td>
            <td><?= $this->BooleanDisplay->format($role->system_role) ?></td>
            <td class="actions">

                <?= $this->Html->link(__('Edit'),
                    ['action' => 'edit', $role->id],
                    ['class' => 'btn btn-warning']) ?>
                <?= $this->Form->postLink(__('Delete'),
                    ['action' => 'delete', $role->id],
                    ['confirm' => __('Are you sure you want to delete {0}?', $role->name), 'class' => 'btn btn-danger']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
    </ul>
</div>
