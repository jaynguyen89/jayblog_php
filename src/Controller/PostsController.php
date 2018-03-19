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

        $query = $this->prepareQuery($post->id, 2);

        $suggestedPosts = $this->readDatabase($query);
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

    private function getCategoriesByPost($posts) {

        $categoriesByPost = array();
        foreach ($posts as $post):
            $query = $this->prepareQuery($post['id'], 1);
            $categoriesByPost[$post['id']] = $this->readDatabase($query);
        endforeach;

        return $categoriesByPost;
    }

    public function programmingInterest() {
        $query = $this->prepareQuery(array_search('Programming Language', parent::POST_TYPES), 0);

        $posts = $this->readDatabase($query);
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function frameworkInterest() {
        $query = $this->prepareQuery(array_search('Frameworks', parent::POST_TYPES), 0);

        $posts = $this->readDatabase($query);
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function apiInterest() {
        $query = $this->prepareQuery(array_search('APIs', parent::POST_TYPES), 0);

        $posts = $this->readDatabase($query);
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function softwareInterest() {
        $query = $this->prepareQuery(array_search('Tools & Software', parent::POST_TYPES), 0);

        $posts = $this->readDatabase($query);
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function webProject() {
        $query = $this->prepareQuery(array_search('Web Application', parent::POST_TYPES), 0);

        $posts = $this->readDatabase($query);
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function computerProject() {
        $query = $this->prepareQuery(array_search('Computer Application', parent::POST_TYPES), 0);

        $posts = $this->readDatabase($query);
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function iosProject() {
        $query = $this->prepareQuery(array_search('iOS Application', parent::POST_TYPES), 0);

        $posts = $this->readDatabase($query);
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function androidProject() {
        $query = $this->prepareQuery(array_search('Android Application', parent::POST_TYPES), 0);

        $posts = $this->readDatabase($query);
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function cloudOthers() {
        $query = $this->prepareQuery(array_search('Server & Clouds', parent::POST_TYPES), 0);

        $posts = $this->readDatabase($query);
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function newsOthers() {
        $query = $this->prepareQuery(array_search('IT News', parent::POST_TYPES), 0);

        $posts = $this->readDatabase($query);
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function tiptrickOthers() {
        $query = $this->prepareQuery(array_search('Tips & Tricks', parent::POST_TYPES), 0);

        $posts = $this->readDatabase($query);
        $categoriesByPost = $this->getCategoriesByPost($posts);

        $this->set(compact('posts', 'categoriesByPost'));
    }

    public function projectSearch() {
        $data = $this->request->getData();
        $posts = array();

        if ($data['form_id'] == 0) {
            if ($this->checkWhiteSpaceString($data['keyword'])) {
                $keywords = explode(' ', $data['keyword']);

                foreach ($keywords as $keyword):
                    $records = $this->readDatabase('SELECT p.id, p.title as ptitle, p.description as pdesc, p.status, p.photo, p.created_on
                                                FROM posts p 
                                                WHERE p.title LIKE \'%'.$keyword.'%\'');

                    if ($records) {
                        foreach ($records as $record)
                            array_push($posts, $record);
                    }
                endforeach;
            }
            else {
                $this->Flash->error(__('Oops! The keyword seems to be all whitespaces. Please remove some!'));
                $this->redirect($this->referer());
            }
        }
        else {
            $years = $this->readDatabase('SELECT DISTINCT YEAR(created_on) as created FROM Posts WHERE YEAR(created_on) <> 0;');
            $yearField = array();
            for ($i = 0; $i < count($years); $i++)
                $yearField[$i] = $years[$i]['created'];

            $posts = $this->readDatabase('SELECT p.id, p.title as ptitle, p.description as pdesc, p.status, p.photo, p.created_on
                                                FROM posts p 
                                                WHERE YEAR(created_on) = '.$yearField[$data['year']].' 
                                                AND MONTH(created_on) = '.$data['month'].';');
        }

        $categoriesByPost = array();
        if ($posts) {
            foreach ($posts as $post):
                $query = $this->prepareQuery($post['id'], 1);
                $categoriesByPost[$post['id']] = $this->readDatabase($query);
            endforeach;
        }

        $this->set(compact('posts', 'categoriesByPost', 'data', 'yearField', 'keywords'));
    }

    private function prepareQuery($data, $context) {
        switch ($context):
            case 0:
                $query = 'SELECT p.id, p.title as ptitle, p.description as pdesc, p.status, p.photo, p.created_on
                        FROM Posts p, Categories c, Distributions d
                        WHERE p.id = d.post_id
                        AND c.id = d.category_id
                        AND c.id = '.$data.'
                        AND d.main = 1
                        ORDER BY p.created_on DESC;';
                break;
            case 1:
                $query = 'SELECT c.title as ctitle, c.description as cdesc, d.main
                        FROM Posts p, Categories c, Distributions d
                        WHERE p.id = d.post_id
                        AND c.id = d.category_id
                        AND p.id = '.$data.';';
                break;
            default:
                $query = 'SELECT Posts.id, Posts.title, status, created_on, main, Categories.title as ctitle, Categories.description
                        FROM Posts Posts, Distributions Distributions, Categories Categories
                        WHERE Posts.id = Distributions.post_id
                        AND Distributions.category_id = Categories.id
                        AND Distributions.main = 1
                        AND Posts.id <> 1
                        AND Posts.id <> '.$data.'
                        AND Posts.status <> 2
                        ORDER BY RAND(), Posts.created_on DESC
                        LIMIT 5;';
                break;
        endswitch;

        return $query;
    }
}
