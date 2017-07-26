<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'MusicMatch: Encuentre a personas con gustos similares';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><a href="">Music Meet</a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
                <!-- Esto revista si hay un usuario con sesión activa o si no hay nadie logueado -->
                <?php if(array_key_exists('Auth', $this->request->session()->read())): ?>
                    <?php if(array_key_exists('User',  $this->request->session()->read()['Auth'])): ?>
                        <?php $userName = $this->request->session()->read()['Auth']['User']['name'] ?>
                        <?php $userId  = $this->request->session()->read()['Auth']['User']['id'] ?>
                        <li><?= $this->Html->link(__($userName), ['controller' => 'Users', 'action' => 'view', $userId])?></li>
                        <li><?= $this->Html->link(__('Terminar sesión'), ['controller' => 'Users', 'action' => 'logout'], $this->request->session()->read()['Auth']['User'])?></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
