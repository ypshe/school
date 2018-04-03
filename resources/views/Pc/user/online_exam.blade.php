@extends('layout')
@section('content')
		<!--导航部分-->
		<!--进入考试弹窗-->
		<div class="lianxitan">
			<span class="guanbi"><img src="/Pc/img/guanbi.png"></span>
			<h1></h1>
			<span style="color:#e70a2e;margin-top:32px;font-size:16px;"><b style="color:#03478f;font-weight: 400;">考试人员：</b><name></name></span>

			<div class="lianxitant">
				<span>试卷总分：<b>100分</b></span>
				<span>及格分数：<b>60分</b></span>
				<span>最高得分：<b>100分</b></span>
				<span>考试时间：<b id="exam_time"></b>分钟</span>
				<span>最短提交时间：<b>无限制</b></span>
			</div>
			<div class="lianxitanm">
				<a href="">进入考试</a>
			</div>
			<p class="shuom">考试说明：考试一旦开始不允许中止，请认真对待！</p>
		</div>
		<!--进入考试弹窗-->
		<div class="zhe"></div>
		<!--主体部分-->
		<div class="main">
			<!--面包屑导航-->
			<div class="mianbao">
				<a href="{{url('/')}}">首页</a>
				<span>></span>
				<a href="{{url('/user')}}">个人中心</a>
				<span>></span>
				<a href="{{url('/user/online_exam')}}">在线考试</a>
			</div>
			<!--面包屑导航-->
			<div class="gerenbox">
				@include('user_public')
					<div class="gerenbori" style="min-height: 847px;">
						<h2>在线考试</h2>
						<div class="shuoming">
							<dd>温馨提示：</dd>
							<dt>1：只能参加已完成学时要求的专业考试；</dt>
							<dt>2：总分100分，≥60分及格；</dt>
							<dt>3：不限制补考次数，历次考试成绩可在“考试历史”中查询。</dt>
						</div>
						<div class="lianxi">
							<div class="lianxitop">
								<span class="on">考试列表</span>
								<span>考试历史</span>
							</div>
							<!--考试列表-->
							<div class="gerenbori lianxibo" style="display: block;">
								@foreach($pro as $k=>$v)
									<dl>
										<dt>
											<img src="{{img_local($v->pic)}}">
										</dt>
										<dd>
											<div class="ddle">
												<h3>{{$v->name}}</h3>
												{{--<span>考试期限：2017-04-18 9：00到2018-12-31 00：00</span>--}}
												<span></span>
												<span>考试时间：<span id="kaoshishijian{{$v->id}}"  style="display: inline;">{{$v->exam_time}}</span>分钟</span>
											</div>
											<div class="ddri jinru" pid="{{$v->id}}">
												<a href="javascript:;">进入</a>
											</div>
										</dd>
									</dl>
								@endforeach
							</div>
							<!--考试列表-->
							<!--考试历史-->
							<div class="gerenbori lianxibo">
								@foreach($history as $k=>$v)
									<dl>
										<dt>
											<img src="{{img_local($v->pic)}}">
										</dt>
										<dd>
											<div class="ddle">
												<h3>{{$v->pname}}</h3>
												<span>考试时间：{{$v->time}}</span>
												<span>成绩：<b>{{$v->value}}</b>分</span>
											</div>
											<div class="ddri chakan">
												<a href="{{url('/user/seeExam/'.$v->id)}}">查看</a>
											</div>
										</dd>
									</dl>
								@endforeach
							</div>
							<!--考试历史-->
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--主体部分-->
		<script>
			//弹出层显示（正在练习）
			$(".jinru").click(function(){
				var biaoti = $(this).prev(".ddle").children("h3").text();
				var time = $(this).prev(".ddle").children("span").text();
				$(".lianxitan h1").text(biaoti+" 在线考试");
				$(".lianxitan name").text('{{$user->name}}');
				$(".lianxitanm a").attr('href','{{url('/user/exam')}}'+'/'+$(this).attr('pid'));
				$(".lianxitan").show();
				$(".zhe").show();
				$('#exam_time').html($('#kaoshishijian'+$(this).attr('pid')).html());
			});
			//关闭弹出层
			$(".guanbi").click(function(){
				$(".lianxitan").hide();
			});
			//tab切换
			$(".lianxitop span").click(function(){
				$(this).addClass("on").siblings().removeClass("on");
				var index = $(".lianxitop span").index(this);
				$(".lianxibo").hide();
				$(".lianxibo").eq(index).show();
			})
		</script>
	@endsection