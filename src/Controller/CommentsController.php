<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Comments Controller
 *
 * @property \App\Model\Table\CommentsTable $Comments
 *
 * @method \App\Model\Entity\Comment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CommentsController extends AppController
{
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['add']);
    }

    public function reviewComment($id = null) {
        $this->autoRender = false;

        $comment = $this->Comments->get($id);
        $comment->active = true;

        if ($this->Comments->save($comment))
            $this->Flash->success(__('The comment #'.$comment->id.' has been revived successfully.'));
        else
            $this->Flash->error(__('Server went wrong. Try again later!'));

        return $this->redirect($this->request->referer());
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
        $comments = $this->paginate($this->Comments);

        $this->set(compact('comments'));
    }

    /**
     * View method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $comment = $this->Comments->get($id, [
            'contain' => ['Posts', 'Replies']
        ]);

        $this->set('comment', $comment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $this->autoRender = false;
        $comment = $this->Comments->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $post = $this->Comments->Posts->get($data['post_id'], ['fields' => ['title']]);

            if (strlen(trim($data['content'])) == 0) {
                $this->Flash->error(__('Oops! Your comment seems to be blank. Please provide some content to continue.'));
                return $this->redirect(['controller' => 'Posts', 'action' => 'view', $data['post_id']]);
            }
            else if (!$this->checkWhiteSpaceString($data['content'])) {
                $this->Flash->error(__('Oops! Your comment seems to be bad formatted or all whitespaced. Please take a look at it again.'));
                return $this->redirect(['controller' => 'Posts', 'action' => 'view', $data['post_id']]);
            }
            else {
                $comment = $this->Comments->patchEntity($comment, $data);
                if ($this->Comments->save($comment)) {
                    $this->sendConfirmation(3, $data['commenter_email'], ['name' => $data['commenter_name'], 'post_title' => $post->title, 'content' => $data['content']]);

                    $this->Flash->success(__('Hooray! Your comment has been posted. It will be reviewed by admin before being officially published. Thanks for your interest!'));
                    return $this->redirect(['controller' => 'Posts', 'action' => 'view', $data['post_id']]);
                }

                $this->Flash->error('Oops! Something went wrong with the server. Please try again later.');
                return $this->redirect(['controller' => 'Posts', 'action' => 'view', $data['post_id']]);
            }
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit() {
        $this->autoRender = false;
        $id = $this->request->query('cid');
        $pid = $this->request->query('pid');

        $comment = $this->Comments->get($id);
        $replies = array();

        if ($pid == 1)
            $comment->active = false;
        else if ($pid == 2) {
            $comment->active = false;
            $replies = $this->Comments->Replies->find('all', ['conditions' => ['comment_id' => $id, 'active' => true]])->toArray();

            if ($replies) {
                foreach ($replies as &$reply)
                    $reply->active = false;

                unset($reply);
            }
        }
        else
            $comment->status = true;

        $i = 0;
        if ($this->Comments->save($comment)) {
            if ($pid == 2) {
                if ($replies) {
                    $success = true;
                    foreach ($replies as $reply) {
                        if ($this->Comments->Replies->save($reply))
                            $i++;
                        else {
                            $success = false;
                            break;
                        }
                    }

                    if ($success)
                        $this->Flash->success(__('The comment #' . $comment->id . ' and all of its replies ('.count($replies).') have been suspended successfully.'));
                    else
                        $this->Flash->warning('The comment #' . $comment->id . ' has been suspended but some of its replies ('.count($replies) - $i.'/'.count($replies).') was failed to suspend.');
                }
                else
                    $this->Flash->success(__('The comment #' . $comment->id . ' has been suspended successfully. No active replies found.'));
            }
            else
                $this->Flash->success(__('The comment #' . $comment->id . ' has been ' . ($pid ? 'suspended' : 'approved') . ' successfully.'));
        }
        else
            $this->Flash->error(__('Server went wrong. Try again later!'));

        return $this->redirect($this->request->referer());
    }

    /**
     * Delete method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->autoRender = false;

        $this->request->allowMethod(['post', 'delete']);
        $comment = $this->Comments->get($id);

        if ($this->Comments->delete($comment))
            $this->Flash->success(__('The comment and its associated replies have been deleted.'));
        else
            $this->Flash->error(__('The comment could not be deleted. Please, try again.'));

        return $this->redirect($this->request->referer());
    }
}
