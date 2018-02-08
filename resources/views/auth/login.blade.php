<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>登录</title>
		<link rel="stylesheet" href="/Pc/css/base.css" />
		<link rel="stylesheet" href="/Pc/css/zhaohuimima.css" />
		<script type="text/javascript" src="/Pc/js/jquery-1.9.1.min.js" ></script>
		<script type="text/javascript" src="/Pc/js/jquery.SuperSlide.2.1.1.js" ></script>
		<script src="/Pc/js/base.js"></script>
	</head>
	<body>
		<div class="zhaohuitop">
			<div class="zhaohuitoptext">
				<div class="zhaohuitoptextle">
					<img src="/Pc/img/logo.png">
				</div>
			</div>
		</div>
		<div class="zhaohuibo denglubox">
			<div class="zhuce denglu" id="denglu">
			<div class="ztop">
				登录
			</div>
			<form  method="POST" action="{{url('login')}}">
				<input type="hidden" name="_token" value="{{csrf_token()}}"/>
				<div class="zmo">
					<dl>
						<dt>
							<input type="text" class="sfz"  value="{{ old('cardId') }}"  placeholder="请输入身份证号码" name="cardId" />
							<span class="jieguo">
								@if ($errors->has('cardId'))
									{{ $errors->first('cardId') }}
								@endif
							</span>
						</dt>
					</dl>
					<dl>
						<dt>
							<input type="password" class="mima mima01"  value="{{ old('password') }}"  placeholder="密码" name="password" />
							<span class="jieguo">
								@if ($errors->has('password'))
									{{ $errors->first('password') }}
								@endif
							</span>
						</dt>
					</dl>
					<dl>
						<dt>
							<div style="float: left">
								<input style="width:280px" class="yan"  value="{{ old('captcha') }}" type="text" required placeholder="验证码" name="captcha" />
							</div>
							<div style="padding-top:2px;padding-left:5px;float: left">
								<img style='height: 42px; line-height: 48px;display:inline' width="120px"  id="changeImg" src="{{captcha_src()}}">
								<script>
                                    $('#changeImg').click(function(){
                                        $('#changeImg').attr('src','{{captcha_src()}}'+Math.random());
                                    });
								</script>
							</div>
							<span class="jieguo" id="resCaptche">
								@if ($errors->has('captcha'))
									{{ $errors->first('captcha') }}
								@endif
							</span>
						</dt>
					</dl>
				</div>
				<div class="btn" id="denglubtn">
					<input type="button" value="登录"/>
				</div>
				<div class="wj">
					<a href="">忘记密码?</a>
					<a class="go" href="javascript:;">去注册</a>
				</div>
			</form>
		</div>
		</div>
		<div class="footers dengluboxb">
			Copyright © 2018-2019 , All Rights Reserved 长垣职业中等专业学校继续教育培训平台  版权所有
		</div>
	</body>

</html>