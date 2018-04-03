<!DOCTYPE html>
<html>

	<head>
		<meta charset='utf-8'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>视频播放</title>
		<link rel="stylesheet" href="/Pc/css/base.css" />
		<link rel="stylesheet" href="/Pc/css/index.css" />
		<link rel="stylesheet" href="{{ URL::asset('/Pc/css/base_start.css') }}" />
		<style>
			.zhe{
				z-index: 9999;
			}
			strong{
				color:rgb(48,178,107)
			}
		</style>
	</head>

	<body>
		<div class="videobox">
			<div class="videoboxtop" style="background:rgb(20,24,30)">
				<div class="videoboxtople">
					<a href="#" style="cursor:default">
						<img style="cursor:pointer" onclick="location.href='{{url('/studyDesc/'.$study->id)}}'" src="/Pc/img/fanhui.png">
						<b style="cursor:pointer" onclick="location.href='{{url('/studyDesc/'.$study->id)}}'">{{$study->name}}</b>
						<span>{{$video->section+1}}-{{$video->sort}}{{$video->name}}
							丨总学时 : <strong>{{$study->video_num}}</strong> 已完成 : <strong>{{$study_time_count->num}}</strong> 有效时间<red style="color:#e70a2e">（以此时间为准，快进不计时）：<time id="stayTime"><z id="mintue">00</z>:<z id="second">00</z></time></red> 备注：只有全部观看完该视频才能计入学时，快进无效。
						</span>
					</a>
				</div>
				<div class="videoboxtopri">
					<a href="{{url('/user')}}">
						<img src="{{img_local(\Illuminate\Support\Facades\Auth::user()->pic)}}">
					</a>
				</div>
			</div>
			<!--中间弹出问题-->
			@if($question)
				<div class="wenti">
				<div class="title">
					<h2>请回答当前问题并继续观看课程</h2>
				</div>
				<div class="wentib">
					<h3>01. {{$question->info}}？</h3>
					<ul>
						<li>
							<label>
									<a>
										<i></i>
										<input type="radio" name="probrem"  value="{{$question->choose_1}}"/>
									</a>
									<span><i>A.</i>{{$question->choose_1}}</span>
								</label>
						</li>
						<li>
							<label>
									<a>
										<i></i>
										<input type="radio" name="probrem"  value="{{$question->choose_2}}"/>
									</a>
									<span><i>B.</i>{{$question->choose_2}}</span>
								</label>
						</li>
						<li>
							<label>
									<a>
										<i></i>
										<input type="radio" name="probrem"  value="{{$question->choose_3}}"/>
									</a>
									<span><i>C.</i>{{$question->choose_3}}</span>
								</label>
						</li>
						<li>
							<label>
									<a>
										<i></i>
										<input type="radio" name="probrem"  value="{{$question->choose_4}}"/>
									</a>
									<span><i>D.</i>{{$question->choose_4}}</span>
								</label>
						</li>
					</ul>
					<div class="btnbox">
						<div class="btn redbtn" id="queding">
							<input type="button" value="确定" />
						</div>
					</div>
				</div>
				<!--回答正确-->
				<div class="zhengque" id="zhengque">
					<img src="/Pc/img/zhengque.png">
					<span>恭喜您回答正确，请继续观看</span>
					<a class="btn lv jixu" href="javascript:;" >
						请继续
					</a>
				</div>
				<!--回答正确-->
				<!--回答错误-->
				<div class="zhengque" id="cuowu">
					<img src="/Pc/img/cuowu.png">
					<span>很抱歉回答错误，正确答案为<b>{{$question->select}}.{{$question->true}}</b></span>
					<span>请继续观看</span>
					<a class="btn lv jixu" href="javascript:;" >请继续</a>
				</div>
				<!--回答错误-->
			</div>
			@endif
			<!--中间弹出问题-->
			<div class="video" onclick="playPause()">
				<div class="bofang">
					<img src="/Pc/img/bofang.png">
				</div>
				<div class="zhedangjindu">
					
				</div>
				<video style="width:100%;height:95%;" id="video" controls="controls" poster="{{img_local($video->url)}}" loop="loop" x-webkit-airplay="true" webkit-playsinline="true">

					<source src="{{img_local($video->url)}}" type="video/ogg" />
					<source src="{{img_local($video->url)}}" type="video/mp4" />
					<source src="{{img_local($video->url)}}" type="video/webm" />
					<object data="" style="width:100%;height:95%;">
				            <embed width="386" height="386" src="" />
				    </object>
				</video>

			</div>
			<div class="section-list" style="right: 0px;">
				<div class="nano has-scrollbar">
					<div class="nano-content" tabindex="0" style="right: -17px;">
						<h3>{{$study->name}}</h3>
						@foreach($section as $k=>$v)
							<ul>
								<li class="sec-title">
									<span>第{{$k+1}}章 {{$v}}</span>
								</li>
								@foreach($videos as $kk=>$vv)
									@if($vv->section==$k)
										<li>
											<a href="{{url('/video/'.$vv->id)}}"  @if($vv->id==$video->id) class="on" @endif>
												<i class="icon"><img src="/Pc/img/xiaoyoujian.png"></i>
												<i>{{$k+1}}-{{$vv->sort}}</i> <b>{{$vv->name}}</b><i>@if($vv->id==$video->id)onlive @else {{intval($vv->time/60)}}:{{intval($vv->time%60)}}@endif</i>
											</a>
										</li>
									@endif
								@endforeach
							</ul>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<!--遮罩层-->
		
		<!--遮罩层-->
		<script type="text/javascript" src="/Pc/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="/Pc/js/jquery.SuperSlide.2.1.1.js"></script>
		<script type="text/javascript" src="/Pc/js/base.js"></script>
		<script>
            var myVideo = $(".video").children("video")[0];
            var stayTime=setInterval(stayTimeFunc,1000);
            function stayTimeFunc(){
                if(!myVideo.paused) {
                    $(".video").find(".bofang").hide();
                    var time ={{$video->time}};
                    var min = parseInt($('#mintue').html());
                    var sec = parseInt($('#second').html());
                    if(min*60+sec<time) {
                        if (sec === 59) {
                            min += 1;
                            sec = 0;
                        } else {
                            sec += 1;
                        }
						@if($question)
                        if((min*60+sec)===parseInt(time/2)){
                            $(".wenti").show();
                            $(".zhe").show();
                            myVideo.pause(); //视频停止
                            exitFullscreen();//退出全屏
                            $(".wenti").attr('is_click','true');
                        }
                        $("#queding").click(function() {
                            if($("input[name='probrem']:checked").val()=='{{$question->true}}'){
                                $("#zhengque").show();
                            }else if($(".wentib ul li").hasClass("on")){
                                $.ajax({
                                    type: 'POST',
                                    url: '/ajax/userError',
                                    data: {eid:{{$question->id}},error:$("input[name='probrem']:checked").val()},
                                    dataType: "json"
                                });
                                $("#cuowu").show();
                            }else{
                                alert("请选择一个答案");
                            }
                            myVideo.pause(); //视频停止
                        });
                        $(".jixu").click(function(){
                            $(".wenti").hide();
                            $("#zhengque").hide();
                            $("#cuowu").hide();
                            $(".zhe").hide();
                            myVideo.play();
                            $(".wenti").attr('is_click','false');
                        });
                        $(".video").find(".bofang").hide();
						@endif
                        if (sec < 10) {
                            sec = '0' + sec;
                        }
                        if (min < 10) {
                            min = '0' + min;
                        }
                        $('#mintue').html(min);
                        $('#second').html(sec);
                    }else{
                        $.ajax({
                            type: 'POST',
                            url: '/ajax/userStudy',
                            data: {vid:{{$video->id}},res:1},
                            dataType: "json"
                        });
                        exitFullscreen();//退出全屏
                        $(".video").find(".bofang").show();
                        $(".wenti").attr('is_click','false');
                        clearInterval(stayTime);
					}
                }
			}
            function playPause() {
                var myVideo = $(".video").children("video")[0];
                if(myVideo.paused) {
                    if($(".wenti").attr('is_click')!=='true') {
                        myVideo.play(); //视频播放
                    }
					$(".video").find(".bofang").hide();
                } else {
                    myVideo.pause(); //视频停止
                    $(".video").find(".bofang").show();
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