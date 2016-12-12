<?php
/* @var $this \Cake\View\View */
$this->extend('Layout/TwitterBootstrap/dashboard');
$this->start('tb_actions');
?>
    <li><?= $this->Html->link('List Roles', ['controller' => 'Roles', 'action' => 'index']); ?></li>
<?php
$this->end();
$this->start('tb_sidebar');
?>
<?= $this->Html->link('List Roles', ['controller' => 'Roles', 'action' => 'index']); ?>
<?php
$this->end();
?>
<?php $this->assign('tb_sidebar', '<ul class="nav nav-sidebar">' . $this->fetch('tb_actions') . '</ul>'); ?>
<?= $this->Form->create($role) ?>
    <fieldset>
        <legend><?= __('Edit Role') ?></legend>
        <?php
        echo $this->Form->input('name');
        echo $this->Form->input('system_role');
        echo $this->Form->input('actions._ids', ['options' => $actions, 'multiple' => 'checkbox']);
        ?>
    </fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>