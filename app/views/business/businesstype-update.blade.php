@extends("common.right")
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "修改促销类型";
        $breadcrumb = array(
                array("商家管理"),
                array("商户促销类型", $baseURL . '/business-type/index'),
                array("修改类型", $baseURL . '/business-type/update/' . $id),
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
                                <label class="control-label">名称</label>
                                <div class="controls">
                                    <input type="text" id="name" name="name" value="{{{$businessType->name}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">排序</label>
                                <div class="controls">
                                    <input type="text" id="sort" name="sort" value="{{{$businessType->sort}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">是否显示</label>
                                <div class="controls">
                                    <label class="radio">
                                        <input type="radio" name="status" value="{{{\App\Module\BaseModule::STATUS_OPEN}}}" @if($businessType->status != \App\Module\BaseModule::STATUS_CLOSE) checked @endif/>
                                        是
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="status" value="{{{\App\Module\BaseModule::STATUS_CLOSE}}}" @if($businessType->status == \App\Module\BaseModule::STATUS_CLOSE) checked @endif/>
                                        否
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{{$id}}}"/>
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
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.validate.min.js" type="text/javascript"></script>
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
                    $.ajax({
                        url: baseURL + "business-type/update",
                        dataType: 'json',
                        type: "POST",
                        data: target.serialize(),
                        success: function (d) {
                            Common.checkLogin(d);
                            if (d.status == 0) {
                                alert("修改成功");
                                clearForm();
                            }
                            else {
                                alert("修改失败");
                            }
                        }
                    });
                    return false;
                },
                rules: {
                    name: {
                        required : true,
                        maxlength : 20
                    },
                    sort : {
                        required : true,
                        range : [1, 99]
                    }

                },
                messages: {
                    name:  {
                        required : "请输入类型名称",
                        maxlength : "名称长度不能超过20个字"
                    },
                    sort : {
                        required : "请输入排序值",
                        range : '请输入1~99之间的数字'
                    }
                }
            });
        });
        $("#clearForm").on('click', function() {
            clearForm();
        });
        var clearForm = function() {
            $("#name").val('');
            $("#sort").val(50);
        }
    </script>
@stop