<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Distributions Controller
 *
 * @property \App\Model\Table\DistributionsTable $Distributions
 *
 * @method \App\Model\Entity\Distribution[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DistributionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Posts', 'Categories']
        ];
        $distributions = $this->paginate($this->Distributions);

        $this->set(compact('distributions'));
    }

    /**
     * View method
     *
     * @param string|null $id Distribution id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $distribution = $this->Distributions->get($id, [
            'contain' => ['Posts', 'Categories']
        ]);

        $this->set('distribution', $distribution);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $distribution = $this->Distributions->newEntity();
        if ($this->request->is('post')) {
            $distribution = $this->Distributions->patchEntity($distribution, $this->request->getData());
            if ($this->Distributions->save($distribution)) {
                $this->Flash->success(__('The distribution has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The distribution could not be saved. Please, try again.'));
        }
        $posts = $this->Distributions->Posts->find('list', ['limit' => 200]);
        $categories = $this->Distributions->Categories->find('list', ['limit' => 200]);
        $this->set(compact('distribution', 'posts', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Distribution id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $distribution = $this->Distributions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $distribution = $this->Distributions->patchEntity($distribution, $this->request->getData());
            if ($this->Distributions->save($distribution)) {
                $this->Flash->success(__('The distribution has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The distribution could not be saved. Please, try again.'));
        }
        $posts = $this->Distributions->Posts->find('list', ['limit' => 200]);
        $categories = $this->Distributions->Categories->find('list', ['limit' => 200]);
        $this->set(compact('distribution', 'posts', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Distribution id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $distribution = $this->Distributions->get($id);
        if ($this->Distributions->delete($distribution)) {
            $this->Flash->success(__('The distribution has been deleted.'));
        } else {
            $this->Flash->error(__('The distribution could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
