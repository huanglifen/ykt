@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "新建客服";
        $breadcrumb = array(
                array("站点管理"),
                array("客服管理", $baseURL . '/cs/index'),
                array("新建客服", $baseURL . '/cs/add'))
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <form id="addCsForm" action="#" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">姓名</label>
                                <div class="controls">
                                    <input type="text" class="span6 m-wrap" id="name" name="name"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">客服地区</label>
                                <div class="controls">
                                    <select class="span6 chosen" tabindex="1" id="cityId" name="cityId">
                                        @foreach($city as $c)
                                            <option value="{{{$c->id}}}">{{{$c->name}}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">qq</label>
                                <div class="controls">
                                    <input type="text" class="span6 m-wrap" id="qq" name="qq" />
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
            var target = $("#addCsForm");
            var v = target.validate({
                errorElement: 'span',
                invalidHandler: function () {
                    return false;
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: baseURL + "cs/add",
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
                                alert("添加失败");
                            }
                        }
                    });
                    return false;
                },
                rules: {
                    name: {
                        required : true,
                        maxlength : 10
                    }
                },
                messages: {
                    name:  {
                        required : "请输入名称",
                        maxlength : "名称长度不能超过10个字"
                    }
                }
            });
        });
        $("#clearForm").on('click', function() {
            clearForm();
        });
        var clearForm = function() {
            $("#name").val('');
            $("#qq").val('');
        }
    </script>
@stop