<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>培训课程</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/swiper.min.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
	</head>
	<body>
		<!--头部-->
		<div class="header bglan overflow textcenter wbai">
			<a class="fl textcenter" href="javascript:history.go(-1);">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a>
			<h3 class="sanwu bai textcenter">@if(isset($title)){{$title}}@else培训课程@endif</h3>
			<a class="iconfont icon-search fr h1 bai b" href="{{url('/wap/search')}}"></a>
		</div>
		<!--头部-->
		<!--培训课程-->
		<article>
			<div class="peixunbo overflow bgbai">
				<div class="main">
					@foreach($study as $k=>$v)
						<dl class="fl w49">
							<a href="{{url('/wap/studyDesc/'.$v->id)}}">
								<dt>
									<img class="wbai" src="{{img_local($v->pic)}}">
								</dt>
								<dd>
									<h4 class="h4 san one-txt-cut">
										{{$v->name}}
									</h4>
									<h4 class="h4 liu one-txt-cut">
										讲师：{{$v->tname}}
									</h4>
								</dd>
							</a>
						</dl>
					@endforeach
				</div>
			</div>
		</article>
		
		<!--培训课程-->
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/swiper.min.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script type="text/javascript" src="/mobile/js/lazyload.js"></script>
		<script>
            //图片懒加载
            $("img .lazy").lazyload({effect: "fadeIn"});
            //上拉加载更多
            var page = 0;
            var flag = true;
            addmore();//默认执行
            window.onscroll=function(){
                if($(document).scrollTop() > $(document).height()-$(window).height()-100 || $(document).scrollTop() === $(document).height()-$(window).height() || $(document).scrollTop() === 0){
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
                }else{console.log(page);
                    console.log("正在加载中");
                    $.ajax({
                        type:'get',
                        url:'/ajax/wap/study',
                        async: false, //同步
                        data:{
                            page:page
                        },
						dataType:'json',
                        success:function(data) {
                            if (data.msg !== 'error') {
                                var shuju = data.study;
                                for (var i = 0; i < shuju.length; i++) {
                                    divadd = '<dl class="fl w49">' +
                                        '<a href="/wap/study/' + shuju[i].id + '">' +
                                        '<dt>' +
                                        '<img class="wbai" src="http://school.com/../storage/uploads/' + shuju[i].pic + '">' +
                                        '</dt>' +
                                        '<dd>' +
                                        '<h4 class="h4 san one-txt-cut">' +
                                        shuju[i].name +
                                        '</h4>' +
                                        '<h4 class="h4 liu one-txt-cut">' +
                                        '讲师：' + shuju[i].tname +
                                        '</h4>' +
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