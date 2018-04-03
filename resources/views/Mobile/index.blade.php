<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>首页</title>
		<link rel="stylesheet" href="mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="mobile/css/base.css" />
		<link rel="stylesheet" href="mobile/css/swiper.min.css" />
	</head>
	<body>
		<!--头部-->
		<header>
			<img class="fl" src="mobile/img/logo.png">
			<a class="iconfont icon-search fr h2 c9 b" href="{{url('/wap/search')}}"></a>
		</header>
		<!--头部-->
		<article>
			<!--banner-->
			<div class="swiper-container wbai">
				<div class="swiper-wrapper wbai">
					@foreach(\App\Admin\Model\Banner::where('place','wap_banner')->orderBy('sort','desc')->limit(3)->get() as $k=>$v)
						<div class="swiper-slide wbai fl">
							<a href="" class="wbai">
								<img class="wbai" src="{{img_local($v->src)}}">
							</a>
						</div>
					@endforeach
				</div>
				<div class="swiper-pagination wbai bannerdw">
				</div>
			</div>
			<!--banner-->
			<!--菜单-->
			<div class="menu bgbai">
				<div class="fl w20">
					<a class="wbai" href="{{url('/wap/study')}}">
						<img src="mobile/img/icon.png">
						<span class="h3 san wbai textcenter">培训课程</span>
					</a>
				</div>
				<div class="fl w20">
					<a class="wbai" href="{{url('/wap/getStudyTime')}}">
						<img src="mobile/img/icon02.png">
						<span class="h3 san wbai textcenter">学时验证</span>
					</a>
				</div>
				<div class="fl w20">
					<a class="wbai" href="{{url('/wap/notice')}}">
						<img src="mobile/img/icon03.png">
						<span class="h3 san wbai textcenter">通知公告</span>
					</a>
				</div>
				<div class="fl w20">
					<a class="wbai" href="{{url('/wap/work')}}">
						<img src="mobile/img/icon04.png">
						<span class="h3 san wbai textcenter">工作动态</span>
					</a>
				</div>
				<div class="fl w20">
					<a class="wbai" href="{{url('/wap/help/1')}}">
						<img src="mobile/img/icon05.png">
						<span class="h3 san wbai textcenter">帮助中心</span>
					</a>
				</div>
			</div>
			<!--菜单-->
			<!--精品课程-->
			<div class="jingpin top20 bgbai">
				<div class="title">
					<span class="fl h2">精品课程</span>
					<a href="{{url('/wap/study')}}" class="fr h4 c9">MORE</a>
				</div>
				<div class="kecheng">
					@foreach($study as $k=>$v)
						<dl class="w49 fl">
							<a href="{{url('/wap/studyDesc/'.$v->id)}}">
								<dt>
								<img class="wbai lazy" data-original="{{img_local($v->pic)}}" src="{{img_local($v->pic)}}">
							</dt>
								<dd>
									<h4 class="h4 one-txt-cut san">{{$v->name}}</h4>
									<h4 class="h4 liu">讲师：{{$v->tname}}</h4>
								</dd>
							</a>
						</dl>
					@endforeach
				</div>
			</div>
			<!--精品课程-->
			<!--通知公告-->
			<div class="gonggao top20 bgbai">
				<div class="title">
					<span class="fl h2">通知公告</span>
					<a href="{{url('/wap/notice')}}" class="fr h4 c9">MORE</a>
				</div>
				@foreach($notice as $k=>$v)
					<dl>
						<a href="{{url('/wap/notice/'.$v->id)}}">
							<dt class="fl">
							<img class="wbai lazy" data-original="{{img_local($v->pic)}}" src="{{img_local($v->pic)}}">
						</dt>
							<dd class="fr">
								<h3 class="h3 san biaoti overflow">{{$v->title}}</h3>
								<div class="overflow">
									<div class="fl jiu h3">
										{{date('Y-m-d',strtotime($v->created_at))}}
									</div>
									<div class="fr jiu h3">
										<i class="iconfont icon-liulan h2 jiu"></i> {{$v->visit_num}}
									</div>
								</div>
							</dd>
						</a>
					</dl>
				@endforeach
			</div>
			<!--通知公告-->
			<!--工作动态-->
			<div class="gonggao top20 bgbai">
				<div class="title">
					<span class="fl h2">工作动态</span>
					<a href="{{url('/wap/work')}}" class="fr h4 c9">MORE</a>
				</div>
				@foreach($work as $k=>$v)
					<dl>
						<a href="{{url('/wap/work/'.$v->id)}}">
							<dt class="fl">
							<img class="wbai lazy" data-original="{{img_local($v->pic)}}" src="{{img_local($v->pic)}}">
						</dt>
							<dd class="fr">
								<h3 class="h3 san biaoti overflow">{{$v->title}}</h3>
								<div class="overflow">
									<div class="fl jiu h3">
										{{date('Y-m-d',strtotime($v->created_at))}}
									</div>
									<div class="fr jiu h3">
										<i class="iconfont icon-liulan h2 jiu"></i> {{$v->visit_num}}
									</div>
								</div>
							</dd>
						</a>
					</dl>
				@endforeach
			</div>
			<!--工作动态-->
			<!--最新考试通过名单-->
			<div class="kaoshi top20 bgbai">
				<div class="title">
					<span class="fl h2">最新考试通过名单</span>
					<a href="{{url('/wap/paste')}}" class="fr h4 c9">MORE</a>
				</div>
				<div class="kaoshilist">
					<div class="kaoshilisttop overflow">
						<span class="fl w33 textcenter san h4">
						地区
					</span>
						<span class="fl w33 textcenter san h4">
						姓名
					</span>
						<span class="fl w33 textcenter san h4">
						通过时间
					</span>
					</div>
					<div class="kaoshilistbo">
						<ul>
							@foreach($paste as $k=>$v)
								<li class="overflow">
									<span class="fl w33 textcenter jiu h5">
										{{$v->home}}
									</span>
										<span class="fl w33 textcenter jiu h5">
										{{$v->name}}
									</span>
										<span class="fl w33 textcenter jiu h5">
										{{date('Y-m-d',strtotime($v->time))}}
									</span>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<!--最新考试通过名单-->
		</article>
		<script type="text/javascript" src="mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="mobile/js/swiper.min.js"></script>
		<script type="text/javascript" src="mobile/js/jquery.SuperSlide.2.1.1.js"></script>
		<script type="text/javascript" src="mobile/js/lazyload.js"></script>
		<script>
			//banner js
			var swiper = new Swiper('.swiper-container', {
				pagination: '.swiper-pagination'
			});
			//名单滚动
			jQuery(".kaoshilist").slide({
				mainCell: ".kaoshilistbo ul",
				effect: "top",
				autoPlay: true,
				vis: 5
			});
			//图片懒加载
			$("img.lazy").lazyload({effect: "fadeIn"});
		</script>
		<!--底部-->
		@include('wap_foot')
		<!--底部-->
		
	</body>

</html>
