<!DOCTYPE html>
<html class="bgbai">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<title>通知公告详情</title>
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
	<h3 class="sanwu bai textcenter">通知公告详情</h3>
	<a class="iconfont icon-wo fr h1 bai b" href="{{url('/wap/user')}}" style="font-size:7vw"></a>
</div>
<!--头部-->
<!--通知公告详情-->
<article>
	<div class="gonggxq">
		<div class="h3 span textcenter">
			{{$data->title}}
		</div>
		<div class="textcenter jiu h3 top10">2018-02-01</div>
		<div class="xqbox liu h3 top20">
			<img class="wbai" src="{{img_local($data->pic)}}">
            <?php echo $data->content;?>
		</div>
	</div>
</article>
<!--通知公告详情-->
<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
<script type="text/javascript" src="/mobile/js/lazyload.js"></script>
<!--底部-->
@include('wap_foot')
<!--底部-->
</body>

</html>