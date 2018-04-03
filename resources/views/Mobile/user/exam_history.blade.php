<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>在线练习</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
		<style>
			.title{
				padding:2vw 2.4vw;
			}
		</style>
	</head>
	<body>
		<!--头部-->
		<div class="header bglan overflow textcenter wbai">
			<a class="fl textcenter" href="/wap/user">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a>
			<h3 class="sanwu bai textcenter">在线考试</h3>
			<a class="iconfont icon-wo fr h1 c9 b" href="/wap/user" style="font-size:7vw"></a>
		</div>
		<!--头部-->
		<!--个人中心-->
		<article class="bgbai">
			<div class="dingdantops overflow">
				<a style="text-align: left;" class="fl w25 textcenter h2 san" href="/wap/user/online_exam">
					在线考试
				</a>
				<a class="fl w25 textcenter h2 san on" href="">
					考试记录
				</a>
			</div>
			<!--考试列表-->
			<div class="dingdanbos top20 zaixian">
				<div class="main">
					@foreach($history as $k=>$v)
						<dl>
							<dd>
								<a class="overflow" href="/wap/user/seeTest/{{$v->id}}">
									<img class="fl ddle lazy" src="{{img_local($v->pic)}}">
									<div class="fr ddri">
										<div class="h2 san">{{$v->pname}}
									</div>
										<div class="overflow top40">
											<span class="fl h2 jiu">
												考试时间：{{date('Y.m.d',strtotime($v->time))}}
											</span>
											<span class="fr h4 hong">{{$v->value}}分</span>
										</div>
									</div>
								</a>
							</dd>
						</dl>
					@endforeach
				</div>
			</div>
		</article>
		<!--个人中心-->
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script type="text/javascript" src="/mobile/js/lazyload.js"></script>
		<script>
            var flag = true;
            var page = 0;
			$(function(){
				//图片懒加载
				$("img.lazy").lazyload({effect: "fadeIn"});
				//上拉加载更多
			addmore();//默认执行
			window.onscroll=function(){
			    if($(document).scrollTop() > $(document).height()-$(window).height()-100 || $(document).scrollTop() == $(document).height()-$(window).height() || $(document).scrollTop() == 0){
			    	addmore();
			    }
			};
			function addmore(){
                var divadd = '<div class="main">';
                page++;
                var zong = {{$num}};//总页数
                if(page > zong){
                    setTimeout(function(){

                    },1000);
                    return false;
                }else{
                    $.ajax({
                        type:'get',
                        url:'/ajax/wap/test',
                        async: false, //同步
                        data:{
                            page:page
                        },
                        dataType:'json',
                        success:function(data) {
                            if (data.msg !== 'error') {
                                var shuju = data.test;
                                for (var i = 0; i < shuju.length; i++) {
                                    divadd = '<dl>' +
                                        '<dd>' +
                                        '<a class="overflow" href="/wap/user/seeTest/'+shuju[i].id+'">' +
                                        '<img class="fl ddle" src="http://school.com/../storage/uploads/'+shuju[i].pic+'">' +
                                        '<div class="fr ddri">' +
                                        '<div class="h2 san">'+shuju[i].pname+' </div>' +
                                        '<div class="overflow top40">' +
                                        '<span class="fl h2 jiu">' +
                                        '考试时间：'+shuju[i].time +
                                        '</span>' +
                                        '<span class="fr h4 hong">'+shuju[i].value+'分</span>' +
                                        '</div>' +
                                        '</div>' +
                                        '</a>' +
                                        '</dd>' +
                                        '</dl>';
                                }
                                ;
                                divadd = divadd + '</div>';
                                $(".dingdanbos").append(divadd);
                            }
                        }
						});
				    }	
				}
			});
		</script>
		<!--底部-->
		@include('wap_foot')
		<!--底部-->
	</body>

</html>