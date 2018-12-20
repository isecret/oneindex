<?php View::layout('install/layout')?>

<?php View::begin('content');?>
	
<div class="mdui-container-fluid">
	<div class="mdui-typo">
	  <h1>系统安装 <small>绑定账号</small></h1>
	</div>


	 <a class="mdui-btn mdui-btn-raised mdui-float-left" href="?step=1">上一步</a>
	 <a href="<?php echo Onedrive::authorize_url();?>" class="mdui-btn mdui-color-theme-accent mdui-ripple mdui-float-right"><i class="mdui-icon material-icons">&#xeb3d;</i> 绑定账号</a>
      
	</form>

	
</div>

<?php View::end('content');?>