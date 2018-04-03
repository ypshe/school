<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<title>错题库</title>
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
	<h3 class="sanwu bai textcenter">多选错题库</h3>
	<a class="iconfont icon-wo fr h1 c9 b" href="/wap/user" style="font-size:7vw"></a>
</div>
<!--头部-->
<!--个人中心-->
<article>
	<div class="yanzheng bgbai top20 overflow">
		<span class="fl h3 lancolor" style="line-height: 7.73vw;">试题名称：</span>
		<form name="form" class="fl" action="@if($type==2)/wap/user/errorExam/2 @else/wap/user/errorExam/1 @endif" method="get">
			{{csrf_field()}}
			<input class="fl h3 liu" type="text" value="{{request('search')}}" name="search"/>
			<button class="fr h3 liu" id="chaxun">查询</button>
		</form>
	</div>
	<!--搜索结果-->
	<div class="yanzhengbo top20">
		<div class="title">
			<span class="fl h2">搜索结果</span>
			<button class="fr h3 liu" style="margin-top: 1.001vw" onclick="javascript:location.href='/wap/user/errorExam/2'">查看单选错题</button>
		</div>
		@foreach($exam as $k=>$v)
			<div style="padding:0 2.4vw" class="shiti top20 bgbai">
				<table class="wbai top20">
					<thead>
					<td class="h3 lancolor" style="width:53vw;">
						试题名称
					</td>
					</thead>
					<tbody>
					<tr>
						<td class="h4 liu">{{$v->info}}？</td>
					</tr>
					<tr>
						<td colspan="3">
							<a class="fl cuoti" href="javascript:;" onclick="cuoti({{$v->id}},'{{implode(',',json_decode($v->error,true))}}')">查看错题</a>
							{{--<a class="fl laiyuan" href="javascript:;" style="margin-left: 6vw;" onclick="laiyuan({{$v->id}})">查看来源</a>--}}
							<a class="fl" href="/wap/user/delError/2/{{$v->id}}" style="margin-left: 6vw;">删除错题</a>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		@endforeach
	</div>
	<!--搜索结果-->
</article>
<!--个人中心-->
<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
<script>
    $(function(){
        $("#chaxun").click(function(){
            $('#form').submit();
        });
    });
    //查看错题弹窗
    function cuoti(value,error){
        $.ajax({
            url:'/ajax/wap/getError/2/'+value,
            type:'get',
            dataType:'json',
            success:function(data){
                var cuoti = '<div class="cuotilook bgbai" id="cuoti" style="min-height: 71.3vw;posiation:relative">'+
                    '<i class="iconfont icon-error guanbi jiu h1"></i>'+
                    '<div class="title">'+
                    '<span class="fl h2">查看错题</span>'+
                    '</div>'+
                    '<div class="cuotibox top40">'+
                    '<dl>'+
                    '<dt class="h2 san">'+data.info+'？</dt>'+
                    '<dd class="top20">'+
                    '<label class="overflow">'+
                    '<input class="fl" type="radio"  name="cuoti" />'+
                    '<span class="fl jiu h2">A.'+data.choose_1+'</span>'+
                    '</label>'+
                    '</dd>'+
                    '<dd class="top20">'+
                    '<label class="overflow">'+
                    '<input class="fl" type="radio" name="cuoti" />'+
                    '<span class="fl jiu h2">B.'+data.choose_2+'</span>'+
                    '</label>'+
                    '</dd>'+
                    '<dd class="top20">'+
                    '<label class="overflow">'+
                    '<input class="fl" type="radio" name="cuoti" />'+
                    '<span class="fl jiu h2">C.'+data.choose_3+'</span>'+
                    '</label>'+
                    '</dd>'+
                    '<dd class="top20">'+
                    '<label class="overflow">'+
                    '<input class="fl" type="radio" name="cuoti" />'+
                    '<span class="fl jiu h2">D.'+data.choose_4+'</span>'+
                    '</label>'+
                    '</dd>';
                if(data.choose_5){
                    cuoti+='<dd class="top20">'+
                        '<label class="overflow">'+
                        '<input class="fl" type="radio" name="cuoti" />'+
                        '<span class="fl jiu h2">E.'+data.choose_5+'</span>'+
                        '</label>'+
                        '</dd>';
				}
                if(data.choose_6){
                    cuoti+='<dd class="top20">'+
                        '<label class="overflow">'+
                        '<input class="fl" type="radio" name="cuoti" />'+
                        '<span class="fl jiu h2">F.'+data.choose_6+'</span>'+
                        '</label>'+
                        '</dd>';
                }
                if(data.choose_6){
                    cuoti+='<dd class="top20">'+
                        '<label class="overflow">'+
                        '<input class="fl" type="radio" name="cuoti" />'+
                        '<span class="fl jiu h2">G.'+data.choose_6+'</span>'+
                        '</label>'+
                        '</dd>';
                }
                cuoti+='</dl>'+
                '</div>'+
                '</div>'+
                    '<div style="color:green">正确答案：'+data.true+
                    '</div>'+
                    '<div style="color:red">你的答案：'+error
                '</div>'
                layer.open({
                    content: cuoti,
                    skin: 'footer',
                });
                $(".guanbi").click(function(){console.log(1);
                    $(this).parents(".layui-m-layer").hide();
                });
            }
        });
    }
    //查看错题弹窗
</script>
<!--底部-->
@include('wap_foot')
<!--底部-->
</body>

</html>