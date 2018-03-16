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
<?php $active = (strpos($this->request->here, '/messages/add') != false ? '1' :
    (strpos($this->request->here, '/posts/view/') != false ? '-1' :
        ((strpos($this->request->here, '/posts/programming-interest') != false || strpos($this->request->here, '/posts/framework-interest') != false || strpos($this->request->here, '/posts/api-interest') != false || strpos($this->request->here, '/posts/software-interest') != false) ? '2' :
            ((strpos($this->request->here, '/posts/web-project') != false || strpos($this->request->here, '/posts/computer-project') != false || strpos($this->request->here, '/posts/ios-project') != false || strpos($this->request->here, '/posts/android-project') != false) ? '3' :
                ((strpos($this->request->here, '/posts/cloud-others') != false || strpos($this->request->here, '/posts/news-others') != false || strpos($this->request->here, '/posts/tiptrick-others') != false) ? '4' : '0'))))); ?>
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
                    <?= $this->Html->image('jaydev.PNG', ['alt' => 'jaydeveloper', 'url' => '/', 'class' => 'brand-img img-responsive']); ?>
                </div>

                <!-- Navbar menu containing collapsible items and links -->
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item <?= $active == 0 ? 'active' : ''; ?>"><?= $this->Html->link(__('Home'), '/', ['class' => 'nav-link']); ?></li>
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
                        <li class="nav-item <?= $active == 1 ? 'active' : ''; ?>"><?= $this->Html->link(__('About'), ['controller' => 'Messages', 'action' => 'add']); ?></li>
                        <li class="nav-item" style="display: none;">
                            <a href="#" style="color: coral" onmouseover="this.style.color='orangered'" onmouseout="this.style.color='coral'"><i class="fa fa-user-circle" style="font-size: larger"></i> Admin Login</a>
                        </li>
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
    </div>

    <section class="content-block-nopad bg-offwhite footer-wrap-1-3">
        <!-- Section containing footer -->
        <div class="container footer-1-3">
            <!-- Section containing logo and social links -->
            <div class="col-md-2 col-sm-4 col-xs-4">
                <?= $this->Html->image('jaydev.PNG', ['alt' => 'jaydeveloper', 'url' => '/', 'class' => 'brand-img img-responsive']); ?>
                <q><i>No pain, no gain</i></q>
                <ul class="social social-light">
                    <li><a href="#" target="_blank" title="Twitter"><i class="fab fa-twitter-square fa-3x"></i></a></li>
                    <li><a role="button" title="Linkedin" target="_blank" onclick="window.open('www.linkedin.com/in/jay-developer', '_blank')"><i class="fab fa-linkedin fa-3x"></i></a></li>
                    <li><a href="tel:+61422357488" title="Whatsapp"><i class="fab fa-whatsapp-square fa-3x"></i></a></li>
                </ul>
                <!-- /.social -->
            </div>
            <!-- End social links -->

            <!-- Section containing suggest form -->
            <div class="col-md-8 col-sm-8 col-xs-8 pull-right">
                <p><i class="fas fa-bomb pomegranate"></i> Got a project idea? Please suggest me.<br><p id="suggestPostError" class="guardsman small"></p></p>
                <div class="row">
                    <!-- Suggest form -->
                    <form id="suggestProject" method="post" action="/jayblog/messages/suggestProject">
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
            <p>Powered by Pinegrow<sup>©</sup> 2015 & Rails 5.1.4. Developed by Jay Nguyen. ALL RIGHTS RESERVED. <a href="#">Privacy Policy</a></p>
        </div>
    </div>

    <?= $this->Html->script('jquery-1.11.1.min.js'); ?>
    <?= $this->Html->script('bootstrap.min.js'); ?>
    <?= $this->Html->script('plugins.js'); ?>
    <?= $this->Html->script('bskit-scripts.js'); ?>

    <?php if (strpos($this->request->here, '/posts/view/') != false) { ?>
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
    <?php } ?>

    <?= $this->Html->script('jayblog.js'); ?>
</body>
</html>
