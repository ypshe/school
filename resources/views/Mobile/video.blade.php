<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>培训课程-详情</title>
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
			<h3 class="sanwu bai textcenter">课程详情</h3>
			<a class="iconfont icon-wo fr h1 c9 b bai" style="font-size:7vw" href="/wap/user"></a>
		</div>
		<!--头部--> 
		<!--培训课程详情-->
		<article style="padding-bottom: 12vw;width:100%;overflow-x: hidden;">
			<div class="xqtop bgbai video" onclick="playPause()" style="width:100%">
				{{--<video x-webkit-airplay="allow"  playsinline="true" x5-video-player-type="h5" x5-video-orientation="portraint" width="100%" height="220"  poster="{{img_local($video->url)}}" loop="loop" x-webkit-airplay="true" webkit-playsinline="true" id="video" controls="controls">--}}
				<video controls=""  x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" width="100%" height="220" id="video">
					<source src="{{img_local($video->url)}}" type="video/ogg" />
					<source src="{{img_local($video->url)}}" type="video/mp4" />
					<source src="{{img_local($video->url)}}" type="video/webm" />
					<object data="" width="100%">
			            <embed width="100%" src="" />
			        </object>
				</video>
			</div>
			<div class="mulu bgbai" style="padding-top: 2.6vw;">
				<div class="title">
					<span>课程目录</span>
				</div>
				<div class="mulubox">
					@foreach($section as $k=>$v)
						<dl>
							<dt class="san h2 overflow">
								第{{$k+1}}章 {{$v}}
								<i class="fr iconfont icon-xiajiantou jiu h1"></i>
							</dt>
							<dd>
								@foreach($videos as $kk=>$vv)
									@if($vv->section==$k)
										<a href="{{url('/wap/video/'.$vv->id)}}" class="overflow on">
											<span class="h3 jiu fl">{{$k+1}}-{{$vv->sort}} {{$vv->name}}</span>
											<span class="h3 jiu fr">@if($vv->id==$video->id)onlive @else {{intval($vv->time/60)}}:{{intval($vv->time%60)}}@endif</span>
										</a>
									@endif
								@endforeach
							</dd>
						</dl>
					@endforeach
				</div>
			</div>
		</article>
		<!--培训课程详情-->
		<script type="text/javascript" src="/mobile/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="/mobile/js/swiper.min.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script type="text/javascript" src="/mobile/js/lazyload.js"></script>
			<script>
			$(".mulubox dl dt").click(function(){
				$(this).children("i").toggleClass("icon-shangjiantou");
				$(this).children("i").toggleClass("icon-xiajiantou");
				$(this).next("dd").toggle();
				$(this).parent("dl").siblings().children("dd").hide();
			});
			@if($question)
			var wenti = '<div class="wenti bgbai" is_click="false" style="padding-top: 2.6vw; padding-bottom: 5vw;">'+
			'<div class="title">'+
				'<span>请回答当前问题并继续观看课程</h2>'+
			'</div>'+
			'<div class="wentib top20" style="margin-top:2.6vw">'+
				'<h3 class="san h2">01. {{$question->info}}？</h3>'+
				'<ul>'+
					'<li>'+
						'<label class="overflow">'+
							'<a class="fl">'+
								'<i></i>'+
								'<input type="radio" name="probrem" value="{{$question->choose_1}}"/>'+
							'</a>'+
							'<span class="fl h2 jiu">A.{{$question->choose_1}}</span>'+
						'</label>'+
					'</li>'+
					'<li>'+
						'<label class="overflow">'+
							'<a class="fl">'+
								'<i></i>'+
								'<input type="radio" name="probrem" value="{{$question->choose_2}}"/>'+
							'</a>'+
							'<span class="fl h2 jiu">B.{{$question->choose_2}}</span>'+
						'</label>'+
					'</li>'+
					'<li>'+
						'<label class="overflow">'+
							'<a class="fl">'+
								'<i></i>'+
								'<input type="radio" name="probrem"  value="{{$question->choose_3}}" />'+
							'</a>'+
							'<span class="fl h2 jiu">C.{{$question->choose_3}}</span>'+
						'</label>'+
					'</li>'+
					'<li>'+
						'<label class="overflow">'+
							'<a class="fl">'+
								'<i></i>'+
								'<input type="radio" name="probrem"  value="{{$question->choose_4}}" />'+
							'</a>'+
							'<span class="fl h2 jiu">D.{{$question->choose_4}}</span>'+
						'</label>'+
					'</li>'+
				'</ul>'+
				'<div class="btnbox top20">'+
					'<a class="anniu textcenter bai h2" href="javascript:;" id="queding">确认</a>'+
				'</div>'+
			'</div>'+
		'</div>';
		    var zhengque = '<div class="zhengque textcenter bgbai" id="zhengque" style="min-height: 50vw;padding-top:2.6vw">'+
			'<i class="iconfont icon-dui h1 san" style="color:#38b00e;display:block;margin-top:10vw"></i>'+
			'<span class="textcenter san h2 top20 jixu">恭喜您回答正确，请继续观看</span>'+
		'</div>';
		    var cuowu = '<div class="zhengque textcenter bgbai" id="cuowu" style="min-height: 50vw;padding-top:2.6vw">'+
			'<i class="iconfont icon-error h1 san" style="color:#e82355;display:block;margin-top:10vw"></i>'+
			'<span class="textcenter san h2 top20">很抱歉回答错误，正确答案为<b style="color:#e70a2e;font-weight: 400;">{{$question->true}}</b></span>'+
			'<a class="textcenter san h2 jixu" href="javascript:;">请继续观看</a>'+
		'</div>';
			@endif
            var stayTime=setInterval(stayTimeFunc,1000);
            var myVideo = $(".video").children("video")[0];
            {{--@if(strpos(\Request::path(),'/true')!==false)--}}
            	{{--var useTime={{intval($video->time/2)}};--}}
            	{{--myVideo.currentTime=useTime;--}}
			{{--@else--}}
            	var useTime=0;
			{{--@endif--}}
//			stayTimeFunc();
            function stayTimeFunc() {
                if (!myVideo.paused) {
                    $(".video").find(".bofang").hide();
                    var time ={{$video->time}};
                    if (useTime < time) {
						@if($question)
                        if (useTime === parseInt(time / 2)) {
							{{--@if(strpos(\Request::path(),'/true')===false)--}}
							{{--location.href=location.href+'/true';--}}
							{{--@else--}}
                            myVideo.pause(); //视频停止
                            layer.open({
                                content: wenti,
                                shadeClose: false,
                                skin: 'footer'
                            });
                            myVideo.webkitExitFullScreen();
                            $("#queding").click(function () {
                                if ($("input[name='probrem']:checked").val() === '{{$question->true}}') {
                                    layer.open({
                                        content: zhengque,
                                        shadeClose: false,
                                        time: 2, //2秒后自动关闭
                                        skin: 'footer'
                                    });
                                } else {
                                    $.ajax({
                                        type: 'POST',
                                        url: '/ajax/userError',
                                        data: {eid:{{$question->id}}, error: $("input[name='probrem']:checked").val()},
                                        dataType: "json"
                                    });
                                    layer.open({
                                        content: cuowu,
                                        shadeClose: false,
                                        time: 2, //2秒后自动关闭
                                        skin: 'footer'
                                    });
                                }
                                setTimeout(askOver, 2000);
                            });
                            $(".zhengque").click(function () {
                                $(".wenti").parents(".layui-m-layer").hide();
                                $("#zhengque").parents(".layui-m-layer").hide();
                                $("#cuowu").parents(".layui-m-layer").hide();
                                $(".wenti").attr('is_click', 'false');
                                myVideo.play();
                            });
							{{--@endif--}}
                        }
						@endif
                            useTime += 1;
                    } else {
                        $.ajax({
                            type: 'POST',
                            url: '/ajax/userStudy',
                            data: {vid:{{$video->id}}, res: 1},
                            dataType: "json"
                        });
                        exitFullscreen();//退出全屏
                        $(".wenti").attr('is_click', 'false');
                        clearInterval(stayTime);
                    }
                }
            }
			function askOver(){
                $(".wenti").attr('is_click','false');
                myVideo.play();
			}
            function playPause() {
				if(myVideo.paused) {
					myVideo.play(); //视频播放
				} else {
					myVideo.pause(); //视频停止
				}
			}
			//退出全屏方法
           function exitFullscreen(){
				if (document.exitFullscreen) {
					document.exitFullscreen();
				} else if (document.msExitFullscreen) {
					document.msExitFullscreen();
				} else if (document.mozCancelFullScreen) {
					document.mozCancelFullScreen();
				} else if(document.oRequestFullscreen){
					document.oCancelFullScreen();
				}else if (document.webkitExitFullscreen){
					document.webkitExitFullscreen();
				}else{
					var docHtml = document.documentElement;
					var docBody = document.body;
					var videobox = document.getElementById('video');
					docHtml.style.cssText = "";
					docBody.style.cssText = "";
					videobox.style.cssText = "";
					document.IsFullScreen = false;
				}
			}
		</script>
	</body>

</html>