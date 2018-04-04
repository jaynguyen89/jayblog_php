<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Attachments Controller
 *
 * @property \App\Model\Table\AttachmentsTable $Attachments
 *
 * @method \App\Model\Entity\Attachment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AttachmentsController extends AppController
{
    public function adminEdit() {
        $this->request->allowMethod(['post', 'put', 'patch', 'get']);

        $id = $this->request->query('pid');
        $form = $this->request->query('form');

        $post = TableRegistry::get('posts')->get($id);

        if (!$form) {
            $files = $this->Attachments->find('all', ['conditions' => ['post_id' => $post->id, 'note <>' => 0]])->toArray();

            $fileTypes = ['1' => 'Photo', '2' => 'Word', '3' => 'Excel', '4' => 'Powerpoint', '5' => 'Archive',
                '6' => 'Code', '7' => 'PDF', '8' => 'Video', '9' => 'Audio', '10' => 'Others'];

            if ($this->request->is('post')) {
                $data = $this->request->getData();

                if (count($data['fileid']) == count($files)) {
                    $editedFiles = $this->findEditedFiles($data, $files);

                    if ($editedFiles) {
                        $result = true;
                        foreach ($editedFiles as $editedFile):
                            if ($this->Attachments->save($editedFile))
                                continue;
                            else {
                                $result = false;
                                break;
                            }
                        endforeach;

                        if ($result)
                            $this->Flash->success('All new files have been updated successfully.');
                        else
                            $this->Flash->error('Server went wrong. Some of the changes may fail to update.');
                        return $this->redirect(['controller' => 'Posts', 'action' => 'view', $id]);
                    }

                    $this->Flash->infopane('No changes has been made. Files are kept as is.');
                    return $this->redirect(['controller' => 'Posts', 'action' => 'view', $id]);
                }

                $editedFiles = $this->findEditedFiles($data, $files);
                $newFiles = $this->findNewFiles($data, count($data['fileid']) - count($files), $id);

                if ($editedFiles) {
                    $result = true;
                    foreach ($editedFiles as $editedFile):
                        if ($this->Attachments->save($editedFile))
                            continue;
                        else {
                            $result = false;
                            break;
                        }
                    endforeach;

                    if (!$result) {
                        $this->Flash->error('Server went wrong. Some of old files may be updated. New files haven\'t been saved.');
                        return $this->redirect(['controller' => 'Posts', 'action' => 'view', $id]);
                    }
                }

                $result = true;
                foreach ($newFiles as $newFile):
                    if ($this->Attachments->save($newFile))
                        continue;
                    else {
                        $result = false;
                        break;
                    }
                endforeach;

                if ($result)
                    $this->Flash->success('All files have been saved successfully.');
                else
                    $this->Flash->error('Server went wrong. Old files are updated. Some of new files have\'t been saved.');

                return $this->redirect(['controller' => 'Posts', 'action' => 'view', $id]);
            }

            $this->set(compact('form', 'post', 'fileTypes', 'files'));
        }
        else {
            $photos = $this->Attachments->find('all', ['conditions' => ['post_id' => $post->id, 'note' => 0]])->toArray();

            if ($this->request->is('post')) {
                $data = $this->request->getData();

                $editedPhotos = $this->findEditedPhotos($data, $photos);

                $newPhotos = array();
                if (count($data['fileid']) != count($photos))
                    $newPhotos = $this->findNewPhotos($data, count($data['fileid']) - count($photos), $id);

                if (!$editedPhotos && !$newPhotos) {
                    $this->Flash->infopane('No changes has been made. Photo Slides are kept as is.');
                    return $this->redirect(['controller' => 'Posts', 'action' => 'view', $id]);
                }

                $result = true;
                foreach ($editedPhotos as $editedPhoto):
                    if ($this->Attachments->save($editedPhoto))
                        continue;
                    else {
                        $result = false;
                        break;
                    }
                endforeach;

                if (!$result) {
                    $this->Flash->error('Server went wrong. Some of old photos may be updated. New photos haven\'t been saved.');
                    return $this->redirect(['controller' => 'Posts', 'action' => 'view', $id]);
                }

                foreach ($newPhotos as $newPhoto):
                    if ($this->Attachments->save($newPhoto))
                        continue;
                    else {
                        $result = false;
                        break;
                    }
                endforeach;

                if ($result)
                    $this->Flash->success('All photos have been saved successfully.');
                else
                    $this->Flash->error('Server went wrong. Old photos are updated. Some of new photos have\'t been saved.');

                return $this->redirect(['controller' => 'Posts', 'action' => 'view', $id]);
            }

            $this->set(compact('form', 'post', 'photos', 'data'));
        }
    }

    private function findEditedFiles($data, $files) {
        $editedFiles = array();
        for ($i = 0; $i < count($files); $i++) {
            if ($files[$i]->file_name != $data['filename'][$i] || $files[$i]->description != $data['filedesc'][$i] || $files[$i]->note != $data['filetype'][$i]) {
                $editedFile = $this->Attachments->newEntity();

                $editedFile->id = $files[$i]->id;
                $editedFile->post_id = $files[$i]->post_id;
                $editedFile->file_name = $data['filename'][$i];
                $editedFile->description = $data['filedesc'][$i];
                $editedFile->note = $data['filetype'][$i];

                array_push($editedFiles, $editedFile);
            }
        }

        return $editedFiles;
    }

    private function findNewFiles($data, $qty, $pid) {
        $newFiles = array();
        for ($i = 0; $i < $qty; $i++) {
            $newFile = $this->Attachments->newEntity();

            $newFile->post_id = $pid;
            $newFile->file_name = $data['filename'][count($data['fileid']) - 1 - $i];
            $newFile->description = $data['filedesc'][count($data['fileid']) - 1 - $i];
            $newFile->note = $data['filetype'][count($data['fileid']) - 1 - $i];
            $newFile->active = true;

            array_push($newFiles, $newFile);
        }

        return $newFiles;
    }

    private function findEditedPhotos($data, $photos) {
        $editedPhotos = array();
        for ($i = 0; $i < count($photos); $i++) {
            if ($photos[$i]->file_name != $data['filename'][$i] || $photos[$i]->description != $data['filedesc'][$i] || !in_array($photos[$i]->id, $data['active'])) {
                $editedPhoto = $this->Attachments->newEntity();

                $editedPhoto->id = $photos[$i]->id;
                $editedPhoto->post_id = $photos[$i]->post_id;
                $editedPhoto->file_name = $data['filename'][$i];
                $editedPhoto->description = $data['filedesc'][$i];
                $editedPhoto->active = in_array($photos[$i]->id, $data['active']);

                array_push($editedPhotos, $editedPhoto);
            }
        }

        return $editedPhotos;
    }

    private function findNewPhotos($data, $qty, $pid) {
        $newPhotos = array();
        for ($i = 0; $i < $qty; $i++) {
            $newPhoto = $this->Attachments->newEntity();

            $newPhoto->post_id = $pid;
            $newPhoto->file_name = $data['filename'][count($data['fileid']) - 1 - $i];
            $newPhoto->description = $data['filedesc'][count($data['fileid']) - 1 - $i];
            $newPhoto->note = 0;
            $newPhoto->active = true;

            array_push($newPhotos, $newPhoto);
        }

        return $newPhotos;
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
