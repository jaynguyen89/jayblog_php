<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Jay\'s Blog - Dare to step';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('bootstrap.min.css'); ?>
    <?= $this->Html->css('styles.css'); ?>
    <?= $this->Html->css('blocks.css'); ?>
    <?= $this->Html->css('plugins.css'); ?>
    <?= $this->Html->css('jayblog.css'); ?>

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

    <?php if (strpos($this->request->here, '/posts/view/')) { ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.5.0/themes/prism.min.css">
    <?php } ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body data-spy="scroll" data-target="nav">
<?php $session = $this->request->session();
$user = $session->read('Auth.User');
$active = (strpos($this->request->here, '/messages/add') != false ? '1' :
    (strpos($this->request->here, '/posts/view/') != false ? '-1' :
        ((strpos($this->request->here, '/posts/programming-interest') != false || strpos($this->request->here, '/posts/framework-interest') != false || strpos($this->request->here, '/posts/api-interest') != false || strpos($this->request->here, '/posts/software-interest') != false) ? '2' :
            ((strpos($this->request->here, '/posts/web-project') != false || strpos($this->request->here, '/posts/computer-project') != false || strpos($this->request->here, '/posts/ios-project') != false || strpos($this->request->here, '/posts/android-project') != false) ? '3' :
                ((strpos($this->request->here, '/posts/cloud-others') != false || strpos($this->request->here, '/posts/news-others') != false || strpos($this->request->here, '/posts/tiptrick-others') != false) ? '4' :
                    ((strpos($this->request->here, '/users/suspended-assets') != false || strpos($this->request->here, '/users/highlighted-assets') != false ) ? '5' : '0')))))); ?>
<header id="header-2" class="soft-scroll header-2">
    <nav class="main-nav navbar navbar-default navbar-fixed-top">
        <!-- Container DIV wrapping the whole navbar and staying fixed to the top of site -->
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?= $user ? $this->Html->image('jaydev.PNG', ['alt' => 'jaydeveloper', 'url' => ['controller' => 'Users', 'action' => 'view'], 'class' => 'brand-img img-responsive']) :
                    $this->Html->image('jaydev.PNG', ['alt' => 'jaydeveloper', 'url' => '/', 'class' => 'brand-img img-responsive']); ?>
            </div>

            <!-- Navbar menu containing collapsible items and links -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <?php if (!$user) { ?>
                        <li class="nav-item <?= $active == 0 ? 'active' : ''; ?>"><?= $this->Html->link(__('Home'), '/', ['class' => 'nav-link']); ?></li>
                    <?php } else { ?>
                        <li class="nav-item <?= $active == 0 ? 'active' : ''; ?>"><?= $this->Html->link(__('Home'),
                                ['controller' => 'Users', 'action' => 'view'], ['class' => 'nav-link']); ?></li>
                    <?php } ?>
                    <!-- Dropdown menu for Interests -->
                    <li class="nav-item dropdown <?= $active == 2 ? 'active' : ''; ?>">
                        <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Interests <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu" style="background-color: lightgray">
                            <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fas fa-code', 'style' => 'margin-right: 10px;']).'Programming Languages',
                                    ['controller' => 'Posts', 'action' => 'programmingInterest'], ['escape' => false]); ?></li>
                            <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fas fa-puzzle-piece', 'style' => 'margin-right: 10px;']).'Frameworks',
                                    ['controller' => 'Posts', 'action' => 'frameworkInterest'], ['escape' => false]); ?></li>
                            <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fas fa-cogs', 'style' => 'margin-right: 10px;']).'APIs',
                                    ['controller' => 'Posts', 'action' => 'apiInterest'], ['escape' => false]); ?></li>
                            <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fas fa-object-group', 'style' => 'margin-right: 10px;']).'Tools & Software',
                                    ['controller' => 'Posts', 'action' => 'softwareInterest'], ['escape' => false]); ?></li>
                        </ul>
                    </li>
                    <!-- End dropdown -->

                    <!-- Dropdown menu for Personal Projects -->
                    <li class="nav-item dropdown <?= $active == 3 ? 'active' : ''; ?>">
                        <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Projects <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu" style="background-color: lightgray">
                            <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fab fa-chrome', 'style' => 'margin-right: 10px;']).'Web Apps',
                                    ['controller' => 'Posts', 'action' => 'webProject'], ['escape' => false]); ?></li>
                            <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fas fa-laptop', 'style' => 'margin-right: 10px;']).'Computer Apps',
                                    ['controller' => 'Posts', 'action' => 'computerProject'], ['escape' => false]); ?></li>
                            <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fab fa-app-store-ios', 'style' => 'margin-right: 10px;']).'iOS Apps',
                                    ['controller' => 'Posts', 'action' => 'iosProject'], ['escape' => false]); ?></li>
                            <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fab fa-android', 'style' => 'margin-right: 10px;']).'Android Apps',
                                    ['controller' => 'Posts', 'action' => 'androidProject'], ['escape' => false]); ?></li>
                        </ul>
                    </li>
                    <!-- End dropdown -->

                    <!-- Dropdown menu for Other contents -->
                    <li class="nav-item dropdown <?= $active == 4 ? 'active' : ''; ?>">
                        <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Others <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu" style="background-color: lightgray">
                            <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fas fa-cloud-upload-alt', 'style' => 'margin-right: 10px;']).'Servers & Clouds',
                                    ['controller' => 'Posts', 'action' => 'cloudOthers'], ['escape' => false]); ?></li>
                            <!--<li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fas fa-code-branch', 'style' => 'margin-right: 10px;']).'Version Control',
                                ['controller' => 'Posts', 'action' => 'vcsOthers'], ['escape' => false]); ?></li>-->
                            <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'far fa-newspaper', 'style' => 'margin-right: 10px;']).'IT News',
                                    ['controller' => 'Posts', 'action' => 'newsOthers'], ['escape' => false]); ?></li>
                            <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'far fa-lightbulb', 'style' => 'margin-right: 10px;']).'Tips & Tricks',
                                    ['controller' => 'Posts', 'action' => 'tiptrickOthers'], ['escape' => false]); ?></li>
                        </ul>
                    </li>
                    <!-- End dropdown -->
                    <?php if (!$user) { ?>
                        <li class="nav-item <?= $active == 1 ? 'active' : ''; ?>"><?= $this->Html->link(__('About'), ['controller' => 'Messages', 'action' => 'add']); ?></li>
                    <?php } ?>
                    <li class="nav-item" style="display: none;">
                        <a href="/users/login" style="color: coral" onmouseover="this.style.color='orangered'" onmouseout="this.style.color='coral'"><i class="fa fa-user-circle" style="font-size: larger"></i> Admin Login</a>
                    </li>
                    <?php if ($user) { ?>
                        <!-- Dropdown menu for Other contents -->
                        <li class="nav-item dropdown <?= $active == 5 ? 'active' : ''; ?>">
                            <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Actions <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu" style="background-color: lightgray">
                                <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fas fa-calendar-times', 'style' => 'margin-right: 10px;']).'Suspendings',
                                        ['controller' => 'Users', 'action' => 'suspendedAssets'], ['escape' => false]); ?></li>
                                <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fas fa-flag-checkered', 'style' => 'margin-right: 10px;']).'Highlightings',
                                        ['controller' => 'Users', 'action' => 'highlightedAssets'], ['escape' => false]); ?></li>
                                <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fas fa-calendar-plus', 'style' => 'margin-right: 10px;']).'New Post',
                                        ['controller' => 'Posts', 'action' => 'add'], ['escape' => false]); ?></li>
                                <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fas fa-plus-circle', 'style' => 'margin-right: 10px;']).'New Category',
                                        ['controller' => 'Categories', 'action' => 'add'], ['escape' => false]); ?></li>
                                <li><?= $this->Html->link($this->Html->tag('i', '', ['class' => 'fas fa-user-times', 'style' => 'margin-right: 10px;']).'Sign Out',
                                        ['controller' => 'Users', 'action' => 'logout'], ['escape' => false]); ?></li>
                            </ul>
                        </li>
                        <!-- End dropdown -->
                    <?php } ?>
                </ul>
            </div>
            <!-- End navbar menu -->
        </div>
        <!-- End navbar container -->
    </nav>
</header>

<div class="container clearfix"><br/><br/><br/><br/><br/>
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>

    <?php if (!$user && (strpos($this->request->here, '/posts/') != false || Cake\Routing\Router::url('/', false) == '/')) { ?>
        <!-- This section contains the modal popup displaying a form that allows feature suggestion -->
        <div class="modal fade" id="suggestFeatureModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Popup header -->
                    <div class="modal-header" align="center">
                        <?= $this->Html->image('jaydev.PNG', ['height' => '50px;', 'id' => 'img_logo']); ?>
                    </div>

                    <!-- Begin popup form -->
                    <div id="div-forms">
                        <form id="login-form" method="post" action="/messages/suggestProject">
                            <div class="modal-body">
                                <div id="div-login-msg"><h6><i class="fas fa-bullhorn" style="color: #3498DB;"></i> Please enter some optional information and your suggestion.</h6></div>
                                <div class="row">
                                    <div class="text-center"><p id="featureFormError" class="small guardsman"></p></div>
                                    <input type="hidden" name="form_id"/>
                                    <input name="post_id" id="postIdInput" type="hidden"/>
                                    <div class="col-xs-12"><input id="postTitleInput" name="post_title" class="form-control" type="text" readonly></div>
                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;"><input name="sender_name" id="featureSuggesterName" class="form-control" type="text" placeholder="Name" oninput="checkSuggestFeatureForm()" /></div>
                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;"><input name="sender_email" id="featureSuggesterEmail" class="form-control" type="text" placeholder="Email" oninput="checkSuggestFeatureForm()" /></div>
                                    <div class="col-xs-12" style="margin-top: 5px;"><textarea name="content" id="featureIdea" class="form-control" rows="3" placeholder="Your feature idea ..." oninput="countSuggestCharacters()"></textarea></div>
                                    <div class="text-center"><p id="featureSuggestCount" class="small">1000 Chars Left</p></div>
                                </div>
                            </div>
                            <div class="modal-footer"><button id="featureSubmit" type="submit" class="btn btn-outline btn-outline-sm outline-dark center-block" disabled style="margin: 0;">Send</button></div>
                        </form>
                    </div>
                    <!-- End popup form -->
                </div>
            </div>
        </div>
        <!-- End modal popup -->
    <?php } ?>
</div>

<?php if (strpos($this->request->here, '/messages/add') == false && strpos($this->request->here, '/users/') == false && strpos($this->request->here, '/users/login') == false &&
    strpos($this->request->here, '/messages/view') == false && !$user) {
    $keywordFieldAttr = ['id' => 'keyword', 'placeholder' => 'Keyword', 'label' => false, 'type' => 'text', 'class' => 'form-control', 'oninput' => 'keywordFormCheck()'];
    $keywordSubmitAttr = ['id' => 'keywordSubmit', 'class' => 'btn btn-outline btn-outline-sm outline-dark', 'style' => 'margin: auto', 'disabled' => true];
    $monthFieldAttr = ['id' => 'month', 'empty' => 'Select Month', 'class' => 'form-control', 'onchange' => 'filterFormCheck()'];
    $yearFieldAttr = ['id' => 'year', 'empty' => 'Select Year', 'class' => 'form-control', 'onchange' => 'filterFormCheck()'];
    $filterSubmitAttr = ['id' => 'filterSubmit', 'class' => 'btn btn-outline btn-outline-sm outline-dark pull-left', 'disabled' => true]; ?>
    <div class="container">
        <div class="row" style="margin-bottom: 20px;">
            <div class="container">
                <div class="underlined-title">
                    <h1>Search for Posts</h1>
                    <hr>
                </div>
            </div>
            <div class="row" style="margin: 0; border-radius: 10px; border: 2px solid #3498DB; padding: 15px;">
                <h3>By keywords (case-insensitive) <p class="guardsman" id="keywordError"></p></h3>
                <div class="row">
                    <form method="post" action="/posts/projectSearch">
                        <input type="hidden" name="form_id" value="0" />
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12"><?= $this->Form->control('keyword', $keywordFieldAttr); ?></div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><?= $this->Form->button(__('Search'), $keywordSubmitAttr); ?></div>
                    </form>
                </div>
                <hr style="border: 1px solid #3498DB;" />
                <h3>By uploaded time <p class="guardsman" id="filterStatus"></p></h3>
                <div class="row">
                    <form method="post" action="/posts/projectSearch">
                        <input type="hidden" name="form_id" value="1" />
                        <div class="col-xs-6"><?= $this->Form->select('month', $months, $monthFieldAttr); ?></div>
                        <div class="col-xs-6"><?= $this->Form->select('year', $yearField, $yearFieldAttr); ?></div>
                        <div class="col-md-12"><?= $this->Form->button(__('Search'), $filterSubmitAttr); ?></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        const specialChars = ['!', '~', '`', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '_', '=', '+', '[',
            '{', ']', '}', '\\', '|', ';', ':', '\'', '"', ',', '<', '.', '>', '/', '?'];

        const postCountsByMonth = {
            <?php $t = 0; foreach ($postCountsByTime as $key => $value):
                echo ($t++ == count($postCountsByTime) - 1) ? '\''.$key.'\': '.$value.'' : '\''.$key.'\': '.$value.', ';
            endforeach; ?>
        };

        const years = {
            <?php $k = 0; foreach ($yearField as $key => $value):
                echo ($k++ == count($yearField) - 1) ? ''.$key.': '.$value.'' : ''.$key.': '.$value.',';
            endforeach; ?>
        };

        var keywordSubmit = document.getElementById('keywordSubmit');
        var filterSubmit = document.getElementById('filterSubmit');

        function keywordFormCheck() {
            var keyword = document.getElementById('keyword').value;
            var keywordError = document.getElementById('keywordError');

            if (keyword.length === 0) {
                keywordSubmit.disabled = true;
                keywordError.innerHTML = '';
                filterFormCheck();
            }
            else {
                var test = true;
                for (var i = 0; i < specialChars.length; i++) {
                    if (keyword.indexOf(specialChars[i]) > -1) {
                        test = false;
                        break;
                    }
                }

                if (!test) {
                    filterFormCheck();
                    keywordSubmit.disabled = true;
                    keywordError.innerHTML = 'Keyword could not contain special characters. Separate keywords by white space.';
                }
                else {
                    keywordSubmit.disabled = false;
                    filterSubmit.disabled = true;
                    keywordError.innerHTML = '';
                }
            }
        }

        function filterFormCheck() {
            var month = document.getElementById('month').value;
            var year = document.getElementById('year').value;
            var filterError = document.getElementById('filterStatus');

            if (month.length === 0 || year.length === 0) {
                filterError.innerHTML = '';
                filterSubmit.disabled = true;
            }

            if (month === 0 && year === 0)
                keywordFormCheck();

            if (month.length !== 0 && year.length !== 0) {
                var key = month.concat('-').concat(years[year]);

                if (postCountsByMonth[key] !== 0) {
                    filterError.innerHTML = '';
                    filterSubmit.disabled = false;
                    keywordSubmit.disabled = true;
                }
                else {
                    filterError.innerHTML = '0 posts found in ' + key.toString();
                    filterSubmit.disabled = true;
                    keywordFormCheck();
                }
            }
        }
    </script>
<?php } ?>

<section class="content-block-nopad bg-offwhite footer-wrap-1-3">
    <!-- Section containing footer -->
    <div class="container footer-1-3">
        <!-- Section containing logo and social links -->
        <div class="col-md-3 col-sm-4 col-xs-4">
            <?= $this->Html->image('jaydev.PNG', ['alt' => 'jaydeveloper', 'url' => '/', 'class' => 'brand-img img-responsive']); ?>
            <q><i>No pain, no gain</i></q>

            <div class="row">
                <p class="margin-bottom0">www.linkedin.com/in/jay-developer</p>
                <p class="margin-top0">Tel: 0422 357 488</p>
            </div>
            <!-- <ul class="social social-light">
                <li><a href="#" target="_blank" title="Twitter"><i class="fab fa-twitter-square fa-3x"></i></a></li>
                <li><a title="Linkedin" target="_blank" href="www.linkedin.com/in/jay-developer"><i class="fab fa-linkedin fa-3x"></i></a></li>
                <li><a href="tel:+61422357488" title="Whatsapp"><i class="fab fa-whatsapp-square fa-3x"></i></a></li>
            </ul> -->
        </div>
        <!-- End social links -->

        <!-- Section containing suggest form -->
        <div class="col-md-8 col-sm-8 col-xs-8 pull-right">
            <p><i class="fas fa-bomb pomegranate"></i> Got a project idea? Please suggest me.<br><p id="suggestPostError" class="guardsman small"></p></p>
            <div class="row">
                <!-- Suggest form -->
                <form id="suggestProject" method="post" action="/messages/suggestProject">
                    <input type="hidden" name="form_id" value="0"/>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="row">
                            <div class="col-xs-12"><input name="sender_name" id="suggesterName" type="text" placeholder="Name" class="form-control" oninput="checkSuggestProjectForm()" /></div>
                            <div class="col-xs-12"><input name="sender_email" id="suggesterEmail" type="text" placeholder="Email" class="form-control" oninput="checkSuggestProjectForm()" /></div>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="row">
                            <div class="col-sm-9 col-xs-12"><textarea name="content" id="projectIdea" class="form-control" rows="3" placeholder="Your project idea ..." style="height: 85px;" oninput="countMessageCharacters()"></textarea></div>
                            <div class="col-sm-3 col-xs-12">
                                <button id="suggestSubmit" type="submit" class="btn btn-outline btn-outline-sm outline-dark" disabled="disabled">Send</button>
                                <p id="suggestProjectCount" class="small" style="margin: 0;">1000 Chars Left</p>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- End form -->
            </div>
        </div>
        <!-- End form section -->
    </div>
    <!-- End footer -->
</section>

<div class="copyright-bar-2">
    <div class="container text-center">
        <p>Powered by CakePHP 3.5. Developed by Jay Nguyen. ALL RIGHTS RESERVED.
            <a href="/messages/view" style="color: lightskyblue !important;"
               onmouseover="this.style.color='#01447e'"
               onmouseout="this.style.color='lightskyblue'">
                Privacy Policy
            </a>
        </p>
    </div>
</div>

<?= $this->Html->script('jquery-1.11.1.min.js'); ?>
<?= $this->Html->script('bootstrap.min.js'); ?>
<?= $this->Html->script('plugins.js'); ?>
<?= $this->Html->script('bskit-scripts.js'); ?>

<?php if (strpos($this->request->here, '/posts/view/') != false && !$user) { ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.5.0/prism.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>

    <script type="text/javascript">
        var commentCheck = false;

        $(function () {
            CKEDITOR.replace('editor1');

            CKEDITOR.instances.editor1.on('change', function() {
                var commentContent = CKEDITOR.instances.editor1.getData();
                if (commentContent === '') {
                    $('#countCommentChars').css('color', '#515157');
                    $('#countCommentChars').html('5000 Chars Left');

                    $('#previewDiv').hide('slow');
                    commentCheck = false;
                }
                else {
                    $('#previewDiv').show('slow');
                    $('#preview').html(commentContent);

                    if (5000 - commentContent.length > 0) {
                        $('#countCommentChars').css('color', '#515157');
                        $('#countCommentChars').html((5000 - commentContent.length).toString().concat(' Chars Left'));
                        commentCheck = true;
                    }
                    else {
                        $('#countCommentChars').css('color', '#D90000');
                        $('#countCommentChars').html('0 Chars Left');
                        commentCheck = false;
                    }
                }

                $('#commentButton').prop('disabled', !(commenterNameCheck && commenterEmailCheck && commentCheck));
            });
        });
    </script>
<?php } else if ($user && (strpos($this->request->here, '/posts/edit') != false || strpos($this->request->here, '/posts/add') != false)) { ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.5.0/prism.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>

    <script type="text/javascript">$(function () { CKEDITOR.replace('editor1'); });</script>
<?php } ?>

<?= $this->Html->script('jayblog.js'); ?>
</body>
</html>
