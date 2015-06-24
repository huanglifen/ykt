@extends("common.right")
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "角色管理";
        $breadcrumb = array(
                array("权限管理"),
                array("角色管理", $baseURL . '/role/index'),
                array("编辑角色", $baseURL . '/role/update/'.$role->id))
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <form id="updateRoleForm" action="#" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">角色名称</label>
                                <div class="controls">
                                    <input type="text" class="span6 m-wrap" id="name" name="name" value="{{{$role->name}}}"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">排序</label>
                                <div class="controls">
                                    <input type="text" id="sort" name="sort" value="{{{$role->sort}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"
                                           data-content="输入的排序值越小，角色越靠前"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">角色描述</label>
                                <div class="controls">
                                    <textarea class="large m-wrap" rows="3" id="description" name="description">{{{$role->description}}}</textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">是否启用</label>
                                <div class="controls">
                                    <label class="radio">
                                        <input type="radio" name="status" value="1" @if($role->status != 2) checked @endif/>
                                        是
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="status" value="2" @if($role->status == 2) checked @endif/>
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
            var target = $("#updateRoleForm");
            var id = '<?php echo $role->id; ?>';
            var v = target.validate({
                errorElement: 'span',
                invalidHandler: function () {
                    return false;
                },
                submitHandler: function (form) {
                    var data = target.serialize();
                    data +="&id="+id;
                    $.ajax({
                        url: baseURL + "role/update",
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
                        maxlength : 20
                    },
                    sort : {
                        range : [0, 99]
                    }

                },
                messages: {
                    name:  {
                        required : "请输入角色名称",
                        maxlength : "名称长度不能超过20个字"
                    },
                    sort : {
                        range : '请输入0~99之间的数字'
                    }
                }
            });
        });
    </script>
@stop