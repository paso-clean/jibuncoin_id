<table class="pointer btn-ajax" data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/user/qr/<?php echo $user['user_code']; ?>/" style="width:100%;border:1px solid #ddd;background:#fff;;">
<tr data-user_code="">
<td style="width:80px;height:80px;"><div style="text-align:center;"><img src="<?php echo $qr; ?>" style="width:60px;height:60px;"></div></td>
<td style="padding-left:20px;">
<div style="font-size:13px;color:#357ebd;"></div>
<div style="font-size:24px;font-weight:bold;color:#357ebd;">QRコード</div>
</td>
</tr>
</table>