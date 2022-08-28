<?php

$logo_img = XSYSTEM_ASSET_URL . 'img/jibun_id.png';


$user_code = $url_param[4];

echo '<div class="content-block" style="text-align:center;padding:20px;">';
echo $user_code;
echo '</div>';

include XSYSTEM_APP_DIR . 'part/network/part-network-id_signature.php';

?>