@extends('layout')
@section('content')
		<!--导航部分-->
		<!--主体部分-->
		<div class="main">
			<!--面包屑导航-->
			<div class="mianbao">
				<a href="{{url('/')}}">首页</a>
				<span>></span>
				<a href="{{url('/notice')}}">通知公告</a>
			</div>
			<!--面包屑导航-->
			<!--通知公告-->
			<div class="jingpinke tongzhi">
				@foreach($notices as $k=>$v)
					<dl>
						<a href="{{url('/notice/'.$v->id)}}">
							<dt>
								<h3>{{$v->title}}</h3>
								<span style="height:auto">发布人：{{$v->showAuthor}}<br>{{$v->blurb}}</span>
								<b class="time">{{$v->created_at}}</b>
							</dt>
							<dd>
								<span>查看详情</span>
							</dd>
						</a>
					</dl>
				@endforeach
				<?php echo $notices->render();?>
			</div>
			<!--通知公告-->
		</div>
		<!--主体部分-->
@endsection