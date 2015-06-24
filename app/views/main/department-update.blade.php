@extends("common.right")
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle="菜单管理";
        $breadcrumb = array(
                array("权限管理"),
                array("部门管理", $baseURL . '/department/index'),
                array("编辑部门", $baseURL . '/department/update/' . $department->id));
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <form id="updateDepartmentForm" action="#" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">部门名称</label>
                                <div class="controls">
                                    <input type="text" class="span6 m-wrap" id="name" name="name" value="{{{$department->name}}}"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">部门编号</label>
                                <div class="controls">
                                    <input type="text" class="span6 m-wrap" id="number" name="number" value="{{{$department->number}}}" disabled/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">上级部门</label>
                                <div class="controls">
                                    <input type="text" class="span6 m-wrap" id="parent" name="parent"value="{{{$department->parent}}}"  disabled/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">部门描述</label>
                                <div class="controls">
                                    <input type="text" class="span6 m-wrap" id="description" name="description" value="{{{$department->description}}}"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">排序</label>
                                <div class="controls">
                                    <input type="text" id="sort" name="sort" value="{{{$department->sort}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"
                                           data-content="输入的排序值越小，菜单越靠前"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">是否显示</label>
                                <div class="controls">
                                    <label class="radio">
                                        <input type="radio" name="status" value="{{{\App\Module\DepartmentModule::STATUS_OPEN}}}" @if($department->status==\App\Module\DepartmentModule::STATUS_OPEN)checked @endif/>
                                        是
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="status" value="{{{\App\Module\DepartmentModule::STATUS_CLOSE}}}" @if($department->status!=\App\Module\DepartmentModule::STATUS_OPEN)checked @endif/>
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
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.validate.min.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
            var target = $("#updateDepartmentForm");
            var id = '<?php echo $department->id; ?>';
            var v = target.validate({
                errorElement: 'span',
                invalidHandler: function () {
                    return false;
                },
                submitHandler: function (form) {
                    var data = target.serialize();
                    data +="&id="+id;
                    $.ajax({
                        url: baseURL + "department/update",
                        dataType: 'json',
                        type: "POST",
                        data: data,
                        success: function (d) {
                            Common.checkLogin(d);
                            if (d.status == 0) {
                                alert("修改成功");
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
                        maxlength : 10
                    },
                    description : {
                        maxlength : 30
                    },
                    sort : {
                        range : [0, 99]
                    }

                },
                messages: {
                    name:  {
                        required : "请输入部门名称",
                        maxlength : "名称长度不能超过10个字"
                    },
                    description : {
                        maxlength : "描述长度不能超过30个字"
                    },
                    sort : {
                        range : '请输入0~99之间的数字'
                    }
                }
            });
        });
        $("#clearForm").on('click', function() {
            clearForm();
        });
        var clearForm = function() {
            $("#name").val('');
            $("#description").val('');
            $("#sort").val(50);
        }
    </script>
@stop