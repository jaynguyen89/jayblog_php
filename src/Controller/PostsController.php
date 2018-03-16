<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

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
        $latestPostFields = ['id', 'title', 'description', 'photo', 'status', 'created_on', 'updated_on'];
        $latestPostConditions = ['ABS(DATEDIFF(NOW(), POSTS.created_on)) <=' => '90', 'POSTS.status <' => '2'];
        $latestPosts = $this->Posts->find('all', ['conditions' => $latestPostConditions, 'fields' => $latestPostFields])->toArray();

        unset($latestPostFields);
        unset($latestPostConditions);

        $commentsByPost = array();
        $likesByPost = array();
        $categoriesByPost = array();
        foreach ($latestPosts as $latestPost):
            $commentsByPost[$latestPost->id] = $this->Posts->Comments->find('all', ['conditions' => ['post_id' => $latestPost->id]])->count();

            $votesByPost = $this->getVotes($latestPost->id);

            $likesByPost[$latestPost->id] = ($votesByPost['upvote'] <= $votesByPost['downvote']) ? 0 : $votesByPost['upvote'] - $votesByPost['downvote'];
            $typesByPost = $this->Posts->Distributions->find('all', ['conditions' => ['post_id' => $latestPost->id]])->toArray();

            $categoriesByPost[$latestPost->id] = array();
            for ($i = 0; $i < count($typesByPost); $i++) {
                $category = TableRegistry::get('Categories')->get($typesByPost[$i]->category_id);

                $category->main = ($typesByPost[$i]->main ? true : false);
                array_push($categoriesByPost[$latestPost->id], $category);
            }

            unset($typesByPost);
        endforeach;

        $oldPostFields = ['id', 'title', 'created_on'];
        $order = ['POSTS.created_on' => 'DESC'];
        $oldPosts = $this->Posts->find('all', [
            'conditions' => ['ABS(DATEDIFF(NOW(), POSTS.created_on)) >' => '90', 'POSTS.status <' => '3'],
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
                    if (count($oldInterestPosts) == 4)
                        continue;

                    array_push($oldInterestPosts, $oldPost);
                    break;
                case 1:
                    if (count($oldProjectPosts) == 4)
                        continue;

                    array_push($oldProjectPosts, $oldPost);
                    break;
                case 2:
                    if (count($oldOtherPosts) == 4)
                        continue;

                    array_push($oldOtherPosts, $oldPost);
                    break;
                default:
                    if (count($proposedPosts) == 4)
                        continue;

                    array_push($proposedPosts, $oldPost);
                    break;
            endswitch;
        endforeach;

        $this->set(compact('latestPosts', 'commentsByPost', 'likesByPost', 'categoriesByPost',
            'oldInterestPosts', 'oldProjectPosts', 'oldOtherPosts', 'proposedPosts'));
    }

    private function getVotes($postId) {
        $votesByPost = $this->Posts->Votes->find('all', ['conditions' => ['post_id' => $postId]]);
        $upVotes = $downVotes = 0;
        foreach ($votesByPost as $vote) {
            $upVotes += ($vote->sign) ? 1 : 0;
            $downVotes += ($vote->sign) ? 0 : 1;
        }

        return array('upvote' => $upVotes, 'downvote' => $downVotes);
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $post = $this->Posts->get($id);
        $session = $this->request->session();

        $votes = $this->getVotes($id);

        $session->write('Post.up_vote', $votes['upvote']);
        $session->write('Post.down_vote', $votes['downvote']);

        $distributions = $this->Posts->Distributions->find('all', ['conditions' => ['post_id' => $post->id]]);
        $categories = array();
        foreach ($distributions as $distribution) {
            $category = TableRegistry::get('Categories')->get($distribution->category_id);
            $category['main'] = $distribution->main;
            array_push($categories, $category);
        }

        $photos = $this->Posts->Attachments->find('all', ['conditions' => ['post_id' => $post->id, 'note' => 0]])->toArray();
        $attachments = $this->Posts->Attachments->find('all', ['conditions' => ['post_id' => $post->id, 'note <>' => 0]])->toArray();

        $connection = ConnectionManager::get('default');
        $query = 'SELECT Posts.id, Posts.title, status, created_on, main, Categories.title as ctitle, Categories.description
            FROM Posts Posts, Distributions Distributions, Categories Categories
            WHERE Posts.id = Distributions.post_id
            AND Distributions.category_id = Categories.id
            AND Distributions.main = 1
            AND Posts.id <> 1
            AND Posts.id <> '.$post->id.'
            AND Posts.status <> 2
            ORDER BY RAND(), Posts.created_on DESC
            LIMIT 5;';

        $statement = $connection->prepare($query);
        $statement->execute();
        $suggestedPosts = $statement->fetchAll('assoc');

        $comments = $this->Posts->Comments->find('all', ['conditions' => ['post_id' => $post->id], 'order' => ['COMMENTS.comment_date' => 'DESC']])->toArray();
        $repliesByComment = array();

        foreach ($comments as $comment)
            $repliesByComment[$comment->id] = $this->Posts->Comments->Replies->find('all', ['conditions' => ['comment_id' => $comment->id], 'order' => ['REPLIES.reply_date' => 'DESC']])->toArray();

        $this->set(compact('post', 'categories', 'photos', 'attachments', 'suggestedPosts', 'comments', 'repliesByComment'));
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

    private function getPostCategories($post_id) {
        $connection = ConnectionManager::get('default');
        $query = 'SELECT c.title as ctitle, c.description as cdesc, d.main
                FROM Posts p, Categories c, Distributions d
                WHERE p.id = d.post_id
                AND c.id = d.category_id
                AND p.id = '.$post_id.';';

        $statement = $connection->prepare($query);
        $statement->execute();
        $categories = $statement->fetchAll('assoc');

        return $categories;
    }

    private function getCategorizedPosts($type) {
        $connection = ConnectionManager::get('default');
        $query = 'SELECT p.id, p.title as ptitle, p.description as pdesc, p.status, p.photo, p.created_on
                FROM Posts p, Categories c, Distributions d
                WHERE p.id = d.post_id
                AND c.id = d.category_id
                AND c.id = '.$type.'
                AND d.main = 1
                ORDER BY p.created_on DESC;';

        $statement = $connection->prepare($query);
        $statement->execute();
        $posts = $statement->fetchAll('assoc');

        return $posts;
    }

    private function getCategoriesByPost($posts) {
        $categoriesByPost = array();
        foreach ($posts as $post)
            $categoriesByPost[$post['id']] = $this->getPostCategories($post['id']);

        return $categoriesByPost;
    }

    public function programmingInterest() {
        $posts = $this->getCategorizedPosts(array_search('Programming Language', parent::POST_TYPES));
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function frameworkInterest() {
        $posts = $this->getCategorizedPosts(array_search('Frameworks', parent::POST_TYPES));
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function apiInterest() {
        $posts = $this->getCategorizedPosts(array_search('APIs', parent::POST_TYPES));
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function softwareInterest() {
        $posts = $this->getCategorizedPosts(array_search('Tools & Software', parent::POST_TYPES));
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function webProject() {
        $posts = $this->getCategorizedPosts(array_search('Web Application', parent::POST_TYPES));
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function computerProject() {
        $posts = $this->getCategorizedPosts(array_search('Computer Application', parent::POST_TYPES));
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function iosProject() {
        $posts = $this->getCategorizedPosts(array_search('iOS Application', parent::POST_TYPES));
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function androidProject() {
        $posts = $this->getCategorizedPosts(array_search('Android Application', parent::POST_TYPES));
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function cloudOthers() {
        $posts = $this->getCategorizedPosts(array_search('Server & Clouds', parent::POST_TYPES));
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function newsOthers() {
        $posts = $this->getCategorizedPosts(array_search('IT News', parent::POST_TYPES));
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function tiptrickOthers() {
        $posts = $this->getCategorizedPosts(array_search('Tips & Tricks', parent::POST_TYPES));
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }
}
