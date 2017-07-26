<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use App\Utility\Session;
use App\Utility\SpotOperator;
use App\Utility\SpotifyWebAPI;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public $paginate = [
        'limit' => 15
    ];
    
    
    public function initialize(){
        parent::initialize();
        $this->Auth->allow('add');
        $this->loadComponent('Paginator');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['add', 'logout']);

    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }


    public function logSpotify()
    {
       require 'vendor/autoload.php';
       $CLIENT_ID = '1b4974912a334d02836ea56760d062c2';
       $CLIENT_SECRET = 'f4a87069788a4c1183eda08686435c5e';
       $REDIRECT_URI = 'http://musicmatcher-ddivney.c9users.io/users/redirectspot';
       
       $session = new Session($CLIENT_ID, $CLIENT_SECRET, $REDIRECT_URI);
      
       $options = [
           'scope' => [
               'playlist-read-private',
               'user-read-private',
               'user-follow-read',
               'user-library-read',
               'playlist-read-collaborative',
               'user-read-recently-played'
           ],
       ];

       header('Location: ' . $session->getAuthorizeUrl($options));
       die();
    }
    
    private function addArtistFromArtist($followedArtist)
    {
        $artistsTable = TableRegistry::get('Artists');
        $artist = $artistsTable -> newEntity();
        $artist -> id = $followedArtist -> artistId;
        $artist -> name = $followedArtist -> artistName;
        $artistsTable -> save($artist);
    }
    
    private function addArtistGenre($artist)
    {
        $artistGenreTable = TableRegistry::get('Artistgenres');
        $artistGenre = $artistGenreTable -> newEntity();
        $artistGenre -> artist_id = $artist -> artistId;
        $artistGenre -> genre_id = $artist -> genreId;
        $artistGenreTable -> save($artistGenre);
    }
    
    private function addGenrePreference($uid, $artist, $preference)
    {
       // $this->loadModel('Genrepreferences');
        $genrePreferencesTable = TableRegistry::get('Genrepreferences');
        $genrePreference = $genrePreferencesTable -> newEntity();
        $genrePreference -> user_id = $uid;
        $genrePreference -> genre_id = $artist -> genreId;
        $genrePreference -> preference =$preference;
        $genrePreferencesTable -> save($genrePreference);
    }
    
    private function addFollowedArtists($uid, $artists, $preference)
    {
         for($i = 0; $i < count($artists); $i ++)
         {
             $artist = $artists[$i];
             $this -> addArtistFromArtist($artist);
             $this -> addArtistGenre($artist);
             $this -> addGenrePreference($uid, $artist, $preference);
         }
    }
    
    private function addArtist($song)
    {
        $artistsTable = TableRegistry::get('Artists');
        $artist = $artistsTable -> newEntity();
        $artist -> id = $song -> artistId;
        $artist -> name = $song -> artistName;
        $artistsTable -> save($artist);
    }
    
    private function addAlbum($song)
    {
        $albumsTable = TableRegistry::get('Albums');
        $album = $albumsTable -> newEntity();
        $album -> id = $song -> albumId;
        $album -> name = $song -> albumName;
        $album -> artist_id = $song  -> artistId;
        $albumsTable -> save($album);
    }
    
    private function addSong($recentSong)
    {
        $songsTable = TableRegistry::get('Songs');
        $song = $songsTable->newEntity();
        $song->id =       $recentSong -> songId;
        $song->album_id = $recentSong -> albumId;
        $song->name =     $recentSong -> songName;
        $songsTable ->save($song);
    }
    
    
    private function addArtistPreference($uid, $song, $preference)
    {
        $artistsPreferencesTable = TableRegistry::get('Artistpreferences'); 
        $artistPreference = $artistsPreferencesTable -> newEntity();
        $artistPreference -> user_id = $uid;
        $artistPreference -> artist_id = $song ->artistId;
        $artistPreference -> preference = $preference;
        $artistsPreferencesTable -> save($artistPreference);
        
    }
    
    private function addAlbumPreference($uid, $song, $preference)
    {
        $albumPreferenceTable = TableRegistry::get('Albumpreferences'); 
        $albumPreference = $albumPreferenceTable -> newEntity();
        $albumPreference -> user_id = $uid;
        $albumPreference -> album_id = $song ->albumId;
        $albumPreference -> preference = $preference;
        $albumPreferenceTable -> save($albumPreference);
    }
    
    private function addSongPreference($uid, $recentsong, $preference)
    {
        $songPreferenceTable = TableRegistry::get('Songpreferences'); 
        $songPreference = $songPreferenceTable -> newEntity();
        $songPreference -> user_id = $uid;
        $songPreference -> song_id = $recentsong ->songId;
        $songPreference -> preference = $preference;
        $songPreferenceTable -> save($songPreference);
    }
    
    private function addUserSongs($userId, $songs, $preferenceRange)
    {
        for($i = 0; $i < count($songs); $i ++)
        {
            $song = $songs[$i];
            $this -> addArtist($song);
            $this -> addAlbum($song);
            $this -> addSong($song);
            $this -> addArtistPreference($userId, $song, $preferenceRange);
            $this -> addAlbumPreference($userId, $song, $preferenceRange);
            $this -> addSongPreference($userId, $song, $preferenceRange);
        }
    }
    
    
    public function redirectspot()
    {
        $CLIENT_ID = '1b4974912a334d02836ea56760d062c2';
        $CLIENT_SECRET = 'f4a87069788a4c1183eda08686435c5e';
        $REDIRECT_URI = 'http://musicmatcher-ddivney.c9users.io/users/redirectspot';
        
        $session = new Session($CLIENT_ID, $CLIENT_SECRET, $REDIRECT_URI);
        
        $api = new SpotifyWebAPI();
        $session->requestAccessToken($_GET['code']);
        $accessToken = $session->getAccessToken();

        $api->setAccessToken($accessToken);
        $userId = $this->Auth->user('id');
        $idSpotify = SpotOperator::getUserId($api);
        
        $recentlyPlayedSongs = SpotOperator::getRecentlyPlayedTracks($api);
        $playlistSongs = SpotOperator::getPlaylistsTracks($api, $idSpotify);
        $addedTracks = SpotOperator::getAddedTracks($api);
        $followedArtists= SpotOperator::getFollowedArtists($api);
       
        $this -> addUserSongs($userId, $recentlyPlayedSongs, 2);
        $this -> addUserSongs($userId, $playlistSongs, 1);
        $this -> addUserSongs($userId, $addedTracks, 1);
        $this -> addFollowedArtists($userId, $followedArtists, 1);
        
        return $this->redirect(['action' => 'view', $this->Auth->user('id')]);
    }
    
    
 
    
    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userid = $this->Auth->user('id');
        if($id != $userid){
            $this->Flash->error(__('No tiene permiso para ver esta información.'));
            return $this->redirect(['action' => 'view', $userid]);
        }
        else {
            $this->loadModel('Songpreferences');
            $user = $this->Users->get($id);
            $songpreferences = $this->Songpreferences->find('all', [ 
                'conditions' => ['user_id =' => $id],
                'contain' => ['Songs.Albums.Artists'],
                'order' => ['Artists__id' => 'DESC']
            ]);
            $this->set('songpreferences', $songpreferences);
            $this->set('user', $user);
            $songs = $this -> paginate($songpreferences);
            $this->set(compact('songs'));
            $this->set('_serialize', ['songs']);
        }
    }
    
    public function viewMatch($id = null)
    {
        $this->loadModel('Songpreferences');
        $ownId = $this->Auth->user('id');
        
        $user = $this->Users->get($id);
        $songpreferences = $this->Songpreferences->find('all', [ 
            'conditions' => ['user_id =' => $id, 'Songpreferences.preference !=' => 0],
            'contain' => ['Songs.Albums.Artists'],
            'order' => ['Artists__id' => 'DESC']
        ]);
        $this->set('songpreferences', $songpreferences);
        $this->set('user', $user);
        $this->set('ownId', $ownId);
        $songs = $this -> paginate($songpreferences);
        $this->set(compact('songs'));
        $this->set('_serialize', ['songs']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Su cuenta ha sido creada.'));
                $this->Auth->setUser($user);
                return $this->redirect(['action' => 'view', $user['id']]);
            }
            $this->Flash->error(__('Su cuenta no ha podido ser creada. Por favor intente de nuevo.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userid = $this->Auth->user('id');
        if($id != $userid){
            $this->Flash->error(__('No tiene permiso para editar esta información.'));
            return $this->redirect(['action' => 'edit', $userid]);
        }
        else {
            $user = $this->Users->get($id, [
                'contain' => []
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Sus detalles han sido actualizados.'));
    
                    return $this->redirect(['action' => 'view', $user['id']]);
                }
                $this->Flash->error(__('Sus detalles no han podido ser actualizados. Por favor intente de nuevo.'));
            }
            $this->set(compact('user'));
            $this->set('_serialize', ['user']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $userid = $this->Auth->user('id');
        if($id != $userid){
            $this->Flash->error(__('No tiene permiso para borrar esta cuenta.'));
            return $this->redirect(['action' => 'delete', $userid]);
        }
        else {
            $this->request->allowMethod(['post', 'delete']);
            $user = $this->Users->get($id);
            if ($this->Users->delete($user)) {
                $this->Flash->success(__('Su cuenta ha sido borrada'));
            } else {
                $this->Flash->error(__('Su cuenta no ha podido ser borrada. Por favor intente de nuevo.'));
            }
            return $this->redirect(['action' => 'add']);
        }
    }
    
    
    public function login()
    {
        $userid = $this->Auth->user('id');
        if($userid != null){
            return $this->redirect(['action' => 'view', $userid]);
        }
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect(['action' => 'view', $user['id']]);
            }
            $this->Flash->error(__('Correo o contraseña inválidos'));
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

}
