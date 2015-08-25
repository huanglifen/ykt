@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/datetimepicker.css" />
    <style>
        .add-field .hide {
            display: none;
        }
    </style>
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "修改活动";
        $breadcrumb = array(
                array("内容管理"),
                array("活动专题", $baseURL . '/subject/index'),
                array("修改活动", $baseURL ."/subject/update/$id"));
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <div id="addContentForm" action="#" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">活动标题</label>
                                <div class="controls">
                                    <input type="text" id="title" name="title" value="{{{$subject->title}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">开始时间</label>
                                <div class="controls input-append" style="margin-left:20px;">
                                    <input class="span12 m-wrap m-ctrl-medium date-picker" name="startTime" id="startTime" readonly
                                           type="text" value="{{{$subject->start_time}}}" />
                                    <span class="add-on"><i class="icon-remove"></i></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">结束时间</label>
                                <div class="controls input-append" style="margin-left:20px;">
                                    <input class="m-wrap m-ctrl-medium date-picker" style="width:167px;" name="endTime" id="endTime" readonly
                                           type="text" value="{{{$subject->end_time}}}"/>
                                    <span class="add-on"><i class="icon-remove"></i></span>
                                    <span for="endTime" class="error JsErrorTip" style="font-size:14px"></span>
                                </div>
                            </div>
                            <form id="jsPicUpload" name="picUpload" enctype="multipart/form-data">
                                <div class="control-group">
                                    <label class="control-label">选择图片</label>
                                    <div class="controls">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="input-append">
                                                <div class="uneditable-input">
                                                    <i class="icon-file fileupload-exists"></i>
                                                    <span class="fileupload-preview"></span>
                                                </div>
													<span class="btn btn-file">
													<span class="fileupload-new">选择图片</span>
													<span class="fileupload-exists">修改选择</span>
													<input type="file"  class="default" name="file" />

													</span>
                                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">重置</a>
                                                <a href="javascript:;" id="jsPic" class="btn green margin-right-10">
                                                    <i class="icon-upload"></i>上传
                                                </a>
                                            </div>
                                            <input type="hidden" id="picture" value=""/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group" style="height:200px;border:1px solid #ccc;margin-left:180px;text-align:center;vertical-align: middle">
                                        <img id="jsPicImg" style="max-height: 190px;margin:5px;" @if($subject->picture)src="{{{$baseURL}}}/{{{$subject->picture}}}"@endif data="{{{$subject->picture}}}"/>
                                    </div>
                                </div>
                            </div>
                            <?php if($subject->field){$defaultArr = explode(",", $subject->field);}else {$defaultArr = array();};?>
                            <div class="control-group">
                                <label class="control-label">报名需填信息</label>
                                <div class="controls">
                                    @foreach($defaultArr as $field)
                                        <label class="checkbox">
                                            <input type="checkbox" value="{{{$field}}}" checked name="fields"/> {{{$field}}}
                                        </label>
                                    @endforeach
                                    <span class="add-field hide">请输入字段名称 <input type="text" class="m-wrap small" /></span>
                                    <button class="btn mini green jsAddField" type="submit">新增</button>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">活动内容</label>
                                <div class="controls">
                                    <script id="editor" name="editor" type="text/plain" style="margin-right:20px;height:300px;"></script>
                                    <input type="hidden" id="content"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">状态</label>
                                <div class="controls">
                                    <label class="radio">
                                        <input type="radio" name="status" value="{{{\App\Module\BaseModule::STATUS_OPEN}}}" @if($subject->status != \App\Module\BaseModule::STATUS_CLOSE)checked @endif />
                                        发布
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="status" value="{{{\App\Module\BaseModule::STATUS_CLOSE}}}"  @if($subject->status == \App\Module\BaseModule::STATUS_CLOSE)checked @endif />
                                        禁用
                                    </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">备注</label>
                                <div class="controls">
                                    <textarea class="large m-wrap" rows="3" name="remark" id="remark">{{{$subject->remark}}}</textarea>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" id="JsSaveBtn" class="btn blue">保存</button>
                            </div>
                        </div>
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
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-fileupload.js"></script>
    <script type="text/javascript" charset="utf-8" src="{{{$mediaURL}}}ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="{{{$mediaURL}}}ueditor/ueditor.all.min.js"> </script>
    <script src="{{{$jsURL}}}jquery.form.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script>
        var ue;
        jQuery(document).ready(function() {
            App.init();
            if (jQuery().datepicker) {
                $('.date-picker').datepicker({
                    rtl : App.isRTL()
                });
            }
            ue = UE.getEditor('editor');
            var content = '<?php echo $subject->content; ?>';
            ue.ready(function() {
                ue.execCommand('insertHtml', content);
            });
            //上传图片
            $("#jsPic").on('click', function() {
                var form = $("form[name=picUpload]");
                if(! $("form[name=picUpload] input[name=file]").val()) {
                    alert('请选择要上传的图片');
                    return false;
                }
                uploadPic(form, '#jsPicImg');
            });
            $(".icon-remove").on("click", function() {
                $(this).parent().siblings("input").val("");
            });
            $("#JsSaveBtn").on('click', function() {
                updateSubject();
            });

            //新增需填字段
            $(".jsAddField").on('click', function() {
                var $sibling = $(this).siblings(".add-field");
                if($sibling.hasClass("hide")) {
                    $sibling.removeClass("hide");
                    $(this).text("确定");
                }else{
                    var input = $sibling.find("input");
                    var fieldName = $(input).val();
                    if( fieldName) {
                        var html = '<label class="checkbox">';
                        html += '<input type="checkbox" name="fields" class="group-checkable" value="' + fieldName+ '" checked="checked"/>';
                        html += fieldName + '</label>';
                        $sibling.before(html)
                    }
                    $(input).val("");
                    $sibling.addClass("hide");
                    $(this).text("新增");
                    App.initUniform(false);
                }
            });
        });

        var updateSubject = function() {
            var title = $("#title").val();
            var startTime = $("#startTime").val();
            var endTime = $("#endTime").val();
            var picture = $("#jsPicImg").attr('data');
            var remark = $("#remark").val();
            var id = <?php echo $id ; ?>;
            var $status = $("input[name=status]");
            var status = 1;
            $.each($status, function(i, item) {
                var $item = $(item);
                if($item.attr('checked') == 'checked') {
                    status = $item.val();
                }
            });
            var content = ue.getContent();
            var fields = [];
            var $fields = $("input[name=fields]");;
            $.each($fields, function(i, item) {
                var $item = $(item);
                if( $item.attr('checked') == 'checked') {
                    fields.push($item.val());
                }
            });

            var data = {"id": id, "content" : content, "title" : title, "startTime" : startTime, "endTime" : endTime, "picture" : picture, "fields" : fields, "status" : status, "remark" : remark};
            Common.clearError();
            $.ajax({
                'url' : baseURL + 'subject/update',
                'dataType' : 'json',
                'data' : data,
                'type' : 'post',
                'success' : function(result) {
                    Common.checkLogin(result);
                    if(result.status == <?php echo \App\Controllers\BaseController::RESPONSE_CHECK_FAIL; ?>) {
                        Common.checkError(result);
                    }else if(result.status == <?php echo \App\Controllers\BaseController::RESPONSE_FAIL; ?>) {
                        alert(result.msg);
                    }else if(result.status == <?php echo \App\Controllers\BaseController::RESPONSE_OK; ?>) {
                        alert('修改成功！');
                    }else {
                        alert('操作失败！')
                    }

                }

            });
        }
        //上传图片
        function uploadPic(form, target) {
            var options  = {
                url : '/import/picture',
                type : 'post',
                dataType : 'json',
                success:function(json) {
                    if(json.status != 0) {
                        alert(json.result);
                    }else{
                        $(target).attr('src', baseURL+json.result);
                        $(target).attr('data', json.result);
                    }
                }
            };
            form.ajaxSubmit(options);
        }
    </script>
@stop