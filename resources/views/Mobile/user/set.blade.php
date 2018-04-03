<!DOCTYPE html>
<html class="bgbai">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>设置</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
	</head>
	<body class="bgbai">
		<!--头部-->
		<div class="header bglan overflow textcenter wbai">
			<a class="fl textcenter" href="/wap/user">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a> 
			<h3 class="sanwu bai textcenter">设置</h3>
		</div>
		<!--头部-->
		<!--设置-->
		<article>
			<div class="shezhi">
				<dl>
					<a class="overflow" href="{{url('/wap/user/index')}}">
						<dt class="fl h2 san">个人资料</dt>
						<dd class="fr h1 san b">
							<i class="iconfont icon-youjiantou h1"></i>
						</dd>
					</a>
				</dl>
				<dl>
					<a class="overflow" href="{{url('/wap/user/changePwd')}}">
						<dt class="fl h2 san">修改密码</dt>
						<dd class="fr h1 san b">
							<i class="iconfont icon-youjiantou h1"></i>
						</dd>
					</a>
				</dl>
			</div>
			<!--设置-->
			<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
			<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
			<script type="text/javascript" src="/mobile/js/lazyload.js"></script>
			@if(!isset($wx))
				<div class="btn" style="margin-top:8.2vw" id="denglu">
					<input class="wbai bai h2" type="button" onclick="javascript:location.href='/wap/logout'" value="退出登录" />
				</div>
			@else
				<div class="btn" style="margin-top:8.2vw" id="denglu">
					<input class="wbai bai h2" type="button" onclick="javascript:;" value="解除微信绑定" />
				</div>
				<script>
					$('#denglu').click(function(){
                        layer.open({
                            content: '确定解除该微信的绑定么？'
                            , btn: ['确定', '取消']
                            , yes: function () {
                                location.href='/wap/user/loseWx';
                            }
                        });
					});
				</script>
			@endif
		</article>
	</body>

</html>