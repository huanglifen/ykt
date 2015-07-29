@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/bootstrap-fileupload.css" />
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
        $breadTitle = "增加内容";
        $breadcrumb[] = array("内容管理");
        $breadcrumb[] = array("新闻公告", $baseURL . '/news/index');
        $breadcrumb[] = array("增加内容", $baseURL ."/news/add");
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <form id="addContentForm" action="#" class="form-horizontal">
                                <div class="control-group">
                                    <label class="control-label">公告类型</label>
                                    <div class="controls">
                                        <select class="span7 chosen" tabindex="1" id="type" name="type">
                                            @foreach($contentType as $key => $value)
                                                <option value="{{{$key}}}">{{{$value}}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            <div class="control-group">
                                <label class="control-label">公告标题</label>
                                <div class="controls">
                                    <input type="text" id="title" name="title"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">公告内容</label>
                                <div class="controls">
                                    <script id="editor" name="editor" type="text/plain" style="margin-right:20px;height:300px;"></script>
                                    <input type="hidden" id="content"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">是否显示</label>
                                <div class="controls">
                                    <label class="radio">
                                        <input type="radio" name="display" value="1" checked />
                                        是
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="display" value="2" />
                                        否
                                    </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">开始时间</label>
                                <div class="controls input-prepend" style="margin-left:20px;">
                                    <span class="add-on"><i class="icon-remove"></i></span>
                                    <input class="span12 m-wrap m-ctrl-medium date-picker" name="startTime" id="startTime" readonly
                                           type="text" value="" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">结束时间</label>
                                <div class="controls input-prepend" style="margin-left:20px;">
                                    <span class="add-on"><i class="icon-remove"></i></span>
                                    <input class="m-wrap m-ctrl-medium date-picker" style="width:167px;" name="endTime" id="endTime" readonly
                                           type="text" value=""/>
                                    <span for="endTime" class="error JsErrorTip" style="font-size:14px"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">信息来源</label>
                                <div class="controls">
                                    <input type="text" id="source" name="source"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">编辑人</label>
                                <div class="controls">
                                    <input type="text" id="author" name="author"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue">发布</button>
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
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-fileupload.js"></script>
    <script type="text/javascript" charset="utf-8" src="{{{$mediaURL}}}ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="{{{$mediaURL}}}ueditor/ueditor.all.min.js"> </script>
    <script src="{{{$mediaURL}}}js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}jquery.form.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
            if (jQuery().datepicker) {
                $('.date-picker').datepicker({
                    rtl : App.isRTL()
                });
            }
            var ue = UE.getEditor('editor');
            var target = $("#addContentForm");
            var v = target.validate({
                errorElement: 'span',
                invalidHandler: function () {
                    return false;
                },
                submitHandler: function (form) {
                    $(".JsErrorTarget").removeClass('error');
                    $(".JsErrorTip").hide();
                    var data = target.serialize();
                    $.ajax({
                        url: baseURL + "news/add",
                        dataType: 'json',
                        type: "POST",
                        data: data,
                        success: function (d) {
                            if (d.status == 0) {
                                alert("添加成功");
                                window.location.reload();
                            }
                            else {
                                Common.checkLogin(d);
                                if(d.status == 1001) {
                                    Common.checkError(d);
                                }else{
                                    alert("添加失败");
                                }
                            }
                        }
                    });
                    return false;
                },
                rules: {
                    title: {
                        required : true,
                        maxlength : 150
                    }
                },
                messages: {
                    title: {
                        required : "请输入标题",
                        maxlength : "标题长度不能超过150"
                    }
                }
            });
            $(".icon-remove").on("click", function() {
                $(this).parent().siblings("input").val("");
            });
        });
    </script>
@stop