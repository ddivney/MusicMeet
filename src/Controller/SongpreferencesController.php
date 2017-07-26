<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;



/**
 * Songpreferences Controller
 *
 * @property \App\Model\Table\SongpreferencesTable $Songpreferences
 *
 * @method \App\Model\Entity\Songpreference[] paginate($object = null, array $settings = [])
 */
class SongpreferencesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id = null)
    {
        $userid = $this->request->session()->read()['Auth']['User']['id'];
        if($userid != $id){
            $this->Flash->error(__('No tiene permiso para ver esta información.'));
            return $this->redirect(['action' => 'index', $userid]);
        }
        else {
            $this->loadModel('Artistpreferences');
            $this->paginate = [
                'conditions' => ['Users.id = ' => $id],
                'contain' => ['Users', 'Songs.Albums']
                ];
            $songpreferences = $this->paginate($this->Songpreferences);
            $conn = ConnectionManager::get('default');
            $query = $conn->execute('select ar.id, ar.name, ap.preference, al.id, al.name, alp.preference, s.id, s.name, sp.preference from artistpreferences ap join artists ar on ap.artist_id = ar.id join albums al on al.artist_id = ar.id join albumpreferences alp on alp.album_id = al.id join songs s on s.album_id = al.id join songpreferences sp on sp.song_id = s.id where ap.user_id = ? AND alp.user_id = ? AND sp.user_id = ?', [$id, $id, $id]);
            $preferences = $query->fetchAll();
            $this->Auth->authorize = 'controller';
            $this->set('uid', $id);
            $this->set('preferences', $preferences);
            $this->set(compact('songpreferences'));
            $this->set('_serialize', ['songpreferences']);
        }
    }

    
    public function setSongPreference($sid, $uid, $pref){
        $sprefs = TableRegistry::get('Songpreferences');
        $preference = $sprefs->newEntity();
        $preference -> user_id = $uid;
        $preference -> song_id = $sid;
        $preference -> preference = $pref;
        $sprefs->save($preference);
    }
        
    private function setChainAlbumPreferences($sid, $uid, $pref){
        $this->loadModel('Albumpreferences');
        $alprefs = TableRegistry::get('Albumpreferences');
        $preferences = $this->Albumpreferences->find('all', [
            'conditions' => ['Albums.artist_id =' => $sid, 'user_id =' => $uid],
            'contain' => ['Albums']]);
        foreach ($preferences as $preference){
            $this->setAlbumPreference($preference->album_id, $uid, $pref);
            $this->log("Here ".$preference->album_id, 'debug');
        }
    }
    
    public function setArtistPreference($sid, $uid, $pref){
        $arprefs = TableRegistry::get('Artistpreferences');
        $preference = $arprefs->newEntity();
        $preference -> user_id = $uid;
        $preference -> artist_id = $sid;
        $preference -> preference = $pref;
        $arprefs->save($preference);
        $this->setChainAlbumPreferences($sid, $uid, $pref);
        $this->redirect(['controller' => 'Songpreferences', 'action' => 'index', $uid]);

    }
    
    public function setChainSongPreferences($sid, $uid, $pref){
        $sprefs = TableRegistry::get('Songpreferences');
        $preferences = $this->Songpreferences->find('all', [
            'conditions' => ['Songs.album_id =' => $sid, 'user_id =' => $uid],
            'contain' => ['Songs']]);
        foreach ($preferences as $preference){
            $this->setSongPreference($preference->song_id, $uid, $pref);
        }

    }
        
    public function setAlbumPreference($sid, $uid, $pref){
        $alprefs = TableRegistry::get('Albumpreferences');
        $preference = $alprefs->newEntity();
        $preference -> user_id = $uid;
        $preference -> album_id = $sid;
        $preference -> preference = $pref;
        $this->log($preference, 'debug');
        $alprefs->save($preference);
        $this->setChainSongPreferences($sid, $uid, $pref);
    }
    
    public function setIndividualAlbumPreference($sid, $uid, $pref){
        $this->setAlbumPreference($sid, $uid, $pref);
        $this->setChainSongPreferences($sid, $uid, $pref);
        $this->redirect(['controller' => 'Songpreferences', 'action' => 'index', $uid]);

    }
    
     public function setIndividualSongPreference($sid, $uid, $pref){
        $this->setSongPreference($sid, $uid, $pref);
        $this->redirect(['controller' => 'Songpreferences', 'action' => 'index', $uid]);

    }
    
    public function isAuthorized($id = null){
          if (in_array($this->request->getParam('action'), ['index'])) {
            $userid = (int)$this->request->getParam('pass.0');
            $this->log($userid." aa ", 'debug');
            return true;
   //         if ($userid == $user['id']) {
   //            return true;
   //         }
     }
    }
}
