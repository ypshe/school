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
						<h2>资料下载</h2>
						<div class="chaxliebiao cuotict dayin">
							<table>
								<thead>
									<td style="text-align: center;padding-left: 0;width:70px;">NO</td>
									<td width="700">资料名称</td>
									<td style="text-align: center;padding-left: 0;">操作</td>
								</thead>
								<tbody>
								@if($file)
									@foreach($file as $k=>$v)
										<tr id="01">
											<td style="text-align: center;padding-left: 0;">{{$k+1}}</td>
											<td width="450" class="biaoti">{{$v->filename}}@if($v->is_admin==0)(您于{{$v->updated_at}}上传)@endif</td>
											<td style="text-align: center;padding-left: 0;"><a href="{{url('/user/download/'.$v->path)}}">下载</a></td>
										</tr>
									@endforeach
								@endif
								</tbody>
							</table>
                            <?php echo $file->render(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--主体部分-->
		<script>
			$("#sousuo").click(function(){
				var value = $(this).prev().prev(".shuru").val();
				console.log(value);
				if(value == ""){
					$(this).prev(".jieguo").text("请填写标题后查询");
					return false;
				}else{
					$(this).prev(".jieguo").text("");
				}
			});
			$("#liuyantijiao").click(function(){
				var liuyan = $(this).parent().prev("textarea").text();
				if(liuyan == ""){
					alert("请填写留言内容");
				}
			});
			$("#woyaoliuyan").click(function(){
				$("#liuyan").show();
				$(".zhe").show();
			});
			function chakanliuyan(value){
				$("#chakan").show();
				$(".zhe").show();
			}
		</script>
	@endsection