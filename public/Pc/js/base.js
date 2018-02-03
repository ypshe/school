$(function(){
	//菜单
	$(".allmenu").mouseover(function(){
		$(".all").css("display","block");
	});
	$(".allmenu").mouseout(function(){
		$(".all").css("display","none");
	});
	$(".indexs .allmenu").mouseover(function(){
		$(".all").css("display","block");
	});
	$(".indexs .allmenu").mouseout(function(){
		$(".all").css("display","block");
	});
    $(".all dl").mouseover(function(){
    	$(this).addClass("on");
		$(this).children(".allRight").css("display","block");
    });
    $(".all dl").mouseout(function(){
    	$(this).removeClass("on");
		$(this).children(".allRight").css("display","none");
    })
	//banner轮播效果
	jQuery(".banner").slide({mainCell:".bd ul",effect:"fold",autoPlay:true,trigger:"click"});
	//已登录状态下鼠标滑过效果
	$(".other dl").mouseover(function(){
		$(this).addClass("on");
	});
	$(".other dl").mouseout(function(){
		$(this).removeClass("on");
	});
	//精品课程
	$(".titletab a").mouseover(function(){
		$(this).addClass("on");
	});
	$(".titletab a").mouseout(function(){
		$(this).removeClass("on");
	});
	//通知公告
	$(".new dl").mouseover(function(){
		$(this).addClass("on");
	});
	$(".new dl").mouseout(function(){
		$(this).removeClass("on");
	});
	//培训指南
	$(".peixunb a").mouseover(function(){
		$(this).addClass("on");
	});
	$(".peixunb a").mouseout(function(){
		$(this).removeClass("on");
	});
	//名单滚动
	jQuery(".mingdanbbo").slide({mainCell:".bd ul",effect:"top",autoPlay:true,vis:5});
	$(".mululist").mouseover(function(){
		$(this).addClass("on");
	});
	$(".mululist").mouseout(function(){
		$(this).removeClass("on");
	});
	$(".mulubox dl dt").click(function(){
		$(this).next("dd").toggle();
	});
	$(".section-list li a").mouseover(function(){
		$(this).addClass("on");
	});
	$(".section-list li a").mouseout(function(){
		$(this).removeClass("on");
	});
	$(".choosetext dl dd a").mouseover(function(){
		$(this).addClass("on");
	});
	$(".choosetext dl dd a").mouseout(function(){
		$(this).removeClass("on");
	});
	$(".choosetext dl dt").click(function(){
		$(this).next("dd").toggle();
	})
	$(".choosetext dl dd a").click(function(){
		var value = $(this).text();
		$(this).parent("dd").prev("dt").text(value);
		$(this).parent("dd").hide();
	});
	var width = $(window).width();
	var height = $(window).height();
	$(".videobox").css("width",width);
	$(".videobox").css("height",height);
	$(".section-list").css("height",height-92);	
	var width2 = $(".section-list").width();
	$(".video").css("width",width-width2);
	$(".video").css("height",height-90);
	$(".wentib ul li").click(function(){
		$(this).addClass("on");
		$(this).siblings().removeClass("on");
		$(this).find("input").attr("checked","checked");
		$(this).siblings().find("input").attr("checked","")
	});
	$(".tongzhi dl").mouseover(function(){
		$(this).addClass("on");
	});
	$(".tongzhi dl").mouseout(function(){
		$(this).removeClass("on");
	});
	//登录、注册
//	<!--注册-->
    var zhuce = '<div class="zhuce" id="zhuce">'+
			'<div class="guanbi">'+
				'<img src="Pc/img/guanbi.png">'+
			'</div>'+
			'<div class="ztop">'+
				'注册'+
			'</div>'+
			'<form>'+
				'<div class="zmo">'+
					'<dl>'+
						'<dt>'+
							'<input type="text" placeholder="请输入身份证号码" class="sfz" name="sfz" />'+
							'<span class="jieguo"></span>'+
						'</dt>'+
					'</dl>'+
					'<dl style="position:relative;">'+
						'<dt class="y">'+
							'<input class="yan" type="text" placeholder="验证码" name="yan" />'+
						'</dt>'+
						'<span class="jieguo" style="position:absolute;right:0;top:52px;color:red"></span>'+
						'<dd>'+
							'<img src="Pc/img/yanzhengma.jpg">'+
						'</dd>'+
					'</dl>'+
					'<dl>'+
						'<dt>'+
							'<input type="password" class="mima mima01" placeholder="设置密码(以字母开头，6-18字符，字符、数字和下划线)" name="mima" />'+
							'<span class="jieguo"></span>'+
						'</dt>'+
					'</dl>'+
					'<dl>'+
						'<dt>'+
							'<input type="password" class="mima mima02" placeholder="设置密码" name="mima" />'+
							'<span class="jieguo"></span>'+
						'</dt>'+
					'</dl>'+
				'</div>'+
				'<div class="btn" id="zhucebtn">'+
					'<input type="button" value="注册"/>'+
				'</div>'+
			'</form>'+
		'</div>';
		var denglu = '<div class="zhuce denglu" id="denglu">'+
			'<div class="guanbi">'+
				'<img src="Pc/img/guanbi.png">'+
			'</div>'+
			'<div class="ztop">'+
				'登录'+
			'</div>'+
			'<form>'+
				'<div class="zmo">'+
					'<dl>'+
						'<dt>'+
							'<input type="text" class="sfz" placeholder="请输入身份证号码" name="sfz" />'+
							'<span class="jieguo"></span>'+
						'</dt>'+
					'</dl>'+
					'<dl>'+
						'<dt>'+
							'<input type="password" class="mima mima01" placeholder="密码" name="mima" />'+
							'<span class="jieguo"></span>'+
						'</dt>'+
					'</dl>'+
				'</div>'+
				'<div class="btn" id="denglubtn">'+
					'<input type="button" value="登录"/>'+
				'</div>'+
				'<div class="wj">'+
					'<a href="">忘记密码?</a>'+
					'<a class="go" href="javascript:;">去注册</a>'+
				'</div>'+
			'</form>'+
		'</div>';
		var zhe = '<div class="zhe"></div>';
		$("body").append(zhuce);
		$("body").append(denglu);
		$("body").append(zhe);
		$(".zc").click(function(){
			$("#zhuce").show();
			$(".zhe").show();
		});
		$(".dl").click(function(){
			$("#denglu").show();
			$(".zhe").show();
		});
		$(".guanbi").click(function(){
			$(this).parent(".zhuce").hide();
			$(".zhe").hide();
		});
		$(".go").click(function(){
			$(this).parents(".zhuce").hide();
			$("#zhuce").show();
		});
		var s = /^\d{15}|\d{}18$/;//验证身份证
		var ms = /^[a-zA-Z]\w{5,17}$/;//验证密码
		console.log(s);
		$("[name='sfz']").blur(function() {
			var v = $(this).val();
			console.log(v);
			if (v == '') {
				$(this).next("span").html("身份证不能为空！");
			}else if(!v.match(s)){
				$(this).next("span").html("身份证不合法！");
			}else{
				$(this).next("span").html("");
			} 
		});
		$("[name='mima']").blur(function(){
			var v = $(this).val();
			console.log(v);
			if (v == '') {
				$(this).next("span").html("密码不能为空！");
			}else if(!v.match(ms)){
				$(this).next("span").html("密码不合法！");
			}else{
				$(this).next("span").html("");
			} 
		});
		//	点击注册按钮
		$("#zhucebtn").click(function(){
			var sfz = $(this).prev(".zmo").find(".sfz").val();
			var mima01 = $(this).prev(".zmo").find(".mima01").val();
			var mima02 = $(this).prev(".zmo").find(".mima02").val();
			var yan = $(this).prev(".zmo").find(".yan").val();
			if(sfz == ""){
				$(this).prev(".zmo").find(".sfz").next("span").html("身份证号不能为空");
			}else if(!sfz.match(s)){
				$(this).prev(".zmo").find(".sfz").next("span").html("身份证号不合法");
			}else{
				$(this).prev(".zmo").find(".sfz").next("span").html("");
			};
			if(mima01 == ""){
				$(this).prev(".zmo").find(".mima01").next("span").html("密码不能为空");
			}else if(!mima01.match(ms)){
				$(this).prev(".zmo").find(".mima01").next("span").html("密码不合法");
			}else{
				$(this).prev(".zmo").find(".mima01").next("span").html("");
			};
			if(mima02 == ""){
				$(this).prev(".zmo").find(".mima02").next("span").html("密码不能为空");
			}else if(!mima02.match(ms)){
				$(this).prev(".zmo").find(".mima02").next("span").html("密码不合法");
			}else{
				$(this).prev(".zmo").find(".mima02").next("span").html("");
			};
			if(mima01 != mima02){
				$(this).prev(".zmo").find(".mima02").next("span").html("密码不一样");
			}else{
				$(this).prev(".zmo").find(".mima02").next("span").html("");
			};
			if(yan == ""){
				$(this).prev(".zmo").find(".yan").parent("dt").next("span").html("验证码不能为空");
			}else{
				$(this).prev(".zmo").find(".yan").next("span").html("");
			};
		});
		//点击登录按钮
		$("#denglubtn").click(function(){
			var sfz = $(this).prev(".zmo").find(".sfz").val();
			var mima01 = $(this).prev(".zmo").find(".mima01").val();
			if(sfz == ""){
				$(this).prev(".zmo").find(".sfz").next("span").html("身份证号不能为空");
			}else if(!sfz.match(s)){
				$(this).prev(".zmo").find(".sfz").next("span").html("身份证号不合法");
			}else{
				$(this).prev(".zmo").find(".sfz").next("span").html("");
			};
			if(mima01 == ""){
				$(this).prev(".zmo").find(".mima01").next("span").html("密码不能为空");
			}else if(!mima01.match(ms)){
				$(this).prev(".zmo").find(".mima01").next("span").html("密码不合法");
			}else{
				$(this).prev(".zmo").find(".mima01").next("span").html("");
			};
		});
		$(".jizhu").click(function(){
			$("#zhuce").show();
			$(".zhe").show();
		})
});
$(window).resize(function(){
	var width = $(window).width();
	var height = $(window).height();
	var width2 = $(".section-list").width();
	$(".video").css("width",width-width2);
	$(".video").css("height",height-90);
	$(".videobox").css("width",width);
	$(".videobox").css("height",height);
	$(".section-list").css("height",height-92);
});
//判断ie版本
function IEVersion() {
    var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串  
    var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1; //判断是否IE<11浏览器  
    var isEdge = userAgent.indexOf("Edge") > -1 && !isIE; //判断是否IE的Edge浏览器  
    var isIE11 = userAgent.indexOf('Trident') > -1 && userAgent.indexOf("rv:11.0") > -1;
    if(isIE) {
        var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
        reIE.test(userAgent);
        var fIEVersion = parseFloat(RegExp["$1"]);
        if(fIEVersion == 7) {
        	$(".all dl").addClass("ie8");
        	alert("系统检测到您当前版本较低，为避免影响您的体验，请升级后浏览");
        } else if(fIEVersion == 8) {
        	alert("系统检测到您当前版本较低，为避免影响您的体验，请升级后浏览");
        } else if(fIEVersion == 9) {
        	alert("系统检测到您当前版本较低，为避免影响您的体验，请升级后浏览");
        } else if(fIEVersion == 10) {
        	alert("系统检测到您当前版本较低，为避免影响您的体验，请升级后浏览");
        } else {
        	alert("系统检测到您当前版本较低，为避免影响您的体验，请升级后浏览");
            return false;
        }   
    } else if(isEdge) {
    	alert("系统检测到您当前版本较低，为避免影响您的体验，请升级后浏览");
    } else if(isIE11) {
    	alert("系统检测到您当前版本较低，为避免影响您的体验，请升级后浏览");
    }else{
    }
}
IEVersion();
