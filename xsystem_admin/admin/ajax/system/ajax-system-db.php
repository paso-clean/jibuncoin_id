<?php
require_once XSYSTEM_ADMIN_DIR . 'class/class-htaccess.php';
$htaccess = new Htaccess();
$active_apps = $htaccess->active_apps();
$dirs = scandir(XSYSTEM_DIR . 'application/');
$excludes = array(
    '.',
    '..',
    '.htaccess',
);

$apps = array();
foreach ($dirs AS $dir) {
    if (in_array($dir, $excludes)) {
        continue;
    }

    $dir_path = XSYSTEM_DIR . 'application/' . $dir;
    if (is_dir($dir_path)) {
        $apps[] = $dir;
    }
}

?>


<div style="padding:5px;text-align:center;">

<div class="content-block">
<div>DB</div>
<button type="button" class="btn btn-danger btn-api" data-action="htaccess" data-tags="boot-apps" data-api_done="htaccess_done" data-api="<?php echo XSYSTEM_ADMIN_URL; ?>api/system/htaccess/">起動</button>
</div>

</div>