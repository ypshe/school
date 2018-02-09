@extends('layout')
@section('content')
		<!--导航部分-->
		<!--查看错题-->
		<div class="zhuce cuoti" id="cuoti">
			<div class="guanbi">
				<img src="/Pc/img/guanbi.png">
			</div>
			<div class="ztop">
				查看错题
			</div>
			<div class="dati">
			</div>
		</div>
		<!--删除确认-->
		<div class="zhe"></div>
		<!--主体部分-->
		<div class="main">
			<!--面包屑导航-->
			<div class="mianbao">
				<a href="{{url('/')}}">首页</a>
				<span>></span>
				<a href="{{url('/user')}}">个人中心</a>
			</div>
			<!--面包屑导航-->
			<div class="gerenbox">
				<div class="gerentop">
					<div class="gerentouxiang">
						<a href="{{url('/user')}}">
							<img src="{{img_local($user->pic)}}">
						</a>
					</div>
					<span>{{$user->name}}</span>
				</div>
				<div class="gerenbo">
					<div class="gerenbole">
						<dl>
							<dt>
								<i>
									<img src="/Pc/img/icongeren.png">
								</i>
								<span>学习中心</span>
							</dt>
							<dd>
								<a href="{{url('/user/study')}}">
									<span>在线学习</span>
									<i></i>
								</a>
								<a href="{{url('/user/test')}}">
									<span>在线练习</span>
									<i></i>
								</a>
								<a href="{{url('/user/exam')}}">
									<span>在线考试</span>
									<i></i>
								</a>
								<a class="on" href="{{url('/user/errorExam')}}">
									<span>错题库</span>
									<i></i>
								</a>
								<a href="{{url('/user/result')}}">
									<span>考核情况</span>
									<i></i>
								</a>
								<a href="{{url('/user/speak')}}">
									<span>在线留言</span>
									<i></i>
								</a>
								<a href="{{url('/user/file')}}">
									<span>资料下载</span>
									<i></i>
								</a>
							</dd>
						</dl>
						<dl>
							<dt>
								<i>
									<img src="/Pc/img/icongeren02.png">
								</i>
								<span>个人中心</span>
							</dt>
							<dd>
								<a href="{{url('/user')}}">
									<span>个人资料</span>
									<i></i>
								</a>
								<a href="{{url('/user/order')}}">
									<span>订单管理</span>
									<i></i>
								</a>
								<a href="{{url('/user/order')}}">
									<span>教育档案</span>
									<i></i>
								</a>
							</dd>
						</dl>
						<dl>
							<dt>
								<i>
									<img src="/Pc/img/icongeren03.png">
								</i>
								<span>客服中心</span>
							</dt>
							<dd class="kefu">
								<a>
									<span>服务热线</span>
									<b>400-2564-2564</b>
									<img src="/Pc/img/erweima02.jpg">
									<span class="sao">扫一扫<br>手机也能看</span>
								</a>
							</dd>
						</dl>
					</div>
					<div class="gerenbori" style="min-height: 847px;">
						<h2>错题库</h2>
						<div class="shuoming">
							说明：练习、考试、视频中回答错题均会录入错题库(错题记录以第一次为主，如再有回答错误将会忽略不计)。
						</div>
						<div class="chaxun cuotic">
							<form action="/user/errorExam" method="get">
								{{csrf_field()}}
								<span>试题名称：</span>
								<input class="shuru" type="text" value="{{request('search')}}" name="search">
								<span class="jieguo"></span>
								<input type="submit" class="btn cx" value="立即查询">
								{{--<a href="">错题重答</a>--}}
							</form>
						</div>
						<div class="chaxliebiao cuotict">
							<table>
								<thead>
									<td style="text-align: center;padding-left: 0;width:50px;">NO</td>
									<td style="text-align: center;">所属课程</td>
									<td style="text-align: center;">试题名称</td>
									<td style="text-align: center;">正确答案</td>
									<td style="text-align: center;">你的答案</td>
									<td width="120" style="text-align: center;">操作</td>
								</thead>
								<tbody>
								@foreach($exam as $k=>$v)
									<tr id="01">
										<td style="text-align: center;padding-left: 0;">{{++$k}}</td>
										<td style="text-align: center;">{{$v->sname}}</td>
										<td style="text-align: left;" >@if(mb_strlen($v->info,'utf-8')){{mb_substr($v->info,0,15,'utf-8')."..."}}@else{{$v->info}}@endif</td>
										<td style="text-align: center;">{{$v->true}}</td>
										<td style="text-align: center;">{{$v->error}}</td>
										<td width="120" style="text-align: center;">
											<a href="javascript:;" onclick="lookwrr({{$v->eid}})">查看错题</a>
											<a href="javascript:;" onclick="del({{$v->errorId}})">删除错题</a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
            //查看错题
            function lookwrr(id){
                $.ajax({
					url:'/ajax/getExam?id='+id,
					type:'get',
					dataType:'json',
					success:function(data){
                        var str='';
                            str+="<dl>\n" +
                                "\t\t\t\t\t<dt>\n" +
                                "\t\t\t\t\t\t<span>问题："+data.info+"( 正确答案：<color style='color:red'>"+data.true+"</color> )</span>\n" +
                                "\t\t\t\t\t</dt>\n" +
                                "\t\t\t\t\t<dd class=\"datimain\">\n" +
                                "\t\t\t\t\t\t<label>\n" +
                                "\t\t\t\t\t\t\t<div class=\"labelle "+(data.true===data.choose_1?"on":'')+"\">\n" +
                                "\t\t\t\t\t\t\t\t<span></span>\n" +
                                "\t\t\t\t\t\t\t\t<input type=\"radio\""+(data.true===data.choose_1?"checked":'')+"/>\n" +
                                "\t\t\t\t\t\t\t</div>\n" +
                                "\t\t\t\t\t\t\t<div class=\"labelri\">\n" +
                                "\t\t\t\t\t\t\t\tA."+data.choose_1+
                                "\t\t\t\t\t\t\t</div>\n" +
                                "\t\t\t\t\t\t</label>\n" +
                                "\t\t\t\t\t\t<label>\n" +
                                "\t\t\t\t\t\t\t<div class=\"labelle "+(data.true===data.choose_2?"on":'')+"\">\n" +
                                "\t\t\t\t\t\t\t\t<span></span>\n" +
                                "\t\t\t\t\t\t\t\t<input type=\"radio\""+(data.true===data.choose_2?"checked":'')+"/>\n" +
                                "\t\t\t\t\t\t\t</div>\n" +
                                "\t\t\t\t\t\t\t<div class=\"labelri\">\n" +
                                "\t\t\t\t\t\t\t\tB."+data.choose_2+
                                "\t\t\t\t\t\t\t</div>\n" +
                                "\t\t\t\t\t\t</label>\n" +
                                "\t\t\t\t\t\t<label>\n" +
                                "\t\t\t\t\t\t\t<div class=\"labelle "+(data.true===data.choose_3?"on":'')+"\">\n" +
                                "\t\t\t\t\t\t\t\t<span></span>\n" +
                                "\t\t\t\t\t\t\t\t<input type=\"radio\""+(data.true===data.choose_3?"checked":'')+"/>\n" +
                                "\t\t\t\t\t\t\t</div>\n" +
                                "\t\t\t\t\t\t\t<div class=\"labelri\">\n" +
                                "\t\t\t\t\t\t\t\tC."+data.choose_3+
                                "\t\t\t\t\t\t\t</div>\n" +
                                "\t\t\t\t\t\t</label>\n" +
                                "\t\t\t\t\t\t<label>\n" +
                                "\t\t\t\t\t\t\t<div class=\"labelle "+(data.true===data.choose_4?"on":'')+"\">\n" +
                                "\t\t\t\t\t\t\t\t<span></span>\n" +
                                "\t\t\t\t\t\t\t\t<input type=\"radio\""+(data.true===data.choose_4?"checked":'')+"/>\n" +
                                "\t\t\t\t\t\t\t</div>\n" +
                                "\t\t\t\t\t\t\t<div class=\"labelri\">\n" +
                                "\t\t\t\t\t\t\t\tD."+data.choose_4+
                                "\t\t\t\t\t\t\t</div>\n" +
                                "\t\t\t\t\t\t</label>\n" +
                                "\t\t\t\t\t</dd>\n" +
                                "\t\t\t\t</dl>";
                        $('.dati').html(str);
                        $("#cuoti").show();
                        $(".zhe").show();
                    }
				});
            }
            //删除错题
            function del(id){
                layer.confirm('确定删除该错题么？', {
                    btn: ['确认','取消'] //按钮
                }, function(){
                    $.ajax({
                        url:"/ajax/delExam?id="+id,
                        type:'get',
						success:function(){
                            layer.msg('删除成功！', {time: 3000, icon:3});
                            var url='/user/errorExam';
                            setTimeout(function() {
                                location.href=url;
                            },2000);
						}
                    });
                });
            }
		</script>
		<!--主体部分-->
@endsection