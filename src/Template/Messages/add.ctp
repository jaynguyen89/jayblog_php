<?php
$nameFieldAttr = ['class' => 'form-control', 'label' => false, 'placeholder' => 'Name*', 'type' => 'text', 'id' => 'contactorName', 'oninput' => 'validateContactForm()'];
$emailFieldAttr = ['class' => 'form-control', 'label' => false, 'placeholder' => 'Email*', 'type' => 'text', 'id' => 'contactorEmail', 'oninput' => 'validateContactForm()'];
$phoneFieldAttr = ['class' => 'form-control', 'label' => false, 'placeholder' => 'Phone', 'type' => 'text', 'id' => 'contactorPhone', 'oninput' => 'validateContactForm()'];
$contentFieldAttr = ['class' => 'form-control', 'label' => false, 'placeholder' => 'Message', 'type' => 'text', 'id' => 'contactContent', 'oninput' => 'countContactContent()']; ?>

<div class="container">
    <!-- Breadcrumb navigation pane -->
    <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Pictures</a></li>
        <li><a href="#">Summer 15</a></li>
        <li>Italy</li>
    </ul>
    <!-- End breadcrumb -->

    <!-- Section contains introductory information about the blog -->
    <section id="content-1-9" class="content-1-9 content-block">
        <!-- Section title -->
        <div class="underlined-title">
            <h1>About this blog</h1>
            <hr>
            <p class="lead">Jay Blog is developed by the inspiration of myself in the field of IT after finishing my degree.
                I wish to, through this blog, share the story of my past study and future further self-improvements. I am continuing to dig deeper in what I have learned, keep practising them, and
                explore new IT aspects. To pace along my side, this blog is commissioned to reflect the progress and the outcomes of my work. Please don't hesitate to see through my blog and leave me a
                message if you find something interesting. Welcome to Jay's Blog!</p>
        </div>
        <!-- End section title -->

        <!-- Section contents -->
        <div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12 pad25">
                <div class="col-xs-2">
                    <span class="fab fa-audible fa-3x" style="color: #3498DB;"></span>
                </div>
                <div class="col-xs-10">
                    <h4>Review</h4>
                    <p>Reflection of Jay's reviews in Programming, Frameworks, Agile Development Models, Testing and more.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 pad25">
                <div class="col-xs-2">
                    <span class="fas fa-magic fa-3x" style="color: #3498DB;"></span>
                </div>
                <div class="col-xs-10">
                    <h4>Research</h4>
                    <p>Expand prior IT knowledge, explore new areas of IT theories, tools and techniques. Getting out of comfort zone.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 pad25">
                <div class="col-xs-2">
                    <span class="fab fa-hotjar fa-3x" style="color: #3498DB;"></span>
                </div>
                <div class="col-xs-10">
                    <h4>Practice</h4>
                    <p>Consolidate and develop new skills. Better to understand in deep with personal projects.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 pad25">
                <div class="col-xs-2">
                    <span class="fas fa-redo-alt fa-3x" style="color: #3498DB;"></span>
                </div>
                <div class="col-xs-10">
                    <h4>Agile</h4>
                    <p>Projects will be developed in Scrum model, be controlled by Git, and be monitored on Trello.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 pad25">
                <div class="col-xs-2">
                    <span class="fas fa-check fa-3x" style="color: #3498DB;"></span>
                </div>
                <div class="col-xs-10">
                    <h4>Update</h4>
                    <p>Testing will be done using Selenium in Python (later in Java). Update is based on the completion of a Git branch.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 pad25">
                <div class="col-xs-2">
                    <span class="far fa-handshake fa-3x" style="color: #3498DB;"></span>
                </div>
                <div class="col-xs-10">
                    <h4>Connect</h4>
                    <p>Widen knowledge. Improve skills. Increase employability. </p>
                </div>
            </div>
        </div>
        <!-- End section contents -->
    </section>
    <!-- End introductory section -->

    <!-- Section contains About Me -->
    <section id="content-2-8" class="content-2-8 content-block-nopad">
        <!-- The outer row contains the whole section contents -->
        <div class="row">
            <!-- The image container taking 3 cols of the outer row -->
            <div class="image-container col-md-4 pull-left">
                <?= $this->Html->image('myphoto.jpg', ['class' => 'background-image-holder']); ?>
            </div>
            <!-- End image container -->

            <!-- The content container taking the rest 9 cols of the outer row -->
            <div class="col-md-8 pull-right">
                <!-- The row wrapping the contents -->
                <div class="row">
                    <!-- Content No.1 About me -->
                    <div class="col-md-8">
                        <div style="margin: 10px;">
                            <h1>About me</h1>
                            <p class="medium">Jay has finished Bachelor of Information Technology at RMIT University. During his study, he achieved Golden Key International Honour Society Certificate, and
                                RMIT LEAD recognition for contribution to Academic Mentoring Program in the Faculty of IT. His areas of expertise include:</p>

                            <div class="row pad10">
                                <div class="col-xs-1">
                                    <span class="far fa-hand-point-right fa-2x" style="color: #3498DB;"></span>
                                </div>
                                <div class="col-xs-11">
                                    <h4 style="margin-top: 0;">Agile Development</h4>
                                    <p>Familiar with Git for continuous development, testing and deployment. Experiences in Scrum, XP and Lean processes.
                                        Knowledge in formal testing and test documentation.</p>
                                </div>
                            </div>

                            <div class="row pad10">
                                <div class="col-xs-1">
                                    <span class="far fa-hand-point-right fa-2x" style="color: #3498DB;"></span>
                                </div>
                                <div class="col-xs-11">
                                    <h4 style="margin-top: 0;">Web Application Development</h4>
                                    <p>CakePHP, ASP.NET, Rails, Bootstrap, JS, JQuery, AJAX, Web APIs, AWS, CPanel, other front-end and back-end libraries/plugins.</p>
                                </div>
                            </div>

                            <div class="row pad10">
                                <div class="col-xs-1">
                                    <span class="far fa-hand-point-right fa-2x" style="color: #3498DB;"></span>
                                </div>
                                <div class="col-xs-11">
                                    <h4 style="margin-top: 0;">Problem Analysis & Solving</h4>
                                    <p>Knowledge in algorithms, program profiling, data structure and design patterns for code optimization.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End about me -->

                    <!-- Content No.2 Contact me -->
                    <div class="col-md-4">
                        <div style="margin: 10px;">
                            <h1>Highlighted</h1>
                            <div class="row">
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Creative Thinking</a>
                                            </h4>
                                        </div>
                                        <div id="collapse1" class="panel-collapse collapse in">
                                            <div class="panel-body">Jay usually looks at things in his life in a way that perhaps no one does.
                                                At the age of 10, he asked his dad: <i><q>Why heart keeps beating</q></i> or <i><q>Why air is transparent</q></i>.
                                                He is keen on critical thinking and never accepts a hasty solution.</div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Flexibility</a>
                                            </h4>
                                        </div>
                                        <div id="collapse2" class="panel-collapse collapse">
                                            <div class="panel-body">Jay is attentive and always goes with a forecast.
                                                So he is able to change to quickly adapt with new conditions. He is a considerate person
                                                in whatever he proposes or is assigned to do.</div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Communication</a>
                                            </h4>
                                        </div>
                                        <div id="collapse3" class="panel-collapse collapse">
                                            <div class="panel-body">Jay is kind, friendly and humorous. He loves working in an interactive and supportive team although
                                                he can also work independently. He always takes great effort to increase the team's productivity. He prefers to be a team leader.</div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Negotiation</a>
                                            </h4>
                                        </div>
                                        <div id="collapse4" class="panel-collapse collapse">
                                            <div class="panel-body">With 2-year working as a Bank Teller in Vietnam, he earned sufficient skills in negotiation and persuasion.
                                                His strength is to deal with hard situations in a professional manner. Yet he also welcomes honest feedback from eveybody.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end of row-->
                        </div>
                    </div>
                    <!-- End contact me -->
                </div>
                <!-- End wrapper row -->
            </div>
            <!-- End content container -->
        </div>
        <!-- End outer row -->
    </section>
    <!-- End section -->

    <section id="content-1-7" class="content-1-7 content-block">
        <!-- Section title -->
        <div class="container">
            <div class="underlined-title">
                <h1>Contact me</h1>
                <hr>
                <p class="lead">Jay is willing and ready to contribute to your business right now.<br/>Please let him know your interest and get his response in no time.</p>
            </div>
        </div>
        <!-- End section title -->

        <!-- The form container -->
        <div id="contact" class="form-container">
            <fieldset style="border-color: #FFF0DD; padding-bottom: 0;">
                <div id="contactFormError" class="guardsman small"></div>
                <?= $this->Form->create($message); ?>
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group"><?= $this->Form->control('sender_name', $nameFieldAttr); ?></div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group"><?= $this->Form->control('sender_email', $emailFieldAttr); ?></div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group"><?= $this->Form->control('sender_phone', $phoneFieldAttr); ?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->textarea('content', $contentFieldAttr); ?>
                        <p id="contactCount" class="small" style="margin: 0;">10000 Chars Left</p>
                        <div class="editContent"><?= $this->Form->button(__('Send'), ['id' => 'contactSubmitBtn', 'class' => 'btn btn-outline btn-outline-lg outline-dark', 'disabled' => true]); ?></div>
                    </div>
                <?= $this->Form->end(); ?>
            </fieldset>
        </div>
        <!-- End form container -->
    </section>
</div>

