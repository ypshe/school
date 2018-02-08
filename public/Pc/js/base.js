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
		var s = /^\d{15}|\d{17}[xX]{1}$/;//验证身份证
		var ms = /^[a-zA-Z0-9]{6,18}$/;//验证密码
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
			var status=1;
			if(sfz == ""){
				$(this).prev(".zmo").find(".sfz").next("span").html("身份证号不能为空");
				status=0;
			}else if(!sfz.match(s)){
				$(this).prev(".zmo").find(".sfz").next("span").html("身份证号不合法");
                status=0;
            }else{
				$(this).prev(".zmo").find(".sfz").next("span").html("");
			};
			if(mima01 == ""){
				$(this).prev(".zmo").find(".mima01").next("span").html("密码不能为空");
                status=0;
            }else if(!mima01.match(ms)){
				$(this).prev(".zmo").find(".mima01").next("span").html("密码不合法");
                status=0;
            }else{
				$(this).prev(".zmo").find(".mima01").next("span").html("");
			};
			if(mima02 == ""){
				$(this).prev(".zmo").find(".mima02").next("span").html("密码不能为空");
                status=0;
            }else if(!mima02.match(ms)){
				$(this).prev(".zmo").find(".mima02").next("span").html("密码不合法");
                status=0;
            }else{
				$(this).prev(".zmo").find(".mima02").next("span").html("");
			};
			if(mima01 != mima02){
				$(this).prev(".zmo").find(".mima02").next("span").html("密码不一样");
                status=0;
            }else{
				$(this).prev(".zmo").find(".mima02").next("span").html("");
			};
			if(yan == ""){
				$(this).prev(".zmo").find(".yan").parent("dt").next("span").html("验证码不能为空");
                status=0;
            }else{
				$(this).prev(".zmo").find(".yan").next("span").html("");
			}
			if(status==1){
                $(this).parent("form").submit();
            }
		});
		//点击登录按钮
		$("#denglubtn").click(function(){
			var sfz = $(this).prev(".zmo").find(".sfz").val();
			var mima01 = $(this).prev(".zmo").find(".mima01").val();
			var yan = $(this).prev(".zmo").find(".yan").val();
			var status=1;
			if(sfz == ""){
				$(this).prev(".zmo").find(".sfz").next("span").html("身份证号不能为空");
				status=0;
			}else if(!sfz.match(s)){
				$(this).prev(".zmo").find(".sfz").next("span").html("身份证号不合法");
                status=0;
            }else{
				$(this).prev(".zmo").find(".sfz").next("span").html("");
			};
			if(mima01 == ""){
				$(this).prev(".zmo").find(".mima01").next("span").html("密码不能为空");
                status=0;
            }else if(!mima01.match(ms)){
				$(this).prev(".zmo").find(".mima01").next("span").html("密码不合法");
                status=0;
            }else{
				$(this).prev(".zmo").find(".mima01").next("span").html("");
			}
            if(yan == ""){
                $('#resCaptche').html("验证码不能为空");
                status=0;
            }else{
                $('#resCaptche').html("");
            }
			if(status==1){
                $(this).parent("form").submit();
			}
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
//新增

