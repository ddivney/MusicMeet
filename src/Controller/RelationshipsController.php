<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use App\Utility\Match;

/**
 * Relationships Controller
 *
 * @property \App\Model\Table\RelationshipsTable $Relationships
 *
 * @method \App\Model\Entity\Relationship[] paginate($object = null, array $settings = [])
 */
class RelationshipsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $relationships = $this->paginate($this->Relationships);

        $this->set(compact('relationships'));
        $this->set('_serialize', ['relationships']);
    }

    /**
     * View method
     *
     * @param string|null $id Relationship id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $relationshipsTable = TableRegistry::get('Relationships');
        $relationship = $relationshipsTable->find('all', [
            'conditions' => ['user_id1 =' => $id],
            'contain' => ['Users2']
        ]) -> select(['uId' => 'Users2.id', 'uName' => 'Users2.name','rStatus' => 'Relationships.status' ]) ;
         
        
        $this->set('userId', $id);
        $this->set('relationship', $relationship);
        $this->set('_serialize', ['relationship']);
    }
    
    
   
    public function setMatches($userId)
    {
        $userId = $this->Auth->user('id');
        $usersTable = TableRegistry::get('Users');
        $query = $usersTable -> find();
        $possibleMatches = array();//array con ids de otros usuarios
        foreach ($query as $user) 
        {
             if($userId !== $user -> id)
             {
                 $pmId = $user -> id;
                 $score = $this -> setMatchScore($userId, $pmId);
                 $possibleMatches[] = new Match($user, $score);
             }
        }
        
        usort($possibleMatches, 'App\Utility\Match::cmp'); //Se ordena descendentemente
        
        $this->set('possibleMatches', $possibleMatches);
        $this->set('userId', $userId );
       // foreach($possibleMatches as $match)
       // {
       //     echo $match -> user -> id;
       //     echo " ";
       //     echo $match -> score;
       //     echo "<br>";
       // }
    }
    
    private function setMatchScore($userId, $pmId)
    {
        $score = 0;
        $score += $this -> getSongMatchScore($userId, $pmId);
        $score += $this -> getAlbumMatchScore($userId, $pmId);
        $score += $this -> getArtistMatchScore($userId, $pmId);
        $score += $this -> getGenreMatchScore($userId, $pmId);
        return $score;
    }
    
    private function getSongMatchScore($uid, $pmId)
    {
         $songpreferencesTable = TableRegistry::get('Songpreferences');
         $songsPM = $songpreferencesTable->find('all', [ 
            'conditions' => ['user_id =' => $pmId],
            'contain' => ['Songs']
        ]) -> select(['Songs.name']);
        
         $coincidences = $songpreferencesTable->find('all', [ 
            'conditions' => ['user_id =' => $uid],
            'contain' => ['Songs']
        ]) -> select(['songName' => 'Songs.name', 
                      'preference' => 'Songpreferences.preference']) 
                      ->where(['Songs.name IN' =>  $songsPM]);
    
        $score = 0;
        foreach($coincidences as $row)
        {
          $score += $row["preference"];
        }
        return $score * 5;
    }
    
    private function getAlbumMatchScore($uid, $pmId)
    {
         $albumpreferencesTable = TableRegistry::get('Albumpreferences');
         $albumsPM = $albumpreferencesTable->find('all', [ 
            'conditions' => ['user_id =' => $pmId],
            'contain' => ['Albums']
        ]) -> select(['Albums.name']);
        
         $coincidences = $albumpreferencesTable -> find('all', [ 
            'conditions' => ['user_id =' => $uid],
            'contain' => ['Albums']
        ]) -> select(['albumName' => 'Albums.name', 
                      'preference' => 'Albumpreferences.preference']) 
                      ->where(['Albums.name IN' =>  $albumsPM]);
    
        $score = 0;
        foreach($coincidences as $row)
        {  
          $score += $row["preference"];
        }
        return $score * 4;
    }
    
    private function getArtistMatchScore($uid, $pmId)
    {
         $artistpreferencesTable = TableRegistry::get('Artistpreferences');
         $artistPM = $artistpreferencesTable->find('all', [ 
            'conditions' => ['user_id =' => $pmId],
            'contain' => ['Artists']
        ]) -> select(['Artists.name']);
        
         $coincidences = $artistpreferencesTable -> find('all', [ 
            'conditions' => ['user_id =' => $uid],
            'contain' => ['Artists']
        ]) -> select(['artistName' => 'Artists.name', 
                      'preference' => 'Artistpreferences.preference']) 
           ->where(['Artists.name IN' =>  $artistPM]);
    
        $score = 0;
        foreach($coincidences as $row)
        {  
          $score += $row["preference"];
        }
        return $score * 3;
    }
    
    private function getGenreMatchScore($uid, $pmId)
    {
        $genrepreferencesTable = TableRegistry::get('Genrepreferences');
        $genrePM = $genrepreferencesTable -> find()
                                          -> select(['genre_id'])
                                          -> where(['user_id' => $pmId]);
        
        $coincidences = $genrepreferencesTable -> find()
                                               -> select(['genre_id', 'preference'])
                                               -> where(['user_id' => $uid])
                                               -> andWhere(['genre_id IN' => $genrePM]);
        $score = 0;
        foreach($coincidences as $row)
        {  
            $score += $row["preference"];
        }
        return $score * 2;
    }
    
    
    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $relationship = $this->Relationships->newEntity();
        if ($this->request->is('post')) {
            $relationship = $this->Relationships->patchEntity($relationship, $this->request->getData());
            if ($this->Relationships->save($relationship)) {
                $this->Flash->success(__('The relationship has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The relationship could not be saved. Please, try again.'));
        }
        $this->set(compact('relationship'));
        $this->set('_serialize', ['relationship']);
    }
    
    public function sendRequest($id1, $id2)
    {
        $this->autoRender = false;
        $relationshipsTable = TableRegistry::get('Relationships');
        $relationshipTo = $relationshipsTable->newEntity();
        $relationshipTo -> user_id1 = $id1;
        $relationshipTo -> user_id2 = $id2;
        $relationshipTo -> status = 2;
        $relationshipFrom = $relationshipsTable->newEntity();
        $relationshipFrom -> user_id1 = $id2;
        $relationshipFrom -> user_id2 = $id1;
        $relationshipFrom -> status = 3;
        
        $relationshipsTable -> save($relationshipTo);
        $relationshipsTable -> save($relationshipFrom);
        return $this->redirect(['action' => 'view', $this->Auth->user('id')]);
        
    }
    public function acceptRequest($id1, $id2)
    {
        $this->autoRender = false;
        $relationshipsTable = TableRegistry::get('Relationships');
        $relation = $relationshipsTable->get( array($id1, $id2)); 
        $relation -> status = 1;
        $relationshipsTable -> save($relation);
        return $this->redirect(['action' => 'view', $this->Auth->user('id')]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Relationship id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $relationship = $this->Relationships->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $relationship = $this->Relationships->patchEntity($relationship, $this->request->getData());
            if ($this->Relationships->save($relationship)) {
                $this->Flash->success(__('The relationship has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The relationship could not be saved. Please, try again.'));
        }
        $this->set(compact('relationship'));
        $this->set('_serialize', ['relationship']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Relationship id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $relationship = $this->Relationships->get($id);
        if ($this->Relationships->delete($relationship)) {
            $this->Flash->success(__('The relationship has been deleted.'));
        } else {
            $this->Flash->error(__('The relationship could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
