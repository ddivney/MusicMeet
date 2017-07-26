<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Acciones') ?></li>
        <li><?= $this->Html->link(__('Ver perfil'), ['action' => 'view', $user->id]) ?> </li>

    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Editar detalles de su cuenta') ?></legend>
        <?php
            echo $this->Form->control('name', ['label'=>'Nombre']);
            echo $this->Form->control('username', ['label'=>'Correo']);
            echo $this->Form->control('location', ['label'=>'Ubicación']);
            echo $this->Form->control('cellphone', ['label'=>'Teléfono']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
    <?= $this->Form->postLink(
                __('Eliminar cuenta'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('¿Está seguro que desea eliminar su cuenta?', $user->id)]
            )
        ?>
</div>
