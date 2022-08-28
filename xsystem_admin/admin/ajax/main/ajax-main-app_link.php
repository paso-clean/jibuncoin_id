<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-htaccess.php';
$htaccess = new Htaccess();
$active_apps = $htaccess->active_apps();
$dirs = scandir(XSYSTEM_DIR . XSYSTEM_PRODUCT .  '_app/');
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

    $dir_path = XSYSTEM_DIR . XSYSTEM_PRODUCT .  '_app/' . $dir;
    if (is_dir($dir_path)) {
        $apps[] = $dir;
    }
}

?>

<div style="padding:10px;">
<?php foreach($apps as $app){ 
    $is_active = false;
    for($i=0;$i<count($active_apps);$i++){
        // echo '<div>' . $active_apps[$i] . '</div>';
        // echo '<div>' . $app . '</div>';
        if($app == $active_apps[$i]){
            $is_active = true;
        }
    }
    if($is_active){
        $css = 'background:#fff;';
    }else{
        $css = 'background:#696969;';
    }
    $link = APP_URL . $app . '/';
?>
<a target="_blank" href="<?php echo $link; ?>">
<table class="pointer" data-url="<?php echo XSYSTEM_ADMIN_URL; ?>ajax/system/db/" style="width:100%;border:1px solid #ddd;color:#357ebd;<?php echo $css; ?>">
<tr data-user_code="">
<td style="width:120px"><div style="margin:20px 30px 20px 30px;font-size:40px;"><i class="fa-solid fa-circle-nodes"></i></div></td>
<td>
<div style="font-size:13px;color:#357ebd;"></div>
<div style="font-size:24px;font-weight:bold;"><?php echo $app; ?></div>
</td>
</tr>
</table>
</a>
<?php } ?>

</div>