<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Replies Controller
 *
 * @property \App\Model\Table\RepliesTable $Replies
 *
 * @method \App\Model\Entity\Reply[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RepliesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Comments']
        ];
        $replies = $this->paginate($this->Replies);

        $this->set(compact('replies'));
    }

    /**
     * View method
     *
     * @param string|null $id Reply id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reply = $this->Replies->get($id, [
            'contain' => ['Comments']
        ]);

        $this->set('reply', $reply);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $this->autoRender = false;
        $reply = $this->Replies->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (strlen(trim($data['content'])) == 0) {
                $this->Flash->error(__('Oops! Your comment seems to be blank. Please provide some content to continue.'));
                return $this->redirect(['controller' => 'Posts', 'action' => 'view', 2]);
            }
            else if (!$this->checkWhiteSpaceString($data['content'])) {
                $this->Flash->error(__('Oops! Your comment seems to be bad formatted or all whitespaced. Please take a look at it again.'));
                return $this->redirect(['controller' => 'Posts', 'action' => 'view', 2]);
            }
            else {
                $reply = $this->Replies->patchEntity($reply, $data);
                if ($this->Replies->save($reply)) {
                    $this->Flash->success(__('Hooray! Your reply has been posted. It will be reviewed by admin before being officially published. Thank you!'));
                    return $this->redirect(['controller' => 'Posts', 'action' => 'view', 2]);
                }

                $this->Flash->error(__('Oops! Something went wrong with the server. Please try again later.'));
            }
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Reply id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reply = $this->Replies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reply = $this->Replies->patchEntity($reply, $this->request->getData());
            if ($this->Replies->save($reply)) {
                $this->Flash->success(__('The reply has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reply could not be saved. Please, try again.'));
        }
        $comments = $this->Replies->Comments->find('list', ['limit' => 200]);
        $this->set(compact('reply', 'comments'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reply id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reply = $this->Replies->get($id);
        if ($this->Replies->delete($reply)) {
            $this->Flash->success(__('The reply has been deleted.'));
        } else {
            $this->Flash->error(__('The reply could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
