@extends('layout')
@section('content')
		<!--主体部分-->
		<div class="main">
			<!--面包屑导航-->
			<div class="mianbao">
				<a href="{{url('/')}}">首页</a>
				<span>></span>
				<a href="{{url('/study')}}">培训课程</a>
			</div>
			<!--面包屑导航-->
			<!--课程列表-->
			<div class="jingpinke kechenglist">
				<div class="title">
					<h2>专业：</h2>
					<div class="titletab">
						@foreach($data['pro'] as $k=>$v)
							<a @if(isset($pid)&&$pid==$v->id) style="color:red" @endif href="{{url('/study/'.$v->id)}}">
								{{$v->name}}
							</a>
						@endforeach
					</div>
				</div>
			</div>
			<div class="protext protextli">
				@foreach($data['studies'] as $v)
					<dl>
						<a href="{{url('/studyDesc/'.$v->id)}}">
							<dt>
								<img src="{{img_local($v->pic)}}">
							</dt>
							<dd>
								<h4 title="{{$v->name}}">{{$v->name}}</h4>
								<span>讲师：{{$v->tname}}</span>
								<span>职务：{{$v->twork}}</span>
							</dd>
						</a>
					</dl>
				@endforeach
			</div>
        <?php echo $data['studies']->render(); ?>
		</div>
		<!--主体部分-->
@endsection