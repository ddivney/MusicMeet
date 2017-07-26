<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\User $user
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Opciones') ?></li>
        <li><?= $this->Html->link(__('Editar detalles de su cuenta'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Html->link(__('Ver conexiones'), ['controller' => 'relationships', 'action' => 'view', $user->id]) ?> </li> 
        <li><?= $this->Html->link(__('Ver emparejamientos'), ['controller' => 'relationships', 'action' => 'setMatches', $user->id]) ?> </li> 
        <li><?= $this->Html->link(__('Editar preferencias musicales'), ['controller' => 'songpreferences', 'action' => 'index', $user->id]) ?> </li> 
        <li><?= $this->Html->link(__('Terminar sesión'), ['action' => 'logout', $user->id]) ?> </li>

    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Correo') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ubicación') ?></th>
            <td><?= h($user->location) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Teléfono') ?></th>
            <td><?= h($user->cellphone) ?></td>
        </tr>
    </table>
    <?php echo $this->Html->link("Sincronizar con Spotify", array('controller' => 'users','action'=> 'logSpotify'), array( 'class' => 'button')) ?>
    </br>
    <div  class="view songpreferences large-9 medium-8 columns content">
    <table>
        <tr>
            <th><h4>Canción</h4></th>
            <th><h4>Artista</h4></th>
            <th><h4>Album</h4></th>
        </tr>
        <?php foreach($songs as $songpreference): ?>
        <tr>
            <th><?= $songpreference->song->name ?></th>
            <th><?= $songpreference->song->album->artist->name ?></th>
            <th><?= $songpreference->song->album->name ?></th>

        </tr>
        <?php endforeach ?>
    </table>
     <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('primer')) ?>
            <?= $this->Paginator->prev('< ' . __('previo')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('siguiente') . ' >') ?>
            <?= $this->Paginator->last(__('último') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de un total de {{count}}')]) ?></p>
    </div>
    </div>
    
    
   
</div>
