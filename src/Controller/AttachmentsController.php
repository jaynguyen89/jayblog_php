<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Attachments Controller
 *
 * @property \App\Model\Table\AttachmentsTable $Attachments
 *
 * @method \App\Model\Entity\Attachment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AttachmentsController extends AppController
{
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
        $attachments = $this->paginate($this->Attachments);

        $this->set(compact('attachments'));
    }

    /**
     * View method
     *
     * @param string|null $id Attachment id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $attachment = $this->Attachments->get($id, [
            'contain' => ['Posts']
        ]);

        $this->set('attachment', $attachment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $attachment = $this->Attachments->newEntity();
        if ($this->request->is('post')) {
            $attachment = $this->Attachments->patchEntity($attachment, $this->request->getData());
            if ($this->Attachments->save($attachment)) {
                $this->Flash->success(__('The attachment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The attachment could not be saved. Please, try again.'));
        }
        $posts = $this->Attachments->Posts->find('list', ['limit' => 200]);
        $this->set(compact('attachment', 'posts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Attachment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit() {
        $this->autoRender = false;

        if ($this->request->is('post'))
            $data = $this->request->getData();

        $result = true;
        if (!$data['file_id'])
            $this->Flash->error('No file has been selected to revive.');
        else {
            foreach ($data['file_id'] as $id):
                $file= $this->Attachments->get($id);
                $file->active = true;

                if ($this->Attachments->save($file))
                    continue;
                else {
                    $result = false;
                    break;
                }
            endforeach;
        }

        if ($result)
            $this->Flash->success('All selected files have been revived successfully. Total: '.(count($data['file_id']) == 1 ? '1 file' : count($data['file_id']).' files').'.');
        else
            $this->Flash->error('An error has been occurred during processing the request. Try again later.');

        $this->redirect($this->request->referer());
    }

    /**
     * Delete method
     *
     * @param string|null $id Attachment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $attachment = $this->Attachments->get($id);
        if ($this->Attachments->delete($attachment)) {
            $this->Flash->success(__('The attachment has been deleted.'));
        } else {
            $this->Flash->error(__('The attachment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
