<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
//use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

    /**
     * Displays a view
     *
     * @param array ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Network\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function display(...$path)
    {
        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }

        /*$latestPostFields = ['id', 'title', 'description', 'photo', 'up_vote', 'down_vote', 'status', 'created_on', 'updated_on'];
        $latestPostConditions = ['ABS(DATEDIFF(NOW(), POSTS.created_on)) <=' => '90', 'POSTS.status <' => '2'];
        $latestPosts = TableRegistry::get('Posts')->find('all', ['conditions' => $latestPostConditions, 'fields' => $latestPostFields])->toArray();

        unset($latestPostFields);
        unset($latestPostConditions);

        $commentsByPost = array();
        $likesByPost = array();
        $categoriesByPost = array();
        foreach ($latestPosts as $latestPost):
            $commentsByPost[$latestPost->id] = TableRegistry::get('Comments')->find('all', ['conditions' => ['post_id' => $latestPost->id]])->count();
            $likesByPost[$latestPost->id] = ($latestPost->up_vote - $latestPost->down_vote < 0) ? 0 : $latestPost->up_vote - $latestPost->down_vote;
            $typesByPost = TableRegistry::get('Distributions')->find('all', ['conditions' => ['post_id' => $latestPost->id]])->toArray();

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
        ])->toArray();

        $oldPostFields = ['id', 'title', 'created_on'];
        $order = ['POSTS.created_on' => 'DESC'];
        $oldPosts = TableRegistry::get('Posts')->find('all', [
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

            $oldPostMainDistribution = TableRegistry::get('Distributions')->find('all', ['conditions' => ['post_id' => $oldPost->id, 'main' => true]])->toArray();
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
            'oldInterestPosts', 'oldProjectPosts', 'oldOtherPosts', 'proposedPosts'));*/
    }

    public function contact() {

    }
}
