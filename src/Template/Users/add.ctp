<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Crear cuenta nueva') ?></legend>
        <?php
            echo $this->Form->control('name', ['label'=>'Nombre']);
            echo $this->Form->control('username', ['label'=>'Correo']);
            echo $this->Form->control('password', ['label'=>'Contraseña']);
            echo $this->Form->control('location', ['label'=>'Ubicación']);
            echo $this->Form->control('cellphone', ['label'=>'Teléfono']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link(__('¿Ya tiene una cuenta?'), ['action' => 'login']) ?>

</div>
