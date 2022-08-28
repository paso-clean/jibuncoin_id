
<?php if($is_secure == 0){ ?>
<table class="pointer btn-ajax" data-url="<?php echo XSYSTEM_COMMON_URL; ?>ajax/id/jibun_id_component/" style="width:100%;border:1px solid #ddd;background:#aaa;">
<tr>
<td style="width:80px;height:80px;"><div style="font-size:40px;color:#fff;text-align:center;"><img src="<?php echo XSYSTEM_ASSET_URL . 'img/jibun_id.png'; ?>" style="width:60px;height:60px;"></div></td>
<td style="padding-left:20px;">
<div style="font-size:24px;font-weight:bold;color:#fff;">ジブンID</div>
</td>
</tr>
</table>
<?php }else{ ?>
<table class="pointer btn-ajax" data-url="<?php echo XSYSTEM_COMMON_URL; ?>ajax/id/jibun_id_component/" style="width:100%;border:1px solid #fff;background:#fff;">
<tr>
<td style="width:80px;height:80px;"><div style="font-size:40px;text-align:center;"><img src="<?php echo XSYSTEM_ASSET_URL . 'img/jibun_id.png'; ?>" style="width:60px;height:60px;"></div></td>
<td style="padding-left:20px;">
<div style="font-size:24px;font-weight:bold;color:#357ebd;">ジブンID</div>
</td>
</tr>
</table>
<?php } ?>