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
		<title>个人中心-在线考试-查看试卷</title>
		<link rel="stylesheet" href="/Pc/css/base.css" />
		<link rel="stylesheet" href="/Pc/css/base_start.css" />
		<link rel="stylesheet" href="/Pc/css/gerenzhongxin.css" />
		<script type="text/javascript" src="/Pc/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="/Pc/js/jquery.SuperSlide.2.1.1.js" ></script>
		<script type="text/javascript" src="/Pc/js/base.js"></script>
		<script type="text/javascript" src="/Vendor/layer/layer.js"></script>
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
				畜牧兽医 在线练习
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
					@if(isset($single)&&$single)
					<h2>一、单选题<span>（本题共{{$pro->exam_single}}小题，每题{{$pro->single_value}}分，共{{$pro->exam_single*$pro->single_value}}分）</span></h2>
                    <?php $a=0;?>
                    <?php $b=0;?>
					@foreach($single as $k=>$v)
					<dl eid="{{$v['id']}}">
						<dt>
							<span>{{++$a}}.{{$v['info']}}？(      )</span>
							<b>本题得{{$pro->single_value}}分</b>
						</dt>
						<dd class="datimain">
							<label>
								<div class="labelle">
									<span></span>
									<input type="radio" name="{{$v['id']}}" value="{{$v['choose_1']}}" choose="A"/>
								</div>
								<div class="labelri">
									A.{{$v['choose_1']}}
								</div>
							</label>
							<label>
								<div class="labelle">
									<span></span>
									<input type="radio"  name="{{$v['id']}}" value="{{$v['choose_2']}}" choose="B" />
								</div>
								<div class="labelri">
									B.{{$v['choose_2']}}
								</div>
							</label>
							<label>
								<div class="labelle">
									<span></span>
									<input type="radio"  name="{{$v['id']}}" value="{{$v['choose_3']}}" choose="C" />
								</div>
								<div class="labelri">
									C.{{$v['choose_3']}}
								</div>
							</label>
							<label>
								<div class="labelle">
									<span></span>
									<input type="radio"  name="{{$v['id']}}" value="{{$v['choose_4']}}" choose="D"/>
								</div>
								<div class="labelri">
									D.{{$v['choose_4']}}
								</div>
							</label>
						</dd>
						<dd class="jiexi" style="display: block">
							<span>参考答案：{{$v['true']}}</span>
							<span style="margin-bottom: 0;">你的答案：{{isset($v['res'])?$v['res']:'未作答'}}</span>
						</dd>
						<dd style="overflow: hidden;height:24px;" class="xianshis">
							<a href="javascript:;" class="xianshi on">
								<b class="youchoose">{{(isset($v['res'])&&$v['is_true'])?'正确':'错误'}}</b>
							</a>
						</dd>
					</dl>
					@endforeach
					@endif
					@if(isset($choose))
						<h2>二、多选题<span>（本题共{{$pro->exam_choose}}小题，每题{{$pro->choose_value}}分，共{{$pro->choose_value*$pro->exam_choose}}分）</span></h2>
						@foreach($choose as $k=>$v)
							<dl eid="{{$v['id']}}">
								<dt>
									<span>{{++$b}}.{{$v['info']}}？(      )</span>
									<b>本题得{{$pro->choose_value}}分</b>
								</dt>
								<dd class="datimain choose">
									<label>
										<div class="labelle">
											<span></span>
											<input type="checkbox" name="duoxuan_{{$v['id']}}[]" value="{{$v['choose_1']}}" choose="A"/>
										</div>
										<div class="labelri">
											A.{{$v['choose_1']}}
										</div>
									</label>
									<label>
										<div class="labelle">
											<span></span>
											<input type="checkbox"  name="duoxuan_{{$v['id']}}[]" value="{{$v['choose_2']}}" choose="B" />
										</div>
										<div class="labelri">
											B.{{$v['choose_2']}}
										</div>
									</label>
									<label>
										<div class="labelle">
											<span></span>
											<input type="checkbox"  name="duoxuan_{{$v['id']}}[]" value="{{$v['choose_3']}}" choose="C" />
										</div>
										<div class="labelri">
											C.{{$v['choose_3']}}
										</div>
									</label>
									<label>
										<div class="labelle">
											<span></span>
											<input type="checkbox"  name="duoxuan_{{$v['id']}}[]" value="{{$v['choose_4']}}" choose="D"/>
										</div>
										<div class="labelri">
											D.{{$v['choose_4']}}
										</div>
									</label>
									@if(isset($v['choose_5']))
										<label>
											<div class="labelle">
												<span></span>
												<input type="checkbox"  name="duoxuan_{{$v['id']}}[]" value="{{$v['choose_5']}}" choose="E"/>
											</div>
											<div class="labelri">
												E.{{$v['choose_5']}}
											</div>
										</label>
									@endif
									@if(isset($v['choose_6']))
										<label>
											<div class="labelle">
												<span></span>
												<input type="checkbox"  name="duoxuan_{{$v['id']}}[]" value="{{$v['choose_6']}}" choose="F"/>
											</div>
											<div class="labelri">
												F.{{$v['choose_6']}}
											</div>
										</label>
									@endif
									@if(isset($v['choose_7']))
										<label>
											<div class="labelle">
												<span></span>
												<input type="checkbox"  name="duoxuan_{{$v['id']}}[]" value="{{$v['choose_7']}}" choose="G"/>
											</div>
											<div class="labelri">
												G.{{$v['choose_7']}}
											</div>
										</label>
									@endif
								</dd>
								<dd class="jiexi" style="display: block">
									<span>参考答案：{{$v['true']}}</span>
									<span style="margin-bottom: 0;">你的答案：{{isset($v['res'])?$v['res']:'未作答'}}</span>
								</dd>
								<dd style="overflow: hidden;height:24px;" class="xianshis">
									<a href="javascript:;" class="xianshi on">
										<b class="youchoose">{{(isset($v['res'])&&$v['is_true'])?'正确':'错误'}}</b>
									</a>
								</dd>
							</dl>
						@endforeach
					@endif
					@if(isset($judge))
                        <?php $a=1;?>
						<h2>@if(isset($choose)&&$choose)三@else二@endif、判断题<span>（本题共{{$pro->judge_num}}小题，每题{{$pro->judge_value}}分，共{{$pro->judge_num*$pro->judge_value}}分）</span></h2>
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
											<input type="hidden"  name="panduan_id[]" value="{{$v['id']}}" />
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
								<dd class="jiexi" style="display: block">
                                    <span>参考答案：{{isset($v['res'])?(!$v['res']?'对':'否'):($v['is_true']?'对':'否')}}</span>
                                    <span style="margin-bottom: 0;">你的答案：{{isset($v['res'])?($v['res']?'对':'否'):'未作答'}}</span>
								</dd>
								<dd style="overflow: hidden;height:24px;" class="xianshis">
									<a href="javascript:;" class="xianshi on">
										<b class="youchoose">{{isset($v['res'])?'正确':'错误'}}</b>
									</a>
								</dd>
							</dl>
						@endforeach
					@endif
				</div>
				<div class="tijiao">
					<a class="btn" href="{{url('/user/online_exam')}}">
						返回
					</a>
				</div>
				</form>
			</div>
			<div class="kaoshiri"  style="position: fixed;right:20px;top:126px;float:left">
				<div class="kaoshiritop">
					试卷得分：{{$examLog->value}}分
					<br><br>
					考试时间：<span id="minute">{{$examLog->time}}</span>
					<br><br>
					作答率：<span id="zuodalv">{{$zuodalv}}</span>%
				</div>
				<div class="kaoshirimo">
					<dl style="margin-left: 20px;">
						<dt style="background: #03478f;"></dt>
						<dd>答对</dd>
					</dl>
					<dl>
						<dt style="background: #e5e5e5;"></dt>
						<dd>未答</dd>
					</dl>
					<dl>
						<dt style="background: #db2308;"></dt>
						<dd>答错</dd>
					</dl>
				</div>
				<div class="kaoshiribo">
					@if(isset($single))
						<div style="color:red;padding-bottom: 5px"><b>单选:</b></div>
                        <?php $a=1;?>
						@foreach($single as $k=>$v)
							<span class="@if(in_array($v['id'],$weida_single)) weida @else @if($v['is_true']==1) dadui @else dacuo @endif @endif">{{$a++}}</span>
						@endforeach
					@endif
					@if(isset($choose))
						<div style="clear: left"></div>
						<div style="color:red;padding-bottom: 5px"><b>多选:</b></div>
                        <?php $a=1;?>
						@foreach($choose as $k=>$v)
							<span class="@if(in_array($v['id'],$weida_choose)) weida @else @if($v['is_true']==1) dadui @else dacuo @endif @endif">{{$a++}}</span>
						@endforeach
					@endif
					@if(isset($judge))
						<div style="clear: left"></div>
						<div style="color:red;padding-bottom: 5px"><b>判断:</b></div>
                        <?php $a=1;?>
						@foreach($judge as $k=>$v)
							<span class="@if(in_array($v['id'],$weida_judge)) weida @else @if($v['is_true']==1) dadui @else dacuo @endif @endif">{{$a++}}</span>
						@endforeach
					@endif
				</div>
			</div>
		</div>
		<!--主体部分-->
		<script type="text/javascript" src="/Pc/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="/Pc/js/jquery.SuperSlide.2.1.1.js" ></script>
		<script type="text/javascript" src="/Pc/js/base.js"></script>
	</body>

</html>