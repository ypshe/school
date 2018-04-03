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
	<a class="fl textcenter" href="javascript:history.go(-1);">
		<i class="iconfont icon-zuojiantou bai h1 b">

		</i>
	</a>
	<h3 class="sanwu bai textcenter">学员考试系统</h3>
	<a id="chengji" class="fr bai h2">交卷</a>
</div>
<!--头部-->
<!--学员考试系统-->
<form action="" method="post" id="form">
	<article>
		<div class="onlinelianxi bgbai"  style="position: fixed;top:14.6vw;width:100%;left:0px;">
			<h1 class="h2 san textcenter">{{$pro->name}} 在线考试</h1>
			<div class="textcenter h4 liu">考试人员：{{$user->name}} / 卷总分：100 / 考试时长：{{$pro->exam_time}}分钟</div>
			<div class="daojishi san h4 textcenter">
				剩余时间：<span id="timer" style="color:red;display: inline-block;"></span> / 作答率：<span id="zuodalv" style="color:red;display: inline-block;">0</span><span style="color:red;display: inline-block;">%</span>
			</div>
		</div>
		<!-- 倒计时 -->
		<script type="text/javascript">
            var daojishibtn = document.getElementById("daojishi");
            var maxtime = {{$pro->exam_time}}*60 //一个小时，按秒计算，自己调整!
            function CountDown(){
                if(maxtime>=0){
                    minutes = Math.floor(maxtime/60);
                    seconds = Math.floor(maxtime%60);
                    msg = +minutes+"分"+seconds+"秒";
                    document.all["timer"].innerHTML=msg;
                    if(maxtime === 5*60) {
                        layer.msg('考试只剩下最后5分钟！请快速答题后提交，系统将在5分钟后自动提交试卷！');
                    }
                    --maxtime;
                }else{
                    submitExam(maxtime);
                }
            }
            timer = setInterval("CountDown()",1000);
		</script>
		<div class="shijuan top20" style="padding-top:35vw;">
			<h2 class="jiu h2"><span class="san h2 fl">一、单选题</span>（本题共{{$pro->exam_single}}小题，每题{{$pro->single_value}}分，共{{$pro->single_value*$pro->exam_single}}分）</h2>
            <?php $a=1;?>
			@foreach($single as $k=>$v)
				<dl class="">
					<dt class="lancolor h2 overflow">
						<span class="h2 san" style="display: inline-block;">{{$a++}}.{{$v['info']}}？ </span>(本题得{{$pro->single_value}}分)
					</dt>
					<dd class="datimain danxuan top20">
						<label class="overflow">
							<div class="labelle on fl">
								<input type="radio"   value="{{$v['choose'][0]}}" choose="A"  name="{{$v['id']}}"/>
							</div>
							<div class="labelri fl h2 liu">
								A.{{$v['choose'][0]}}
							</div>
						</label>
						<label class="overflow">
							<div class="labelle fl">
								<input type="radio"   value="{{$v['choose'][1]}}" choose="B" name="{{$v['id']}}"/>
							</div>
							<div class="labelri fl h2 liu">
								B.{{$v['choose'][1]}}
							</div>
						</label>
						<label class="overflow">
							<div class="labelle fl">
								<input type="radio"  value="{{$v['choose'][2]}}" choose="C"  name="{{$v['id']}}"/>
							</div>
							<div class="labelri fl h2 liu">
								C.{{$v['choose'][2]}}
							</div>
						</label>
						<label class="overflow">
							<div class="labelle fl">
								<input type="radio" value="{{$v['choose'][3]}}" choose="D" name="{{$v['id']}}"/>
								<input type="hidden"  name="id[]" value="{{$v['id']}}" />
							</div>
							<div class="labelri fl h2 liu">
								D.{{$v['choose'][3]}}
							</div>
						</label>
					</dd>
					<dd style="overflow: hidden;" class="xianshis">
						<a href="javascript:;" class="xianshi fr">
							<b class="h3 textcenter"><z class="youChoose"></z></b>
						</a>
					</dd>
				</dl>
			@endforeach
		</div>
		@if(isset($choose))
			<div class="shijuan top20">
				<h2 class="jiu h2"><span class="san h2 fl">二、多选题</span>（本题共{{$pro->exam_choose}}小题，每题{{$pro->choose_value}}分，共{{$pro->choose_value*$pro->exam_choose}}分）</h2>
                <?php $a=1;?>
				@foreach($choose as $k=>$v)
					<dl class="">
						<dt class="lancolor h2 overflow">
							<span class="h2 san" style="display: inline-block;">{{$a++}}.{{$v['info']}}？ </span>(本题得{{$pro->choose_value}}分)
						</dt>
						<dd class="datimain duoxuan top20">
							<label class="overflow">
								<div class="labelle on fl">
									<input type="checkbox"   value="{{$v['choose'][0]}}" choose="A"  name="{{$v['id']}}"/>
									<input type="hidden"  name="duoxuan_id[]" value="{{$v['id']}}" />
								</div>
								<div class="labelri fl h2 liu">
									A.{{$v['choose'][0]}}
								</div>
							</label>
							<label class="overflow">
								<div class="labelle fl">
									<input type="checkbox"   value="{{$v['choose'][1]}}" choose="B" name="{{$v['id']}}"/>
								</div>
								<div class="labelri fl h2 liu">
									B.{{$v['choose'][1]}}
								</div>
							</label>
							<label class="overflow">
								<div class="labelle fl">
									<input type="checkbox"   value="{{$v['choose'][2]}}" choose="C"  name="{{$v['id']}}"/>
								</div>
								<div class="labelri fl h2 liu">
									C.{{$v['choose'][2]}}
								</div>
							</label>
							<label class="overflow">
								<div class="labelle fl">
									<input type="checkbox"  value="{{$v['choose'][3]}}" choose="D" name="{{$v['id']}}"/>
								</div>
								<div class="labelri fl h2 liu">
									D.{{$v['choose'][3]}}
								</div>
							</label>
							@if(isset($v['choose'][4]))
								<label class="overflow">
									<div class="labelle fl">
										<input type="checkbox"  value="{{$v['choose'][4]}}" choose="E" name="{{$v['id']}}"/>
									</div>
									<div class="labelri fl h2 liu">
										E.{{$v['choose'][4]}}
									</div>
								</label>
							@endif
							@if(isset($v['choose'][5]))
								<label class="overflow">
									<div class="labelle fl">
										<input type="checkbox"  value="{{$v['choose'][5]}}" choose="E" name="{{$v['id']}}"/>
									</div>
									<div class="labelri fl h2 liu">
										F.{{$v['choose'][5]}}
									</div>
								</label>
							@endif
							@if(isset($v['choose'][6]))
								<label class="overflow">
									<div class="labelle fl">
										<input type="checkbox"  value="{{$v['choose'][6]}}" choose="F" name="{{$v['id']}}"/>
									</div>
									<div class="labelri fl h2 liu">
										G.{{$v['choose'][6]}}
									</div>
								</label>
							@endif
						</dd>
						<dd style="overflow: hidden;" class="xianshis">
							<a href="javascript:;" class="xianshi fr">
								<b class="h3 textcenter"><z class="youChoose"></z></b>
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
						<input type="hidden"  name="panduan_id[]" value="{{$v['id']}}" />
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
						<dd style="overflow: hidden;" class="xianshis">
							<a href="javascript:;" class="xianshi fr">
								<b class="h3 textcenter"><z class="youChoose"></z></b>
							</a>
						</dd>
					</dl>
				@endforeach
			</div>
		@endif
	</article>
	<input type="hidden" name="time" id="submitTime">
	<input type="hidden" name="count" value="{{$count}}">
	<input type="hidden" name="uid" value="{{$user->id}}">
	<input type="hidden" name="pid" value="{{$pro->id}}">
	{{csrf_field()}}
	<npt
			m>
		<!--学员考试系统-->

		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script type="text/javascript" src="/mobile/js/lazyload.js"></script>
		<script>
            $(".datimain label").css('cursor','pointer');
            var chengji = '<div class="chengji bgbai" style="min-height: 87.2vw;padding-top:2.4vw">'+
                '<div class="title">'+
                '<span>提交试卷</span>'+
                '</div>'+
                '<div class="cg textcenter top20" style="margin-top:10vw">'+
                '<i class="iconfont icon-success textcenter" style="color:#38b00e;font-size:10vw;"></i>'+
                '<span class="san h2 textcenter top20">成功提交试卷</span>'+
                '<div class="textcenter h2 jiu top20">'+
                '考试成绩：<b style="color:#e70a2e;font-weight: 400;"><z id="score">80</z>分</b>'+
                '&nbsp;&nbsp;&nbsp;&nbsp;'+
                '考试耗时：<b style="color:#333333;font-weight: 400;"><z id="useTime_m"></z>分钟</b>'+
                '</div>'+
                '</div>'+
                '<a class="anniu textcenter bai h2" id="chakanshijuan" href="">查看试卷</a>'+
                '</div>';
            function submitExam(time){
                $('#chengji').attr('disable','disable');
                clearTimeout(timer);
                time={{$pro->exam_time}}*60-time;
                $('#submitTime').val(time);
                var data=$('#form').serializeArray();console.log(data);
                $.ajax({
                    type:'post',
                    url:'{{url('/ajax/wap/user/submitExam')}}',
                    dataType:'json',
                    data:data,
                    success:function(res){
                        if(res.error===1){
                            layer.open({
                                content: '您未作答任何题目，本次考试0分无效！！！'
                            });
                        }else if(res.error===2){
                            layer.open({
                                content: '操作有误，请重新答题！！！'
                            });
                        }else{
                            layer.open({
                                content: chengji,
                                skin: 'footer',
                            });
                            $('#score').html(res.value);
                            $('#useTime_m').html(parseInt(res.time/60));
                            $('#useTime_s').html(parseInt(res.time%60));
                            $('#chakanshijuan').attr('href','{{url('/wap/user/seeExam')}}'+'/'+res.id);
                        }
                        $(".shijuantan").show();
                        $(".zhe").show();
                    }
                });
            }
            $(function(){
                //单选
                $(".danxuan label").click(function(){
                    $(this).find("input").attr("checked",'checked');
                    $(this).parent().parent().find('.youChoose').html('你选择：'+$(this).find("input").attr('choose'));
                    checkZuodalv();
                });
                //判断
                $(".panduan label").click(function(){
                    $(this).find("input").attr("checked",'checked');
                    $(this).parent().parent().find('.youChoose').html('你选择：'+$(this).find("input").attr('choose'));
                    checkZuodalv();
                });
                //多选
                $(".duoxuan label").click(function(){
                    $(this).find(".labelle").toggleClass("on");
                    if($(this).find("input[type='checkbox']").attr('checked')==='checked'){
                        $(this).find("input[type='checkbox']").removeAttr("checked");
                    }else{
                        $(this).find("input[type='checkbox']").attr('checked','checked');
                    }
                    var res='';
                    $(this).parent().find("input[type='checkbox']:checked").each(function(){
                        res+=$(this).attr('choose');
                    });
                    $(this).parent().parent().find('.youChoose').html(res);
                    checkZuodalv();
                });
                function checkZuodalv(){
                    var exam=$.merge($.merge($('#form .duoxuan'),$('#form .danxuan')),$('#form .panduan'));
                    var yida=0;
                    $.each(exam,function(){
                        if($(this).find('input[checked]').length!==0){
                            yida++;
                        }
                    });
                    $('#zuodalv').html(yida * parseInt('{{(!$count)?0:(100/$count)}}'));
                }
                //提交按钮
                $("#chengji").click(function(){
                    if($(this).attr('disable')==='disable'){
                        layer.open({
                            content: '试卷已提交，请勿重复提交！'
                        });
                    }else {
                        layer.open({
                            content: '确定提交试卷么？'
                            , btn: ['确定', '取消']
                            , yes: function (index) {
                                if (parseInt($('#zuodalv').html()) !== 100) {
                                    layer.open({
                                        content: '还有题目未答，确定提交试卷么？',
                                        btn: ['确定', '取消'],
                                        yes: function (index) {
                                            layer.close(index);
                                            submitExam(maxtime);
                                        }
                                    });
                                } else {
                                    layer.close(index);
                                    submitExam(maxtime);
                                }
                            }
                        });
                    }
                });
            });
		</script>
</body>

</html>