<!DOCTYPE html>
<html class="bgbai">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<title>个人资料</title>
		<link rel="stylesheet" href="/mobile/iconfont/iconfont.css" />
		<link rel="stylesheet" href="/mobile/css/base.css" />
		<link rel="stylesheet" href="/mobile/css/LArea.css" />
	</head>
	<body class="bgbai">
		<!--头部-->
		<div class="header bglan overflow textcenter wbai">
			<a class="fl textcenter" href="javascript:history.go(-1);">
				<i class="iconfont icon-zuojiantou bai h1 b">
					
				</i>
			</a> 
			<h3 class="sanwu bai textcenter">个人资料</h3>
		</div>
		<!--头部-->
		<!--设置-->
		<article>
			<div class="shezhi">
				<dl>
					<a class="overflow" id="touxiang" href="javascript:;">
						<dt class="fl h1 san">头像</dt>
						<dd class="fr h1 san b" id="zwb_upload">
							<i class="iconfont icon-youjiantou h1 fr"></i>
							<span class="fr" style="margin-top:1.2vw">
								<label>
									<form action="" id="headForm">
										<img id="touxiangbox" style="width:8vw;height:8vw;border-radius: 100%;float: right;" src="@if($user->pic){{img_local($user->pic)}}@elseif($user->wx_pic){{$user->wx_pic}}@else /Pc/img/touxiang.png @endif">
										<input type="file" name="file" id="file" class="file" value="" accept="image/jpg,image/jpeg,image/png,image/bmp" style="width:0px;height:0px" multiple />
									</form>
								</label>
							</span>
						</dd>
					</a>
				</dl>
				<dl>
					<a id="xiugaixingming" class="overflow" href="javascript:;">
						<dt class="fl h1 san">姓名</dt>
						<dd class="fr h1 san b">
							<i class="iconfont icon-youjiantou h1 fr"></i>
							<span class="fr jiu" style="font-weight: 400;">
								{{$user->name}}
							</span>
						</dd>
					</a>
				</dl>
				<dl>
					<a id="xiugaixingbie" class="overflow" href="javascript:;">
						<dt class="fl h1 san">性别</dt>
						<dd class="fr h1 san b">
							<i class="iconfont icon-youjiantou h1 fr"></i>
							<span class="fr jiu" style="font-weight: 400;">
								{{$user->sex}}
							</span>
						</dd>
					</a>
				</dl>
				<dl>
					<a id="xiugaiminzu" class="overflow" href="javascript:;">
						<dt class="fl h1 san">民族</dt>
						<dd class="fr h1 san b">
							<i class="iconfont icon-youjiantou h1 fr"></i>
							<span class="fr jiu" style="font-weight: 400;">
								{{$user->nationality}}
							</span>
						</dd>
					</a>
				</dl>
				<dl>
					<a id="xiugaizhengzhi" class="overflow" href="javascript:;">
						<dt class="fl h1 san">政治面貌</dt>
						<dd class="fr h1 san b">
							<i class="iconfont icon-youjiantou h1 fr"></i>
							<span class="fr jiu" style="font-weight: 400;">
								{{$user->political}}
							</span>
						</dd>
					</a>
				</dl>
				<dl>
					<a class="overflow" href="javascript:;">
						<dt class="fl h1 san">身份证号</dt>
						<dd class="fr h1 san b">
							<i class="iconfont icon-youjiantou h1 fr" style="opacity: 0;"></i>
							<span class="fr jiu" style="font-weight: 400;">
								{{$user->cardId}}
							</span>
						</dd>
					</a>
				</dl>
				<dl>
					<a id="xiugaishoujihao" class="overflow" href="javascript:;">
						<dt class="fl h1 san">手机号</dt>
						<dd class="fr h1 san b">
							<i class="iconfont icon-youjiantou h1 fr"></i>
							<span class="fr jiu" style="font-weight: 400;">
								{{$user->phone}}
							</span>
						</dd>
					</a>
				</dl>
				<dl>
					<a id="xiugaiyouxiang" class="overflow" href="javascript:;">
						<dt class="fl h1 san">邮箱</dt>
						<dd class="fr h1 san b">
							<i class="iconfont icon-youjiantou h1 fr"></i>
							<span class="fr jiu" style="font-weight: 400;">
								{{$user->email}}
							</span>
						</dd>
					</a>
				</dl>
				<dl>
					<form action="" id="addrForm">
					<a class="overflow" href="javascript:;">
						<dt class="fl h1 san">地区</dt>
						<dd class="fr h1 san b">
							{{--<i class="iconfont icon-youjiantou h1 fr"></i>--}}
							<span class="fr jiu" id="dizhi" style="font-weight: 400; #color:#00ccff">
								<input class="wbai h1 jiu" style="text-align: right;" id="demo1" value="@if($user->home_p&&$user->home_c&&$user->home_a){{implode(',',[\App\Admin\Model\Addr::find($user->home_p)->name,\App\Admin\Model\Addr::find($user->home_c)->name,\App\Admin\Model\Addr::find($user->home_a)->name])}}@else待完善 @endif" />
							</span>
						</dd>
					</a>
					<input id="value1" type="hidden" value="20,234,504"/>
					</form>
				</dl>
			</div>
		</article>
		<script type="text/javascript" src="/mobile/js/jquery-1.8.2.js"></script>
		<script type="text/javascript" src="/mobile/js/layer_mobile/layer.js"></script>
		<script type="text/javascript" src="/mobile/js/lazyload.js"></script>
		<script type="text/javascript" src="/mobile/js/LAreaData1.js"></script>
		<script type="text/javascript" src="/mobile/js/LAreaData2.js"></script>
		<script type="text/javascript" src="/mobile/js/LArea.js"></script>
		<script type="text/javascript" src="/mobile/js/upload.min.js"></script>
		<script>
			$('#dizhi').click(function(){
			    layer.open({
					content:'请登录电脑端修改地址数据！'
				});
			});
		</script>
		<!--设置-->
		<script>
			$('#file').change(function(){
                var data = new FormData();
                data.append('pic', $('#file')[0].files[0]);
                $.ajax({
                    url: '/ajax/wap/user/changPic',
                    type: 'POST',
                    data: data,
                    cache: false,
                    processData: false,
                    contentType: false,
					dataType:'json',
					success:function(res){
                        if(res.error===0){
                            layer.open({
                                content: '修改头像成功！'
                            });
						}else{
                            layer.open({
                                content: res.msg
                            });
						}
					}
				});
			});
			function changeData(field,value){
                var data = {field:field,value:value};
                $.ajax({
                    url: '/ajax/wap/user/changData',
                    type: 'POST',
                    data: data,
                    dataType:'json',
                    success:function(res){
                        if(res.error===0){
                            layer.open({
                                content: res.msg
                            });
                        }else{
                            layer.open({
                                content: res.msg
                            });
                        }
                    }
                });
			}
		    // 修改姓名
		    var xingming = '<div class="tanchuceng" id="xingming" style="min-height: 43.2vw;background: #f4f4f4;padding-top: 1vw;padding-bottom:2.6vw;">'+
				'<h2 class="san h1 textcenter top20">请输入姓名</h2>'+
				'<textarea id="textinput" type="text" class="h1 jiu bgbai"></textarea>'+
				'<div class="annius overflow" style="padding-top: 1vw;">'+
					'<a class="fl anniu textcenter bai h2" style="background: #c9c9c9 !important;margin-top: 0;" id="quxiaoxingming" href="javascript:;">取消</a>'+
					'<a class="fr anniu textcenter bai h2" id="quedingxingming" style="margin-top: 0;" href="javascript:;">确定</a>'+
				'</div>'+
			'</div>';
			 $("#xiugaixingming").click(function(){
		    	layer.open({
			       content: xingming,
			       skin: 'footer',
			    });
			    $("#quedingxingming").click(function(){
			     	var value2 = $("#textinput").val();
				    if(value2 == ""){
				    	alert("请输入姓名");
					    return false;
				    }else{
				    	$("#xingming").parents(".layui-m-layer").hide();
				    	$("#xiugaixingming span").text(value2);
				    	$("#textinput").text(value2);
				    	changeData('name',value2);
				    };
			    });
			    $("#quxiaoxingming").click(function(){
			    	$("#textinput").parents(".layui-m-layer").hide();
			    });
		    })
		    //修改性别
		    var xingbie = '<div class="tanchuceng" id="xingbie" style="min-height: 43.2vw;background: #f4f4f4;padding-top: 1vw;padding-bottom:2.6vw;">'+
			'<h2 class="san h1 textcenter top20">性别</h2>'+
			'<div class="bgbai top20" style="width:94%;margin:auto;margin-top:2.6vw">'+
				'<a class="overflow sex" style="border-bottom: 1px solid #eeeeee;" href="javascript:;">'+
					'<span class="fl liu h1">男</span>'+
					'<i class="fr"></i>'+
				'</a>'+
				'<a class="overflow sex" href="javascript:;">'+
					'<span class="fl liu h1">女</span>'+
					'<i class="fr"></i>'+
				'</a>'+
			'</div>'+
			'<div class="annius overflow" style="padding-top: 1vw;margin-top:2.6vw">'+
				'<a id="xingbiequeding" class="anniu textcenter bai h2" style="margin-top: 0;" href="javascript:;">确定</a>'+
			'</div>'+
		'</div>';
		    $("#xiugaixingbie").click(function(){
		     	layer.open({
			       content: xingbie,
			       skin: 'footer',
			    });
			    $("#xingbie .bgbai a").click(function(){
			    	$(this).addClass("on").siblings().removeClass("on");
			    });
			    $("#xingbiequeding").click(function(){
			    	$("#xingbie .bgbai a").each(function(){
			    		if($(this).hasClass("on")){
			    			var on = $(this).children("span").text();
			    			$("#xiugaixingbie span").text(on);
			    			$("#xingbie").parents(".layui-m-layer").hide();
                            changeData('sex',$("#xiugaixingbie span").text());
			    		}
			    	})
                })
		     });
		    //修改性别
            // 修改民族
            var minzu = '<div class="tanchuceng" id="minzu" style="min-height: 43.2vw;background: #f4f4f4;padding-top: 1vw;padding-bottom:2.6vw;">'+
                '<h2 class="san h1 textcenter top20">请输入民族</h2>'+
                '<textarea id="textinput" type="text" class="h1 jiu bgbai"></textarea>'+
                '<div class="annius overflow" style="padding-top: 1vw;">'+
                '<a class="fl anniu textcenter bai h2" style="background: #c9c9c9 !important;margin-top: 0;" id="quxiaominzu" href="javascript:;">取消</a>'+
                '<a class="fr anniu textcenter bai h2" id="quedingminzu" style="margin-top: 0;" href="javascript:;">确定</a>'+
                '</div>'+
                '</div>';
            $("#xiugaiminzu").click(function(){
                layer.open({
                    content: minzu,
                    skin: 'footer',
                });
                $("#quedingminzu").click(function(){
                    var value2 = $("#textinput").val();
                    if(value2 == ""){
                        alert("请输入民族");
                        return false;
                    }else{
                        $("#minzu").parents(".layui-m-layer").hide();
                        $("#xiugaiminzu span").text(value2);
                        $("#textinput").text(value2);
                        changeData('nationality',value2);
                    };
                });
                $("#quxiaominzu").click(function(){
                    $("#textinput").parents(".layui-m-layer").hide();
                });
            })
		    //修改政治面貌
		    var zhengzhimianmao = '<div class="tanchuceng" id="zhengzhi" style="min-height: 43.2vw;background: #f4f4f4;padding-top: 1vw;padding-bottom:2.6vw;">'+
			'<h2 class="san h1 textcenter top20">政治面貌</h2>'+
			'<div class="bgbai top20" style="width:94%;margin:auto;margin-top:2.6vw">'+
				'<a class="overflow sex" style="border-bottom: 1px solid #eeeeee;" href="javascript:;">'+
					'<span class="fl liu h1">党员</span>'+
					'<i class="fr"></i>'+
				'</a>'+
				'<a class="overflow sex" href="javascript:;">'+
					'<span class="fl liu h1">群众</span>'+
					'<i class="fr"></i>'+
				'</a>'+
			'</div>'+
			'<div class="annius overflow" style="padding-top: 1vw;margin-top:2.6vw">'+
				'<a id="zhengzhiqueding" class="anniu textcenter bai h2" style="margin-top: 0;" href="javascript:;">确定</a>'+
			'</div>'+
		'</div>';
			$("#xiugaizhengzhi").click(function(){
		     	layer.open({
			       content: zhengzhimianmao,
			       skin: 'footer',
			    });
			    $("#zhengzhi .bgbai a").click(function(){
			    	$(this).addClass("on").siblings().removeClass("on");
			    });
			    $("#zhengzhiqueding").click(function(){
			    	$("#zhengzhi .bgbai a").each(function(){
			    		if($(this).hasClass("on")){
			    			var on = $(this).children("span").text();
			    			$("#xiugaizhengzhi span").text(on);
			    			$("#zhengzhi").parents(".layui-m-layer").hide();
                            changeData('political',$("#xiugaizhengzhi span").text());
                        }
			    	})
			    })
		     });
		    //修改政治面貌

		    // 修改手机号
		    var shoujihaoo = '<div class="tanchuceng" id="shoujihaoss" style="min-height: 43.2vw;background: #f4f4f4;padding-top: 1vw;padding-bottom:2.6vw;">'+
				'<h2 class="san h1 textcenter top20">请输入手机号</h2>'+
				'<textarea id="shoujihaos" type="text" class="h1 jiu bgbai"></textarea>'+
				'<div class="annius overflow" style="padding-top: 1vw;">'+
					'<a class="fl anniu textcenter bai h2" style="background: #c9c9c9 !important;margin-top: 0;" id="quxiaoshoujihao" href="javascript:;">取消</a>'+
					'<a class="fr anniu textcenter bai h2" id="quedingshoujihao" style="margin-top: 0;" href="javascript:;">确定</a>'+
				'</div>'+
			'</div>';
			 $("#xiugaishoujihao").click(function(){
		    	layer.open({
			       content: shoujihaoo,
			       skin: 'footer',
			    });
			    var yansj = /^[1][3,4,5,7,8][0-9]{9}$/;//验证手机号
			    $("#quedingshoujihao").click(function(){
			     	var value2 = $("#shoujihaos").val();
				    if(value2 == ""){
				    	layer.open({content:"请输入手机号"});
					    return false;
				    }else if(!yansj.test(value2)){
                        layer.open({content:"手机号不符合规范"});
				    	return false;
				    }else if(value2 != "" && yansj.test(value2)){
				    	$("#shoujihaoss").parents(".layui-m-layer").hide();
				    	$("#xiugaishoujihao span").text(value2);
				    	$("#shoujihaos").text(value2);
                        changeData('phone',value2);
				    }
			    }); 
			    $("#quxiaoshoujihao").click(function(){
			    	$("#shoujihaoss").parents(".layui-m-layer").hide();
			    }); 
		    })
		    //修改手机号
		    //修改邮箱
		    var youxiang = '<div class="tanchuceng" id="youxiang" style="min-height: 43.2vw;background: #f4f4f4;padding-top: 1vw;padding-bottom:2.6vw;">'+
				'<h2 class="san h1 textcenter top20">请输入邮箱</h2>'+
				'<textarea id="youxiangs" type="text" class="h1 jiu bgbai"></textarea>'+
				'<div class="annius overflow" style="padding-top: 1vw;">'+
					'<a class="fl anniu textcenter bai h2" style="background: #c9c9c9 !important;margin-top: 0;" id="quxiaoyouxiang" href="javascript:;">取消</a>'+
					'<a class="fr anniu textcenter bai h2" id="quedingyouxiang" style="margin-top: 0;" href="javascript:;">确定</a>'+
				'</div>'+
			'</div>';
			 $("#xiugaiyouxiang").click(function(){
		    	layer.open({
			       content: youxiang,
			       skin: 'footer'
			    });
			    var reg = /^([a-zA-Z0-9._-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;//验证邮箱
			    $("#quedingyouxiang").click(function(){
			     	var value2 = $("#youxiangs").val();
				    if(value2 === ""){
                        layer.open({content:"请输入邮箱"});
					    return false;
				    }else if(!reg.test(value2)){
                        layer.open({content:"邮箱不符合规范"});
				    	return false;
				    }else if(value2 !== "" && reg.test(value2)){
				    	$("#youxiang").parents(".layui-m-layer").hide();
				    	$("#xiugaiyouxiang span").text(value2);
				    	$("#youxiangs").text(value2);
                        changeData('email',value2);
                    }
			    }); 
			    $("#quxiaoyouxiang").click(function(){
			    	$("#youxiang").parents(".layui-m-layer").hide();
			    });
		    });
		    //修改邮箱
//		    var area1 = new LArea();
//		    area1.init({
//		        'trigger': '#demo1', //触发选择控件的文本框，同时选择完毕后name属性输出到该位置
//		        'valueTo': '#value1', //选择完毕后id属性输出到该位置
//		        'keys': {
//		            id: 'id',
//		            name: 'name'
//		        }, //绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
//		        'type': 1, //数据源类型
//		        'data': LAreaData, //数据源,
//				'valueType':'name'
//		    });
//		    area1.value=[1,13,3];//控制初始位置，注意：该方法并不会影响到input的value
		    //修改地区
		</script>
	</body>

</html>