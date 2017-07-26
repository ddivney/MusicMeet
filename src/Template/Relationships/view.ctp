<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Relationship $relationship
  */
?>

<div class="relationships view large-9 medium-8 columns content">
    
    <table >
        <tr>
             <th>Nombre</th>
             <th>Estado</th>
             <th></th>
             <th></th>
        </tr>
        <?php foreach($relationship as $r): ?>
        <tr>
            <td><?= $r['uName'] ?></td>
            <?php if ($r['rStatus'] === 1): ?>
                 <td> Amigos</td>
                 <td><?= $this->Html->link(__('Ver perfil'),  array('controller' => 'users','action'=> 'viewMatch', $r['uId'])) ?></td>
                 <td><?= $this->Html->link(__('Eliminar contacto'), ['action' => 'rejectRequest', $userId, $r['uId']]) ?></td>

           <?php elseif ($r['rStatus'] === 2): ?>
                 <td> Solicitud enviada</td>
                 <td></td>
                 <td></td>
           <?php elseif ($r['rStatus'] === 3): ?>
                 <td>Pendiente</td>
                 <td><?= $this->Html->link(__('Aceptar solicitud'), ['action' => 'acceptRequest', $userId, $r['uId']]) ?></td>
                 <td><?= $this->Html->link(__('Borrar solicitud'), ['action' => 'rejectRequest', $userId, $r['uId']]) ?></td>

           <?php endif; ?>
        </tr>
        <?php endforeach ?>
    </table>
</div>
