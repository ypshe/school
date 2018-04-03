<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>我要留言</title>
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
			<a class="fl textcenter" href="javascript:history.go(-1);">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a>
			<h3 class="sanwu bai textcenter">我要留言</h3>
			<a class="fr h2 bai b" href="javascript:;" id="liuyan">
				留言
			</a>
		</div>
		<!--头部-->
		<!--我要留言-->
		<article class="bgbai" style="padding-bottom: 0px">
			<div class="liuyan">
				@if($ask)
					@foreach($ask as $k=>$v)
					<dl>
						<dt class="h2 san">{{$v->content}}？</dt>
						<dd class="h2 lancolor">
							@if($v->return){{$v->return}}@else未回复@endif
						</dd>
					</dl>
					@endforeach
				@endif
			</div>
		</article>
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script type="text/javascript" src="/mobile/js/lazyload.js"></script>
		<script>
			$(function(){
				var liuyan = '<div class="liuyantan bgbai posiation:relative">'+
				'<i class="iconfont icon-error guanbi jiu h1"></i>'+
				'<div class="title">'+
					'<span class="h1 san">我要留言</span>'+
				'</div>'+
				'<div class="liuyans top40">'+
					'<textarea id="liuyans" class="liu h2 wbai"></textarea>'+
				'</div>'+
				'<div id="tijiao" class="red h2 bai top40 textcenter">'+
					'提交'+
				'</div>'+
			    '</div>';
				$("#liuyan").click(function(){
					layer.open({
				       content: liuyan,
				       skin: 'footer',
				       style: 'position:fixed; bottom:0; left:0; width: 100%; border:none;'
				    });
				    $(".guanbi").click(function(){
						$(this).parents(".layui-m-layer").hide();
					});
				    $('#tijiao').click(function(){
				        var value=$('#liuyans').val();
						if(value===''){
                            layer.open({
                                content: '请输入留言内容！',
                                skin: 'msg',
                                time: 2 //2秒后自动关闭
                            });
						}else{
							$.ajax({
								url:'/ajax/user/addAsk',
								type:'post',
								data:{content:value,_token:'{{csrf_token()}}'},
								dataType:'json',
								success:function(){
                                    layer.open({
                                        content: '留言成功！',
                                        skin: 'msg',
                                        time: 2 //2秒后自动关闭
                                    });
                                    $(".guanbi").parents(".layui-m-layer").hide();
                                    setTimeout('location.reload()',2000);
								}
							});
						}
					});
				});
			});
		</script>
		<!--底部-->
		@include('wap_foot')
		<!--底部-->
	</body>

</html>