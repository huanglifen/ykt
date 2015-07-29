@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/bootstrap-fileupload.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "添加素材";
        $breadcrumb[] = array("内容管理");
        $breadcrumb[] = array("微信素材", $baseURL . '/wsource/index');
        $breadcrumb[] = array("添加素材", $baseURL ."/wsource/add/".$type);
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
                                <label class="control-label">标题</label>
                                <div class="controls">
                                    <input type="text" id="title" name="title"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">详细内容</label>
                                <div class="controls">
                                    <script id="editor" name="editor" type="text/plain" style="margin-right:20px;height:300px;"></script>
                                    <input type="hidden" id="content"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" id="JsSaveBtn" class="btn blue">保存</button>
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
    <script type="text/javascript" charset="utf-8" src="{{{$mediaURL}}}ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="{{{$mediaURL}}}ueditor/ueditor.all.min.js"> </script>
    <script src="{{{$mediaURL}}}js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}jquery.form.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
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
                    data +="&type="+<?php echo $type; ?>;
                    $.ajax({
                        url: baseURL + "wsource/add",
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
        });
    </script>
@stop