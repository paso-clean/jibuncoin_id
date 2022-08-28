<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-htaccess.php';
$htaccess = new Htaccess();
$active_apps = $htaccess->active_apps();
$dirs = scandir(XSYSTEM_DIR . '/' . XSYSTEM_PRODUCT . '_app/');
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

    $dir_path = XSYSTEM_DIR . '/' . XSYSTEM_PRODUCT . '_app/' . $dir;
    if (is_dir($dir_path)) {
        $apps[] = $dir;
    }
}

?>


<div style="padding:5px;text-align:center;">

<div class="content-block">
<div id="boot-apps" style="padding:20px;">
<?php 
foreach($apps as $app){
    $is_active = false;
    for($i=0;$i<count($active_apps);$i++){
        if($app == $active_apps[$i]){
            $is_active = true;
        }
    }
    if($is_active){
        echo '<div class="tag active-right-blue active" data-active_color="right-blue" >' . $app . '</div>';
    }else{
        echo '<div class="tag" data-active_color="right-blue" >' . $app . '</div>';
    }

} ?>
</div>
<button type="button" class="btn btn-danger btn-api" data-action="app_boot" data-done="alert" data-tags="boot-apps" data-url="<?php echo XSYSTEM_ADMIN_URL; ?>api/system/boot/">起動</button>
</div>

</div>