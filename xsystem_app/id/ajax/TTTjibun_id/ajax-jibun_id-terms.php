<?php
$app_name = basename(dirname(dirname(dirname(__FILE__))));
if (!defined('XSYSTEM_ASSET_URL')) {
	define('XSYSTEM_ASSET_URL', APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . $app_name . '/asset/');
}
if (!defined('XSYSTEM_APP_URL')) {
	define('XSYSTEM_APP_URL', APP_URL . $app_name . '/');
}
if (!defined('XSYSTEM_APP_DIR')) {
	define('XSYSTEM_APP_DIR', XSYSTEM_DIR . XSYSTEM_PRODUCT . '_app/' . $app_name . '/');
}
require_once XSYSTEM_APP_DIR . 'class/class-sotauth.php';

$sotauthIns = new Sotauth();


$logo_img = XSYSTEM_ASSET_URL . 'img/jibun_id.png';


$session_name = $url_param[4];
$session_code = $url_param[5];

$sotauthIns->delete_linkage_session($session_name);

$sotauthIns->set_linkage_session($session_name,$session_code);






?>

<div class="content-block" style="text-align:center;padding:20px;">
<div><img src="<?php echo $logo_img; ?>" style="width:100px;height:100px;"></div>
<div><h3>ジブンID</h3></div>
<div style="text-align:center;">
様々な別のアプリケーションを使うためには、ジブンIDと連携する必要があります。
<br>
<ul style="width:60%;min-width:300px;text-align:left;margin:auto;">
<li>●ジブンショップ</li>
<li>●グローバルコインの作成(他のコミュニティでも使えるコイン)</li>
<li>●二段階認証(セキュアワンタイム認証)</li>
<li>●その他コミュニティサービス</li>
</ul>
<br>
</div>
</div>

<div class="content-block" style="background:#fff;border-color:ddd;text-align:center;">
<div style="padding:10px;font-size:18px;">ジブンIDとの連携を許可しますか？</div>
<div style="padding:10px;"><span class="pointer" style="color:#0000ff;font-size:20px;">利用規約</span></div>
<div style="font-size:20px;">
<div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1" style="width:20px;height:20px;">
    <label class="form-check-label" for="exampleCheck1">利用規約に署名</label>
  </div>
</div>
<div style="padding:10px;"><button class="btn btn-lg btn-success btn-ajax" data-url_id="#url-<?php echo $session_name; ?>">許可する</button></div>
</div>