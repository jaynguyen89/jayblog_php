<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

/*$this->layout = 'error';

if (Configure::read('debug')) :
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?php if ($error instanceof Error) : ?>
        <strong>Error in: </strong>
        <?= sprintf('%s, line %s', str_replace(ROOT, 'ROOT', $error->getFile()), $error->getLine()) ?>
<?php endif; ?>
<?php
    echo $this->element('auto_table_warning');

    if (extension_loaded('xdebug')) :
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;*/
?>

<div class="row text-center guardsman"><h1 style="font-size: 10em; font-weight: bold; margin-bottom: 0;">500</h1></div>
<div class="row text-center"><h2 style="margin-top: 0;"><?= h($message) ?></h2></div>
<div class="row text-center">
    <p class="error">
        <strong><?= __d('cake', 'Error') ?>: </strong>
        <?= __d('cake', 'Internal Server Error - Unknown Request - Record Not Found', "<strong>'{$url}'</strong>") ?>
    </p>
</div>
