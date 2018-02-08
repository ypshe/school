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
	</head>

	<body>
		<div class="videobox">
			<div class="videoboxtop">
				<div class="videoboxtople">
					<a href="{{url('/studyDesc/'.$study->id)}}">
						<img src="/Pc/img/fanhui.png">
						<b>{{$study->name}}</b>
						<span>{{$video->section+1}}-{{$video->sort}}{{$video->name}}</span>
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
				<video style="width:100%;height:95%;" id="video" controls="controls">

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
			@if($question)
				function playPause() {
					var myVideo = $(".video").children("video")[0];
					if(myVideo.paused) {
						myVideo.play(); //视频播放
						setTimeout(function() {
							$(".wenti").show();
							$(".zhe").show();
							myVideo.pause(); //视频停止
						}, {{($video->time/2)*1000}});
						$("#queding").click(function() {
							if($("input[name='probrem']:checked").val()=='{{$question->true}}'){
								$("#zhengque").show();
							}else{
								if(1){
									$.ajax({
										type: 'POST',
										url: '/ajax/userError',
										data: {eid:{{$question->id}},error:$("input[name='probrem']:checked").val()},
										dataType: "json"
									});
								}
								$("#cuowu").show();
							}
							myVideo.pause(); //视频停止
						});
						$(".jixu").click(function(){
							$.ajax({
								type: 'POST',
								url: '/ajax/userStudy',
								data: {vid:{{$video->id}},res:0},
								dataType: "json",
								success:function(){
									$(".wenti").hide();
									$("#zhengque").hide();
									$("#cuowu").hide();
									$(".zhe").hide();
									myVideo.play();
								}
							});
						});
						$(".video").find(".bofang").hide();
					} else {
						myVideo.pause(); //视频停止
						$(".video").find(".bofang").show();
					}
				}
			@else
            function playPause() {
                var myVideo = $(".video").children("video")[0];
                if(myVideo.paused) {
                    myVideo.play(); //视频播放
                    $(".video").find(".bofang").hide();
                } else {
                    myVideo.pause(); //视频停止
                    $(".video").find(".bofang").show();
                }
            }
			@endif
            /*视频结束或错误*/
            $("#video").bind('error ended', function(){
                $.ajax({
                    type: 'POST',
                    url: '/ajax/userStudy',
                    data: {vid:{{$video->id}},res:1},
                    dataType: "json"
                });
            });
		</script>
	</body>

</html>