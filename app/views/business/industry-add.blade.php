@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "行业管理";
        $breadcrumb = array(
                array("商家信息"),
                array("行业管理", $baseURL . '/industry/index'),
                array("新增行业", $baseURL . '/industry/add'),
        )
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <form id="addIndustryForm" action="#" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">行业名称</label>
                                <div class="controls">
                                    <input type="text" id="name" name="name" class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">所属父行业</label>
                                <div class="controls">
                                    <select class="span6 chosen" tabindex="1" id="parentId" name="parentId">
                                        <option value="0">无</option>
                                        @foreach($parents as $key => $parent)
                                            <option value="{{{$parent->id}}}">{{{$parent->name}}}</option>
                                        @endforeach
                                    </select>
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
    <script type="text/javascript" src="{{{$mediaURL}}}js/chosen.jquery.min.js"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.validate.min.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
            var target = $("#addIndustryForm");
            var v = target.validate({
                errorElement: 'span',
                invalidHandler: function () {
                    return false;
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: baseURL + "industry/add",
                        dataType: 'json',
                        type: "POST",
                        data: target.serialize(),
                        success: function (d) {
                            Common.checkLogin(d);
                            if (d.status == 0) {
                                alert("添加成功");
                                window.location.reload();
                            }
                            else {
                                alert(d.result);
                            }
                        }
                    });
                    return false;
                },
                rules: {
                    name: {
                        required : true,
                        maxlength : 20
                    }
                },
                messages: {
                    name:  {
                        required : "请输入行业名称",
                        maxlength : "名称长度不能超过20个字"
                    }
                }
            });
            $("#clearForm").on('click', function() {
                clearForm();
            });
            var clearForm = function() {
                $("#name").val('');
            }
        });
    </script>
@stop