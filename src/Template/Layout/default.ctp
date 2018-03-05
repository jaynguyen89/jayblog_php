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

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body data-spy="scroll" data-target="nav">
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
                        <li class="nav-item active"><?= $this->Html->link(__('Home'), '/', ['class' => 'nav-link']); ?></li>
                        <!-- Dropdown menu for Interests -->
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Interests <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu" style="background-color: grey">
                                <li class="nav-item">
                                    <a href="#"><i class="fas fa-code" style="margin-right: 10px;"></i>Programming Languages</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#"><i class="fas fa-puzzle-piece" style="margin-right: 10px;"></i>Frameworks</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#"><i class="fas fa-cogs" style="margin-right: 10px;"></i>APIs</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#"><i class="fas fa-object-group" style="margin-right: 10px;"></i>Tools & Software</a>
                                </li>
                            </ul>
                        </li>
                        <!-- End dropdown -->

                        <!-- Dropdown menu for Personal Projects -->
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Personal Projects <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu" style="background-color: grey">
                                <li class="nav-item">
                                    <a href="#"><i class="fab fa-chrome" style="margin-right: 10px;"></i>Web Apps</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#"><i class="fas fa-laptop" style="margin-right: 10px;"></i>Computer Apps</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#"><i class="fab fa-app-store-ios" style="margin-right: 10px;"></i>iOS Apps</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#"><i class="fab fa-android" style="margin-right: 10px;"></i>Android Apps</a>
                                </li>
                                <!-- Nested dropdown inside the outer dropdown menu
                                <li class="nav-item dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#"><i class="fas fa-mobile" style="margin-right: 10px;"></i>Mobile Apps <i class="fa fa-angle-down"></i></a>
                                    <ul class="dropdown-menu bg-asbestos">
                                        <li class="nav-item">
                                            <a href="#" class="text-right"><i class="fab fa-app-store-ios" style="margin-right: 10px;"></i>iOS</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="text-right"><i class="fab fa-android" style="margin-right: 10px;"></i>Android</a>
                                        </li>
                                    </ul>
                                </li>
                                -->
                            </ul>
                        </li>
                        <!-- End dropdown -->

                        <!-- Dropdown menu for Other contents -->
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Others <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu" style="background-color: grey">
                                <li class="nav-item"><a href="#"><i class="fas fa-cloud-upload-alt" style="margin-right: 10px;"></i>Servers & Clouds</a></li>
                                <li class="nav-item"><a href="#"><i class="fas fa-code-branch" style="margin-right: 10px;"></i>Version Control</a></li>
                                <li class="nav-item">
                                    <a href="#"><i class="far fa-newspaper" style="margin-right: 10px;"></i>IT News</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#"><i class="far fa-lightbulb" style="margin-right: 10px;"></i>Tips & Tricks</a>
                                </li>
                            </ul>
                        </li>
                        <!-- End dropdown -->
                        <li class="nav-item"><?= $this->Html->link(__('Contact'), ['controller' => 'Messages', 'action' => 'add']); ?></li>
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
            <div class="col-md-4 col-sm-4 col-xs-4">
                <?= $this->Html->image('jaydev.PNG', ['alt' => 'jaydeveloper', 'url' => '/', 'class' => 'brand-img img-responsive']); ?>
                <q><i>No pain, no gain</i></q>
                <ul class="social social-light">
                    <li>
                        <a href="#" title="Facebook"><i class="fab fa-facebook-square fa-3x"></i></a>
                    </li>
                    <li>
                        <a href="#" title="Twitter"><i class="fab fa-twitter-square fa-3x"></i></a>
                    </li>
                    <li>
                        <a href="#" title="Google Plus"><i class="fab fa-google-plus-square fa-3x"></i></a>
                    </li>
                    <li>
                        <a href="#" title="Linkedin"><i class="fab fa-linkedin fa-3x"></i></a>
                    </li>
                    <li>
                        <a href="#" title="Whatsapp"><i class="fab fa-whatsapp-square fa-3x"></i></a>
                    </li>
                </ul>
                <!-- /.social -->
            </div>
            <!-- End social links -->

            <!-- Section containing suggest form -->
            <div class="col-md-8 col-sm-8 col-xs-8">
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
    <?= $this->Html->script('jayblog.js'); ?>
</body>
</html>
