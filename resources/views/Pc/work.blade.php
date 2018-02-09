@extends('layout')
@section('content')
	<!--导航部分-->
	<!--主体部分-->
	<div class="main">
		<!--面包屑导航-->
		<div class="mianbao">
			<a href="{{url('/')}}">首页</a>
			<span>></span>
			<a href="{{url('/work')}}">工作动态</a>
		</div>
		<!--面包屑导航-->
		<!--通知公告-->
		<div class="jingpinke tongzhi">
			@foreach($works as $k=>$v)
				<dl>
					<a href="{{url('/notice/'.$v->id)}}">
						<dt>
						<div>
							<div style=" float:left;width:140px;height: 100px" ><img style="width:140px;height: 100px" src="{{img_local($v->pic)}}" alt="查看详情"></div>
							<div style="padding-left:160px">
								<h3>{{$v->title}}</h3>
								<span style="height:auto">发布人：{{$v->showAuthor}}<br>发布时间：{{$v->created_at}}</span>
								{{--<b class="time">{{$v->created_at}}</b>--}}
							</div>
							<span style="height:auto">概要：{{$v->blurb}}</span>
						</div>
						</dt>
						<dd>
							<span>查看详情</span>
						</dd>
					</a>
				</dl>
			@endforeach
            <?php echo $works->render();?>
		</div>
		<!--通知公告-->
	</div>
	<!--主体部分-->
@endsection