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
		<title>个人中心-在线练习-查看试卷</title>
		<link rel="stylesheet" href="/Pc/css/base.css" />
		<link rel="stylesheet" href="/Pc/css/base_start.css" />
		<link rel="stylesheet" href="/Pc/css/gerenzhongxin.css" />
		<script type="text/javascript" src="/Pc/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="/Pc/js/jquery.SuperSlide.2.1.1.js" ></script>
		<script type="text/javascript" src="/Pc/js/base.js"></script>
		<script type="text/javascript" src="/vendor/layer/layer.js"></script>
	</head>
	<body>
		<!--试卷头部-->
		<div class="shijuantop">
			<div class="shijuantoptext">
				<div class="shijuanle">
					<img src="/Pc/img/kaoshilogo.png">
				</div>
			</div>
		</div>
		<!--试卷头部-->
		<!--成功提交试卷弹窗-->
		<div class="zhuce shijuantan">
			<div class="">
				{{--<img src="/Pc/img/guanbi.png">--}}
			</div>
			<div class="ztop">
				畜牧兽医 在线考试
			</div>
			<div class="good">
				<img src="/Pc/img/zhifuchenggong.png">
				<span>成功提交试卷</span>
				<p id="kaoshichengji">考试成绩：
					<b style="color:#e70a2e;font-weight: 400;">
						<z id="score"></z>分
					</b>考试耗时：
					<b style="color:#333333;font-weight: 400;">
						<z id="useTime_m"></z>分<z id="useTime_s"></z>秒
					</b>
				</p>
				<a class="btn" id="chakanshijuan" href="">查看试卷</a>
			</div>
		</div>
		<!--成功提交试卷弹窗-->
		<div class="zhe"></div>
		<!--主体部分-->
		<div class="main">
			<div class="kaoshile">
				<form action="" id="examForm">
					<h1>{{$pro->name}} 在线考试</h1>
					<input type="hidden" name="uid" value="{{$user->id}}">
					<input type="hidden" name="pid" value="{{$pro->id}}">
					{{csrf_field()}}
					<div class="kaoshixinxi">
						考试人员：{{$user->name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;试卷总分：100分&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;考试时长：{{$pro->exam_time}}分钟
					</div>
					<div class="zhuyi">
						注：答题过程中请不要刷新页面
					</div>
					<div class="xuxian">
						<img src="/Pc/img/xuxian.png">
					</div>
					<div class="dati">
						<h2>一、单选题<span>（本题共{{$pro->exam_single}}小题，每题{{$pro->single_value}}分，共{{$pro->single_value*$pro->exam_single}}分）</span></h2>
						@foreach($single as $k=>$v)
						<dl eid="{{$v['id']}}">
							<dt>
								<span>{{$k+1}}.{{$v['info']}}？(      )</span>
								<b>本题得{{$pro->single_value}}分</b>
							</dt>
							<dd class="datimain danxuan">
								<label>
									<div class="labelle">
										<span></span>
										<input type="radio" name="{{$v['id']}}" value="{{$v['choose'][0]}}" choose="A"/>
									</div>
									<div class="labelri">
										A.{{$v['choose'][0]}}
									</div>
								</label>
								<label>
									<div class="labelle">
										<span></span>
										<input type="radio"  name="{{$v['id']}}" value="{{$v['choose'][1]}}" choose="B" />
									</div>
									<div class="labelri">
										B.{{$v['choose'][1]}}
									</div>
								</label>
								<label>
									<div class="labelle">
										<span></span>
										<input type="radio"  name="{{$v['id']}}" value="{{$v['choose'][2]}}" choose="C" />
									</div>
									<div class="labelri">
										C.{{$v['choose'][2]}}
									</div>
								</label>
								<label>
									<div class="labelle">
										<span></span>
										<input type="radio"  name="{{$v['id']}}" value="{{$v['choose'][3]}}" choose="D"/>
									</div>
									<div class="labelri">
										D.{{$v['choose'][3]}}
									</div>
								</label>
							</dd>
							<input type="hidden"  name="id[]" value="{{$v['id']}}" />
							<dd style="overflow: hidden;height:24px;" class="xianshis">
								<a href="javascript:;" class="xianshi on">
									<b class="youchoose">未作答</b>
								</a>
							</dd>
						</dl>
						@endforeach
						@if($pro->exam_choose)
							<h2>二、多选题<span>（本题共{{$pro->exam_choose}}小题，每题{{$pro->choose_value}}分，共{{$pro->choose_value*$pro->exam_choose}}分）</span></h2>
							@foreach($choose as $k=>$v)
								<dl eid="{{$v['id']}}">
									<dt>
										<span>{{$k+1}}.{{$v['info']}}？(      )</span>
										<b>本题得{{$pro->choose_value}}分</b>
									</dt>
									<dd class="datimain choose">
										<label>
											<div class="labelle">
												<span></span>
												<input type="checkbox" name="duoxuan_{{$v['id']}}[]" value="{{$v['choose'][0]}}" choose="A"/>
											</div>
											<div class="labelri">
												A.{{$v['choose'][0]}}
											</div>
										</label>
										<label>
											<div class="labelle">
												<span></span>
												<input type="checkbox"  name="duoxuan_{{$v['id']}}[]" value="{{$v['choose'][1]}}" choose="B" />
											</div>
											<div class="labelri">
												B.{{$v['choose'][1]}}
											</div>
										</label>
										<label>
											<div class="labelle">
												<span></span>
												<input type="checkbox"  name="duoxuan_{{$v['id']}}[]" value="{{$v['choose'][2]}}" choose="C" />
											</div>
											<div class="labelri">
												C.{{$v['choose'][2]}}
											</div>
										</label>
										<label>
											<div class="labelle">
												<span></span>
												<input type="checkbox"  name="duoxuan_{{$v['id']}}[]" value="{{$v['choose'][3]}}" choose="D"/>
											</div>
											<div class="labelri">
												D.{{$v['choose'][3]}}
											</div>
										</label>
										@if(isset($v['choose'][4]))
											<label>
												<div class="labelle">
													<span></span>
													<input type="checkbox"  name="duoxuan_{{$v['id']}}[]" value="{{$v['choose'][4]}}" choose="E"/>
												</div>
												<div class="labelri">
													E.{{$v['choose'][4]}}
												</div>
											</label>
										@endif
										@if(isset($v['choose'][5]))
											<label>
												<div class="labelle">
													<span></span>
													<input type="checkbox"  name="duoxuan_{{$v['id']}}[]" value="{{$v['choose'][5]}}" choose="F"/>
												</div>
												<div class="labelri">
													F.{{$v['choose'][5]}}
												</div>
											</label>
										@endif
										@if(isset($v['choose'][6]))
											<label>
												<div class="labelle">
													<span></span>
													<input type="checkbox"  name="duoxuan_{{$v['id']}}[]" value="{{$v['choose'][6]}}" choose="G"/>
												</div>
												<div class="labelri">
													G.{{$v['choose'][6]}}
												</div>
											</label>
										@endif
									</dd>
									<input type="hidden"  name="duoxuan_id[]" value="{{$v['id']}}" />
									<dd style="overflow: hidden;height:24px;" class="xianshis">
										<a href="javascript:;" class="xianshi on">
											<b class="youchoose">未作答</b>
										</a>
									</dd>
								</dl>
							@endforeach
						@endif
						@if($pro->judge_num)
                            <?php $a=1;?>
							<h2>@if($pro->exam_choose)三@else二@endif、判断题<span>（本题共{{$pro->judge_num}}小题，每题{{$pro->judge_value}}分，共{{$pro->judge_num*$pro->judge_value}}分）</span></h2>
							@foreach($judge as $k=>$v)
								<dl eid="{{$v['id']}}">
									<dt>
										<span>{{$a++}}.{{$v['info']}}？(      )</span>
										<b>本题得{{$pro->judge_value}}分</b>
									</dt>
									<dd class="datimain panduan">
										<label>
											<div class="labelle">
												<span></span>
												<input type="radio" name="panduan_{{$v['id']}}" value=1 choose="对"/>
											</div>
											<div class="labelri">
												对
											</div>
										</label>
										<label>
											<div class="labelle">
												<span></span>
												<input type="radio"  name="panduan_{{$v['id']}}" value=0  choose="否"/>
											</div>
											<div class="labelri">
												否
											</div>
										</label>
									</dd>
									<input type="hidden"  name="panduan_id[]" value="{{$v['id']}}" />
									<dd style="overflow: hidden;height:24px;" class="xianshis">
										<a href="javascript:;" class="xianshi on">
											<b class="youchoose">未作答</b>
										</a>
									</dd>
								</dl>
							@endforeach
						@endif
					</div>
						<input type="hidden" id="submitTime" name="time" value="">
						<input type="hidden" name="count" value="{{$count}}">
					<div class="tijiao">
						<a class="btn" href="javascript:;">
							提交
						</a>
					</div>
				</form>
			</div>
			<div class="kaoshiri" style="position: fixed;right:50%;top:126px;margin-right:-600px;">
				<div class="kaoshiritop" id="remainTime">
					剩余时间：<span id="minute">00</span>分<span id="second">00</span>秒
					<br><br>
					作答率：<span id="zuodalv">0</span>%
				</div>
				<div class="kaoshirimo">
					<dl style="margin-left: 20px;">
						<dt style="background: #03478f;"></dt>
						<dd>已答</dd>
					</dl>
					<dl>
						<dt style="background: #e5e5e5;"></dt>
						<dd>未答</dd>
					</dl>
				</div>
				<div class="kaoshiribo">
					<div style="color:red;padding-bottom: 5px"><b>单选:</b></div>
                    <?php $a=1;?>
					@foreach($single as $k=>$v)
						<span class="weida" id="danxuan{{$v['id']}}">{{$a++}}</span>
					@endforeach
					<div style="clear: left"></div>
					@if($pro->exam_choose)
						<div style="color:red;padding-bottom: 5px"><b>多选:</b></div>
                        <?php $a=1;?>
						@foreach($choose as $k=>$v)
							<span class="weida" id="duoxuan{{$v['id']}}">{{$a++}}</span>
						@endforeach
						<div style="clear: left"></div>
					@endif
					@if($pro->judge_num)
						<div style="color:red;padding-bottom: 5px"><b>判断:</b></div>
                        <?php $a=1;?>
						@foreach($judge as $k=>$v)
							<span class="weida" id="panduan{{$v['id']}}">{{$a++}}</span>
						@endforeach
					@endif
				</div>
			</div>
		</div>
		<!--主体部分-->
		
		<script type="text/javascript" src="/Pc/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="/Pc/js/jquery.SuperSlide.2.1.1.js" ></script>
		<script type="text/javascript" src="/Pc/js/base.js"></script>
		<script>
            $(".datimain label").css('cursor','pointer');
            $(".datimain input").attr('disabled','disabled');
            var time={{$pro->exam_time}}*60;
            var t;
            function timedCount() {
                var m=parseInt(time/60);
                var s=parseInt(time%60);
                $('#minute').html(m);
                $('#second').html(s);
                if(time>0){
                    if(time===5*60){
                        layer.msg('考试只剩下最后5分钟！请快速答题后提交，系统将在5分钟后自动提交试卷！');
					}
                    t=setTimeout("timedCount()",1000);
					time--;
                }else{
					submitExam(0);
				}
            }
            timedCount();
            function submitExam(time){
                clearTimeout(t);
				time={{$pro->exam_time}}*60-time;
                $('#submitTime').val(time);
                $(".datimain input").removeAttr('disabled');
                var data=$('#examForm').serializeArray();
                $.ajax({
					type:'post',
					url:'{{url('/user/submitExam')}}',
					dataType:'json',
					data:data,
					success:function(res){
					    if(res.error===1){
							$('#kaoshichengji').html('您未作答任何题目，本次考试0分无效！！！');
							$('#chakanshijuan').hide();
						}else{
                            $('#score').html(res.value);
                            $('#useTime_m').html(parseInt(res.time/60));
                            $('#useTime_s').html(parseInt(res.time%60));
                            $('#chakanshijuan').attr('href','{{url('/user/seeExam')}}'+'/'+res.id);
						}
                        $(".shijuantan").show();
                        $(".zhe").show();
                    }
				});
			}
            $(function(){
                //单选
                $(".danxuan label").click(function(){
                    $(this).children(".labelle").addClass("on");
                    $(this).siblings().children(".labelle").removeClass("on");
                    $(this).find("input").prop("checked",true);
                    $(this).siblings().find("input").prop('checked',false);
                    $(this).parent().parent().find('.youchoose').html('你选：'+$(this).find("input").attr('choose'));
                    var eid='#danxuan'+$(this).parent().parent().attr('eid');
                    $(eid).removeClass('weida');
                    $(eid).addClass('dadui');
                    checkZuodalv();
                });
                //判断
                $(".panduan label").click(function(){
                    $(this).children(".labelle").addClass("on");
                    $(this).siblings().children(".labelle").removeClass("on");
                    $(this).find("input").prop("checked",true);
                    $(this).siblings().find("input").prop('checked',false);
                    $(this).parent().parent().find('.youchoose').html('你选：'+$(this).find("input").attr('choose'));
                    var eid='#panduan'+$(this).parent().parent().attr('eid');
                    $(eid).removeClass('weida');
                    $(eid).addClass('dadui');
                    checkZuodalv();
                });
                //多选
                $(".choose label").click(function(){
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
                    $(this).parent().parent().find('.youchoose').html(res);
                    var eid='#duoxuan'+$(this).parent().parent().attr('eid');
                    console.log($(this).parent().find("input[type='checkbox']:checked").length);
                    if($(this).parent().find("input[type='checkbox']:checked").length!==0) {
                        $(eid).removeClass('weida');
                        $(eid).addClass('dadui');
                    }else{
                        $(eid).removeClass('dadui');
                        $(eid).addClass('weida');
                    }
                    checkZuodalv();
                });
                function checkZuodalv(){
                    if($('.kaoshiribo .dadui').length==={{(count($choose)+count($single)+count($judge))}}){
                        $('#zuodalv').html(100);
                    }else {
                        $('#zuodalv').html($('.kaoshiribo .dadui').length * parseInt('{{100/(count($choose)+count($single)+count($judge))}}'));
                    }
                }
                //提交按钮
                $(".tijiao").click(function(){
                    layer.confirm('确定提交试卷么？', {
                        btn: ['确定','取消'] //按钮
                    }, function(index){
                        if(parseInt($('#zuodalv').html())!==100) {
                            layer.confirm('还有题目未答，确定提交试卷么？', {
                                btn: ['确定', '取消'] //按钮
                            }, function (index) {
                                layer.close(index);
                                submitExam(time);
                            });
                        }else{
                            layer.close(index);
                            submitExam(time);
                        }
                    });
                });
            });
		</script>
	</body>

</html>