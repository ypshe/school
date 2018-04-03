@extends('layout')
@section('content')
		<!--导航部分-->
		<!--主体部分-->
		<div class="main">
			<!--面包屑导航-->
			<div class="mianbao">
				<a href="{{url('/')}}">首页</a>
				<span>></span>
				<a href="{{url('/getStudy')}}">报名培训</a>
			</div>
			<!--面包屑导航-->
			<!--报名培训第一步-->
			<div class="peixunn">
				<div class="peixuntop">
					<div class="title">
						<h2>报名培训</h2>
					</div>
					<div class="buzhou">
						<dl class="on">
							<dt>
								1
							</dt>
							<dd>
								选择课程
							</dd>
						</dl>
						<dl style="width:100px;margin:auto 65px;">
							<dt>
								2
							</dt>
							<dd>
								确认订单并支付
							</dd>
						</dl>
						<dl>
							<dt>
								3
							</dt>
							<dd>
								支付成功
							</dd>
						</dl>
					</div>
				</div>
				<div class="choose">
					<div class="choosetext">
						<span>请选择继续教育科目:</span>
						<dl>
							<dt class="value">
								@if(isset($pro)){{$pro->name}}@else -------------- 请选择   --------------@endif
							</dt>
							<dd>
								@foreach($pros as $k=>$v)
									<a href="{{url('/getStudy/'.$v->id)}}">{{$v->name}}</a>
								@endforeach
							</dd>
						</dl>
					</div>
				</div>
				@if(isset($pro))
					<div class="prolist">
					<div class="prolisttop">
						<span style="width:536px;">科目名称</span>
						<span style="width:280px;">课程列表</span>
						<span style="width:150px;text-align: center;">学时</span>
						<span style="width:150px;text-align: center;">价格</span>
					</div>
					<div class="prolistmo">
						<ul>
							<li>
								<span style="width:536px;">
									<a href="">
										<img class="pro" src="{{img_local($pro->pic)}}">
										<b>
											<h4 title="{{$pro->name}}">【{{$pro->name}}】</h4>
											<i>{{$pro->desc}}</i>
										</b>
									</a>
								</span>
								<span style="width:280px;" >
									<dl>
										<dt>
											@if($study){{$study}}@else无@endif
										</dt>
									</dl>
								</span>
								<span style="width:150px;text-align: center;">{{$study_time}}</span>
								<span style="width:150px;text-align: center;color:#e70a2e">￥{{$pro->price}}</span>
							</li>
						</ul>
					</div>
					<div class="prolistbo">
						<input type="button" id="getStudy" value="确认报名" />
						{{--<b>￥{{$pro->price}}</b>--}}
						<b>0元</b>
						<span>应付(现属于免费学习阶段):</span>
					</div>
				</div>
					<script>
                        $('#getStudy').click(function(){
                            location.href='/getStudy/confirm'+'/'+{{$pro->id}};
                        });
					</script>
				@endif
			</div>
			<!--报名培训第一步-->
		</div>
		<!--主体部分-->
		<!--公共底部-->
@endsection