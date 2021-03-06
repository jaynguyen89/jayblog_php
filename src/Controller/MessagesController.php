<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Messages Controller
 *
 * @property \App\Model\Table\MessagesTable $Messages
 *
 * @method \App\Model\Entity\Message[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MessagesController extends AppController
{
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['add', 'suggestProject', 'view']);
    }

    public function reviewMessage($id = null) {
        $this->autoRender = false;
        $message = $this->Messages->get($id);

        $message->active = true;

        if ($this->Messages->save($message))
            $this->Flash->success(__('The suggestion #'.$message->id.' has been revived successfully.'));
        else
            $this->Flash->error(__('Server went wrong. Try again later!'));

        return $this->redirect($this->request->referer());
    }

    public function suggestProject() {
        $this->autoRender = false;
        $message = $this->Messages->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (strlen(trim($data['content'])) == 0) {
                $this->Flash->error(__('Oops! Your '.($data['form_id'] ? 'feature' : 'project').' suggestion seems to be blank. Please provide some content to continue.'));
                return $this->redirect($this->request->referer());
            }
            else if (!$this->checkWhiteSpaceString($data['content'])) {
                $this->Flash->error(__('Oops! Your '.($data['form_id'] ? 'feature' : 'project').' suggestion seems to be bad formatted or all whitespaced. Please take a look at it again.'));
                return $this->redirect($this->request->referer());
            }
            else {
                if ($data['form_id'] == 0) {
                    $data['post_id'] = 1;
                    $data['type'] = 2;
                }
                else
                    $data['type'] = 1;

                $message = $this->Messages->patchEntity($message, $data);
                if ($this->Messages->save($message)) {
                    if ($data['sender_email'])
                        //$this->sendConfirmation(1, $data['sender_email'], ['name' => $data['sender_name'], 'post_title' => null, 'content' => $data['content']]);

                    $this->Flash->success(__('Hooray! Your '.($data['form_id'] ? 'feature' : 'project').' suggestion has been sent successfully.'));
                    return $this->redirect($this->request->referer());
                }

                $this->Flash->error(__('Oops! Something went wrong with the server. Please try again later.'));
            }
        }
    }

    public function highlighter() {
        $this->autoRender = false;
        $id = $this->request->query('sid');
        $pid = $this->request->query('form');

        $message = $this->Messages->get($id);

        if ($pid)
            $message->is_oppened = false;
        else
            $message->flagged = true;

        if ($this->Messages->save($message))
            $this->Flash->success('The suggestion #'.$message->id.' has been '.($pid ? 'marked as unopened' : 'highlighted').' successfully.');
        else
            $this->Flash->error('Server went wrong. Try again later.');

        return $this->redirect($this->request->referer());
    }

    public function lowlighter() {
        $this->autoRender = false;
        $id = $this->request->query('sid');
        $pid = $this->request->query('form');

        $message = $this->Messages->get($id);

        if ($pid) {
            $message->active = false;
            $message->flagged = false;
        }
        else
            $message->flagged = false;

        if ($this->Messages->save($message))
            $this->Flash->success('The suggestion #'.$message->id.' has been '.($pid ? 'lowlighted and suspended' : 'lowlighted').' successfully.');
        else
            $this->Flash->error('Server went wrong. Try again later.');

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
        $messages = $this->paginate($this->Messages);

        $this->set(compact('messages'));
    }

    /**
     * View method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) { }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $message = $this->Messages->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (strlen(trim($data['content'])) == 0) {
                $this->Flash->error(__('Oops! Your contact message seems to be blank. Please provide some content to continue.'));
                return $this->redirect(['action' => 'add']);
            }
            else if (!$this->checkWhiteSpaceString($data['content'])) {
                $this->Flash->error(__('Oops! Your contact message seems to be bad formatted or all whitespaced. Please take a look at it again.'));
                return $this->redirect(['action' => 'add']);
            }
            else {
                $data['type'] = 0;
                $data['post_id'] = 1;

                $message = $this->Messages->patchEntity($message, $data);
                if ($this->Messages->save($message)) {
                    $this->sendConfirmation(0, $data['sender_email'], ['name' => $data['sender_name'], 'post_title' => null, 'content' => $data['content']]);

                    $this->Flash->success(__('Hooray! Your contact message has been sent successfully.'));
                    return $this->redirect(['action' => 'add']);
                }

                $this->Flash->error(__('Oops! Something went wrong with the server. Please try again later.'));
            }
        }
        
        $categories = TableRegistry::get('categories')->find('all')->toArray();

        $this->set(compact('message', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit() {
        $this->autoRender = false;
        $id = $this->request->query('mid');
        $pid = $this->request->query('pid');

        $message = $this->Messages->get($id);

        if ($pid == 1)
            $message->active = false;
        else if ($pid == 0)
            $message->is_oppened = true;
        else {
            $message->is_oppened = true;
            $message->flagged = true;
        }

        if ($this->Messages->save($message)) {
            $label = ($pid == 0 ? 'marked as `opened`' : ($pid == 1 ? 'suspended' : 'highlighted'));
            $this->Flash->success(__('The suggestion #' . $message->id . ' has been ' .$label. ' successfully.'));
        }
        else
            $this->Flash->error(__('Server went wrong. Try again later!'));

        return $this->redirect($this->request->referer());
    }

    /**
     * Delete method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->autoRender = false;
        $this->request->allowMethod(['post', 'delete']);

        $message = $this->Messages->get($id);
        if ($this->Messages->delete($message))
            $this->Flash->success(__('The message has been deleted.'));
        else
            $this->Flash->error(__('The message could not be deleted. Please, try again.'));

        return $this->redirect(['action' => 'index']);
    }
}
