@extends('layout')
@section('content')
		<link rel="stylesheet" href="/Pc/css/gerenzhongxin.css" />
		<!--导航部分-->
		<!--主体部分-->
		<div class="main">
			<!--面包屑导航-->
			<div class="mianbao">
				<a href="{{url('/')}}">首页</a>
				<span>></span>
				<a href="{{url('/user')}}">个人中心</a>
			</div>
			<!--面包屑导航-->
			<div class="gerenbox">
				<div class="gerentop">
					<div class="gerentouxiang">
						<a href="{{url('/user')}}">
							<img src="{{img_local($user->pic)}}">
						</a>
					</div>
					<span>{{$user->name}}</span>
				</div>
				<div class="gerenbo">
					<div class="gerenbole">
						<dl>
							<dt>
								<i>
									<img src="/Pc/img/icongeren.png">
								</i>
								<span>学习中心</span>
							</dt>
							<dd>
								<a href="">
									<span>在线学习</span>
									<i></i>
								</a>
								<a href="">
									<span>在线练习</span>
									<i></i>
								</a>
								<a href="">
									<span>在线考试</span>
									<i></i>
								</a>
								<a href="{{url('/user/errorExam')}}">
									<span>错题库</span>
									<i></i>
								</a>
								<a href="">
									<span>考核情况</span>
									<i></i>
								</a>
								<a href="">
									<span>在线留言</span>
									<i></i>
								</a>
								<a href="">
									<span>资料下载</span>
									<i></i>
								</a>
							</dd>
						</dl>
						<dl>
							<dt>
								<i>
									<img src="/Pc/img/icongeren02.png">
								</i>
								<span>个人中心</span>
							</dt>
							<dd>
								<a class="on" href="">
									<span>个人资料</span>
									<i></i>
								</a>
								<a href="">
									<span>订单管理</span>
									<i></i>
								</a>
								<a href="">
									<span>教育档案</span>
									<i></i>
								</a>
							</dd>
						</dl>
						<dl>
							<dt>
								<i>
									<img src="/Pc/img/icongeren03.png">
								</i>
								<span>客服中心</span>
							</dt>
							<dd class="kefu">
								<a>
									<span>服务热线</span>
									<b>400-2564-2564</b>
									<img src="/Pc/img/erweima02.jpg">
									<span class="sao">扫一扫<br>手机也能看</span>
								</a>
							</dd>
						</dl>
					</div>
					<div class="gerenbori">
						<h2>个人资料</h2>
						<div class="lianxi">
							<div class="lianxitop">
								<span @if(!session('userIndexType'))class="on"@endif>个人资料</span>
								<span @if(session('userIndexType')==1)class="on"@endif>修改密码</span>
								<span @if(session('userIndexType')==2)class="on"@endif>上传资料</span>
							</div>
							<!--个人资料-->
							<div class="ziliao" style="display: block;">
								<form id="editUser" method="post" action="{{url('/user/edit')}}" enctype="multipart/form-data">
									<input type="hidden" name="_token" value="{{csrf_token()}}"/>
									<input type="hidden" name="cardIdOld" value="{{$user->cardId}}">
									<dl>
										<dt style="margin-top:17px;">头像：</dt>
										<dd class="z_photo upimg-div clear">
											<div class="touxbox">
												<img src="{{img_local($user->pic)}}">
											</div>
											<div class="xiugai z_file fl">
												<label>
													<span>修改头像</span>
													<input type="file" name="pic" id="file" class="file" value="" accept="image/jpg,image/jpeg,image/png,image/bmp" multiple />
												</label>
											</div>
										</dd>
									</dl>
									<dl>
										<dt>姓名：</dt>
										<dd class="inputs">
											<input type="text" name="name" id="xingming" value="{{old('name',$user->name)}}" />
										</dd>
									</dl>
									<dl>
										<dt>性别：</dt>
										<dd class="labels">
											<label>
												<input type="radio" value="男"  name="sex" @if(old('sex',$user->sex)=='男')checked="checked"@endif />
												男
											</label>
											<label>
												<input type="radio" value="女" name="sex" @if(old('sex',$user->sex)=='女')checked="checked"@endif />
												女
											</label>
										</dd>
									</dl>
									<dl>
										<dt>民族：</dt>
										<dd class="inputs">
											<input type="text" name="nationality" id="xingming" value="{{old('nationality',$user->nationality)}}" />
										</dd>
									</dl>
									<dl>
										<dt>政治面貌：</dt>
										<dd class="labels">
											<label>
												<input type="radio" value="党员" name="political" @if(old('political',$user->political)=='党员')checked="checked"@endif/>
												党员
											</label>
											<label>
												<input type="radio" value="群众" name="political" @if(old('political',$user->political)=='群众')checked="checked"@endif/>
												群众
											</label>
										</dd>
									</dl>
									<dl>
										<dt>身份证号：</dt>
										<dd class="inputs">
											<input type="text" name="cardId" id="shenfenz" value="{{old('cardId',$user->cardId)}}" />
										</dd>
									</dl>
									<dl>
										<dt>手机号：</dt>
										<dd class="inputs">
											<input type="mobile" name="phone" id="shenfenz" value="{{old('phone',$user->phone)}}" />
										</dd>
									</dl>
									<dl>
										<dt>籍贯：</dt>
										<dd class="selects" id="demo1">
											<select id="where_p" name="where_p">
												@foreach($p as $v)
													<option @if(old('where_p',$user->where_p)==$v->id)selected="selected" @endif  value="{{$v->id}}">
														{{$v->name}}
													</option>
												@endforeach
											</select>
											<select id="where_c" name="where_c">
											</select>
										</dd>
									</dl>
									<dl>
										<dt>住址：</dt>
										<dd class="selects" id="demo2">
											<select id="home_p" name="home_p">
												@foreach($p as $v)
													<option @if(old('home_p',$user->home_p)==$v->id)selected="selected" @endif value="{{$v->id}}">
														{{$v->name}}
													</option>
												@endforeach
											</select>
											<select id="home_c" name="home_c">
												<option></option>
											</select>
											<select id="home_a" name="home_a">
												<option></option>
											</select>
											<input id="home" type="text" style='width:300px' class="inputs" name="home" value="{{old('home',$user->home)}}" />
										</dd>
									</dl>
									<dl>
										<dt>输入密码：</dt>
										<dd class="inputs">
											<input type="password" name="password" id="password" value="" />
										</dd>
									</dl>
									<script>
                                        function getAddr(obj,pid,select){
											$.ajax({
												url:'/ajax/addr?q='+pid,
												type:'get',
												success:function(data){
												    var str='';
                                                    $.each(data,function(){
												        str+= '<option '+(select===this.id?'selected="selected"':' ')+' value="'+this.id+'">'+this.name+'</option>'
													});
												    obj.html(str);
												}
											});
                                        }
										@if(old('where_c',$user->where_c))
                                        	getAddr($('#where_c'),{{old('where_p',$user->where_p)}},{{old('where_c',$user->where_c)}});
										@endif
										@if(old('home_c',$user->home_c))
                                        	getAddr($('#home_c'),{{old('home_p',$user->home_p)}},{{old('home_c',$user->home_c)}});
										@endif
										@if(old('home_a',$user->home_a))
                                        	getAddr($('#home_a'),{{old('home_c',$user->home_c)}},{{old('home_a',$user->home_a)}});
										@endif
                                        $('#where_p').change(function(){
                                            getAddr($('#where_c'),$(this).val(),0);
                                        });
                                        $('#where_c').change(function(){
                                            getAddr($('#where_a'),$(this).val(),0);
                                        });
                                        $('#home_p').change(function(){
                                            getAddr($('#home_c'),$(this).val(),0);
                                        });
                                        $('#home_c').change(function(){
                                            getAddr($('#home_a'),$(this).val(),0);
                                        });
									</script>
									<dl>
										<dt></dt>
										<dd class="btndd" style="position: inherit;">
											<input id="btn" class="btn" type="button" value="保存" />
										</dd>
									</dl>
								</form>
							</div>
							<!--个人资料-->
							<!--修改密码-->
							<div class="ziliao mima">
								<form action="{{url('/user/updatePwd')}}" method="POST">
									<input type="hidden" name="_token" value="{{csrf_token()}}"/>
									<input type="hidden" name="id" value="{{$user->id}}">
									<ul>
										<li>
											<i>旧密码</i>
											<input value="{{old('pwd',$user->pwd)}}" name="pwd" type="password" />
										</li>
										<li>
											<i>新密码</i>
											<input value="{{old('password1',$user->password1)}}" name="password1" id="newpass" type="password" />
											<span></span>
										</li>
										<li>
											<i>确认新密码</i>
											<input value="{{old('password2',$user->password2)}}" name="password2" id="newpass2" type="password" />
											<span></span>
										</li>
										<div class="btndd" style="margin-top:25px;position: inherit;margin-left: 0;">
											<input id="tijiao" class="btn" type="submit" value="提交" />
										</div>
									</ul>
								</form>
							</div>
							<!--修改密码-->
							<!--上传资料-->
							<div class="ziliao">
								<div class="shangchuantop">
									<form>
										<dl>
											<dt>资料类型：</dt>
											<dd class="selects">
												<select style="width:235px;">
													<option>个人资料</option>
													<option>报名表格</option>
												</select>
											</dd>
										</dl>
										<dl>
											<dt>上传资料：</dt>
											<dd class="inputs">
												<input type="text" id="ziliao"  value="" />
											</dd>
										</dl>
										<dl>
											<dt></dt>
											<dd class="btndd" style="position: inherit;">
												<input id="shangchuan" class="btn" type="button" value="上传" />
											</dd>
										</dl>
									</form>
								</div>
								<div class="shangchuanbo">
									<div class="shangchuanbole">
										已传资料
									</div>
									<div class="shangchuanbori">
										<div class="shangtop">
											<span>01.个人资料.doc</span>
											<a href="">下载</a>
											<a href="">修改</a>
										</div>
										<div class="shangtop">
											<span>02.个人资料.doc</span>
											<a href="">下载</a>
											<a href="">修改</a>
										</div>
									</div>
								</div>
							</div>
							<!--上传资料-->
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--主体部分-->
		<script type="text/javascript" src="/Pc/js/upload.min.js"></script>
		<script type="text/javascript" src="/Pc/js/jquery.citys.js"></script>
		<script>
			@if($user->status==0&&!session('message_error'))
            	layer.msg('观看学习视频需要将个人资料补充完整，请将个人资料补充完整！', {time: 5000, icon:3});
			@endif
			@if(session('message_error'))
            	layer.msg('{{session('message_error')}}', {time: 5000, icon:3});
			@endif
			$(function(){
				//tab切换
				$(".lianxitop span").click(function(){
					$(this).addClass("on").siblings().removeClass("on");
					var index = $(".lianxitop span").index(this);
					$(".ziliao").hide();
					$(".ziliao").eq(index).show();
				});
				@if(session('userIndexType'))
					var index ={{session('userIndexType')}}
					$(".ziliao").hide();
					$(".ziliao").eq(index).show();
				@endif
				$("#btn").click(function(){
					var xingming = $("#xingming").val();
					var shenfenz = $("#shenfenz").val();
					var status=1;
					if(xingming == ""){
					    status=0;
                        layer.msg("请填写姓名");
					}
					if(shenfenz == ""){
					    status=0;
                        layer.msg("请填写身份证号");
					}
					if(status){
					    $('#editUser').submit();
					}
				});
				var ms = /^[a-zA-Z]\w{5,17}$/;//验证密码
				var v01;
				var v02;
				$("[name='mima01']").blur(function(){
					v01 = $(this).val();
					if (v01 == '') {
						$(this).next("span").html("密码不能为空！");
					}else if(!v01.match(ms)){
						$(this).next("span").html("密码不合法！");
					}else{
						$(this).next("span").html("");
					}
				});
				$("[name='mima02']").blur(function(){
					v02 = $(this).val();
					if (v02 == '') {
						$(this).next("span").html("密码不能为空！");
					}else if(v02 != v01){
						$(this).next("span").html("密码不一样！");
					}else{
						$(this).next("span").html("");
					}
				});
				$("#tijiao").click(function(){
					var pass01 = $("#newpass").val();
					var pass02 = $("#newpass2").val();
				})
			})
		</script>
	@endsection