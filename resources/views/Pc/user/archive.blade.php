@extends('layout')
@section('content')
		<!--导航部分-->
		<!--打印证书-->
		<div class="dayintan">
			<img src="/Pc/img/zhengshu.jpg">
			<div class="btndd">
				<input type="button" value="打印证书" />
				<a href="javascript:;">取消打印</a>
			</div>
		</div>
		<div class="zhe"></div>
		<!--打印证书-->
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
					@include('user_public')
					<div class="gerenbori" style="min-height: 847px;">
						<h2>教育档案</h2>
						<div class="chaxun cuotic">
							<form>
								<span>试题名称：</span>
								<input class="shuru" type="text" value="{{$search}}" name="name">
								<span class="jieguo"></span>
								{{--<span style="margin-left: 12px;">是否达标：</span>--}}
								{{--<select class="selectss" style="width:112px;margin-left:12px;height:40px;border: 1px solid #dcdcdc;">--}}
									{{--<option>已达标</option>--}}
									{{--<option>未达标</option>--}}
								{{--</select>--}}
								<input type="button" class="btn cx" value="立即查询">
							</form>
						</div>
						<div class="chaxliebiao cuotict dayin">
							<table>
								<thead>
									<td style="text-align: center;padding-left: 0;width:70px;">NO</td>
									<td width="370">培训名称</td>
									<td style="text-align: center;">分数</td>
									<td style="text-align: center;">是否达标</td>
									<td style="text-align: center;">达标时间</td>
									<td style="text-align: center;">操作</td>
								</thead>
								<tbody>
								@foreach($pro as $k=>$v)
									<tr id="01">
										<td style="text-align: center;padding-left: 0;">1</td>
										<td width="370" class="biaoti">{{$v->pname}}</td>
										<td style="text-align: center;">{{$v->value}}</td>
										<td style="text-align: center;">是</td>
										<td style="text-align: center;">{{$v->time}}</td>
										<td style="text-align: center;">
											<a href="javascript:;" onclick="dayin('01')">打印证书</a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
                            <?php echo $pro->render(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--主体部分-->
		<script>
			$(".btn").click(function(){
				var value = $("input[name='name']").val();
				location.href='{{url('/user/archive')}}'+'/'+value;
			});
			function dayin(value){
				$(".dayintan").show();
			}
			$(".dayintan .btndd a").click(function(){
				$(".dayintan").hide();
			})
		</script>
	@endsection