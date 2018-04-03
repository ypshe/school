<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>修改密码</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
		<!--修改密码-->
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script type="text/javascript" src="/mobile/js/lazyload.js"></script>
		<style>
			.title{
				padding:2vw 2.4vw;
			}
		</style>
	</head>
	<body>
		<!--头部-->
		<div class="header bglan overflow textcenter wbai">
			<a class="fl textcenter" href="/wap/user/set">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a>
			<h3 class="sanwu bai textcenter">修改密码</h3>
			<a class="iconfont icon-wo fr h1 c9 b" href="" style="font-size:7vw"></a>
		</div>
		<!--头部-->
		<!--修改密码-->
		<article class="bgbai">
			<div class="xiugai">
				<form action="/wap/user/submitPwd" method="post" id="form">
					{{csrf_field()}}
					<dl class="overflow">
						<dt class="fl h2 san">原密码</dt>
						<dd class="fl">
							<input id="yuan" class="wbai h2 jiu" value="{{old('pwd')}}" type="password" name="pwd" placeholder="原密码" />
						</dd>
					</dl>
					<dl class="overflow">
						<dt class="fl h2 san">新密码</dt>
						<dd class="fl">
							<input id="xin" class="wbai h2 jiu" value="{{old('password1')}}"  type="password" name="password1" placeholder="新密码" />
						</dd>
					</dl>
					<dl class="overflow">
						<dt class="fl h2 san">确认新密码</dt>
						<dd class="fl">
							<input id="xin2" class="wbai h2 jiu" value="{{old('password2')}}" type="password" name="password2" placeholder="确认新密码" />
						</dd>
					</dl>
					<div class="xinxi h2 jiu">
						密码由6-20位英文字母、数字或符号组成
					</div>
					<div class="btn" style="margin-top:8.5vw" id="queren">
						<input type="button" class="bai h2"  value="确认">
					</div>
				</form>
			</div>
		</article>
		<script>
			@if(session('message_error'))
				layer.open({
					content: "{{session('message_error')}}",
					skin: 'msg',
					time: 2 //2秒后自动关闭
				});
			@endif
			$(function(){
				var mm = /^[a-zA-Z\w]{5,17}$/;//验证密码
				$("#queren").click(function(){
					var yuan = $("#yuan").val();
					var xin = $("#xin").val();
					var xin2 = $("#xin2").val();
					if(yuan === ""){
						layer.open({
					       content: '请填写原密码',
					       skin: 'msg',
					       time: 2 //2秒后自动关闭
					    });
					    return false;
					}
					if(xin === ""){
                        layer.open({
                            content: '请填写新密码',
                            skin: 'msg',
                            time: 2 //2秒后自动关闭
                        });
                        return false;
                    }
                    if(xin2 === ""){
                        layer.open({
                            content: '请填写确认新密码',
                            skin: 'msg',
                            time: 2 //2秒后自动关闭
                        });
                        return false;
                    }
                    if(xin2 !== xin){
                        layer.open({
                            content: '两次输入的密码不相同！',
                            skin: 'msg',
                            time: 2 //2秒后自动关闭
                        });
                        return false;
                    }
					if(!yuan.match(mm)){
						layer.open({
					       content: '原密码不合法，请重新输入',
					       skin: 'msg',
					       time: 2 //2秒后自动关闭
					    });
					    return false;
					}
					if(!xin.match(mm)){
						layer.open({
					       content: '新密码不合法，请重新输入',
					       skin: 'msg',
					       time: 2 //2秒后自动关闭
					    });
					    return false;
					}
                    if(xin===yuan){
                        layer.open({
                            content: '新密码与原密码相同，请重新输入',
                            skin: 'msg',
                            time: 2 //2秒后自动关闭
                        });
                        return false;
                    }
					$('#form').submit();
				})
			});
		</script>
		<!--底部-->
		@include('wap_foot')
		<!--底部-->
	</body>

</html>