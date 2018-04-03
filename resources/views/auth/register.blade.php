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
		<title>注册</title>
		<link rel="stylesheet" href="/Pc/css/base.css" />
		<link rel="stylesheet" href="/Pc/css/base_start.css" />
		<link rel="stylesheet" href="/Pc/css/zhaohuimima.css" />
        <script type="text/javascript" src="/Pc/js/jquery-1.9.1.min.js" ></script>
        <script type="text/javascript" src="/Pc/js/jquery.SuperSlide.2.1.1.js" ></script>
        <script type="text/javascript" src="/Pc/js/base.js"></script>
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
			<div class="zhuce" id="zhuce">
			<div class="ztop">
				注册
			</div>
			<form action="{{ route('register') }}" method="POST">
                {{ csrf_field() }}
				<div class="zmo">
					<dl>
						<dt>
							<input type="text" placeholder="请输入身份证号码" value="{{ old('cardId') }}" class="sfz" name="cardId" />
							<span class="jieguo">
                                @if ($errors->has('cardId'))
                                    {{ $errors->first('cardId') }}
                                @endif
                            </span>
						</dt>
					</dl>
					<dl style="position:relative;">
						<dt class="y">
							<input class="yan" type="text" placeholder="验证码" value="{{ old('captcha') }}" name="captcha" />
						</dt>
						<span class="jieguo" style="position:absolute;right:0;top:52px;color:red">
                            @if ($errors->has('captcha'))
                                {{ $errors->first('captcha') }}
                            @endif
                        </span>
						<dd style="-webkit-margin-start:0px">
                            <img  id="changeImg" src="{{captcha_src()}}">
                            <script>
                                $('#changeImg').click(function(){
                                    $('#changeImg').attr('src','{{captcha_src()}}'+Math.random());
                                });
                            </script>
						</dd>
					</dl>
					<dl>
						<dt>
							<input type="password" class="mima mima01" value="{{ old('password') }}" placeholder="设置密码(6-18字符，字符、数字和下划线)" name="password" />
							<span class="jieguo">
                                @if ($errors->has('password'))
                                    {{ $errors->first('password') }}
                                @endif
                            </span>
						</dt>
				    </dl>
					<dl>
						<dt>
							<input type="password" class="mima mima02" value="{{ old('password_confirmation') }}" placeholder="再次输入密码" name="password_confirmation" />
							<span class="jieguo">
                            </span>
						</dt>
					</dl>
				</div>
				<div class="btn" id="zhucebtn">
					<input type="button" value="注册"/>
				</div>
			</form>
		</div>
		</div>
		<div class="footers dengluboxb">
			Copyright © 2018-2019 , All Rights Reserved 长垣职业中等专业学校继续教育培训平台  版权所有
		</div>
	</body>
</html>