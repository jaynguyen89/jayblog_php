<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 *
 * @method \App\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PostsController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['index', 'view', 'androidProject', 'apiInterest', 'cloudOthers', 'computerProject', 'frameworkInterest',
            'iosProject', 'newsOthers', 'programmingInterest', 'projectSearch', 'softwareInterest', 'tiptrickOthers', 'webProject']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $latestPostFields = ['id', 'title', 'description', 'photo', 'status', 'created_on', 'updated_on'];
        $latestPostConditions = ['ABS(DATEDIFF(NOW(), POSTS.created_on)) <=' => '90', 'POSTS.status <' => '2', 'active' => true];
        $latestPosts = $this->Posts->find('all', ['conditions' => $latestPostConditions, 'fields' => $latestPostFields])->toArray();

        unset($latestPostFields);
        unset($latestPostConditions);

        $commentsByPost = array();
        $likesByPost = array();
        $categoriesByPost = array();
        foreach ($latestPosts as $latestPost):
            $commentsByPost[$latestPost->id] = $this->Posts->Comments->find('all', ['conditions' => ['post_id' => $latestPost->id, 'active' => true]])->count();

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
            'conditions' => ['ABS(DATEDIFF(NOW(), POSTS.created_on)) >' => '90', 'POSTS.status <' => '3', 'active' => true],
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
        $votesByPost = $this->Posts->Votes->find('all', ['conditions' => ['post_id' => $postId, 'active' => true]]);
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

        $photos = $this->Posts->Attachments->find('all', ['conditions' => ['post_id' => $post->id, 'note' => 0, 'active' => true]])->toArray();
        $attachments = $this->Posts->Attachments->find('all', ['conditions' => ['post_id' => $post->id, 'note <>' => 0, 'active' => true]])->toArray();

        $query = $this->prepareQuery($post->id, 2);

        $suggestedPosts = $this->readDatabase($query);
        $comments = $this->Posts->Comments->find('all', ['conditions' => ['post_id' => $post->id, 'active' => true], 'order' => ['COMMENTS.comment_date' => 'DESC']])->toArray();
        $repliesByComment = array();

        foreach ($comments as $comment)
            $repliesByComment[$comment->id] = $this->Posts->Comments->Replies->find('all', ['conditions' => ['comment_id' => $comment->id, 'active' => true], 'order' => ['REPLIES.reply_date' => 'DESC']])->toArray();

        $postDate = new \DateTime($post->created_on);
        $now = Time::now();

        $diff = $now->diff($postDate)->days;
        $isCommentable = $diff > 180 ? false : true;

        $this->set(compact('post', 'categories', 'photos', 'attachments', 'suggestedPosts', 'comments', 'repliesByComment', 'isCommentable'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $post = $this->Posts->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if ($data['context']) {
                $data['created_on'] = null;
                $data['updated_on'] = null;
            }

            $post = $this->Posts->patchEntity($post, $data);
            if ($this->Posts->save($post)) {
                $post = $this->readDatabase('SELECT MAX(id) as `id` FROM posts;');
                $this->Flash->success(__('The new post has been saved.'));

                return $this->redirect(['action' => 'view', $post[0]['id']]);
            }
            $this->Flash->error(__('Server went wrong. Please, try again.'));
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
    public function edit() {
        $this->request->allowMethod(['post', 'delete', 'put', 'patch', 'get']);

        $id = $this->request->query('pid');
        $form = $this->request->query('form');

        $post = $this->Posts->get($id);
        $categories = array();
        $postCateIds = array();
        $mainCate = array();

        if ($form) {
            $categories = TableRegistry::get('Categories')->find('all')->toArray();
            foreach ($categories as $category)
                $mainCate[$category['id']] = false;

            $postCategories = $this->readDatabase('SELECT c.id, d.main FROM posts p, distributions d, categories c
                                                         WHERE p.id = d.post_id AND d.category_id = c.id AND p.id = '.$post->id.';');

            foreach ($postCategories as $postCategory) {
                array_push($postCateIds, $postCategory['id']);
                $mainCate[$postCategory['id']] = $postCategory['main'];
            }
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($form) {
                $data = $this->request->getData();
                $post = $this->Posts->patchEntity($post, $data);

                $post->photo = ($data['photo'] == '' ? 'pending.jpeg' : $data['photo']);

                if ($this->Posts->save($post)) {
                    $discardedCategories = array();
                    foreach ($postCateIds as $postCateId):
                        if (!in_array($postCateId, $data['category']))
                            array_push($discardedCategories, $postCateId);
                    endforeach;

                    $newPostCategories = array();
                    foreach ($data['category'] as $category):
                        if (!in_array($category, $postCateIds))
                            array_push($newPostCategories, $category);
                    endforeach;

                    if ($discardedCategories) {
                        foreach ($discardedCategories as $discardedCategory):
                            $distribution = $this->Posts->Distributions->find('all', ['conditions' => ['post_id' => $post->id, 'category_id' => $discardedCategory]])->first();

                            if ($this->Posts->Distributions->delete($distribution))
                                continue;
                            else {
                                $this->Flash->error('Post has been updated but some categories may fail to update.');
                                return $this->redirect(['action' => 'view', $post->id]);
                            }
                        endforeach;
                    }

                    if ($newPostCategories) {
                        foreach ($newPostCategories as $newPostCategory):
                            $distData = array();
                            $distData['post_id'] = $post->id;
                            $distData['category_id'] = $newPostCategory;
                            $distData['main'] = ($data['main'] == $newPostCategory ? true : false);

                            $distribution = $this->Posts->Distributions->newEntity();
                            $distribution = $this->Posts->Distributions->patchEntity($distribution, $distData);

                            if ($this->Posts->Distributions->save($distribution))
                                continue;
                            else {
                                $this->Flash->error('Post has been updated but some categories may fail to update.');
                                return $this->redirect(['action' => 'view', $post->id]);
                            }
                        endforeach;
                    }

                    $remainedCategories = array_intersect($data['category'], $postCateIds);
                    if ($remainedCategories) {
                        foreach ($remainedCategories as $remainedCategory):
                            $distribution = $this->Posts->Distributions->find('all', ['conditions' => ['post_id' => $post->id, 'category_id' => $remainedCategory]])->first();

                            $distribution->main = ($data['main'] == $remainedCategory ? true : false);
                            if ($this->Posts->Distributions->save($distribution))
                                continue;
                            else {
                                $this->Flash->error('Post has been updated but some categories may fail to update.');
                                return $this->redirect(['action' => 'view', $post->id]);
                            }
                        endforeach;
                    }

                    $this->Flash->success(__('The post and its categories have been editted successfully.'));
                    return $this->redirect(['action' => 'view', $post->id]);
                }

                $this->Flash->error(__('Server went wrong. Try again later.'));
            }
            else {
                $post = $this->Posts->patchEntity($post, $this->request->getData());

                if ($this->Posts->save($post)) {
                    $this->Flash->success(__('The post has been editted successfully.'));
                    return $this->redirect(['action' => 'view', $post->id]);
                }

                $this->Flash->error(__('Server went wrong. Try again later.'));
            }
        }

        $this->set(compact('post', 'form', 'categories', 'postCateIds', 'mainCate'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->autoRender = false;
        $this->request->allowMethod(['post', 'delete']);

        $post = $this->Posts->get($id);
        $post->active = false;

        if ($this->Posts->save($post))
            $this->Flash->success(__('The post has been suspended successfully.'));
        else
            $this->Flash->error(__('Server went wrong. Try again later.'));

        return $this->redirect($this->request->referer());
    }

    public function revive($id = null) {
        $this->autoRender = false;
        $post = $this->Posts->get($id);
        $post->active = true;

        if ($this->Posts->save($post))
            $this->Flash->success('Hooray! The post #'.$post->id.' has been revived successfully.');
        else
            $this->Flash->error('Server went wrong. Try again later.');

        return $this->redirect($this->request->referer());
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
                                                WHERE p.title LIKE \'%'.$keyword.'%\'
                                                AND p.active = true;');

                    if ($records) {
                        foreach ($records as $record)
                            array_push($posts, $record);
                    }
                endforeach;
            }
            else {
                $this->Flash->error(__('Oops! The keyword seems to be all whitespaces. Please remove some!'));
                $this->redirect($this->request->referer());
            }
        }
        else {
            $years = $this->readDatabase('SELECT DISTINCT YEAR(created_on) as created FROM Posts WHERE YEAR(created_on) <> 0 AND active = true;');
            $yearField = array();
            for ($i = 0; $i < count($years); $i++)
                $yearField[$i] = $years[$i]['created'];

            $posts = $this->readDatabase('SELECT p.id, p.title as ptitle, p.description as pdesc, p.status, p.photo, p.created_on
                                                FROM posts p 
                                                WHERE YEAR(created_on) = '.$yearField[$data['year']].' 
                                                AND MONTH(created_on) = '.$data['month'].'
                                                AND p.active = true;');
        }

        $categoriesByPost = array();
        if ($posts) {
            foreach ($posts as $post):
                $query = $this->prepareQuery($post['id'], 1);
                $categoriesByPost[$post['id']] = $this->readDatabase($query);
            endforeach;
        }

        $this->set(compact('posts', 'categoriesByPost', 'data', 'yearField'));
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
                        AND p.active = true
                        ORDER BY p.created_on DESC;';
                break;
            case 1:
                $query = 'SELECT c.title as ctitle, c.description as cdesc, d.main
                        FROM Posts p, Categories c, Distributions d
                        WHERE p.id = d.post_id
                        AND c.id = d.category_id
                        AND p.id = '.$data.'
                        AND p.active = true;';
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
                        AND Posts.active = true
                        ORDER BY RAND(), Posts.created_on DESC
                        LIMIT 5;';
                break;
        endswitch;

        return $query;
    }
}
