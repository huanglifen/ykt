var Common = Common || {};

//显示后台返回的错误提示
Common.checkError = function(result) {
        var msg = result.result;
        $.each(msg, function(i, item) {
            var target = $("#"+i);
            target.addClass('error');
            var next = target.next('span[for='+i+']');
            if(next.length > 0) {
                next.text(item).show();
            }else{
                var html = '<span for="'+i+'" class="error">'+item+'</span>';
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

