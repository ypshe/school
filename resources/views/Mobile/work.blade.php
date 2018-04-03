<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>工作动态</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
	</head>
	<body class="bgbai">
		<!--头部-->
		<div class="header bglan overflow textcenter wbai">
			<a class="fl textcenter" href="javascript:history.go(-1);">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a>
			<h3 class="sanwu bai textcenter">工作动态</h3>
			<a class="iconfont icon-wo fr h1 bai b" href="{{url('/wap/user')}}" style="font-size:7vw"></a>
		</div>
		<!--头部-->
		<!--通知公告-->
		<article>
			<div class="gonggaobox bgbai">
				<div class="main">
					@foreach($data as $k=>$v)
						<dl class="overflow">
							<a class="overflow" href="{{url('/wap/work/'.$v->id)}}">
								<dt class="fl">
									<img class="wbai lazy" src="{{img_local($v->pic)}}">
								</dt>
								<dd class="fr">
									<h2 class="h3 san">
										{{$v->blurb}}
									</h2>
									<div class="overflow top10">
										<span class="fl jiu h3">{{$v->created_at}}</span>
										<span class="fr jiu h3"><i class="iconfont icon-liulan h1 jiu b fl"></i>{{$v->visit_num}}</span>
									</div>
								</dd>
							</a>
						</dl>
					@endforeach
				</div>
			</div>
		</article>
		<!--通知公告-->
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script type="text/javascript" src="/mobile/js/lazyload.js"></script>
		<script>
            var flag = true;
            var page = 1;
			//图片懒加载
			$("img.lazy").lazyload({effect: "fadeIn"});
			//上拉加载更多
			addmore();//默认执行
			window.onscroll=function(){
			    if($(document).scrollTop() > $(document).height()-$(window).height()-100 || $(document).scrollTop() == $(document).height()-$(window).height() || $(document).scrollTop() == 0){
			    	$(".loader-icons").show();
			    	addmore();
			    }
			};
			function addmore(){
				var divadd = '<div class="main">';
					page++;
					var zong = {{$num}};//总页数
					if(page > zong){
						console.log("已经没有数据了呢");
						setTimeout(function(){
							
						},1000);
						return false;
					}else{
						console.log("正在加载中");
						$.ajax({
							type:'get',
							url:'/ajax/wap/work',
							async: false, //同步
							data:{
								page:page
							},
							dataType:'json',
							success:function(data) {
                                if (data.msg !== 'error') {
                                    var shuju = data.res;
                                    for (var i = 0; i < shuju.length; i++) {
                                        divadd = '<dl class="overflow">' +
                                            '<a class="overflow" href="/wap/notice/'+shuju[i].id+'">' +
                                            '<dt class="fl">' +
                                            '<img class="wbai" src="http://school.com/../storage/uploads/' + shuju[i].pic + '">' +
                                            '</dt>' +
                                            '<dd class="fr">' +
                                            '<h2 class="h3 san">' +
                                            shuju[i].blurb +
                                            '</h2>' +
                                            '<div class="overflow top10">' +
                                            '<span class="fl jiu h3">'+shuju[i].created_at+'</span>' +
                                            '<span class="fr jiu h3"><i class="iconfont icon-liulan h1 jiu b fl"></i>'+shuju[i].visit_num+'</span>' +
                                            '</div>' +
                                            '</dd>' +
                                            '</a>' +
                                            '</dl>';
                                        $(".main").append(divadd);
                                    }
                                }
                            }
						});
				    }	
				}
		</script>
		<!--底部-->
		@include('wap_foot')
		<!--底部-->
	</body>

</html>