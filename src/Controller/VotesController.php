<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Security;

/**
 * Votes Controller
 *
 * @property \App\Model\Table\VotesTable $Votes
 *
 * @method \App\Model\Entity\Vote[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VotesController extends AppController
{
    public function setVotes() {
        $this->autoRender = false;
        $post_id = $this->request->query('pid');
        $sign = $this->request->query('sign');

        $ip = $this->request->ClientIp();
        $ipHash = Security::hash($ip, 'md5', true);

        unset($ip);

        if ($this->Votes->exists(['post_id' => $post_id, 'client_ip' => $ipHash])) {
            $this->Flash->warning('You already voted for this post. '.($sign ? 'Thank you again.' : 'Please consider suggesting me something to improve. Thank you!'));
            return $this->redirect(['controller' => 'Posts', 'action' => 'view', $post_id]);
        }

        $vote = $this->Votes->newEntity();
        $vote = $this->Votes->patchEntity($vote, ['post_id' => $post_id, 'client_ip' => $ipHash, 'sign' => $sign]);

        if ($this->Votes->save($vote)) {
            $post = $this->Votes->Posts->get($post_id, ['fields' => 'title']);

            $this->Flash->success($sign ? 'Hooray! You have raised a positive vote for '.$post->title.'. You can make it better by suggesting me a feature. Thank you!' :
                'Thank you for voting on '.$post->title.'. Please take some times to suggest me a way to improve this post.');
            return $this->redirect(['controller' => 'Posts', 'action' => 'view', $post_id]);
        }

        $this->Flash->error(__('Oops! Something went wrong with the server. Please try again later.'));
        $this->redirect(['controller' => 'Posts', 'action' => 'view', $post_id]);
    }

    private function getClientIp() {
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            $ip = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ip = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = 'UNKNOWN';

        return $ip;
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Posts']
        ];
        $votes = $this->paginate($this->Votes);

        $this->set(compact('votes'));
    }

    /**
     * View method
     *
     * @param string|null $id Vote id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vote = $this->Votes->get($id, [
            'contain' => ['Posts']
        ]);

        $this->set('vote', $vote);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $vote = $this->Votes->newEntity();
        if ($this->request->is('post')) {
            $vote = $this->Votes->patchEntity($vote, $this->request->getData());
            if ($this->Votes->save($vote)) {
                $this->Flash->success(__('The vote has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vote could not be saved. Please, try again.'));
        }
        $posts = $this->Votes->Posts->find('list', ['limit' => 200]);
        $this->set(compact('vote', 'posts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Vote id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $vote = $this->Votes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vote = $this->Votes->patchEntity($vote, $this->request->getData());
            if ($this->Votes->save($vote)) {
                $this->Flash->success(__('The vote has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vote could not be saved. Please, try again.'));
        }
        $posts = $this->Votes->Posts->find('list', ['limit' => 200]);
        $this->set(compact('vote', 'posts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Vote id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vote = $this->Votes->get($id);
        if ($this->Votes->delete($vote)) {
            $this->Flash->success(__('The vote has been deleted.'));
        } else {
            $this->Flash->error(__('The vote could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
