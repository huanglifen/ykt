@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "内容管理";
        $breadcrumb = array(
                array("内容管理"),
                array("内容类型", $baseURL . '/contentType/index'),
                array("编辑内容类型", $baseURL . '/contentType/update/'.$contentType->id),
        )
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <form id="updateTypeForm" action="#" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">类型编号</label>
                                <div class="controls">
                                    <input type="text" id="number" name="number" value="{{{$contentType->number}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">类型名称</label>
                                <div class="controls">
                                    <input type="text" id="name" name="name" value="{{{$contentType->name}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">显示顺序</label>
                                <div class="controls">
                                    <input type="text" id="sort" name="sort" value="{{{$contentType->sort}}}"
                                           data-content="输入的排序值越小越靠前"  class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" id="JsSaveBtn" class="btn blue">保存</button>
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
    <script type="text/javascript" src="{{{$mediaURL}}}js/chosen.jquery.min.js"></script>
    <script src="{{{$mediaURL}}}js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}jquery.form.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
            var target = $("#updateTypeForm");
            var v = target.validate({
                errorElement: 'span',
                invalidHandler: function () {
                    return false;
                },
                submitHandler: function (form) {
                    var data = target.serialize();
                    data += "&id="+<?php echo $contentType->id ?>;
                    $.ajax({
                        url: baseURL + "contentType/update",
                        dataType: 'json',
                        type: "POST",
                        data: data,
                        success: function (d) {
                            Common.checkLogin(d);
                            if (d.status == 0) {
                                alert("修改成功！");
                            }
                            else {
                                alert("修改失败！");
                            }
                        }
                    });
                    return false;
                },
                rules: {
                    name: {
                        required : true,
                        maxlength : 30
                    },
                    sort : {
                        range : [0, 99]
                    },
                    number : {
                        required : true,
                        maxlength : 50
                    }

                },
                messages: {
                    name:  {
                        required : "请输入类型名称",
                        maxlength : "名称长度不能超过30个字"
                    },
                    sort : {
                        range : '请输入0~99之间的数字'
                    },
                    number : {
                        required : '请输入类型编号',
                        maxlength : '编号长度不能超过50'
                    }
                }
            });

            $("#clearForm").on('click', function() {
                clearForm();
            });
        });

        var clearForm = function() {
            $("#name").val('');
            $("#number").val('');
            $("#sort").val('50');
        }

    </script>
@stop