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
		<link rel="stylesheet" href="Pc/css/base.css" />
		<link rel="stylesheet" href="Pc/css/index.css" />
	</head>

	<body>
		<div class="videobox">
			<div class="videoboxtop">
				<div class="videoboxtople">
					<a href="">
						<img src="Pc/img/fanhui.png">
						<b>2018初级会计实务精讲班</b>
						<span>1-1课程介绍</span>
					</a>
				</div>
				<div class="videoboxtopri">
					<a href="">
						<img src="Pc/img/touxiang.png">
					</a>
				</div>
			</div>
			<!--中间弹出问题-->
			<div class="wenti">
				<div class="title">
					<h2>请回答当前问题并继续观看课程</h2>
				</div>
				<div class="wentib">
					<h3>01. 该课程中出现的NETTY是什么意思？</h3>
					<ul>
						<li class="on">
							<label>
									<a>
										<i></i>
										<input type="radio" name="probrem" checked="checked"  />
									</a>
									<span><i>A.</i>表示一种固体</span>
								</label>
						</li>
						<li>
							<label>
									<a>
										<i></i>
										<input type="radio" name="probrem" checked="" />
									</a>
									<span><i>B.</i>表示一种固体</span>
								</label>
						</li>
						<li>
							<label>
									<a>
										<i></i>
										<input type="radio" name="probrem" checked="" />
									</a>
									<span><i>C.</i>表示一种固体</span>
								</label>
						</li>
						<li>
							<label>
									<a>
										<i></i>
										<input type="radio" name="probrem" checked="" />
									</a>
									<span><i>D.</i>表示一种固体</span>
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
					<img src="Pc/img/zhengque.png">
					<span>恭喜您回答正确，请继续观看</span>
					<a class="btn lv" href="javascript:;" id="jixu01">
						请继续
					</a>
				</div>
				<!--回答正确-->
				<!--回答错误-->
				<div class="zhengque" id="cuowu">
					<img src="Pc/img/cuowu.png">
					<span>很抱歉回答错误，正确答案为<b>B.表示一种气体</b></span>
					<span>请继续观看</span>
					<a class="btn lv" href="javascript:;" id="jixu02">请继续</a>
				</div>
				<!--回答错误-->
			</div>
			<!--中间弹出问题-->
			<div class="video" onclick="playPause()">
				<div class="bofang">
					<img src="Pc/img/bofang.png">
				</div>
				<video style="width:100%;height:95%;" id="video" controls="controls">

					<source src="video/movie.ogg" type="video/ogg" />
					<source src="video/movie.mp4" type="video/mp4" />
					<source src="" type="video/webm" />
					<object data="" style="width:100%;height:95%;">
				            <embed width="386" height="386" src="" />
				       </object>
				</video>

			</div>
			<div class="section-list" style="right: 0px;">
				<div class="nano has-scrollbar">
					<div class="nano-content" tabindex="0" style="right: -17px;">
						<h3>Netty入门之WebSocket初体验</h3>
						<ul>
							<li class="sec-title">
								<span>第1章 课程介绍</span>
							</li>
							<li>
								<a href=""><i class="icon"><img src="Pc/img/xiaoyoujian.png"></i><i>1-1</i> <b>课程介绍</b><i>(06:47)</i></a>
							</li>
						</ul>
						<ul>
							<li class="sec-title">
								<span>第2章 IO通信</span>
							</li>
							<li>
								<a href=""><i class="icon"><img src="Pc/img/xiaoyoujian.png"></i><i>2-1</i> <b>IO通信</b><i>(09:45)</i></a>
							</li>
						</ul>
						<ul>
							<li class="sec-title">
								<span>第3章 Netty入门</span>
							</li>
							<li>
								<a href=""><i class="icon"><img src="Pc/img/xiaoyoujian.png"></i><i>3-1</i> <b>Netty入门</b><i>(03:46)</i></a>
							</li>
						</ul>
						<ul>
							<li class="sec-title">
								<span>第4章 WebSocket入门</span>
							</li>
							<li>
								<a href=""><i class="icon"><img src="Pc/img/xiaoyoujian.png"></i><i>4-1</i> <b>WebSocket入门</b><i>(07:12)</i></a>
							</li>
						</ul>
						<ul>
							<li class="sec-title">
								<span>Netty实现WebSocket</span>
							</li>
							<li>
								<a href=""><i class="icon"><img src="Pc/img/xiaoyoujian.png"></i><i>5-1</i> <b>WebSocket工程全局配置类WebSocket工程全局配置类WebSocket工程全局配置类</b><i>(03:42)</i></a>
							</li>
							<li>
								<a href=""><i class="icon"><img src="Pc/img/xiaoyoujian.png"></i><i>5-2</i> <b>WebSocket核心类方法说明</b><i>(03:42)</i></a>
							</li>
							<li>
								<a href=""><i class="icon"><img src="Pc/img/xiaoyoujian.png"></i><i>5-3</i> <b>WebSocket握手请求业务的</b><i>(03:42)</i></a>
							</li>
							<li>
								<a href=""><i class="icon"><img src="Pc/img/xiaoyoujian.png"></i><i>5-4</i> <b>WebSocket连接业务的实现</b><i>(03:42)</i></a>
							</li>
							<li>
								<a href=""><i class="icon"><img src="Pc/img/xiaoyoujian.png"></i><i>5-5</i> <b>WebSocket初始化连接时各</b><i>(03:42)</i></a>
							</li>
							<li>
								<a href=""><i class="icon"><img src="Pc/img/xiaoyoujian.png"></i><i>5-6</i> <b>WebSocket启动类的实现</b><i>(03:42)</i></a>
							</li>
							<li>
								<a href=""><i class="icon"><img src="Pc/img/xiaoyoujian.png"></i><i>5-6</i> <b>WebSocket客户端网页基本</b><i>(03:42)</i></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!--遮罩层-->
		
		<!--遮罩层-->
		<script type="text/javascript" src="Pc/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="Pc/js/jquery.SuperSlide.2.1.1.js"></script>
		<script type="text/javascript" src="Pc/js/base.js"></script>
		<script>
			function playPause() {
				console.log("执行了");
				var myVideo = $(".video").children("video")[0];
				console.log(myVideo);
				if(myVideo.paused) {
					console.log("paused");
					myVideo.play(); //视频播放
					setTimeout(function() {
						$(".wenti").show();
						$(".zhe").show();
						myVideo.pause(); //视频停止
					}, 5000);
					$("#queding").click(function() {
						$("#zhengque").show();
						myVideo.pause(); //视频停止
					});
					$("#jixu01").click(function(){
						$(".wenti").hide();
						$("#zhengque").hide();
						$("#cuowu").hide();
						$(".zhe").hide();
						myVideo.play();
					})
					$(".video").find(".bofang").hide();
				} else {
					myVideo.pause(); //视频停止
					$(".video").find(".bofang").show();
				}
			}
		</script>
	</body>

</html>