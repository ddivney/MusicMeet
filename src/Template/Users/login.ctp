<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="users form" style="text-align:center; margin-top:10%">
<?= $this->Flash->render('auth') ?>
        <div class="large-4 medium-6 small-12" style="display:inline-block;">
        <?= $this->Form->create() ?>
        <fieldset>
            <legend><?= __('Por favor ingrese su correo y contraseña') ?></legend>
            <?= $this->Form->control('username', ['label'=>'Correo']) ?>
            <?= $this->Form->control('password', ['label'=>'Contraseña']) ?>
        </fieldset>
        <?= $this->Form->button(__('Login')); ?>
        <?= $this->Form->end() ?>
        <?= $this->Html->link(__('Crear cuenta nueva'), ['action' => 'add']) ?>
        </div>

</div>
