@extends('layout')
@section('content')
	<!--主体部分-->
	<div class="main">
		<!--面包屑导航-->
		<div class="mianbao">
			<a href="{{url('/')}}">首页</a>
			<span>></span>
			<a href="{{url('/notice')}}">通知公告</a>
			<span>></span>
			<a href="">详情</a>
		</div>
		<!--面包屑导航-->
		<!--通知公告详情-->
		<div class="jingpinke tongzhixq">
			<div class="tztop">
				<h1>{{$notice->title}}</h1>
				<div class="tztopb">
					发布时间：{{$notice->created_at}} &nbsp;&nbsp;&nbsp;&nbsp; 浏览数：{{$notice->visit_num}}
				</div>
			</div>
			<div class="tztopxq">
				<color style="font-size: 15px;color:#999999">发布人：{{$notice->showAuthor}}<br>概要：{{$notice->blurb}}</color><br><br>
			<?php echo $notice->content;?>
			</div>
		</div>
		<!--通知公告详情-->
	</div>
	<!--主体部分-->
@endsection