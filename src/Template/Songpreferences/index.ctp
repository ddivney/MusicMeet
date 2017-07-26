<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Songpreference[]|\Cake\Collection\CollectionInterface $songpreferences
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>

    </ul>
</nav>
<div class="songpreferences index large-9 medium-8 columns content">
    <h3><?= __('Su Música:') ?></h4>
    <div class="prefs">
        <?php $currentArtist = '' ; ?>
        <?php $currentArtistName = '' ; ?>
        <?php $currentAlbum  = ''; ?>
        <?php $currentAlbumName  = ''; ?>
        <?php $currentSong =  ''; ?>
        <?php $currentSongName  = ''; ?>
        <?php $firstAlbum = true; ?>
        <?php $firstSong = true; ?>
        <ul><ul><ul>
        <?php foreach($preferences as $preference): ?>
            <?php if($currentArtist != $preference[0]): ?>    <!-- if artist is new -->
                </ul></ul>
                <?php $firstSong = true ?>
                <?php $firstAlbum = true ?>
                &#x1F464
                <?= $preference[1] ?>
                <?php echo $this->Html->link(
                    'Amplificar',
                    ['controller' => 'songpreferences', 'action' => 'setArtistPreference', $preference[0], $uid,  2],
                    ['class' => (($preference[2] == 2) ? 'button tiny disabled prefr' : 'button tiny prefr')]
                    );
                ?>
                <?php echo $this->Html->link(
                    'Normalizar',
                    ['controller' => 'songpreferences', 'action' => 'setArtistPreference', $preference[0], $uid,  1],
                    ['class' => (($preference[2] == 1) ? 'button tiny disabled prefr' : 'button tiny prefr')]
                    );
                ?>
                <?php echo $this->Html->link(
                    'Suprimir', ['controller' => 'songpreferences', 'action' => 'setArtistPreference', $preference[0], $uid, 0],
                    ['class' => (($preference[2] == 0) ? 'button tiny disabled prefr' : 'button tiny prefr')]
                );
                ?>
                <?php $currentArtist = $preference[0]?>
                <?php $firstAlbum = true ?>
                <ul>                                                <!-- album list start -->
            <?php endif ?>
            <?php if($currentAlbum != $preference[3]): ?>            <!-- if album is new -->
                <?php $firstSong = true ?>
                <?php if(!$firstAlbum): ?>                                    <!-- if not first -->
                </ul>                             <!-- tracklist end -->
                <?php endif; ?>
                <?php $firstAlbum = false ?>
                &#x1f4bf
                <?= $preference[4] ?>
                <?php echo $this->Html->link(
                    'Amplificar',
                    ['controller' => 'songpreferences', 'action' => 'setIndividualAlbumPreference',  $preference[3], $uid, 2],
                    ['class' => (($preference[5] == 2) ? 'button tiny disabled prefr' : 'button tiny prefr')]
                    );
                ?>
                <?php echo $this->Html->link(
                    'Normalizar',
                    ['controller' => 'songpreferences', 'action' => 'setIndividualAlbumPreference', $preference[3], $uid, 1],
                    ['class' => (($preference[5] == 1) ? 'button tiny disabled prefr' : 'button tiny prefr')]
                    );
                ?>
                <?php echo $this->Html->link(
                    'Suprimir',
                    ['controller' => 'songpreferences', 'action' => 'setIndividualAlbumPreference', $preference[3], $uid,  0],
                    ['class' => (($preference[5] == 0) ? 'button tiny disabled prefr' : 'button tiny prefr')]
                    );
                ?>
                <?php $currentAlbum = $preference[3]?>
                <ul>                                     <!-- tracklist start -->
            <?php endif ?>
            &#x266B
            <?= $preference[7] ?>
            <?php echo $this->Html->link(
                'Amplificar',
                ['controller' => 'Songpreferences', 'action' => 'setIndividualSongPreference', $preference[6], $uid, 2],
                ['class' => (($preference[8] == 2) ? 'button tiny disabled prefr' : 'button tiny prefr')]
                );
            ?>
            <?php echo $this->Html->link(
                'Normalizar',
                ['controller' => 'Songpreferences', 'action' => 'setIndividualSongPreference', $preference[6], $uid, 1],
                ['class' => (($preference[8] == 1) ? 'button tiny disabled prefr' : 'button tiny prefr')]
                );
            ?>
            <?php echo $this->Html->link(
                'Suprimir',
                ['controller' => 'Songpreferences', 'action' => 'setIndividualSongPreference', $preference[6], $uid, 0],
                ['class' => (($preference[8] == 0) ? 'button tiny disabled prefr' : 'button tiny prefr')]
                );
            ?>
            </br>
        <?php endforeach ?>
        </ul> </ul> </ul>
    </div>
</div>
