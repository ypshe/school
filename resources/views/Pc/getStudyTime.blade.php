@extends('layout')
@section('content')
		<!--主体部分-->
		<div class="main">
			<!--面包屑导航-->
			<div class="mianbao">
				<a href="">首页</a>
				<span>></span>
				<a href="">学时验证</a>
			</div>
			<!--面包屑导航-->
			<!--学时验证-->
			<div class="jingpinke xueshi">
				<div class="title">
					<h2>学时验证</h2>
					<span>输入相关信息进行查询</span>
				</div>
				<div class="chaxun">
					<form>
						<span>身份证号：</span>
						<input class="shuru" type="text" name="name" value="{{$cardId}}"/>
						<span class="jieguo"></span>
						<input type="button" class="btn cx" value="立即查询" />
					</form>
				</div>
				@if(isset($time)&&$time)
				<div class="chaxliebiao">
					<table>
						<thead>
							<td style="text-align: center;padding-left: 0;">NO</td>
							<td>最后学习时间</td>
							<td>姓名</td>
							<td class="neirong" width="496">学习内容</td>
							<td>学时</td>
							<td>已有学时</td>
							<td>结果</td>
						</thead>
						<tbody>
						@foreach($time as $k=> $v)
							<tr>
								<td style="text-align: center;padding-left: 0;">{{$k+1}}</td>
								<td>{{$v->addTime}}</td>
								<td>{{$user->name}}</td>
								<td width="496">{{\App\Admin\Model\Profession::find($v->pid)->name}}
									@if($user->id==\Illuminate\Support\Facades\Auth::id())
										<a style="text-decoration:underline;display:inline;" class="seeDesc" pid="{{$v->pid}}" href="#">查看详情</a>
									@endif
								</td>
								<td>{{$v->allTime}}</td>
								<td>{{$v->time}}</td>
								<td>@if($v->allTime<=$v->time)<color style="color:green">通过</color>@else<color style="color:red">未通过</color>@endif</td>
							</tr>
						@endforeach
						</tbody>
						@if($user->id==\Illuminate\Support\Facades\Auth::id())
							<script>
								$('.seeDesc').click(function(){
								    var pid=$(this).attr('pid');
								    $.ajax({
										url:'/ajax/time'+'/'+pid+'/'+'{{$cardId}}',
										type:'get',
										dataType:'json',
										success:function(data){console.log(data);
										    var str='<div class="chaxliebiao" style="width:600px"><table><thead>' +
                                                '<td >课程</td>' +
                                                '<td>章节</td>' +
                                                '<td>获得学时</td>' +
                                                '<td>时间</td></thead><tbody>';
                                            $.each(data,function(key,value){
                                                str+='<tr>' +
                                                '<td>'+value.sname+'</td>'+
                                                '<td>'+(value.section+1)+'-'+value.vsort+'</td>'+
                                                '<td>'+value.study_time+'</td>'+
                                                '<td>'+value.join_time+'</td>'+
                                                '</tr>';
											});
                                            str+='</tbody></table></div>';
                                            layer.open({
                                                type: 1,
                                                skin: 'layui-layer-demo', //样式类名
                                                closeBtn: 0, //不显示关闭按钮
                                                anim: 2,
                                                area: ['700px', '500px'],
                                                shadeClose: true, //开启遮罩关闭
                                                content:str
                                            });
										}
									});
								});
							</script>
						@endif
					</table>
				</div>
				@elseif(isset($error))
					<div class="chaxliebiao">
						<div style="text-align: center;font-size: 20px"> <color style="color:red">X</color> {{$error}}</div>
					</div>
				@endif
			</div>
			<!--学时验证-->
			<?php echo isset($time)&&$time ? $time->render() : '';?>
		</div>
		<!--主体部分-->
		<script>
			$("[name='name']").blur(function() {
				var v = $(this).val();
				if (v == '') {
					$("[name='name']").next("span").html("身份证号不能为空！");
				}else{
					$("[name='name']").next("span").html("");
				} 
			});
			$(".cx").click(function(){
				var name=$("[name='name']").val();
				if (name=="") {
					$("[name='name']").next("span").html("身份证号不能为空！");
					return;
				}else{
				    location.href="{{url('/time')}}"+'/'+$("[name='name']").val();
				}
			});
		</script>
	@endsection