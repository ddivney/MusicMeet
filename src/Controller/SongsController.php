<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Songs Controller
 *
 * @property \App\Model\Table\SongsTable $Songs
 *
 * @method \App\Model\Entity\Song[] paginate($object = null, array $settings = [])
 */
class SongsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Albums']
        ];
        $songs = $this->paginate($this->Songs);

        $this->set(compact('songs'));
        $this->set('_serialize', ['songs']);
    }

    /**
     * View method
     *
     * @param string|null $id Song id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $song = $this->Songs->get($id, [
            'contain' => ['Albums', 'Songpreferences']
        ]);

        $this->set('song', $song);
        $this->set('_serialize', ['song']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $song = $this->Songs->newEntity();
        if ($this->request->is('post')) {
            $song = $this->Songs->patchEntity($song, $this->request->getData());
            if ($this->Songs->save($song)) {
                $this->Flash->success(__('The song has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The song could not be saved. Please, try again.'));
        }
        $albums = $this->Songs->Albums->find('list', ['limit' => 200]);
        $this->set(compact('song', 'albums'));
        $this->set('_serialize', ['song']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Song id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $song = $this->Songs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $song = $this->Songs->patchEntity($song, $this->request->getData());
            if ($this->Songs->save($song)) {
                $this->Flash->success(__('The song has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The song could not be saved. Please, try again.'));
        }
        $albums = $this->Songs->Albums->find('list', ['limit' => 200]);
        $this->set(compact('song', 'albums'));
        $this->set('_serialize', ['song']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Song id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $song = $this->Songs->get($id);
        if ($this->Songs->delete($song)) {
            $this->Flash->success(__('The song has been deleted.'));
        } else {
            $this->Flash->error(__('The song could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
