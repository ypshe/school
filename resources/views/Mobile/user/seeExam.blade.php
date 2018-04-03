<!DOCTYPE html>
<html class="bgbai">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<title>学员考试系统</title>
	<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
	<link rel="stylesheet" href="/mobile/css/base.css" />
</head>
<body class="bgbai">
<!--头部-->
<div class="header bglan overflow textcenter wbai"  style="position: fixed;top:0vw;width:100%;left:0px;">
	<a class="fl textcenter" href="/wap/user/exam_history">
		<i class="iconfont icon-zuojiantou bai h1 b">

		</i>
	</a>
	<h3 class="sanwu bai textcenter">学员考试系统</h3>
	<a id="chengji" class="fr bai h2">成绩</a>
</div>
<!--头部-->
<!--学员考试系统-->
<article>
	<div class="onlinelianxi"  style="background-color:white;position: fixed;top:14.6vw;width:100%;left:0px;">
		<h1 class="h2 san textcenter">{{$pro->name}} 在线考试</h1>
		<div class="textcenter h4 liu">考试人员：{{$user->name}} / 卷总分：100 / 考试时长：{{$pro->exam_time}}分钟</div>
	</div>
	<div class="shijuan top20" style="padding-top:35vw;">
		<h2 class="jiu h2"><span class="san h2 fl">一、单选题</span>（本题共{{$pro->exam_single}}小题，每题{{$pro->single_value}}分，共{{$pro->single_value*$pro->exam_single}}分）</h2>
        <?php $a=1;?>
		@foreach($single as $k=>$v)
			<dl class="">
				<dt class="lancolor h2 overflow">
					<span class="h2 san" style="display: inline-block;">{{$a++}}.{{$v['info']}}？ </span>(本题得{{$pro->single_value}}分)
				</dt>
				<dd class="datimain top20">
					<label class="overflow">
						<div class="labelle on fl">
							<input type="radio"  name="0"/>
						</div>
						<div class="labelri fl h2 liu">
							A.{{$v['choose_1']}}
						</div>
					</label>
					<label class="overflow">
						<div class="labelle fl">
							<input type="radio"  name="0"/>
						</div>
						<div class="labelri fl h2 liu">
							B.{{$v['choose_2']}}
						</div>
					</label>
					<label class="overflow">
						<div class="labelle fl">
							<input type="radio"  name="0"/>
						</div>
						<div class="labelri fl h2 liu">
							C.{{$v['choose_3']}}
						</div>
					</label>
					<label class="overflow">
						<div class="labelle fl">
							<input type="radio"  name="0"/>
						</div>
						<div class="labelri fl h2 liu">
							D.{{$v['choose_4']}}
						</div>
					</label>
				</dd>
				<dd class="jiexi overflow" style="display: none;">
					<span class="h2">你的答案：{{isset($v['res'])?$v['res']:'未答'}}</span>
					<span style="margin-bottom: 0;" class="h2">正确答案：{{$v['true']}}</span>
				</dd>
				<dd style="overflow: hidden;" class="xianshis">
					<a href="javascript:;" class="xianshi fr">
						<b class="h3 textcenter">显示答案</b>
					</a>
				</dd>
			</dl>
		@endforeach
	</div>
	@if(isset($choose))
		<div class="shijuan top20">
            <?php $a=1;?>
			<h2 class="jiu h2"><span class="san h2 fl">二、多选题</span>（本题共{{$pro->exam_choose}}小题，每题{{$pro->choose_value}}分，共{{$pro->exam_choose*$pro->choose_value}}分）</h2>
			@foreach($choose as $k=>$v)
				<dl class="">
					<dt class="lancolor h2 overflow">
						<span class="h2 san" style="display: inline-block;">{{$a++}}.{{$v['info']}}？ </span>(本题得{{$pro->single_value}}分)
					</dt>
					<dd class="datimain top20">
						<label class="overflow">
							<div class="labelle on fl">
								<input type="checkbox"  name="0"/>
							</div>
							<div class="labelri fl h2 liu">
								A.{{$v['choose_1']}}
							</div>
						</label>
						<label class="overflow">
							<div class="labelle fl">
								<input type="checkbox"  name="0"/>
							</div>
							<div class="labelri fl h2 liu">
								B.{{$v['choose_2']}}
							</div>
						</label>
						<label class="overflow">
							<div class="labelle fl">
								<input type="checkbox"  name="0"/>
							</div>
							<div class="labelri fl h2 liu">
								C.{{$v['choose_3']}}
							</div>
						</label>
						<label class="overflow">
							<div class="labelle fl">
								<input type="checkbox"  name="0"/>
							</div>
							<div class="labelri fl h2 liu">
								D.{{$v['choose_4']}}
							</div>
						</label>
						@if(isset($v['choose_5'])&&$v['choose_5'])
							<label class="overflow">
								<div class="labelle fl">
									<input type="checkbox"  name="0"/>
								</div>
								<div class="labelri fl h2 liu">
									E.{{$v['choose_5']}}
								</div>
							</label>
						@endif
						@if(isset($v['choose_6'])&&$v['choose_6'])
							<label class="overflow">
								<div class="labelle fl">
									<input type="checkbox" name="0"/>
								</div>
								<div class="labelri fl h2 liu">
									F.{{$v['choose_6']}}
								</div>
							</label>
						@endif
						@if(isset($v['choose_7'])&&$v['choose_7'])
							<label class="overflow">
								<div class="labelle fl">
									<input type="checkbox"  name="0"/>
								</div>
								<div class="labelri fl h2 liu">
									G.{{$v['choose_7']}}
								</div>
							</label>
						@endif
					</dd>
					<dd class="jiexi overflow" style="display: none;">
						<span class="h2">你的答案：{{isset($v['res'])?$v['res']:'未答'}}</span>
						<span style="margin-bottom: 0;" class="h2">正确答案：{{$v['true']}}</span>
					</dd>
					<dd style="overflow: hidden;" class="xianshis">
						<a href="javascript:;" class="xianshi fr">
							<b class="h3 textcenter">显示答案</b>
						</a>
					</dd>
				</dl>
			@endforeach
		</div>
	@endif
	@if(isset($judge))
		<div class="shijuan top20">
			<h2 class="jiu h2"><span class="san h2 fl">@if(isset($choose))三@else二@endif、判断题</span>（本题共{{$pro->judge_num}}小题，每题{{$pro->judge_value}}分，共{{$pro->judge_value*$pro->judge_num}}分）</h2>
            <?php $a=1;?>
			@foreach($judge as $k=>$v)
				<dl class="">
					<dt class="lancolor h2 overflow">
						<span class="h2 san" style="display: inline-block;">{{$a++}}.{{$v['info']}}？ </span>(本题得{{$pro->judge_value}}分)
					</dt>
					<dd class="datimain panduan top20">
						<label class="overflow">
							<div class="labelle on fl">
								<input type="radio"   value=1 choose="对"  name="panduan_{{$v['id']}}"/>
							</div>
							<div class="labelri fl h2 liu">
								对
							</div>
						</label>
						<label class="overflow">
							<div class="labelle fl">
								<input type="radio"   value=0 choose="否" name="panduan_{{$v['id']}}"/>
							</div>
							<div class="labelri fl h2 liu">
								否
							</div>
						</label>
					</dd>
					<dd class="jiexi overflow" style="display: none;">
						<span class="h2">你的答案：{{isset($v['res'])?($v['res']?'对':'否'):'未答'}}</span>
						<span style="margin-bottom: 0;" class="h2">正确答案：{{isset($v['res'])?(($v['res']&&$v['is_true'])?'对':'否'):($v['is_true']?'对':'否')}}</span>
					</dd>
					<dd style="overflow: hidden;" class="xianshis">
						<a href="javascript:;" class="xianshi fr">
							<b class="h3 textcenter">显示答案</b>
						</a>
					</dd>
				</dl>
			@endforeach
		</div>
	@endif
</article>
<!--学员考试系统-->
<!--查看试卷成绩-->

<!--查看试卷成绩-->
<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
<script type="text/javascript" src="/mobile/js/lazyload.js"></script>
<script>
    //单选
    $(".datimain label").click(function(){
        $(this).children(".labelle").addClass("on");
        $(this).siblings().children(".labelle").removeClass("on");

    });
    $(".xianshi").click(function(){
        $(this).parent("dd").prev(".jiexi").toggle();
    });
    var chengji = '<div class="chengji bgbai" style="min-height: 87.2vw;padding-top:2.4vw; posiation:relative">'+
        '<i class="iconfont icon-error guanbi jiu h1"></i>'+
        '<div class="title">'+
        '<span>试卷成绩</span>'+
        '</div>'+
        '<div class="fenshu textcenter" style="font-size:6.1vw;color:#e70a2e">{{$examLog->value}}分</div>'+
        '<div class="shuomings overflow">'+
        '<span class="fl kuai" style="margin-left: 0;"></span>'+
        '<span class="fl liu h2">答对</span>'+
        '<span class="fl kuai" style="background: #e5e5e5;"></span>'+
        '<span class="fl liu h2">未答</span>'+
        '<span class="fl kuai" style="background: #db2308;"></span>'+
        '<span class="fl liu h2">答错</span>'+
        '</div>'+
        '<div class="shuomings shuomingsw overflow top20" style="border-bottom: none;">'+
        '<span class="fl h2 textcenter" style="margin-left: 0;">单选：</span>'+
		<?php $a=1;?>
		@foreach($single as $k=>$v)
			'<span class="fl kuai h2 bai textcenter" style="margin-left: 0;@if(in_array($v['id'],$weida_single))background: #e5e5e5; @else @if($v['is_true']==1)  @else background: #db2308; @endif @endif">{{$a++}}</span>'+
		@endforeach
		'</div>'+
		@if(isset($choose))
			'<div class="shuomings shuomingsw overflow top20" style="border-bottom: none;">'+
			'<span class="fl h2 textcenter" style="margin-left: 0;">多选：</span>'+
			<?php $a=1;?>
			@foreach($choose as $k=>$v)
				'<span class="fl kuai h2 bai textcenter" style="margin-left: 0;@if(in_array($v['id'],$weida_choose))background: #e5e5e5; @else @if($v['is_true']==1)  @else background: #db2308; @endif @endif">{{$a++}}</span>'+
			@endforeach
			'</div>'+
		@endif
		@if(isset($judge))
			'<div class="shuomings shuomingsw overflow top20" style="border-bottom: none;">'+
			'<span class="fl h2 textcenter" style="margin-left: 0;">判断：</span>'+
			<?php $a=1;?>
			@foreach($judge as $k=>$v)
				'<span class="fl kuai h2 bai textcenter" style="margin-left: 0;@if(in_array($v['id'],$weida_judge))background: #e5e5e5; @else @if($v['is_true']==1)  @else background: #db2308; @endif @endif">{{$a++}}</span>'+
			@endforeach
			'</div>'+
		@endif
		'</div>';
    $("#chengji").click(function(){
        layer.open({
            content: chengji,
            skin: 'footer',
        });
        $(".guanbi").click(function(){
            $(this).parents(".layui-m-layer").hide();
        });
    })
</script>
</body>

</html>