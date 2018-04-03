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
		<title>密码找回-填写邮箱</title>
		<link rel="stylesheet" href="/Pc/css/base.css" />
		<link rel="stylesheet" href="/Pc/css/base_start.css" />
		<link rel="stylesheet" href="/Pc/css/zhaohuimima.css" />
		<script type="text/javascript" src="/Pc/js/jquery-1.9.1.min.js" ></script>
		<script type="text/javascript" src="/vendor/layer/layer.js" ></script>
		<script>
            var yx = new RegExp("^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$");
            var youxiang;
            var yanzhengma;
            $("[name='youxiang']").blur(function(){
                youxiang = $(this).val();
                if (youxiang == '') {
                    $(this).next("span").html("邮箱不能为空！");
                }else if(!youxiang.match(yx)){
                    $(this).next("span").html("邮箱不合法！");
                }else{
                    $(this).next("span").html("");
                }
            });
            $("[name='yanzhengma']").blur(function(){
                yanzhengma = $(this).val();
                if (yanzhengma == '') {
                    $(this).next("span").html("验证码不能为空！");
                }else{
                    $(this).next("span").html("");
                }
            });
		</script>
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
				<div class="zhaohuile on">
					<i>1</i>
					<span>填写邮箱</span>
				</div>
				<div class="zhaohuile" style="margin-left: 173px;margin-right: 213px;">
					<i>2</i>
					<span>设置新密码</span>
				</div>
				<div class="zhaohuile">
					<i>3</i>
					<span>完成</span>
				</div>
			</div>
			<div class="zhaohuibobo">
				<form method="POST" id="formEmail" action="{{ route('password.email') }}" >
					{{ csrf_field() }}
					<dl>
					<dt>邮箱：</dt>
					<dd>
						<input id="email" type="email" class="form-control" placeholder="请输入邮箱" name="email" value="{{ old('email') }}" required>
						@if ($errors->has('email'))
							<span>
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</dd>
				</dl>
				<div class="btn anniu">
					<a onclick="submitForm()" style="border:none;margin-top:0;color:#ffffff">下一步</a>
				</div>
				<script>
					function submitForm(){
						$('#formEmail').submit();
					}
				</script>
				</form>
			</div>
		</div>
        @if (session('status'))
            <script>
                layer.msg('邮件已发送，请登录邮箱进行下一步操作！');
            </script>
        @endif
		<div class="footers">
			Copyright © 2018-2019 , All Rights Reserved 长垣职业中等专业学校继续教育培训平台  版权所有
		</div>
	</body>

</html>