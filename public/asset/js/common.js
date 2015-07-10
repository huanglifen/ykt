var Common = Common || {};

//显示后台返回的错误提示
Common.checkError = function(result) {
        var msg = result.result;
        $.each(msg, function(i, item) {
            var target = $("#"+i);
            target.addClass('error').addClass('JsErrorTarget');
            var next = target.next('span[for='+i+']');
            if(next.length > 0) {
                next.text(item).show();
            }else{
                var html = '<span for="'+i+'" class="error JsErrorTip">'+item+'</span>';
                target.after(html);
            }
        })
    }

Common.changeStatus = function(url) {
    $("body").on('click',".JsUpdateStatus", function() {

        var that = $(this);
        var id = that.attr('data-id');
        var text = that.text();
        $.ajax({
            'type' : 'post',
            'dataType' : 'json',
            'data' : 'id='+id,
            'url' : baseURL + url,
            'success' : function(json) {
                if(json.status == 0) {
                    if(text == "是") {
                        that.text("否");
                    }else{
                        that.text("是");
                    }

                }else{
                    alert('操作失败，请重试！');
                }
            }
        });
    });
}
Common.dataTableSelectAll = function() {
    $("#JsSelectAll").on('click', function() {
        var that = $(this);
        var parent = that.parent();
        var checkBoxes = $("td .group-checkable");
        if(parent.hasClass('checked')) {
            checkBoxes.parent().addClass('checked');
            checkBoxes.attr('checked', 'checked');
        }else{
            checkBoxes.parent().removeClass('checked');
            checkBoxes.attr('checked',false);
        }
    });
}

Common.checkLogin = function(d) {
    if(d.status == 2001) {
        parent.window.location.href = baseURL+"login";
    }
}

Common.bindCitySelect = function(flag, loadMap ) {
    if(typeof loadMap == 'undefined') {
        loadMap = true;
    }
    $("#cityId").chosen().change(function() {
        var $this = $(this);
        var cityId = $this.val();
        $.ajax({
            'url' : baseURL + "circle/district/"+cityId,
            'type' : 'get',
            'dataType' : 'json',
            'success' : function(data) {
                var option = [];
                var districts = data.result;
                if(flag) {
                    option.push('<option value="0">','全部','</option>');
                }
                $.each(districts,function(index,item){
                    option.push('<option value="'+item.id+'">',item.name,'</option>');
                });
                $('#districtId').html(option.join(''));
                $("#districtId").trigger("liszt:updated");
                if(loadMap) {
                    Common.location();
                }
            }
        })
    });
    $("#districtId").chosen().change(function() {
        if(loadMap) {
            Common.location();
        }
    })
}

MapJs = true;
Common.bindMap = function(pointX, pointY) {
    if(! MapJs) {
        return false;
    }

   try{
       map = new BMap.Map("allmap");
       map.enableScrollWheelZoom(true);
       if(pointX !== false && pointY !== false) {
           var point = new BMap.Point(pointX,pointY);
           map.centerAndZoom(point,15);
       } else{
           var city = $("#cityId").find("option:selected").text();
           if (city != "") {
               map.centerAndZoom(city, 12);      // 用城市名设置地图中心点
           }else {
               pointX = 114.26;
               pointY = 38.03;
               var point = new BMap.Point(pointX,pointY);
               map.centerAndZoom(point,11);
           }
       }

       map.addEventListener("click", function(e){
           $("#lng").val(e.point.lng);
           $("#lat").val(e.point.lat);
       });
       map.addEventListener("tilesloaded",function(e){
       });
   }catch(e) {
       MapJs = false;
    }
}

var level = 12;
Common.location = function() {
    if(! MapJs) {
        return false;
    }
    var city = $("#cityId").find("option:selected").text();
    var district = $("#districtId").find("option:selected").text();
    if(district) {
        level = 15;
    }
    city = city+district;
    if (city != "") {
        map.centerAndZoom(city, level);      // 用城市名设置地图中心点
    }
}

//地图按关键字搜索
Common.search = function(that) {
    if(! MapJs) {
        return false;
    }
    var value = $(that).val();
    if(! value) {
        return false;
    }
    var city = $("#cityId").find("option:selected").text();
    map = new BMap.Map("allmap");
    map.enableScrollWheelZoom(true);
    map.centerAndZoom(city, 11);

    var local = new BMap.LocalSearch(map, {
        renderOptions:{map: map}
    });
    local.search(value);
    map.addEventListener("click", function(e){
        $("#lng").val(e.point.lng);
        $("#lat").val(e.point.lat);
    });
}
//地图上画个椭圆，该功能暂时未用到
Common.addOval = function(center, x, y) {
    var assemble=new Array();
    var angle;
    var dot;
    var tangent=x/y;
    for(i=0;i<36;i++)
    {
        angle = (2* Math.PI / 36) * i;
        dot = new BMap.Point(centre.lng+Math.sin(angle)*y*tangent, centre.lat+Math.cos(angle)*y);
        assemble.push(dot);
    }
    return assemble;
}

Common.formatDate = function(time) {
    time = new Date(parseInt(time)*1000);
    var   year=time.getFullYear();
    var   month=time.getMonth()+1;
    var   date=time.getDate();
    return   year+"-"+month+"-"+date;
}


