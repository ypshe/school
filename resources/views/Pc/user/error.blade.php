@extends('layout')
@section('content')
		<!--主体部分-->
		<div class="main">
			<!--面包屑导航-->
			<div class="mianbao">
				<a href="{{url('/')}}">首页</a>
				<span>></span>
				<a href="{{url('/user/index')}}">个人中心</a>
			</div>
			<!--面包屑导航-->
			<div class="gerenbox">
				@include('user_public')
					<style>
						.yichangtiaoz{
							margin-top:150px;
						}
						.yichangtiaoz img{
							margin:auto;
							width:50px;
						}
						.yichangtiaoz span{
							text-align: center;
							font-size:16px;
							display: block;
							margin:20px auto;
						}
						.yichangtiaoz .xiao{
							font-size:12px;
						}
						.yichangtiaoz .xiao a{
							color:#03478f;
							font-size:12px;
							display: inline-block;
						}
						.yichangtiaoz .xiao b{
							font-weight: 400;
						}
					</style>
					<!--成功-->
				@if($message['type']=='success')
					<div class="gerenbori" id="chenggong" style="min-height: 847px;">
						<div class="yichangtiaoz">
							<img src="/Pc/img/zhengque.png">
							<span>{{$message['msg']}}</span>
							<span class="xiao"><b class="miaozhong">5</b>秒钟后跳转，点击<a href="{{$message['url']}}">立即跳转</a></span>
						</div>
					</div>
				@else
					<!--失败-->
					<div class="gerenbori" id="shibai" style="min-height: 847px;">
						<div class="yichangtiaoz">
							<img src="/Pc/img/shibai_03.png">
							<span>{{$message['msg']}}</span>
							<span class="xiao"><b class="miaozhong">5</b>秒钟后跳转，点击<a href="{{$message['url']}}">立即跳转</a></span>
						</div>
					</div>
				@endif
				</div>
			</div>
		</div>
		<!--主体部分-->
		<script>
			//5秒后跳转
			//倒计时方法
			var wait = 5;
			function time() {
				if (wait == 0) {
				    window.location=$('.xiao a').attr('href');
				} else { 
					$(".miaozhong").text(wait);
				    wait--;
				    setTimeout(function() {
				       time()
				    },
				    1000)
				}
			}
			time();
		</script>
	@endsection