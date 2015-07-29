@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/select2_metro.css" />
    <link rel="stylesheet" href="{{{$mediaURL}}}css/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/halflings.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/bootstrap-toggle-buttons.css" />
    <style>
        .form-horizontal-wrap .control-label {
            float : left;
            padding-top: 5px;
            text-align: right;
            width: 90px;
        }
        .form-horizontal-wrap .controls {
            margin-left: 110px;
        }
        .form-horizontal-wrap h4 {
            margin-left :22px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .add-money .hide {
            display: none;
        }
        .toggle-button {
            width: 200px;
            height: 25px;
        }
        .labelRight {
            width: 100px;
            height: 25px;
            line-height: 25px;
        }
        .labelLeft {
            width: 100px;
            height: 25px;
            line-height: 25px;
        }
        .toggle-button label {
            width: 100px;
            height: 25px;
        }
    </style>
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "通讯费";
        $breadcrumb = array(
                array("缴费管理"),
                array("业务设置"),
                array("通讯费", $baseURL . '/paySet/index/'.\App\Module\paySetModule::CATEGORY_MOBILE));
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box">
                    <div class="portlet-body form-horizontal-wrap">
                        <h4 >
                            通讯业务设置
                        </h4>
                        <div class="control-group">
                            <label class="control-label">中国移动</label>
                            <div class="controls">
                                <div data-id="{{{$mobile->id}}}" class="toggle-button">
                                    <div class="toggle-div" style="left: @if($mobile->status == \App\Module\BaseModule::STATUS_OPEN)0px; @else -50%; @endif width: 300px;">
                                        <span class="labelLeft" >已启用
                                        </span><label></label>
                                        <span class="labelRight">已禁止</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">中国联通</label>
                            <div class="controls">
                                <div data-id="{{{$unicom->id}}}" class="toggle-button" >
                                    <div class="toggle-div" style="left: @if($unicom->status == \App\Module\BaseModule::STATUS_OPEN)0px; @else -50%; @endif width: 300px;">
                                        <span class="labelLeft">已启用
                                        </span><label></label>
                                        <span class="labelRight" style="">已禁止</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">中国电信</label>
                            <div class="controls">
                                <div data-id="{{{$telcom->id}}}" class="toggle-button" >
                                    <div class="toggle-div" style="left: @if($telcom->status == \App\Module\BaseModule::STATUS_OPEN)0px; @else -50%; @endif width: 300px;">
                                        <span class="labelLeft">已启用
                                        </span><label></label>
                                        <span class="labelRight" style="">已禁止</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="portlet box">
                    <div class="portlet-body form-horizontal-wrap">
                        <h4 >
                            充值单控制
                        </h4>
                        <?php $defaultArr = array(10, 20, 30, 50, 100); ?>
                        <div class="control-group">
                            <label class="control-label">中国移动</label>
                            <div class="controls">
                                <?php if($mobile->support_money)$mobile->support_money = explode(",", $mobile->support_money); else $mobile->support_money = array(); ?>
                                <?php $showArr = array(); $showArr = array_unique(array_merge($defaultArr, $mobile->support_money)); sort($showArr);?>
                                @foreach($showArr as $money)
                                        <label class="checkbox">
                                            <input type="checkbox" value="{{{$money}}}"@if(in_array($money, $mobile->support_money)) checked="checked" @endif/> {{{$money}}}元
                                        </label>
                                    @endforeach
                                    <span class="add-money hide"><input type="text" class="m-wrap small" /> 元</span>
                                    <button class="btn mini green jsAddMoney" type="submit">新增</button>
                                    <button class="btn mini blue JsSaveMoney" data-id="{{{$mobile->id}}}" type="submit">保存</button>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">中国联通</label>
                            <div class="controls">
                                <?php if($unicom->support_money)$unicom->support_money = explode(",", $unicom->support_money); else $unicom->support_money = array(); ?>
                                <?php $showArr = array(); $showArr = array_unique(array_merge($defaultArr, $unicom->support_money)); sort($showArr);?>
                                @foreach($showArr as $money)
                                    <label class="checkbox">
                                        <input type="checkbox" value="{{{$money}}}"@if(in_array($money, $unicom->support_money)) checked="checked" @endif/> {{{$money}}}元
                                    </label>
                                @endforeach
                                    <span class="add-money hide"><input type="text" class="m-wrap small" /> 元</span>
                                    <button class="btn mini green jsAddMoney" type="submit">新增</button>
                                    <button class="btn mini blue JsSaveMoney" data-id="{{{$unicom->id}}}" type="submit">保存</button>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">中国电信</label>
                            <div class="controls">
                                <?php if($telcom->support_money)$telcom->support_money = explode(",", $telcom->support_money); else $telcom->support_money = array(); ?>
                                <?php $showArr = array(); $showArr = array_unique(array_merge($defaultArr, $telcom->support_money)); sort($showArr);?>
                                @foreach($showArr as $money)
                                    <label class="checkbox">
                                        <input type="checkbox" value="{{{$money}}}"@if(in_array($money, $telcom->support_money)) checked="checked" @endif/> {{{$money}}}元
                                    </label>
                                @endforeach
                                    <span class="add-money hide"><input type="text" class="m-wrap small" /> 元</span>
                                    <button class="btn mini green jsAddMoney" type="submit">新增</button>
                                    <button class="btn mini blue JsSaveMoney" data-id="{{{$telcom->id}}}" type="submit">保存</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="portlet box">
                    <div class="portlet-body form-horizontal-wrap">
                        <h4 >
                            支持卡类型
                        </h4>
                        <div class="control-group">
                            <label class="control-label">中国移动</label>
                            <div class="controls">
                                <?php if($mobile->support_card) $mobile->support_card = explode(",", $mobile->support_card); else $mobile->support_card = array(); ?>
                                @foreach($cardType as $type)
                                        <label class="checkbox">
                                            <input type="checkbox" value="{{{$type->id}}}" @if(in_array($type->id, $mobile->support_card)) checked="checked" @endif/>{{{$type->name}}}
                                        </label>
                                @endforeach
                                    <button class="btn mini blue JsSaveCardType" data-id="{{{$mobile->id}}}" type="submit">保存</button>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">中国联通</label>
                            <div class="controls">
                                <?php if($unicom->support_card ) $unicom->support_card = explode(",", $unicom->support_card); else $unicom->support_card = array(); ?>
                                @foreach($cardType as $type)
                                    <label class="checkbox">
                                        <input type="checkbox" value="{{{$type->id}}}" @if(in_array($type->id, $unicom->support_card)) checked="checked" @endif/>{{{$type->name}}}
                                    </label>
                                @endforeach
                                    <button class="btn mini blue JsSaveCardType" data-id="{{{$unicom->id}}}" type="submit">保存</button>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">中国电信</label>
                            <div class="controls">
                                <?php if($telcom->support_card) $telcom->support_card = explode(",", $telcom->support_card); else $telcom->support_card = array(); ?>
                                @foreach($cardType as $type)
                                    <label class="checkbox">
                                        <input type="checkbox" value="{{{$type->id}}}" @if(in_array($type->id, $telcom->support_card)) checked="checked" @endif/>{{{$type->name}}}
                                    </label>
                                @endforeach
                                    <button class="btn mini blue JsSaveCardType" data-id="{{{$telcom->id}}}" type="submit">保存</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->
    <!-- END PAGE -->
@stop
@section('otherJs')
    <script src="{{{$mediaURL}}}js/select2.min.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/DT_bootstrap.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/table-managed.js" type="text/javascript"></script>
    <script>
        $(function() {
           App.init();
            initToggle();
            saveSupportMoney();
            saveSupportCardType();
            $(".jsAddMoney").on('click', function() {
               var $sibling = $(this).siblings(".add-money");
                if($sibling.hasClass("hide")) {
                    $sibling.removeClass("hide");
                    $(this).text("确定");
                }else{
                    var input = $sibling.find("input");
                    var number = parseInt($(input).val());
                    if(number) {
                        var html = '<label class="checkbox">';
                        html += '<input type="checkbox" class="group-checkable" value="' + number+ '" checked="checked"/>';
                        html += number + '元</label>';
                        $sibling.before(html);
                    }
                    $(input).val("");
                    $sibling.addClass("hide");
                    $(this).text("新增");
                    App.initUniform(false);
                }
            });
        });
        //更新支持的金额
        var saveSupportMoney = function() {
            $(".JsSaveMoney").on('click', function() {
                var $this = $(this);
                var parent = $this.parent();
                var checkLabel = $(parent).find(".checkbox .checker .checked");
                var money = "";
                $.each(checkLabel, function(i, item) {
                    if(i == 0) {
                        money = $(item).find("input").val();
                    } else {
                        money += ",";
                        money += $(item).find("input").val();
                    }
                });
                var id = $this.attr('data-id');
                var data = "money=" + money + "&id=" + id;
                var url = baseURL + "paySet/money";
                saveUpdate(url, data);
            });
        }

        //修改支持的卡类型
        var saveSupportCardType = function() {
            $(".JsSaveCardType").on('click', function() {
                var $this = $(this);
                var parent = $this.parent();
                var checkLabel = $(parent).find(".checkbox .checker .checked");
                var cardType = "";
                $.each(checkLabel, function(i, item) {
                    if(i == 0) {
                        cardType = $(item).find("input").val();
                    } else {
                        cardType += ",";
                        cardType += $(item).find("input").val();
                    }
                });
                var id = $this.attr('data-id');
                var data = "cardType=" + cardType + "&id=" + id;
                var url = baseURL + "paySet/card-type";
                saveUpdate(url, data);
            });
        }

        //更新数据公共方法
        var saveUpdate = function(url, data) {
            $.ajax({
                'dataType' : 'json',
                'data' : data,
                'type' : 'post',
                'url' : url,
                'success' : function(d) {
                    Common.checkLogin(d);
                    if(d.status == 0) {
                        alert('保存成功！');
                    }else if(d.state == 1000) {
                        alert(d.result);
                    }else{
                        alert('操作失败');
                    }
                }
            });
        }
        //禁止/启动
        var initToggle = function() {
            $(".toggle-button").on('click', function() {
                var $this = $(this);
                var id = $this.attr('data-id');
                var data = 'id='+id;
                $.ajax({
                    'dataType' : 'json',
                    'data' : data,
                    'type' : 'post',
                    'url' : baseURL + 'paySet/status',
                    'success' : function(d) {
                        Common.checkLogin(d);
                        if(d.status == 0) {
                            if(d.result.state == <?php echo \App\Module\BaseModule::STATUS_OPEN; ?>) {
                                $this.find(".toggle-div").css("left", "0px");
                            }else{
                                $this.find(".toggle-div").css("left", "-50%");
                            }
                        }else if(d.state == 1000) {
                            alert(d.result);
                        }else{
                            alert('操作失败');
                        }

                    }
                });
            })
        }
    </script>
@stop