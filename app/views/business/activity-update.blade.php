@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/datetimepicker.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "商户管理";
        $breadcrumb = array(
                array("商家信息"),
                array("商户管理", $baseURL . '/business/index'),
                array("活动列表", $baseURL . '/activity/index/'.$businessId),
                array("编辑活动", $baseURL . '/activity/update/'.$businessId."/".$id),
        );
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <form id="addActivityForm" action="#" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">商户编号</label>
                                <div class="controls" >
                                    <span class="help-inline">{{{$business->number}}}</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">商户名称</label>
                                <div class="controls">
                                    <span class="help-inline">{{{$business->name}}}</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">活动标题</label>
                                <div class="controls">
                                    <input type="text" id="title" name="title" value="{{{$activity->title}}}" class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">开始时间</label>
                                <div class="controls">
                                    <input class="m-wrap m-ctrl-medium date-picker" id="startTime" name="startTime" readonly size="16" type="text" value="<?php echo date("m/d/Y", $activity->start_time) ?>"  placeholder="请输入开始时间"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">结束时间</label>
                                <div class="controls">
                                    <input class="m-wrap m-ctrl-medium date-picker"id="endTime"  name="endTime" readonly size="16" type="text" value="<?php echo date("m/d/Y", $activity->end_time) ?>"  placeholder="请输入结束时间"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">活动内容</label>
                                <div class="controls">

                                    <textarea class="large m-wrap" rows="3" name="content" id="content">{{{$activity->content}}}</textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">活动状态</label>
                                <div class="controls">
                                    <label class="radio">
                                        <input type="radio" name="status" value="1" @if($activity->status != 2)checked @endif />
                                        启用
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="status" value="2" @if($activity->status == 2)checked @endif/>
                                        禁用
                                    </label>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue">保存</button>
                                <button type="button" class="btn" id="clearForm">清空</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->
    <!-- END PAGE -->
@stop
@section('otherJs')
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/daterangepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/chosen.jquery.min.js"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.validate.min.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
            if (jQuery().datepicker) {
                $('.date-picker').datepicker({
                    rtl : App.isRTL()
                });
            }
            var target = $("#addActivityForm");
            var businessId = <?php echo $businessId; ?>;
            var v = target.validate({
                errorElement: 'span',
                invalidHandler: function () {
                    return false;
                },
                submitHandler: function (form) {
                    var data = target.serialize();
                    data +="&businessId="+businessId;
                    data +="&id="+<?php echo $id ;?>;

                    $(".JsErrorTarget").removeClass('error');
                    $(".JsErrorTip").text('').hide();

                    $.ajax({
                        url: baseURL + "activity/update",
                        dataType: 'json',
                        type: "POST",
                        data: data,
                        success: function (d) {
                            Common.checkLogin(d);
                            if (d.status == 0) {
                                alert("修改成功！");
                            }
                            else {
                                if(d.status == 1001) {
                                    Common.checkError(d);
                                }else{
                                    alert("修改失败！");
                                }
                            }
                        }
                    });
                    return false;
                },
                rules: {
                    title: {
                        required : true,
                        maxlength : 30
                    },
                    startTime : {
                        required : true,
                        date:true
                    },
                    endTime : {
                        required : true,
                        date : true
                    },
                    content : {
                        required : true,
                        maxlength : 500
                    }

                },
                messages: {
                    title:  {
                        required : "请输入标题",
                        maxlength : "标题长度不能超过30个字"
                    },
                    startTime:  {
                        required : "请输入开始时间",
                        date:"请输入日期格式"
                    },
                    endTime:  {
                        required : "请输入结束时间",
                        date:"请输入日期格式"
                    },
                    content : {
                        required : "请输入活动内容",
                        maxlength : "活动内容长度不能超过500个字"
                    }
                }
            });
        });
        $("#clearForm").on('click', function() {
            clearForm();
        });
        var clearForm = function() {
            $("#title").val('');
            $("#content").val('');
            $("#startTime").val('');
            $("#endTime").val('');
        }
    </script>
@stop