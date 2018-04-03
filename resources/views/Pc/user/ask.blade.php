@extends('layout')
@section('content')
	@if(isset($success))
		<script>
			layer.msg('留言成功！');
		</script>
	@endif
		<!--导航部分-->
		<!--我要留言-->
		<div class="zhuce" id="liuyan" style=" height:393px;margin-top:-200px;">
			<div class="guanbi">
				<img src="/Pc/img/guanbi.png">
			</div>
			<div class="ztop">
				我要留言
			</div>
			<div class="zmob">
				<form action="{{url('/user/addAsk')}}" id="submitForm" method="post">
					{{csrf_field()}}
					<textarea id="content" style="font-size: 16px;" name="content" placeholder="请输入想要留言的内容">{{old('content')}}</textarea>
					<br>
					<div style="float: left;margin-left:30px;height:42px;line-height: 42px;font-size: 16px">请输入验证码：</div>
					<div style="float: left;height:42px">
						<input style="width:140px;height:28px;margin-top:5px" class="yan"  value="{{ old('captcha') }}" type="text" required placeholder="验证码" name="captcha" />
					</div>
					<div style="padding-top:2px;padding-left:5px;float: left">
						<img style='height: 42px; line-height: 48px;display:inline' onclick="this.src='{{captcha_src()}}'+Math.random()" width="120px"  id="changeImg" src="{{captcha_src()}}">
					</div>
					<span class="jieguo" id="resCaptche" style="height:42px;line-height: 42px;font-size: 16px;color:red">&nbsp;&nbsp;&nbsp;
						@if ($errors->has('captcha'))
							{{ $errors->first('captcha') }}
						@endif
					</span>
					<div class="btndd" style="position: inherit;margin-left: 582px;margin-top:-30px;width:auto;">
						<input id="liuyantijiao" type="button" class="btn" value="提交" />
					</div>
				</form>
			</div>
		</div>
		<!--我要留言-->
		<div class="zhe"></div>
		<!--主体部分-->
		<div class="main">
			<!--面包屑导航-->
			<div class="mianbao">
				<a href="{{url('/')}}">首页</a>
				<span>></span>
				<a href="{{url('/user')}}">个人中心</a>
				<span>></span>
				<a href="{{url('/user/ask')}}">在线留言</a>
			</div>
			<!--面包屑导航-->
			<div class="gerenbox">
				@include('user_public')
					<div class="gerenbori" style="min-height: 847px;">
						<h2>在线留言</h2>
						<div class="chaxun cuotic">
							<form>
								<span>标题：</span>
								<input class="shuru" type="text" name="name" value="@if(isset($search)){{$search}}@endif">
								<span class="jieguo"></span>
								<input type="button" id="sousuo" class="btn cx" value="搜索">
								<a href="javascript:;" id="woyaoliuyan">我要留言</a>
							</form>
						</div>
						<div class="chaxliebiao cuotict dayin">
							<table>
								<thead>
									<td width="370">留言内容</td>
									<td style="text-align: center;padding-left: 0;">时间</td>
									<td style="text-align: center;padding-left: 0;">状态</td>
									<td style="text-align: center;padding-left: 0;">操作</td>
								</thead>
								<tbody>
								@if($ask)
									@foreach($ask as $v)
										<tr id="{{$v->id}}">
											<td width="370" class="biaoti">{{$v->content}}</td>
											<td style="text-align: center;padding-left: 0;">{{$v->created_at}}</td>
											<td style="text-align: center;padding-left: 0;" class="yihuifu">
												@if($v->status==1||$v->status==2)
													已回复
												@else
													未回复
												@endif
											</td>
											<td style="text-align: center;padding-left: 0;">
												@if($v->status==1||$v->status==2)
												<a href="javascript:;" onclick="chakanliuyan({{$v->id}})">查看</a>
												@else
													&nbsp;
												@endif
											</td>
										</tr>
									@endforeach
								@endif
								</tbody>
							</table>
                            <?php echo $ask->render(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--主体部分-->
		<script>
			$("#sousuo").click(function(){
				var value = $(this).prev().prev(".shuru").val();
				location.href='{{url('/user/ask')}}'+'/'+value;
			});
			$("#liuyantijiao").click(function(){
				var liuyan = $('#content').val();
				if(liuyan == ""){
					layer.msg("请填写留言内容");
				}else if($('.yan').val()==''){
                    layer.msg("请填写验证码");
                }else{
				    $('#submitForm').submit();
				}
			});
			$("#woyaoliuyan").click(function(){
				$("#liuyan").show();
				$(".zhe").show();
			});
			function chakanliuyan(value){
			    $.ajax({
					url:'/ajax/askDesc/'+value,
					type:'GET',
					dataType:'json',
					success:function(data){
						layer.open({
                            type: 1,
                            skin: 'layui-layer-demo', //样式类名
                            closeBtn: 0, //不显示关闭按钮
                            anim: 2,
                            shadeClose: true, //开启遮罩关闭
                            content: '<div class="zhuce" style="height:400px;margin-top:-200px;display: inline">\n' +
                            '\t\t\t<div class="guanbi">\n' +
                            '\t\t\t</div>\n' +
                            '\t\t\t<div class="ztop">\n' +
                            '\t\t\t\t查看\n' +
                            '\t\t\t</div>\n' +
                            '\t\t\t<div class="zmob">\n' +
                            '\t\t\t\t<dl>\n' +
                            '\t\t\t\t\t<dt>\n' +
                            '\t\t\t\t\t\t留言内容\n' +
                            '\t\t\t\t\t</dt>\n' +
                            '\t\t\t\t\t<dd>'+data.content+'</dd>\n' +
                            '\t\t\t\t</dl>\n' +
                            '\t\t\t\t<dl class="huifu">\n' +
                            '\t\t\t\t\t<dt>\n' +
                            '\t\t\t\t\t\t留言回复\n' +
                            '\t\t\t\t\t</dt>\n' +
                            '\t\t\t\t\t<dd>'+data.return+'</dd>\n' +
                            '\t\t\t\t</dl>\n' +
                            '\t\t\t</div>\n' +
                            '\t\t</div>'
                        });
					}
				});
			}
			@if($errors->has('captcha'))
				$("#liuyan").show();
				$(".zhe").show();
			@endif
		</script>
	@endsection