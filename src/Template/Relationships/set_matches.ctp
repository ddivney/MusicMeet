<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Relationship $relationship
  */
?>

<div class="relationships  large-9 medium-8 columns content">
    
    <h3>Posibles emparejamientos</h3>
    <table >
        <tr>
             <th>Puntaje de similitud</th>
             <th>Nombre</th>
             <th>Ubicación</th>
             <th>Opciones</th>
        </tr>
        <?php foreach($possibleMatches as $possibleMatch): ?>
        <tr>
            <td><?= $possibleMatch -> score ?></td>
            <td><?= $possibleMatch -> user -> name ?> </td>
            <td><?= $possibleMatch -> user -> location ?> </td>
            <td><?= $this->Html->link(__('Ver perfil'),  array('controller' => 'users','action'=> 'viewMatch', $possibleMatch -> user -> id)) ?></td>
        </tr>
        <?php endforeach ?>
    </table>
    <?= $this->Html->link(__('Volver al perfil'), ['controller' => 'users', 'action' => 'view', $userId],  array( 'class' => 'button')) ?>
</div>
