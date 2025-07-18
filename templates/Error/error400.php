<?php
/**
 * @var \App\View\AppView $this
 * @var string $message
 * @var string $url
 */
use Cake\Core\Configure;

$this->layout = 'error';

// Detect CSRF error
$isCsrfError = stripos($message, 'csrf') !== false;

if (Configure::read('debug')) :
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.php');

    $this->start('file');
    echo $this->element('auto_table_warning');
    $this->end();
endif;

// Redirect if CSRF error
if ($isCsrfError) {
    header('Location: https://subscriptionsassistantcakephp-production.up.railway.app/users/login');
    exit;
}
?>
<h2><?= h($message) ?></h2>
<p class="error">
    <strong><?= __d('cake', 'Error') ?>: </strong>
    <?= __d('cake', 'The requested address {0} was not found on this server.', "<strong>'{$url}'</strong>") ?>
</p>
