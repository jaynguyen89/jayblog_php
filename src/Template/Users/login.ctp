<?php $usernameFieldAttr = ['class' => 'form-control', 'label' => false, 'id' => 'username', 'type' => 'text', 'placeholder' => 'Username', 'required' => true];
$passwordFieldAttr = ['class' => 'form-control', 'label' => false, 'id' => 'password', 'type' => 'password', 'placeholder' => 'Password', 'style' => 'margin-top: 10px;', 'required' => true];
$loginBtnAttr = ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'type' => 'submit', 'id' => 'loginSubmit']; ?>

<div class="container" style="min-height: 621px;">
    <section id="content-1-9" class="content-1-9 content-block" style="padding-bottom: 10px;">
        <div class="row" style="margin-bottom: 20px;">
            <!-- Section title -->
            <div class="container">
                <div class="underlined-title">
                    <h1><i class="fa fa-user-circle" style="color: #3498DB;"></i> Admin Login</h1>
                    <hr>
                </div>
            </div>
            <!-- End section title -->

            <!-- Card containing login form -->
            <div class="card" style="width: 50%; margin: auto;">
                <p class="guardsman" id="loginError"></p>
                <form method="post" action="/users/login">
                    <div class="row">
                        <div class="col-xs-12"><?= $this->Form->control('username', $usernameFieldAttr) ?></div>
                        <div class="col-xs-12"><?= $this->Form->control('password', $passwordFieldAttr) ?></div>
                        <div class="col-xs-12" style="margin: 10px 0 10px 0;"><?= $this->Form->button(__('Log In'), $loginBtnAttr); ?></div>
                    </div>
                </form>
            </div>
            <!-- End login form -->
        </div>
    </section>
</div>
