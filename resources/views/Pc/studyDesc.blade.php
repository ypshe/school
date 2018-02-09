@extends('layout')
@section('content')
		<!--主体部分-->
		<div class="main">
			<!--面包屑导航-->
			<div class="mianbao">
				<a href="{{url('/')}}">首页</a>
				<span>></span>
				<a href="{{url('/study')}}">培训课程</a>
				<span>></span>
				<a href="">培训课程详情</a>
			</div>
			<!--面包屑导航-->
			<!--精英班-->
			<div class="bantop">
				<div class="bantople">
					<h2>{{$study->name}}</h2>
					<div class="keshi">
						<ul>
							<li>
								<span>学习人数</span>
								<span>{{$study->study_num}}</span>
							</li>
							<li style="width: 107px">
								<span>课程时长</span>
								<span>{{intval($study->time/(60*60))}}小时{{(intval($study->time/60)-intval($study->time/(60*60)))}}分{{intval($study->time%(60))}}秒</span>
							</li>
							<li>
								<span>综合评分</span>
								<span>{{$study->grade}}</span>
							</li>
						</ul>
					</div>
				</div>
				<div class="bantopri">
					<div class="bantopritop">
						<a class="goStudy" url=""@if($define===0){{url('/videoFirst/'.$study->id)}}@else{{url('/getStudy/'.$study->id)}}@endif">@if($define===0)开始学习@else立即报名@endif</a>
					</div>
				</div>
			</div>
			<!--精英班-->
			<!--简介-->
			<div class="jianjie">
				<div class="jianjiele">
					<div class="title">
						<h2>课程简介</h2>
					</div>
					<div class="jianjietext">
						简介：{{$study->desc}}
					</div>
					<div class="title">
						<h2>课程目录</h2>
					</div>
					<div class="mulubox">
						@foreach($section as $k=>$v)
							<dl>
								<dt>
									<span>第{{$k+1}}章 {{$v}} </span>
									<i></i>
								</dt>
								@foreach($videos as $kk=>$vv)
									@if($vv->section==$k)
										<dd>
											<a class="goStudy" url="@if($define===0){{url('/video/'.$vv->id)}}@else{{url('/getStudy/'.$study->id)}}@endif">
												<div class="mululist">
													<i></i>
													<span>{{$k+1}}-{{$vv->sort}} {{$vv->name}}（{{intval($vv->time/60)}}：{{intval($vv->time%60)}}） </span>
													<b>@if($define===0)开始学习@else立即报名@endif</b>
												</div>
											</a>
										</dd>
									@endif
								@endforeach
							</dl>
						@endforeach
					</div>
					<script>
						$('.goStudy').click(function(){
						    @if(!\Illuminate\Support\Facades\Auth::check())
                                layer.msg('请登录后进行课程学习！', {time: 3000, icon:3});
                                var url=$(this).attr('url');
                            	setTimeout(function() {
                                    location.href=url;
								},2000);
							@else
                                location.href=$(this).attr('url');
                            @endif
						});
					</script>
				</div>
				<!--讲师简介-->
				<div class="jianjieri">
					<div class="jianjieritop">
						<div class="title">
							<h2>讲师简介</h2>
						</div>
						<div class="jianjiebox">
							<h4>{{$study->tname}}</h4>
							<span> {{$study->twork}}</span>
							<b>{{mb_substr($study->tdesc,0,80,'utf-8')}}{{(mb_strlen($study->tdesc,'utf-8')>80)? '...':''}}</b>
						</div>
					</div>
					<div class="jianjieribo">
						<div class="title">
							<h2>推荐课程</h2>
						</div>
						<div class="kechengbox">
							@foreach($orderStudy as $v)
								<dl>
									<a href="{{url('/studyDesc/'.$v->id)}}">
										<dt>
											<img src="{{img_local($v->pic)}}">
										</dt>
										<dd>
											<span>{{$v->name}}</span>
											<b>讲师：{{$v->tname}}</b>
										</dd>
									</a>
								</dl>
							@endforeach
						</div>
					</div>
				</div>
				<!--讲师简介-->
			</div>
			<!--简介-->
		</div>
		<!--主体部分-->
		<!--公共底部-->
		@endsection