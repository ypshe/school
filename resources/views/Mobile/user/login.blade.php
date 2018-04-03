<!DOCTYPE html>
<html class="bgbai">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>登录</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
	</head>
	<body class="bgbai">
		<!--登录头部-->
		<div class="header bglan overflow textcenter wbai">
			<a class="fl textcenter" href="javascript:history.go(-1);">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a>
			<h3 class="sanwu bai textcenter">@if(isset($wx))绑定账号@else登录 @endif</h3>
			<a class="fr bai textcenter h2" href="{{url('/wap/register')}}">注册</a>
		</div>
		<!--登录头部-->
		<!--登录主体-->
		<article>
			<div class="dllogo wbai">
				<img src="/mobile/img/logodl.png">
				<span class="textcenter b h2 lancolor">长垣职业中等专业学校继续教育培训平台</span>
			</div>
			<div class="maindl">
				<form id="form" method="post" action="{{url('/wap/attemptLogin')}}">
					{{csrf_field()}}
					<dl class="overflow">
						<dt class="fl textcenter">
							<i class="iconfont icon-wo c9 b h1"></i>
						</dt>
						<dd class="fl">
							<input class="wbai h2 liu" id="shenfenzheng" name="cardId" value="{{ old('cardId') }}" type="text" placeholder="请输入身份证号" />
						</dd>
					</dl>
					<dl class="overflow" style="margin-bottom: 3.4vw;">
						<dt class="fl textcenter">
							<i class="iconfont icon-mima c9 b h1"></i>
						</dt>
						<dd class="fl">
							<input class="wbai h2 liu" id="mima" name="password" value="{{ old('password') }}" type="password" placeholder="请输入密码" />
						</dd>
					</dl>
					<dl class="overflow yan"  style="border-bottom: 1px solid #dddddd;height:7.1vw">
						<div class="fl">
							<dt class="fl textcenter">
								<i class="iconfont icon-wo c9 b h1"></i>
							</dt>
							<dd class="fl">
								<input class="wbai h2 liu" id="yanzhengma"  value="{{ old('captcha') }}" type="text" required placeholder="验证码" name="captcha" />
							</dd>
						</div>
						<dd class="fr tu" style="width:22.2vw">
							<img id="changeSrc" src="{{captcha_src()}}">
						</dd>
						<script>
                            $('#changeSrc').click(function(){
                                $('#changeSrc').attr('src','{{captcha_src()}}'+Math.random());
                            });
						</script>
					</dl>
					<div class="wjmm textright c9 h4">
						忘记密码?
					</div>
					<div class="btn" style="margin-top:8.2vw" id="denglu">
						<input class="wbai bai h2" type="button" value="@if(isset($wx))绑 定@else登 录 @endif" />
					</div>
					{{--@if(!isset($wx)||0)--}}
						{{--<div class="more">--}}
							{{--<span class="textcenter jiu h3">更多登录方式</span>--}}
							{{--<a class="textcenter" href="https://open.weixin.qq.com/sns/explorer_broker?appid={{urlencode(config('wechat.official_account.default.app_id'))}}&redirect_uri=http://www.apanclub.cn&response_type=code&scope=default&state=rfum3y4n&connect_redirect=1#wechat_redirect">--}}
								{{--<i class="iconfont icon-weixin3f lvse" style="font-size:10vw"></i>--}}
							{{--</a>--}}
						{{--</div>--}}
					{{--@endif--}}
				</form>
			</div>
		</article>
		<!--登录主体-->
		<script>
			@if(isset($errors)&&$errors->has('password'))
				layer.open({
					content: '密码错误！',
					skin: 'msg',
					time: 2 //2秒后自动关闭
				});
			@endif
			@if(isset($errors)&&$errors->has('cardId'))
				layer.open({
					content: '身份证号未注册！',
					skin: 'msg',
					time: 2 //2秒后自动关闭
				});
			@endif
			@if(isset($errors)&&$errors->has('captcha'))
				layer.open({
					content: '验证码错误！',
					skin: 'msg',
					time: 2 //2秒后自动关闭
				});
			@endif
			//验证
			var sfz = /^\d{17}[\dxX]{1}$/;//验证身份证
			var mm = /^[a-zA-Z\w]{5,17}$/;//验证密码
			
			$("#denglu").click(function(){
				var shenfengz = $("#shenfenzheng").val();
				var mima = $("#mima").val();
				if(shenfengz == ""){
					layer.open({
				       content: '请填写身份证号',
				       skin: 'msg',
				       time: 2 //2秒后自动关闭
				    });
				    return false;
				}
				if(!shenfengz.match(sfz)){
					layer.open({
				       content: '身份证号不合法请重新输入',
				       skin: 'msg',
				       time: 2 //2秒后自动关闭
				    });
				    return false;
				}
				if(mima == ""){
					layer.open({
				       content: '请填写密码',
				       skin: 'msg',
				       time: 2 //2秒后自动关闭
				    });
				    return false;
				}
				if(!mima.match(mm)){
					layer.open({
				       content: '密码不合法请重新输入',
				       skin: 'msg',
				       time: 2 //2秒后自动关闭
				    });
				    return false;
				}
				$('#form').submit();
			})
		</script>
	</body>

</html>