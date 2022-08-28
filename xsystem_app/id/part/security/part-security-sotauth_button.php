
<?php if($is_secure == 0){ ?>
<table class="pointer btn-ajax" data-url="<?php echo XSYSTEM_COMMON_URL; ?>ajax/security/setting/" style="width:100%;border:1px solid #ddd;background:#aaa;">
<tr>
<td style="width:80px;height:80px;"><div style="font-size:40px;color:#fff;text-align:center;"><i class="fa-solid fa-shield-halved"></i></div></td>
<td style="padding-left:20px;">
<div style="font-size:24px;font-weight:bold;color:#fff;">セキュリティ</div>
<div style="font-size:13px;color:#fff;">SecureOneTime Authentication</div>
</td>
</tr>
</table>
<?php }else{ ?>
<table class="pointer btn-ajax" data-url="<?php echo XSYSTEM_COMMON_URL; ?>ajax/security/setting/" style="width:100%;border:1px solid #1e3799;background:#1e3799;">
<tr>
<td style="width:80px;height:80px;"><div style="font-size:40px;color:#fff;text-align:center;"><i class="fa-solid fa-shield-halved"></i></div></td>
<td style="padding-left:20px;">
<div style="font-size:24px;font-weight:bold;color:#fff;">セキュリティ</div>
<div style="font-size:13px;color:#fff;">SecureOneTime Authentication</div>
</td>
</tr>
</table>
<?php } ?>