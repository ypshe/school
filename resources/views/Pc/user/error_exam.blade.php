@extends('layout')
@section('content')
		<!--导航部分-->
		<!--查看错题-->
		<div class="zhuce cuoti" id="cuoti"  style="height:390px">
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
				<span>></span>
				<a href="{{url('/user/errorExam')}}">错题库</a>
			</div>
			<!--面包屑导航-->
			<div class="gerenbox">
				@include('user_public')
					<div class="gerenbori" style="min-height: 847px;">
						<h2>错题库</h2>
						<div class="shuoming">
							说明：练习、考试、视频中回答错题均会录入错题库(错题记录以第一次为主，如再有回答错误将会忽略不计)。
						</div>
						<div class="chaxun cuotic">
							<form action="@if($type==2)/user/errorExam/2 @else/user/errorExam @endif" method="get">
								{{csrf_field()}}
								<span>试题名称：</span>
								<input class="shuru" type="text" value="{{request('search')}}" name="search">
								<span class="jieguo"></span>
								<input type="submit" class="btn cx" value="立即查询">
								@if($type!=2)
									<a href="{{url('/user/errorExam/2')}}">查看多选错题</a>
								@else
									<a href="{{url('/user/errorExam')}}">查看单选错题</a>
								@endif
							</form>
						</div>
						<div class="chaxliebiao cuotict">
							<table>
								<thead>
									<td style="text-align: center;padding-left: 0;width:50px;">NO</td>
									<td style="text-align: center;">所属专业</td>
									<td style="text-align: center;">试题名称</td>
									<td style="text-align: center;">正确答案</td>
									<td style="text-align: center;">你的答案</td>
									<td width="120" style="text-align: center;">操作</td>
								</thead>
								<tbody>
								@if(isset($exam))
									@foreach($exam as $k=>$v)
										<tr id="01">
											<td style="text-align: center;padding-left: 0;">{{++$k}}</td>
											<td style="text-align: center;">{{$v->pname}}</td>
											<td style="text-align: left;" >@if(mb_strlen($v->info,'utf-8')>15){{mb_substr($v->info,0,15,'utf-8')."..."}}@else{{$v->info}}?@endif</td>
											<td style="text-align: center;">@if($type==2)@foreach(json_decode($v->true,true) as $val){{$v->$val}}&nbsp;&nbsp;<br/>@endforeach @else{{$v->true}}@endif</td>
											<td style="text-align: center;">@if($type==2)@foreach(json_decode($v->error,true) as $val){{$val}}&nbsp;&nbsp;<br/>@endforeach @else{{$v->error}}@endif</td>
											<td width="120" style="text-align: center;">
												<a href="javascript:;" onclick="lookwrr({{$v->eid}})">查看错题</a>
												<a href="javascript:;" onclick="del({{$v->errorId}})">删除错题</a>
											</td>
										</tr>
									@endforeach
								@endif
								</tbody>
							</table>
                            <?php echo $exam->render(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
            //查看错题
            function lookwrr(id){
                var url='';
                if({{$type??0}}===2){
                    url='/ajax/getExam/2?id='+id;
				}else{
                    url='/ajax/getExam?id='+id;
				}
                $.ajax({
					url:url,
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
                                "\t\t\t\t\t\t</label>\n" ;
                            if(data.choose_5){
								str+="\t\t\t\t\t\t<label>\n" +
									"\t\t\t\t\t\t\t<div class=\"labelle "+((data.choose_5 in data.true_array)?"on":'')+"\">\n" +
									"\t\t\t\t\t\t\t\t<span></span>\n" +
									"\t\t\t\t\t\t\t\t<input type=\"radio\""+((data.choose_5 in data.true_array)?"checked":'')+"/>\n" +
									"\t\t\t\t\t\t\t</div>\n" +
									"\t\t\t\t\t\t\t<div class=\"labelri\">\n" +
									"\t\t\t\t\t\t\t\tE."+data.choose_5+
									"\t\t\t\t\t\t\t</div>\n" +
									"\t\t\t\t\t\t</label>\n" ;
                        	}
                        if(data.choose_6){
                            str+="\t\t\t\t\t\t<label>\n" +
                                "\t\t\t\t\t\t\t<div class=\"labelle "+((data.choose_6 in data.true_array)?"on":'')+"\">\n" +
                                "\t\t\t\t\t\t\t\t<span></span>\n" +
                                "\t\t\t\t\t\t\t\t<input type=\"radio\""+((data.choose_6 in data.true_array)?"checked":'')+"/>\n" +
                                "\t\t\t\t\t\t\t</div>\n" +
                                "\t\t\t\t\t\t\t<div class=\"labelri\">\n" +
                                "\t\t\t\t\t\t\t\tF."+data.choose_6+
                                "\t\t\t\t\t\t\t</div>\n" +
                                "\t\t\t\t\t\t</label>\n" ;
                        }
                        if(data.choose_7){
                            str+="\t\t\t\t\t\t<label>\n" +
                                "\t\t\t\t\t\t\t<div class=\"labelle "+((data.choose_7 in data.true_array)?"on":'')+"\">\n" +
                                "\t\t\t\t\t\t\t\t<span></span>\n" +
                                "\t\t\t\t\t\t\t\t<input type=\"radio\""+((data.choose_7 in data.true_array)?"checked":'')+"/>\n" +
                                "\t\t\t\t\t\t\t</div>\n" +
                                "\t\t\t\t\t\t\t<div class=\"labelri\">\n" +
                                "\t\t\t\t\t\t\t\tG."+data.choose_7+
                                "\t\t\t\t\t\t\t</div>\n" +
                                "\t\t\t\t\t\t</label>\n" ;
                        }
                        str+="\t\t\t\t\t</dd>\n" +"\t\t\t\t</dl>";
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
                            @if($type??0==2)
                           		 var url='/user/errorExam/2';
                            @else
                            	var url='/user/errorExam';
                            @endif
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