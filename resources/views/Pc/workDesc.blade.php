@extends('layout')
@section('content')
	<!--主体部分-->
	<div class="main">
		<!--面包屑导航-->
		<div class="mianbao">
			<a href="{{url('/')}}">首页</a>
			<span>></span>
			<a href="{{url('/work')}}">工作动态</a>
			<span>></span>
			<a href="">详情</a>
		</div>
		<!--面包屑导航-->
		<div class="jingpinke tongzhixq">
			<div class="tztop">
				<h1>{{$work->title}}</h1>
				<div class="tztopb">
					发布时间：{{$work->created_at}} &nbsp;&nbsp;&nbsp;&nbsp; 浏览数：{{$work->visit_num}}
				</div>
			</div>
			<div class="tztopxq">
				<color style="font-size: 15px;color:#999999">发布人：{{$work->showAuthor}}<br>概要：{{$work->blurb}}</color><br><br>
                <?php echo $work->content;?>
			</div>
		</div>
	</div>
	<!--主体部分-->
@endsection