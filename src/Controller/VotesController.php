<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Security;
use Cake\Event\Event;

/**
 * Votes Controller
 *
 * @property \App\Model\Table\VotesTable $Votes
 *
 * @method \App\Model\Entity\Vote[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VotesController extends AppController
{
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['add']);
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
    public function add() {
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

    /**
     * Edit method
     *
     * @param string|null $id Vote id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $this->autoRender = false;
        $votes = $this->Votes->find('all', ['conditions' => ['post_id' => $id, 'active' => true]])->toArray();

        $result = true;
        foreach ($votes as $vote):
            $vote->active = false;
            if ($this->Votes->save($vote))
                continue;
            else {
                $result = false;
                break;
            }
        endforeach;


        if ($result)
            $this->Flash->success(__('All votes have been reset successfully.'));
        else
            $this->Flash->error(__('Server went wrong. Some votes haven\'t been reset. Try again later.'));

        return $this->redirect(['controller' => 'Posts', 'action' => 'view', $id]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Vote id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->autoRender = false;
        $this->request->allowMethod(['post', 'delete']);

        $votes = $this->Votes->find('all', ['conditions' => ['post_id' => $id, 'active' => true], 'fields' => ['id']])->toArray();

        $result = true;
        foreach ($votes as $vote):
            if ($this->Votes->delete($vote))
                continue;
            else {
                $result = false;
                break;
            }
        endforeach;


        if ($result)
            $this->Flash->success(__('All votes have been reset successfully.'));
        else
            $this->Flash->error(__('Server went wrong. Some votes haven\'t been reset. Try again later.'));

        return $this->redirect(['controller' => 'Posts', 'action' => 'view', $id]);
    }
}
