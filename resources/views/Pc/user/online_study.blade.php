@extends('layout')
@section('content')
<link rel="stylesheet" href="/Pc/css/gerenzhongxin.css" />
		<!--导航部分-->
		<!--练习弹窗-->
		<div class="lianxitan">
			<a href="javascript:;" class="guanbi"><img src="/Pc/img/guanbi.png"></a>
			<h1>畜牧兽医 在线练习</h1>
			<span style="color:#e70a2e;margin-top:32px;font-size:16px;"><b style="color:#03478f;font-weight: 400;">考试人员：</b>王先飞</span>
			<div class="lianxitant">
				<span>试卷总分：<b>100分</b></span>
				<span>及格分数：<b>60分</b></span>
				<span>最高得分：<b>无限制</b></span>
				<span>最短提交时间：<b>无限制</b></span>
			</div>
			<div class="lianxitanm">
				<a href="">进入练习</a>
			</div>
			<p class="shuom">练习说明：练习一旦开始不允许中止，请认真对待！</p>
		</div>
		<div class="zhe"></div>
		<!--练习弹窗-->
		<!--主体部分-->
		<div class="main">
			<!--面包屑导航-->
			<div class="mianbao">
				<a href="">首页</a>
				<span>></span>
				<a href="{{url('/user')}}">个人中心</a>
				<span>></span>
				<a href="{{url('/user/online_study')}}">在线学习</a>
			</div>
			<!--面包屑导航-->
			<div class="gerenbox">
					@include('user_public')
					<div class="gerenbori">
						<h2>在线学习</h2>
						<div class="lianxi">
							<div class="lianxitop">
								<span class="on">正在学习</span>
								{{--<span>已经学习</span>--}}
							</div>
							<!--正在学习-->
							<div class="gerenbori lianxibo" style="display: block;">
								@if($profession)
									@foreach($profession as $k=>$v)
									<div class="xuexitop on">
										<i></i>
										<span>{{$v->name}}</span>
										<b>已学习{{$v->width}}%</b>
										<img src="/Pc/img/xuxians.png">
									</div>
									<div class="xuexibo" @if($k==0)style="display: block;"@endif>
										@foreach($v['study'] as $vv)
											<dl>
												<dt>
													<img src="{{img_local($vv->pic)}}">
												</dt>
												<dd>
													<div class="ddle">
														<h3>{{$vv->name}}</h3>
														<span>学时：{{$vv->video_num}}</span>
														<div class="jindutiao">
															<div class="jindutiaole">
																<i style="width:{{$vv->width??0}}%"></i>
															</div>
															<div class="jindutiaori">
																已学习{{$vv->width??0}}%
															</div>
														</div>
													</div>
													<div class="ddri">
														<a href="{{url('/studyDesc/'.$vv->id)}}">开始学习</a>
													</div>
												</dd>
											</dl>
										@endforeach
									</div>
									@endforeach
								@else
									您还没有参加任何专业课程的学习...<a href="{{url('/study')}}">点击选择学习课程</a>
								@endif
							</div>
							<!--正在学习-->
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--主体部分-->
		<script>
			$(function(){
				//tab切换
				$(".lianxitop span").click(function(){
					$(this).addClass("on").siblings().removeClass("on");
					var index = $(".lianxitop span").index(this);
					$(".lianxibo").hide();
					$(".lianxibo").eq(index).show();
				});
				//展开
				$(".xuexitop").click(function(){
					$(this).next(".xuexibo").toggle();
					$(this).toggleClass("on");
				})
			})
		</script>
@endsection