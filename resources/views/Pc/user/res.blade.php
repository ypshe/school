@extends('layout')
@section('content')
		<!--导航部分-->
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
						<h2>考核情况</h2>
						<div class="shuoming">
							温馨提示：考核情况为您显示当前课程学习达标情况，考试成绩60分为达标。
						</div>
						<div class="chaxliebiao cuotict dayin kaohe">
							<table>
								<thead>
									<td width="370">试题名称</td>
									<td style="text-align: center;">考核标准值</td>
									<td style="text-align: center;">考核当前值</td>
									<td style="text-align: center;">是否已达标</td>
								</thead>
								<tbody>
								@if($pro)
									@foreach($pro as $k=>$v)
										<tr>
											<td width="370" class="biaoti">{{$v->pname}}</td>
											<td style="text-align: center;">60分</td>
											<td style="text-align: center;">{{$v->value}}分</td>
											<td style="text-align: center;"><img src="/Pc/img/@if($v->value>=60)yidabiao.png @else weidabiao.png @endif"></td>
										</tr>
									@endforeach
								@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection