<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 *
 * @method \App\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PostsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $latestPostFields = ['id', 'title', 'description', 'photo', 'up_vote', 'down_vote', 'status', 'created_on', 'updated_on'];
        $latestPostConditions = ['ABS(DATEDIFF(NOW(), POSTS.created_on)) <=' => '90', 'POSTS.status <' => '2'];
        $latestPosts = $this->Posts->find('all', ['conditions' => $latestPostConditions, 'fields' => $latestPostFields])->toArray();

        unset($latestPostFields);
        unset($latestPostConditions);

        $commentsByPost = array();
        $likesByPost = array();
        $categoriesByPost = array();
        foreach ($latestPosts as $latestPost):
            $commentsByPost[$latestPost->id] = $this->Posts->Comments->find('all', ['conditions' => ['post_id' => $latestPost->id]])->count();
            $likesByPost[$latestPost->id] = ($latestPost->up_vote - $latestPost->down_vote < 0) ? 0 : $latestPost->up_vote - $latestPost->down_vote;
            $typesByPost = $this->Posts->Distributions->find('all', ['conditions' => ['post_id' => $latestPost->id]])->toArray();

            for ($i = 0; $i < count($typesByPost); $i++) {
                $categoriesByPost[$i] = array();
                array_push($categoriesByPost[$i], TableRegistry::get('Categories')->get($typesByPost[$i]->category_id));

                $typesByPost[$i]->main ? array_push($categoriesByPost[$i], true) : array_push($categoriesByPost[$i], false);
            }

            unset($typesByPost);
        endforeach;

        /*$oldPostFields = ['Posts.title', 'Categories.title', 'Categories.description'];
        $oldPostConditions = ['Posts.id' => 'Distributions.post_id',
                              'Distributions.category_id' => 'Categories.id',
                              'ABS(DATEDIFF(NOW(), Posts.created_on)) >' => '90',
                              'Distributions.main' => true];
        $oldPosts = $this->Posts->find('all', [
            'fields' => $oldPostFields,
            'type' => 'LEFT JOIN',
            'contain' => ['Distributions', 'Categories'],
            'conditions' => $oldPostConditions,
            'group' => 'Categories.id',
            'order' => ['Posts.created_on' => 'DESC'],
            'limit' => 5
        ])->toArray();*/

        $oldPostFields = ['id', 'title', 'created_on'];
        $order = ['POSTS.created_on' => 'DESC'];
        $oldPosts = $this->Posts->find('all', [
            'conditions' => ['ABS(DATEDIFF(NOW(), POSTS.created_on)) >' => '90'],
            'fields' => $oldPostFields,
            'order' => $order
        ])->toArray();

        $oldInterestPosts = array();
        $oldProjectPosts = array();
        $oldOtherPosts = array();
        $proposedPosts = array();

        foreach ($oldPosts as $oldPost):
            if (count($oldInterestPosts) == 5 && count ($oldProjectPosts) == 5 &&
                count($oldOtherPosts) == 5 && count($proposedPosts) == 5)
                break;

            $oldPostMainDistribution = $this->Posts->Distributions->find('all', ['conditions' => ['post_id' => $oldPost->id, 'main' => true]])->toArray();
            $oldPostType = TableRegistry::get('Categories')->get($oldPostMainDistribution[0]->category_id);

            $oldPost['category'] = $oldPostType->title;
            $oldPost['description'] = $oldPostType->description;

            switch ($oldPostType->type):
                case 0:
                    if (count($oldInterestPosts) == 5)
                        continue;

                    array_push($oldInterestPosts, $oldPost);
                    break;
                case 1:
                    if (count($oldProjectPosts) == 5)
                        continue;

                    array_push($oldProjectPosts, $oldPost);
                    break;
                case 2:
                    if (count($oldOtherPosts) == 5)
                        continue;

                    array_push($oldOtherPosts, $oldPost);
                    break;
                default:
                    if (count($proposedPosts) == 5)
                        continue;

                    array_push($proposedPosts, $oldPost);
                    break;
            endswitch;
        endforeach;

        $this->set(compact('latestPosts', 'commentsByPost', 'likesByPost', 'categoriesByPost',
            'oldInterestPosts', 'oldProjectPosts', 'oldOtherPosts', 'proposedPosts'));
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $post = $this->Posts->get($id, [
            'contain' => ['Comments', 'Distributions', 'Files', 'Messages']
        ]);

        $this->set('post', $post);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $post = $this->Posts->newEntity();
        if ($this->request->is('post')) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post could not be saved. Please, try again.'));
        }
        $this->set(compact('post'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $post = $this->Posts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post could not be saved. Please, try again.'));
        }
        $this->set(compact('post'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $post = $this->Posts->get($id);
        if ($this->Posts->delete($post)) {
            $this->Flash->success(__('The post has been deleted.'));
        } else {
            $this->Flash->error(__('The post could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
