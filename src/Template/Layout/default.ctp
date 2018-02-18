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
                    <?= $this->Html->image('jaydev.PNG', ['alt' => 'jaydeveloper', 'url' => ['controller' => 'Pages', 'action' => 'display'], 'class' => 'brand-img img-responsive']); ?>
                </div>

                <!-- Navbar menu containing collapsible items and links -->
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="nav-item active"><?= $this->Html->link(__('Home'), ['controller' => 'Pages', 'action' => 'display'], ['class' => 'nav-link']); ?></li>
                        <!-- Dropdown menu for Interests -->
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Interests <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu" style="background-color: grey">
                                <li class="nav-item">
                                    <a href="#"><i class="fas fa-code" style="margin-right: 10px;"></i>Programming Languages</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#"><i class="fas fa-th-large" style="margin-right: 10px;"></i>Frameworks</a>
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
                                <li class="nav-item"><a href="#"><i class="fas fa-cloud-upload-alt" style="margin-right: 10px;"></i>Web Server & Clouds</a></li>
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
                        <li class="nav-item"><?= $this->Html->link(__('Contact'), ['controller' => 'Pages', 'action' => 'contact']); ?></li>
                        <li class="nav-item" style="display: none;">
                            <a href="#" style="color: coral" onmouseover="this.style.color='orangered'" onmouseout="this.style.color='coral'" ><i class="fa fa-user-circle" style="font-size: larger"></i> Admin Login</a>
                        </li>
                    </ul>
                </div>
                <!-- End navbar menu -->
            </div>
            <!-- End navbar container -->
        </nav>
    </header>

    <?= $this->Flash->render() ?>
    <div class="container clearfix"><br/><br/><br/><br/><br/>
        <?= $this->fetch('content') ?>
    </div>

    <section class="content-block-nopad bg-offwhite footer-wrap-1-3">
        <div class="container footer-1-3">
            <div class="col-md-4 pull-left">
                <?= $this->Html->image('jaydev.PNG', ['alt' => 'jaydeveloper', 'url' => ['controller' => 'Pages', 'action' => 'display'], 'class' => 'brand-img img-responsive']); ?>
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
            <div class="col-md-4 pull-right">
                <p><i class="fas fa-bomb pomegranate"></i> Got an idea? Suggest a project</p>
                <div class="row">
                    <div class="col-sm-10"><textarea name="comments" id="comments" class="form-control" rows="3" placeholder="Message" id="textArea" style="height: 60px;"></textarea></div>
                    <div class="col-sm-2"><a href="#" class="btn btn-outline btn-outline-sm outline-dark">Send</a></div>
                </div>
            </div>
        </div>
        <!-- /.container -->
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

    <!-- Piece of javascript code to disable right click
    <script language="javascript">
        document.onmousedown=disableclick;
        status="Right Click Disabled";
        function disableclick(event)
        {
            if(event.button == 2)
            {
                alert(status);
                return false;
            }
        }
    </script>
    -->
</body>
</html>
