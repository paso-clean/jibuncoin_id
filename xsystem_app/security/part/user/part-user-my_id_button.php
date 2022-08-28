<table class="pointer btn-ajax"  data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/user/my_id/" style="width:100%;border:1px solid #ddd;background:#fff;">
<tr>
<td style="width:80px;height:80px;"><div style="text-align:center;"><img class="reload_class_<?php echo $user['objects']['user_img'][0]['object_code']; ?>" src="<?php echo XSYSTEM_IMG_URL; ?>user/thum/<?php echo $user['objects']['user_img'][0]['object']; ?>" style="width:80px;height:80px;margin:0;"></div></td>
<td style="padding-left:20px;">
<div style="font-size:13px;color:#357ebd;">[<?php echo $user['user_code']; ?>]</div>
<div style="font-size:13px;color:#357ebd;"><?php echo $user['name1_kana'] . ' ' . $user['name2_kana']; ?></div>
<div style="font-size:22px;font-weight:bold;color:#357ebd;"><?php echo $user['name1'] . ' ' . $user['name2']; ?></div>
</td>
</tr>
</table>