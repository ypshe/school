!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):t(window.jQuery||window.Zepto)}(function(t,e){function a(){}function r(t,e){var a;return a=e._$container==d?("innerHeight"in s?s.innerHeight:d.height())+d.scrollTop():e._$container.offset().top+e._$container.height(),a<=t.offset().top-e.threshold}function n(e,a){var r;return r=a._$container==d?d.width()+(t.fn.scrollLeft?d.scrollLeft():s.pageXOffset):a._$container.offset().left+a._$container.width(),r<=e.offset().left-a.threshold}function o(t,e){var a;return a=e._$container==d?d.scrollTop():e._$container.offset().top,a>=t.offset().top+e.threshold+t.height()}function l(e,a){var r;return r=a._$container==d?t.fn.scrollLeft?d.scrollLeft():s.pageXOffset:a._$container.offset().left,r>=e.offset().left+a.threshold+e.width()}function i(t,e){var a=0;t.each(function(i,c){function f(){_.trigger("_lazyload_appear"),a=0}var _=t.eq(i);if(!(_.width()<=0&&_.height()<=0||"none"===_.css("display")))if(e.vertical_only)if(o(_,e));else if(r(_,e)){if(++a>e.failure_limit)return!1}else f();else if(o(_,e)||l(_,e));else if(r(_,e)||n(_,e)){if(++a>e.failure_limit)return!1}else f()})}function c(t){return t.filter(function(e,a){return!t.eq(e)._lazyload_loadStarted})}function f(t,e){function a(){l=0,i=+new Date,o=t.apply(r,n),r=null,n=null}var r,n,o,l,i=0;return function(){r=this,n=arguments;var t=new Date-i;return l||(t>=e?a():l=setTimeout(a,e-t)),o}}var _,s=window,d=t(s),u={threshold:0,failure_limit:0,event:"scroll",effect:"show",effect_params:null,container:s,data_attribute:"original",data_srcset_attribute:"original-srcset",skip_invisible:!0,appear:a,load:a,vertical_only:!1,check_appear_throttle_time:300,url_rewriter_fn:a,no_fake_img_loader:!1,placeholder_data_img:"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAsYAAAH0BAMAAADMHPa9AAAAD1BMVEXj4+PY2Njb29vg4ODd3d1UF6dGAAADQUlEQVR42uzBgQAAAACAoP2pF6kCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGB27ii3VSCGwrCZYQE1zQJi0gVAyAJIk/2v6SLKMED6dON56v9Jlao8HlkT20MAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADA3xAHQVE3U9UvQTlXnTWCzD1iQi6r1tVZUMRds05QQK0bn4ICet0SFKATTuSigiqHRTnj5qigfStjrlnTSfv8NjqLEuY8dTLK5M6BXICdROIScapo/RA4uutZQq7cyJeej1urzVcns0q1C9pI0pOx49x8SW1b06cyToV8EnhEnKr12EjcydhzbL6skTePTmR4yiSQsev2Z9zPeOd0WJzi80GP/N+uj2H4tu1AdxzvbK1yeNx6fGwLeUyHCSG7CJup2fbDXaU5dLyjz71FtF3VBnZDXmxTq7d2GUkGrvY8hV9q9fssIpFFsv+4l9Q2Bx61aY1bJxdx3z7cLJ0Nl+nvymHhOvE17VfbHs+NwJLTQ9TstWqNA9lD9XqNN0oS6N5cmB62F6GTFRm/6/KyIJo+iY1kRmPxpn7c7C3SXt7OkvVk/KaqkV3Il7ljFjJ2FJaeoTadtN2c9ycZe4p5whu6VNKjbBjfee+yw4L4fkyUy1OXKe/UySLacQYJzCBOF3s/O81hHaUzY1/hN4C09tsofeXhQgdB95pdxFyEuBbySxnrhLVbgUI+yYpfOPnpNWs2eRpl7Oeuq1Ey41ra0TVHvLFEzEnhI+i6rjhsjnkDgGPGn8OScKrlmunDPeMUbfqn4jksV3Xu0HqVH0bGruLaGdfpfAi0xs7SHUhMwUbjCSFH+acKbauzx3AzemNvlW6xqSih1gWvVyjHdMFrQooJujgZDx6XkRdDXcVrm0qJlk5go4wz/5CbUURqfmtTXmCpWV5sWWoCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwL/24JAAAAAAQND/186wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAJMA7Qlh8IZFY3EAAAAASUVORK5CYII=",placeholder_real_img:"http://ditu.baidu.cn/yyfm/lazyload/0.0.1/img/placeholder.png"};_=function(){var t=Object.prototype.toString;return function(e){return t.call(e).replace("[object ","").replace("]","")}}(),t.fn.hasOwnProperty("lazyload")||(t.fn.lazyload=function(e){var r,n,o,l=this;return t.isPlainObject(e)||(e={}),t.each(u,function(a,r){-1!=t.inArray(a,["threshold","failure_limit","check_appear_throttle_time"])?"String"==_(e[a])?e[a]=parseInt(e[a],10):e[a]=r:"container"==a?(e.hasOwnProperty(a)?e[a]==s||e[a]==document?e._$container=d:e._$container=t(e[a]):e._$container=d,delete e.container):!u.hasOwnProperty(a)||e.hasOwnProperty(a)&&_(e[a])==_(u[a])||(e[a]=r)}),r="scroll"==e.event,o=0==e.check_appear_throttle_time?i:f(i,e.check_appear_throttle_time),n=r||"scrollstart"==e.event||"scrollstop"==e.event,l.each(function(r,o){var i=this,f=l.eq(r),_=f.attr("src"),s=f.attr("data-"+e.data_attribute),d=e.url_rewriter_fn==a?s:e.url_rewriter_fn.call(i,f,s),u=f.attr("data-"+e.data_srcset_attribute),h=f.is("img");return 1==f._lazyload_loadStarted||_==d?(f._lazyload_loadStarted=!0,void(l=c(l))):(f._lazyload_loadStarted=!1,h&&!_&&f.one("error",function(){f.attr("src",e.placeholder_real_img)}).attr("src",e.placeholder_data_img),f.one("_lazyload_appear",function(){function r(){n&&f.hide(),h?(u&&f.attr("srcset",u),d&&f.attr("src",d)):f.css("background-image",'url("'+d+'")'),n&&f[e.effect].apply(f,o?e.effect_params:[]),l=c(l)}var n,o=t.isArray(e.effect_params);f._lazyload_loadStarted||(n="show"!=e.effect&&t.fn[e.effect]&&(!e.effect_params||o&&0==e.effect_params.length),e.appear!=a&&e.appear.call(i,f,l.length,e),f._lazyload_loadStarted=!0,e.no_fake_img_loader||u?(e.load!=a&&f.one("load",function(){e.load.call(i,f,l.length,e)}),r()):t("<img />").one("load",function(){r(),e.load!=a&&e.load.call(i,l.length,e)}).attr("src",d))}),void(n||f.on(e.event,function(){f._lazyload_loadStarted||f.trigger("_lazyload_appear")})))}),n&&e._$container.on(e.event,function(){o(l,e)}),d.on("resize load",function(){o(l,e)}),t(function(){o(l,e)}),this})});