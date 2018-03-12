<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Messages Controller
 *
 * @property \App\Model\Table\MessagesTable $Messages
 *
 * @method \App\Model\Entity\Message[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MessagesController extends AppController
{
    public function suggestProject() {
        $this->autoRender = false;
        $message = $this->Messages->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (strlen(trim($data['content'])) == 0) {
                $this->Flash->error(__('Oops! Your '.($data['form_id'] ? 'feature' : 'project').' suggestion seems to be blank. Please provide some content to continue.'));
                return $this->redirect('/');
            }
            else if (!$this->checkWhiteSpaceString($data['content'])) {
                $this->Flash->error(__('Oops! Your '.($data['form_id'] ? 'feature' : 'project').' suggestion seems to be bad formatted or all whitespaced. Please take a look at it again.'));
                return $this->redirect('/');
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
                    return $this->redirect('/');
                }

                $this->Flash->error(__('Oops! Something went wrong with the server. Please try again later.'));
            }
        }
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
    public function view($id = null)
    {
        $message = $this->Messages->get($id, [
            'contain' => ['Posts']
        ]);

        $this->set('message', $message);
    }

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

        $this->set(compact('message'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $message = $this->Messages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $message = $this->Messages->patchEntity($message, $this->request->getData());
            if ($this->Messages->save($message)) {
                $this->Flash->success(__('The message has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The message could not be saved. Please, try again.'));
        }
        $posts = $this->Messages->Posts->find('list', ['limit' => 200]);
        $this->set(compact('message', 'posts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $message = $this->Messages->get($id);
        if ($this->Messages->delete($message)) {
            $this->Flash->success(__('The message has been deleted.'));
        } else {
            $this->Flash->error(__('The message could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
