@extends('layout')
@section('content')
		<div class="main">
			<!--面包屑导航-->
			<div class="mianbao">
				<a href="{{url('/')}}">首页</a>
				<span>></span>
				<a href="{{url('/user')}}">个人中心</a>
			</div>
			<!--面包屑导航-->
			<div class="gerenbox">
				@include('user_public')
					<div class="gerenbori">
						@if(isset($study))
						<h2>最近学习课程</h2>
						<dl>
							<dt>
								<img src="{{img_local($study->pic)}}">
							</dt>
							<dd>
								<div class="ddle">
									<h3>{{$study->name}}</h3>
									<span>学时：{{$study->video_num}}</span>
									<div class="jindutiao">
										<div class="jindutiaole">
											<i style="width:{{$study->width}}%"></i>
										</div>
										<div class="jindutiaori">
											已学习{{$study->width}}%
										</div>
									</div>
								</div>
								<div class="ddri">
									<a href="{{url('/studyDesc/'.$study->id)}}">开始学习</a>
								</div>
							</dd>
						</dl>
						<h2>我的课程</h2>
							@foreach($studies as $k=>$v)
								<dl>
									<dt>
										<img src="{{img_local($v->pic)}}">
									</dt>
										<dd>
											<div class="ddle">
												<h3>{{$v->name}}</h3>
												<span>学时：{{$v->video_num}}</span>
												<div class="jindutiao">
													<div class="jindutiaole">
														<i style="width:{{$v->width}}%"></i>
													</div>
													<div class="jindutiaori">
														已学习{{$v->width}}%
													</div>
												</div>
											</div>
											<div class="ddri">
												<a href="{{url('/studyDesc/'.$v->id)}}">开始学习</a>
											</div>
										</dd>
								</dl>
							@endforeach
						@else
							<h2>您还未报名参加任何专业课程！</h2>
							<h2><a href="{{url('/getStudy')}}" style="color:red;font-size: 18px;">点击报名</a></h2>
							<br>
						@endif
					</div>
				</div>
			</div>
		</div>
@endsection