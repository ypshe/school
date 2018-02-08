/**
 * jquery.citys.js 1.0
 * http://jquerywidget.com
 */
;(function (factory) {
    if (typeof define === "function" && (define.amd || define.cmd) && !jQuery) {
        // AMD鎴朇MD
        define([ "jquery" ],factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node/CommonJS
        module.exports = function( root, jQuery ) {
            if ( jQuery === undefined ) {
                if ( typeof window !== 'undefined' ) {
                    jQuery = require('jquery');
                } else {
                    jQuery = require('jquery')(root);
                }
            }
            factory(jQuery);
            return jQuery;
        };
    } else {
        //Browser globals
        factory(jQuery);
    }
}(function ($) {
    $.support.cors = true;
    $.fn.citys = function(parameter,getApi) {
        if(typeof parameter == 'function'){ //閲嶈浇
            getApi = parameter;
            parameter = {};
        }else{
            parameter = parameter || {};
            getApi = getApi||function(){};
        }
        var defaults = {
            dataUrl:'http://passer-by.com/data_location/list.json',     //鏁版嵁搴撳湴鍧€
            dataType:'json',          //鏁版嵁搴撶被鍨�:'json'鎴�'jsonp'
            provinceField:'province', //鐪佷唤瀛楁鍚�
            cityField:'city',         //鍩庡競瀛楁鍚�
            areaField:'area',         //鍦板尯瀛楁鍚�
            valueType:'code',         //涓嬫媺妗嗗€肩殑绫诲瀷,code琛屾斂鍖哄垝浠ｇ爜,name鍦板悕
            code:0,                   //鍦板尯缂栫爜
            province:0,               //鐪佷唤,鍙互涓哄湴鍖虹紪鐮佹垨鑰呭悕绉�
            city:0,                   //鍩庡競,鍙互涓哄湴鍖虹紪鐮佹垨鑰呭悕绉�
            area:0,                   //鍦板尯,鍙互涓哄湴鍖虹紪鐮佹垨鑰呭悕绉�
            required: true,           //鏄惁蹇呴』閫変竴涓�
            nodata: 'hidden',         //褰撴棤鏁版嵁鏃剁殑琛ㄧ幇褰㈠紡:'hidden'闅愯棌,'disabled'绂佺敤,涓虹┖涓嶅仛浠讳綍澶勭悊
            onChange:function(){}     //鍦板尯鍒囨崲鏃惰Е鍙�,鍥炶皟鍑芥暟浼犲叆鍦板尯鏁版嵁
        };
        var options = $.extend({}, defaults, parameter);
        return this.each(function() {
            //瀵硅薄瀹氫箟
            var _api = {};
            var $this = $(this);
            var $province = $this.find('select[name="'+options.provinceField+'"]'),
                $city = $this.find('select[name="'+options.cityField+'"]'),
                $area = $this.find('select[name="'+options.areaField+'"]');
            $.ajax({
                url:options.dataUrl,
                type:'GET',
                crossDomain: true,
                dataType:options.dataType,
                jsonpCallback:'jsonp_location',
                success:function(data){
                    var province,city,area,hasCity;
                    if(options.code){   //濡傛灉璁剧疆鍦板尯缂栫爜锛屽垯蹇界暐鍗曠嫭璁剧疆鐨勪俊鎭�
                        var c = options.code - options.code%1e4;
                        if(data[c]){
                            options.province = c;
                        }
                        c = options.code - (options.code%1e4 ? options.code%1e2 : options.code);
                        if(data[c]){
                            options.city = c;
                        }
                        c = options.code%1e2 ? options.code : 0;
                        if(data[c]){
                            options.area = c;
                        }
                    }
                    var updateData = function(){
                        province = {},city={},area={};
                        hasCity = false;       //鍒ゆ柇鏄潪鏈夊湴绾у煄甯�
                        for(var code in data){
                            if(!(code%1e4)){     //鑾峰彇鎵€鏈夌殑鐪佺骇琛屾斂鍗曚綅
                                province[code]=data[code];
                                if(options.required&&!options.province){
                                    if(options.city&&!(options.city%1e4)){  //鐪佹湭濉紝骞跺垽鏂负鐩磋緰甯�
                                        options.province = options.city;
                                    }else{
                                        options.province = code;
                                    }
                                }else if(data[code].indexOf(options.province)>-1){
                                    options.province = isNaN(options.province)?code:options.province;
                                }
                            }else{
                                var p = code - options.province;
                                if(options.province&&p>0&&p<1e4){    //鍚岀渷鐨勫煄甯傛垨鍦板尯
                                    if(!(code%100)){
                                        hasCity = true;
                                        city[code]=data[code];
                                        if(data[code].indexOf(options.city)>-1){
                                            options.city = isNaN(options.city)?code:options.city;
                                        }
                                    }else if(p>9000){                   //鐪佺洿杈栧幙绾ц鏀垮崟浣�
                                        city[code] = data[code];
                                        if(data[code].indexOf(options.city)>-1){
                                            options.city = isNaN(options.city)?code:options.city;
                                        }
                                    }else if(hasCity){                  //闈炵洿杈栧競
                                        var c = code-options.city;
                                        if(options.city&&c>0&&c<100){     //鍚屼釜鍩庡競鐨勫湴鍖�
                                            area[code]=data[code];
                                            if(data[code].indexOf(options.area)>-1){
                                                options.area = isNaN(options.area)?code:options.area;
                                            }
                                        }
                                    }else{
                                        area[code]=data[code];            //鐩磋緰甯�
                                        if(data[code].indexOf(options.area)>-1){
                                            options.area = isNaN(options.area)?code:options.area;
                                        }
                                    }
                                }
                            }
                        }
                    };
                    var format = {
                        province:function(){
                            $province.empty();
                            if(!options.required){
                                $province.append('<option value=""> - 璇烽€夋嫨 - </option>');
                            }
                            for(var i in province){
                                $province.append('<option value="'+(options.valueType=='code'?i:province[i])+'" data-code="'+i+'">'+province[i]+'</option>');
                            }
                            if(options.province){
                                var value = options.valueType=='code'?options.province:province[options.province];
                                $province.val(value);
                            }
                            this.city();
                        },
                        city:function(){
                            $city.empty();
                            if(!hasCity){
                                $city.css('display','none');
                            }else{
                                $city.css('display','');
                                if(!options.required){
                                    $city.append('<option value=""> - 璇烽€夋嫨 - </option>');
                                }
                                if(options.nodata=='disabled'){
                                    $city.prop('disabled',$.isEmptyObject(city));
                                }else if(options.nodata=='hidden'){
                                    $city.css('display',$.isEmptyObject(city)?'none':'');
                                }
                                for(var i in city){
                                    $city.append('<option value="'+(options.valueType=='code'?i:city[i])+'" data-code="'+i+'">'+city[i]+'</option>');
                                }
                                if(options.city){
                                    var value = options.valueType=='code'?options.city:city[options.city];
                                    $city.val(value);
                                }else if(options.area){
                                    var value = options.valueType=='code'?options.area:city[options.area];
                                    $city.val(value);
                                }
                            }
                            this.area();
                        },
                        area:function(){
                            $area.empty();
                            if(!options.required){
                                $area.append('<option value=""> - 璇烽€夋嫨 - </option>');
                            }
                            if(options.nodata=='disabled'){
                                $area.prop('disabled',$.isEmptyObject(area));
                            }else if(options.nodata=='hidden'){
                                $area.css('display',$.isEmptyObject(area)?'none':'');
                            }
                            for(var i in area){
                                $area.append('<option value="'+(options.valueType=='code'?i:area[i])+'" data-code="'+i+'">'+area[i]+'</option>');
                            }
                            if(options.area){
                                var value = options.valueType=='code'?options.area:area[options.area];
                                $area.val(value);
                            }
                        }
                    };
                    //鑾峰彇褰撳墠鍦扮悊淇℃伅
                    _api.getInfo = function(){
                        var status = {
                            direct:!hasCity,
                            province:data[options.province]||'',
                            city:data[options.city]||'',
                            area:data[options.area]||'',
                            code:options.area||options.city||options.province
                        };
                        return status;
                    };
                    //浜嬩欢缁戝畾
                    $province.on('change',function(){
                        options.province = $(this).find('option:selected').data('code')||0; //閫変腑鑺傜偣鐨勫尯鍒掍唬鐮�
                        options.city = 0;
                        options.area = 0;
                        updateData();
                        format.city();
                        options.onChange(_api.getInfo());
                    });
                    $city.on('change',function(){
                        options.city = $(this).find('option:selected').data('code')||0; //閫変腑鑺傜偣鐨勫尯鍒掍唬鐮�
                        options.area = 0;
                        updateData();
                        format.area();
                        options.onChange(_api.getInfo());
                    });
                    $area.on('change',function(){
                        options.area = $(this).find('option:selected').data('code')||0; //閫変腑鑺傜偣鐨勫尯鍒掍唬鐮�
                        options.onChange(_api.getInfo());
                    });
                    //鍒濆鍖�
                    updateData();
                    format.province();
                    if(options.code){
                        options.onChange(_api.getInfo());
                    }
                    getApi(_api);
                }
            });
        });
    };
}));