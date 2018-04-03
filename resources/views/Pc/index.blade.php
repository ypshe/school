@extends('layout')
@section("content")
	<style>
		.yanzhengma img{
			padding-top: 2px;
		}
		.qita{
			background:url(Pc/img/bj_03.png) repeat center top !important;
}
	</style>
	<!--banner部分-->
	<div class="banner">
		<div class="bannerbox">
			<div class="bd">
				<ul>
					@foreach($banner as $v)
						<li>
							<a href="#">
								<img src="{{img_local($v->src)}}">
							</a>
						</li>
					@endforeach
				</ul>
			</div>
			<div class="hd">
				<ul>
					<li></li>
					<li></li>
					<li></li>
				</ul>
			</div>
		</div>
		<!--用户登录（未登录）-->
		@if(!\Illuminate\Support\Facades\Auth::check())
		<div class="loginbox">
			<form method="POST" action="{{url('login')}}">
				<input type="hidden" name="_token" value="{{csrf_token()}}"/>
				<h2>
					用户登录
				</h2>
				<dl>
					<dt>身份证号：</dt>
					<dd>
						<input type="text" class="yhm" name="cardId" value="{{ old('cardId') }}"/>
							<span>
								@if ($errors->has('cardId'))
									{{ $errors->first('cardId') }}
								@endif
							</span>
					</dd>
				</dl>
				<dl>
					<dt>密&nbsp;&nbsp;码：</dt>
					<dd>
						<input type="password" class="mimai" name="password" value="{{ old('password') }}"/>
						<span>
							@if ($errors->has('password'))
								{{ $errors->first('password') }}
							@endif
						</span>
					</dd>
				</dl>
				<div class="yanzhengma">
					<dl>
						<dt>验证码：</dt>
						<dd>
							<input type="text" class="captcha" name="captcha" value="{{ old('captcha') }}">
						</dd>
					</dl>
					<img id="changeImg" src="{{captcha_src()}}">
					<script>
                        $('#changeImg').click(function(){
                            $('#changeImg').attr('src','{{captcha_src()}}'+Math.random());
                        });
					</script>
					<span class="yanzjieguo">
						@if ($errors->has('captcha'))
							{{ $errors->first('captcha') }}
						@endif
					</span>
				</div>
				<div class="jizhu">
					<label>
						<input name="remember" type="checkbox" />
						<span>记住密码</span>
					</label>
					<a href="{{url('/password/reset')}}">忘记密码？</a>
				</div>
				<div class="btn" id="dl">
					<input type="button" class="button" value="登录" />
				</div>
				<div class="jizhu">
					<a href="{{url('/register')}}">还没有账号，现在注册</a>
				</div>
			</form>
		</div>
		<!--用户登录（未登录）-->
		@else
		<!--用户登录（已登录）-->
		<div class="loginbox">
			<h2>
				用户信息
			</h2>
			<div class="touxiang">
				<a href="{{url('/user')}}">
					<img src="@if(\Illuminate\Support\Facades\Auth::user()->pic){{img_local(\Illuminate\Support\Facades\Auth::user()->pic)}}@else /Pc/img/touxiang.png @endif">
				</a>
			</div>
			<h3>{{\Illuminate\Support\Facades\Auth::user()->name}}</h3>
			<div class="tishi">
				您已成功登陆继续教育培训平台
			</div>
			<div class="other">
				<dl>
					<a href="{{url('/user')}}">
						<dt>

						</dt>
						<dd>
							个人中心
						</dd>
					</a>
				</dl>
				<dl style="border-right:none;border-left:none;">
					<a href="{{url('/study')}}">
						<dt class="dt02">

						</dt>
						<dd>
							立即学习
						</dd>
					</a>
				</dl>
				<dl style="border-bottom: none;border-top:none">
					<a href="{{url('/user/ask')}}">
						<dt class="dt03">

						</dt>
						<dd>
							查看留言
						</dd>
					</a>
				</dl>
				<dl style="border-bottom: none;border-right:none;border-top:none;border-left:none;">
					<a href="{{url('/logout')}}">
						<dt class="dt04">

						</dt>
						<dd>
							退出登录
						</dd>
					</a>
				</dl>
			</div>
		</div>
		<!--用户登录（已登录）-->
		@endif
	</div>
		<!--主体部分-->
		<div class="main">
			<!--培训流程-->
			<div class="liucheng">
				<div class="liuchengle">
					<div class="liuchenglem">
						<img src="Pc/img/icon15.png">
						<span>培训流程</span>
					</div>
				</div>
				<div class="liuchengmo">
					<dl>
						<dt>
							<img src="Pc/img/liucheng01.png">
						</dt>
						<dd>用户注册</dd>
					</dl>
					<i>
						<img src="Pc/img/icon16.png">
					</i>
					<dl>
						<dt>
							<img src="Pc/img/liucheng02.png">
						</dt>
						<dd>报班缴费</dd>
					</dl>
					<i>
						<img src="Pc/img/icon16.png">
					</i>
					<dl>
						<dt>
							<img src="Pc/img/liucheng03.png">
						</dt>
						<dd>在线学习</dd>
					</dl>
					<i>
						<img src="Pc/img/icon16.png">
					</i>
					<dl>
						<dt>
							<img src="Pc/img/liucheng04.png">
						</dt>
						<dd>在线练习</dd>
					</dl>
					<i>
						<img src="Pc/img/icon16.png">
					</i>
					<dl>
						<dt>
							<img src="Pc/img/liucheng05.png">
						</dt>
						<dd>在线考试</dd>
					</dl>
					<i>
						<img src="Pc/img/icon16.png">
					</i>
					<dl>
						<dt>
							<img src="Pc/img/liucheng06.png">
						</dt>
						<dd>档案记载</dd>
					</dl>
				</div>
				<div class="liuchengri">
					<a href="{{url('/getStudy')}}">
						<h2>立即报名</h2>
						<span>点击参加专业课程学习</span>
					</a>
				</div>
			</div>
			<!--培训流程-->
			<!--精品课程-->
			<div class="jingpinke">
				<div class="title">
					<h2>精品课程</h2>
					<div class="titletab">
						<a class="on" href="">
							全部
						</a>
						@foreach($data['proSix'] as $v)
							<a href="{{url('study/'.$v['id'])}}">
								{{$v['name']}}
							</a>
						@endforeach
					</div>
					<div class="titlemore">
						<a href="{{url('/study')}}">
							<img src="Pc/img/icon18.png">
						</a>
					</div>
				</div>
				<div class="protext">
					@foreach($data['studies'] as $v)
						<dl>
							<a href="{{url('/studyDesc/'.$v->id)}}">
								<dt>
									<img src="{{img_local($v->pic)}}">
								</dt>
								<dd>
									<h4 title="{{$v->name}}">{{$v->name}}</h4>
									<span>讲师：{{$v->tname}}</span>
									<span>职务：{{$v->twork}}</span>
								</dd>
							</a>
						</dl>
					@endforeach
				</div>
			</div>
			<!--精品课程-->
			<!--通知公告、工作动态、培训指南-->
			<div class="mainbo">
				<div class="gonggao">
					<div class="title">
						<h2>通知公告</h2>
						<div class="titlemore">
							<a href="{{url('/notice')}}">
								<img src="Pc/img/icon18.png">
							</a>
						</div>
					</div>
					<div class="nbanner">
						<a href="#">
							<img src="Pc/img/gonggao.jpg">
						</a>
					</div>
					<div class="new">
						@foreach($notices as $v)
							<dl>
								<a title="{{$v->title}}" href="{{url('/notice/'.$v->id)}}">
									<dt>{{$v->title}}</dt>
									<dd>[{{date('Y-m-d',strtotime($v->created_at))}}]</dd>
								</a>
							</dl>
						@endforeach
					</div>
				</div>
				<div class="gonggao dongtai">
					<div class="title">
						<h2>工作动态</h2>
						<div class="titlemore">
							<a href="{{url('/work')}}">
								<img src="Pc/img/icon18.png">
							</a>
						</div>
					</div>
					<div class="nbanner">
						<a href="#">
							<img src="Pc/img/dongtai.jpg">
						</a>
					</div>
					<div class="new">
						@foreach($works as $v)
							<dl>
								<a title="{{$v->title}}" href="{{url('/work/'.$v->id)}}">
									<dt>{{$v->title}}</dt>
									<dd>[{{date('Y-m-d',strtotime($v->created_at))}}]</dd>
								</a>
							</dl>
						@endforeach
					</div>
				</div>
				<div class="zhinan">
					<div class="peixun">
						<div class="peititle">
							<img src="Pc/img/icon17.png">
							<span>培训指南</span>
						</div>
						<div class="peixunb">
							<a href="{{url('/help/1')}}">
								培训<br>流程
							</a>
							<a style="margin-left:27px;margin-right: 28px;" href="{{url('/help/3')}}">
								培训<br>须知
							</a>
							<a  href="{{url('/help/2')}}">
								操作<br>演示
							</a>
						</div>
					</div>
					<div class="peixun mingdan">
						<div class="peititle">
							<img src="Pc/img/icon19.png">
							<span>最新考试通过名单</span>
						</div>
						<div class="mingdanb">
							<div class="mingdanbtop">
								<span>地区</span>
								<span style="text-align: center;">姓名</span>
								<span style="width:98px;text-align: right;">通过时间</span>
							</div>
							<div class="mingdanbbo">
								<div class="bd">
									<ul>
										@foreach($paste as $k=>$v)
											<li>
												<span>{{$v->home}}</span>
												<span style="text-align: center;">{{$v->uname}}</span>
												<span style="width:98px;text-align: right;">{{$v->time}}</span>
											</li>
										@endforeach
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--通知公告、工作动态、培训指南-->
		</div>
		<!--主体部分-->

		<!--表单验证-->
		<script type="text/javascript">
		var s = /^\d{15}|\d{17}[xX]{1}$/; //验证身份证
		var d = /^[a-zA-Z0-9]{6,18}$/;//验证密码
		var status=1;
		$("[name='name']").blur(function() {
			var v = $(this).val();
			if (v == '') {
				$(this).next("span").html("身份证不能为空！");
                status=0;
			}else if(!v.match(s)){
				$(this).next("span").html("身份证不合法！");
                status=0;
            }else{
				$(this).next("span").html("");
			} 
		});
		$("[name='yan']").blur(function() {
			var v = $(this).val();
			if (v == '') {
				$(this).parents(".yanzhengma").children("span").html("验证码不能为空！");
                status=0;
            }else{
				$(this).parents(".yanzhengma").children("span").html("");
			} 
		});
		$("[name='mima']").blur(function() {
			var v = $(this).val();
			if (v == '') {
				$(this).next("span").html("密码不能为空！");
                status=0;
            }else if(!v.match(d)){
				$(this).next("span").html("密码不合法！");
                status=0;
            }else{
				$(this).next("span").html("");
			} 
		});
		//点击登录之后
		$('#dl').click(function(){
			var name = $(this).parent("form").find(".yhm").val();
			var yan = $(this).parent("form").find(".captcha").val();
			var mima = $(this).parent("form").find(".mimai").val();
			var status =1;
			if (name=="") {
				$(this).parent("form").find(".yhm").next("span").html("身份证号不能为空");
                status=0;
            }else if(!name.match(s)){
				$(this).parent("form").find(".yhm").next("span").html("请输入正确格式的身份证号");
                status=0;
            }else{
				$(this).parent("form").find(".yhm").next("span").html("");
			};
			if (yan == "") {
				$(this).parent("form").find(".yanzjieguo").html("验证码不能为空");
                status=0;
            }else{
				$(this).parent("form").find(".yanzjieguo").html("");
			};
			
			
			if (mima == "") {
				$(this).parent("form").find(".mimai").next("span").html("密码不能为空");
                status=0;
            }else if(!mima.match(d)){
				$(this).parent("form").find(".mimai").next("span").html("请输入正确的密码");
                status=0;
            }else{
				$(this).parent("form").find(".mimai").next("span").html("");
			}
			if(status==1){
                $(this).parent("form").submit();
			}
		});

		</script>
		<!--表单验证-->
		@endsection