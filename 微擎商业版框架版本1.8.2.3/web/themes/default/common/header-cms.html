{template 'common/header-base'}
	{if !empty($_W['uid'])}
		{if !empty($_W['uniacid'])}
			<div class="navbar navbar-inverse navbar-static-top" role="navigation" style="position:static;">
				<div class="container-fluid">
					<ul class="nav navbar-nav">
						<li><a href="./?refresh"><i class="fa fa-reply-all"></i>返回系统</a></li>
						{php global $top_nav;}
						{loop $top_nav $nav}
							{if !empty($_W['isfounder']) || empty($_W['setting']['permurls']['sections']) || in_array($nav['name'], $_W['setting']['permurls']['sections'])}<li{if FRAME == $nav['name']} class="active"{/if}><a href="{php echo url('home/welcome/' . $nav['name']);}"><i class="{$nav['append_title']}"></i>{$nav['title']}</a></li>{/if}
						{/loop}
						<li {if $action == 'emulator'}class="active"{/if}>
							<a href="{php echo url('utility/emulator');}" target="_blank"><i class="fa fa-mobile"></i> 模拟测试</a>
						</li>
						{if IMS_FAMILY != 'x'}
						<li><a href="http://bbs.we7.cc"><i class="fa fa-comment"></i>微擎论坛</a></li>
						<li><a href="http://wpa.b.qq.com/cgi/wpa.php?ln=1&key=XzkzODAwMzEzOV8xNzEwOTZfNDAwMDgyODUwMl8yXw"><i class="fa fa-suitcase"></i>联系客服</a></li>
						{/if}
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown topbar-notice">
							<a type="button" data-toggle="dropdown">
								<i class="fa fa-bell"></i>
								<span class="badge" id="notice-total">0</span>
							</a>
							<div class="dropdown-menu" aria-labelledby="dLabel">
								<div class="topbar-notice-panel">
									<div class="topbar-notice-arrow"></div>
									<div class="topbar-notice-head">
										<span>系统公告</span>
										<a href="{php echo url('article/notice-show/list');}" class="pull-right">更多公告>></a>
									</div>
									<div class="topbar-notice-body">
										<ul id="notice-container"></ul>
									</div>
								</div>
							</div>
						</li>
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" style="display:block; max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; "><i class="fa fa-group"></i>{$_W['account']['name']} <b class="caret"></b></a>
							<ul class="dropdown-menu">
								{if $_W['role'] != 'operator'}
								<li><a href="{url 'account/post' array('uniacid' => $_W['uniacid'])}" target="_blank"><i class="fa fa-weixin fa-fw"></i> 编辑当前账号资料</a></li>
								{/if}
								<li><a href="{url 'account/display'}" target="_blank"><i class="fa fa-cogs fa-fw"></i> 管理其它公众号</a></li>
								<li><a href="{url 'utility/emulator'}" target="_blank"><i class="fa fa-mobile fa-fw"></i> 模拟测试</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" style="display:block; max-width:185px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; "><i class="fa fa-user"></i>{$_W['user']['username']} ({if $_W['role'] == 'founder'}系统管理员{elseif $_W['role'] == 'manager'}公众号管理员{else}公众号操作员{/if}) <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="{url 'user/profile/profile'}" target="_blank"><i class="fa fa-weixin fa-fw"></i> 我的账号</a></li>
								{if $_W['role'] == 'founder'}
								<li class="divider"></li>
								<li><a href="{url 'system/welcome'}" target="_blank"><i class="fa fa-sitemap fa-fw"></i> 系统选项</a></li>
								<li><a href="{url 'system/welcome'}" target="_blank"><i class="fa fa-cloud-download fa-fw"></i> 自动更新</a></li>
								<li><a href="{url 'system/updatecache'}" target="_blank"><i class="fa fa-refresh fa-fw"></i> 更新缓存</a></li>
								<li class="divider"></li>
								{/if}
								<li><a href="{url 'user/logout'}"><i class="fa fa-sign-out fa-fw"></i> 退出系统</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		{else}
			<div class="navbar navbar-inverse navbar-static-top" role="navigation" style="z-index:1001;">
				<div class="container-fluid">
					<ul class="nav navbar-nav">
						<li class="active"><a href="./?refresh"><i class="fa fa-cogs"></i>系统管理</a></li>
						<li><a href="{url 'account/display'}" target="_blank"><i class="fa fa-share"></i>管理公众号</a></li>
						{if IMS_FAMILY != 'x'}
						<li><a href="http://bbs.we7.cc"><i class="fa fa-comment"></i>微擎论坛</a></li>
						<li><a href="http://wpa.b.qq.com/cgi/wpa.php?ln=1&key=XzkzODAwMzEzOV8xNzEwOTZfNDAwMDgyODUwMl8yXw"><i class="fa fa-suitcase"></i>联系客服</a></li>
						{/if}
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" style="display:block; max-width:185px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; "><i class="fa fa-user"></i>{$_W['user']['username']} ({if $_W['role'] == 'founder'}系统管理员{elseif $_W['role'] == 'manager'}公众号管理员{else}公众号操作员{/if}) <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="{url 'user/profile/profile'}" target="_blank"><i class="fa fa-weixin fa-fw"></i> 我的账号</a></li>
								{if $_W['role'] != 'operator'}
								<li class="divider"></li>
								<li><a href="{url 'system/welcome'}" target="_blank"><i class="fa fa-sitemap fa-fw"></i> 系统选项</a></li>
								<li><a href="{url 'system/welcome'}" target="_blank"><i class="fa fa-cloud-download fa-fw"></i> 自动更新</a></li>
								<li><a href="{url 'system/updatecache'}" target="_blank"><i class="fa fa-refresh fa-fw"></i> 更新缓存</a></li>
								<li class="divider"></li>
								{/if}
								<li><a href="{url 'user/logout'}"><i class="fa fa-sign-out fa-fw"></i> 退出系统</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		{/if}
	{else}
		<div class="navbar navbar-inverse navbar-static-top" role="navigation" style="z-index:1001;">
			<div class="container-fluid container">
				<ul class="nav navbar-nav navbar-right">
					<li class="active"><a href="{php echo url('user/register');}"><i class="fa fa-user"></i>注册</a></li>
					<li><a href="{php echo url('user/login');}"><i class="fa fa-user-plus"></i>登陆</a></li>
				</ul>
			</div>
		</div>
	{/if}

	<div class="container-fluid">
		{if defined('IN_MESSAGE')}
			<div class="jumbotron clearfix alert alert-{$label}">
				<div class="row">
					<div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
						<i class="fa fa-5x fa-{if $label=='success'}check-circle{/if}{if $label=='danger'}times-circle{/if}{if $label=='info'}info-circle{/if}{if $label=='warning'}exclamation-triangle{/if}"></i>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
						{if is_array($msg)}
							<h2>MYSQL 错误：</h2>
							<p>{php echo cutstr($msg['sql'], 300, 1);}</p>
							<p><b>{$msg['error'][0]} {$msg['error'][1]}：</b>{$msg['error'][2]}</p>
						{else}
						<h2>{$caption}</h2>
						<p>{$msg}</p>
						{/if}
						{if $redirect}
						<p><a href="{$redirect}" class="alert-link">如果你的浏览器没有自动跳转，请点击此链接</a></p>
						<script type="text/javascript">
							setTimeout(function () {
								location.href = "{$redirect}";
							}, 3000);
						</script>
						{else}
							<p>[<a href="javascript:history.go(-1);" class="alert-link">点击这里返回上一页</a>] &nbsp; [<a href="./?refresh" class="alert-link">首页</a>]</p>
						{/if}
					</div>
				</div>
			</div>
		{/if}
