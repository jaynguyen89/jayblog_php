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

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Mailer\Email;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    const POST_TYPES = [1 => 'Web Application', 2 => 'Computer Application', 3 => 'iOS Application', 4 => 'Android Application', 5 => 'Programming Language', 6 => 'Frameworks',
        7 => 'APIs', 8 => 'Tools & Software', 9 => 'Server & Clouds', 10 => 'Version Control', 11 => 'IT News', 12 => 'Tips & Tricks'];

    public $helpers = ['Gravatar' => [
        'className' => 'GravatarHelper.Gravatar'
    ]];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'view'
            ],
            'logoutRedirect' => [
                'controller' => 'Posts',
                'action' => 'index', 'home'
            ]
        ]);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event) {
        $this->Auth->allow(['login']);
    }

    public function beforeRender(Event $event) {
        $years = $this->readDatabase('SELECT DISTINCT YEAR(created_on) as created FROM Posts WHERE YEAR(created_on) <> 0;');

        $postCountsByTime = array();
        $yearField = array();
        for ($i = 0; $i < count($years); $i++) {
            foreach (parent::MONTHS as $number => $month):
                $key = $number . '-' . $years[$i]['created'];

                $conditions = ['YEAR(created_on)' => $years[$i]['created'], 'MONTH(created_on)' => $number];
                $postCountsByTime[$key] = TableRegistry::get('Posts')->find('all', ['conditions' => $conditions])->count();
            endforeach;

            $yearField[$i] = $years[$i]['created'];
        }

        $this->set(compact('yearField', 'postCountsByTime'));
        $this->set('months', parent::MONTHS);

        return parent::beforeRender($event);
    }

    public function isAuthorized($user) {
        return isset($user) ? true : false;
    }

    public function readDatabase($query) {
        $connection = ConnectionManager::get('default');
        $statement = $connection->prepare($query);
        $statement->execute();
        $data = $statement->fetchAll('assoc');

        return $data;
    }

    public function checkWhiteSpaceString($sentence) {
        $whiteSpaces = substr_count($sentence, ' ') + substr_count($sentence, '&nbsp');
        $ratio = $whiteSpaces*1.0/strlen($sentence);

        return $ratio < parent::SPACETOCHAR_RATIO;
    }

    public function sendConfirmation($form = 0, $recipient = null, $data = null) {
        $email = new Email();
        $email->transport('gmail')
            ->template($form == 3 ? 'comment' : 'default')
            ->emailFormat('html')
            ->viewVars(['form' => $form, 'receiver' => $data['name'], 'postTitle' => $data['post_title'], 'message' => $data['content']])
            ->from(['nguyen.le.kim.phuc@gmail.com' => 'Jay Developer'])
            ->to($recipient)
            ->subject('[Jay\'s Blog] Thanks for your '.($form == 3 ? 'comment!' : 'message!'))
            ->send();
    }
}
