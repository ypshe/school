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
		<title>密码找回-设置新密码</title>
		<link rel="stylesheet" href="/Pc/css/base.css" />
		<link rel="stylesheet" href="/Pc/css/base_start.css" />
		<link rel="stylesheet" href="/Pc/css/zhaohuimima.css" />
	</head>
	<body>
		<div class="zhaohuitop">
			<div class="zhaohuitoptext">
				<div class="zhaohuitoptextle">
					<img src="/Pc/img/logo.png">
					<span>密码找回</span>
				</div>
			</div>
		</div>
		<div class="zhaohuibo">
			<div class="zhaohuibotop">
				<div class="zhaohuile">
					<i>1</i>
					<span>填写邮箱</span>
				</div>
				<div class="zhaohuile on" style="margin-left: 173px;margin-right: 213px;">
					<i>2</i>
					<span>设置新密码</span>
				</div>
				<div class="zhaohuile">
					<i>3</i>
					<span>完成</span>
				</div>
			</div>
			<div class="zhaohuibobo">
				<form id="formEmail" class="form-horizontal" method="POST" action="{{ route('password.request') }}">
					{{ csrf_field() }}
				<dl>
					<dt>身份证号：</dt>
					<dd>
						<input type="text" value="{{ old('cardId') }}" name="cardId" placeholder="请输入您的身份证号"/>
						<input type="hidden" value="{{ request('token')}}" name="token" placeholder="请输入您的身份证号"/>
						@if ($errors->has('cardId'))
							<span class="help-block">
								<strong>{{ $errors->first('cardId') }}</strong>
							</span>
						@endif
					</dd>
				</dl>
				<dl>
					<dt>邮箱地址：</dt>
					<dd>
						<input type="text" value="{{ $email or old('email') }}" name="email" placeholder="请输入您的邮箱"/>
						@if ($errors->has('email'))
							<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
						@endif
					</dd>
				</dl>
				<dl>
					<dt>新密码：</dt>
					<dd>
						<input type="password" value="{{ old('password') }}" name="password" placeholder="请输入密码"/>
						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</dd>
				</dl>
				<dl>
					<dt>确认密码：</dt>
					<dd>
						<input type="password" value="{{ old('password_confirmation') }}" name="password_confirmation" placeholder="请再次输入密码" />
						@if ($errors->has('password_confirmation'))
							<span class="help-block">
								<strong>{{ $errors->first('password_confirmation') }}</strong>
							</span>
						@endif
					</dd>
				</dl>
				<div class="btn anniu">
					<a href="javascript:;" onclick="submitForm()" style="border:none;margin-top:0;color:#ffffff">下一步</a>
				</div>
				</form>
			</div>
		</div>
		<div class="footers">
			Copyright © 2018-2019 , All Rights Reserved 长垣职业中等专业学校继续教育培训平台  版权所有
		</div>
		<script type="text/javascript" src="/Pc/js/jquery-1.9.1.min.js" ></script>
		<script>
            function submitForm(){
                $('#formEmail').submit();
            }
		</script>
	</body>

</html>