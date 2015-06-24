@extends("common.right")
@section("context")
    <!-- BEGIN PAGE -->
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            <?php
            $breadTitle="菜单管理";
            $breadcrumb = array(
                    array("权限管理"),
                    array("菜单管理", $baseURL . '/menu/index'),
                    array("编辑菜单", $baseURL . '/menu/update/' . $menu->id));
            ?>
            @include('common.bread')
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box blue">
                        <div class="portlet-body form">
                            <form id="updateMenuForm" action="#" class="form-horizontal">
                                <div class="control-group">
                                    <label class="control-label">菜单名称</label>
                                    <div class="controls">
                                        <input type="text" class="span6 m-wrap" id="name" name="name" value="{{{$menu->name}}}"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">菜单编号</label>
                                    <div class="controls">
                                        <input type="text" class="span6 m-wrap" id="number" name="number" value="{{{$menu->number}}}" disabled/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">上级菜单</label>
                                    <div class="controls">
                                        <input type="text" class="span6 m-wrap" id="parent" name="parent"value="{{{$menu->parent}}}"  disabled/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">URL</label>
                                    <div class="controls">
                                        <input type="text" class="span6 m-wrap" id="url" name="url" value="{{{$menu->url}}}"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">排序</label>
                                    <div class="controls">
                                        <input type="text" id="sort" name="sort" value="{{{$menu->sort}}}"
                                               class="span6 m-wrap popovers" data-trigger="hover"
                                               data-content="输入的排序值越小，菜单越靠前"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">是否显示</label>
                                    <div class="controls">
                                        <label class="radio">
                                            <input type="radio" name="display" value="1" @if($menu->display==\App\Module\MenuModule::MENU_SHOW)checked @endif/>
                                            是
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="display" value="2" @if($menu->display!=\App\Module\MenuModule::MENU_SHOW)checked @endif/>
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
            var target = $("#updateMenuForm");
            var id = '<?php echo $menu->id; ?>';
            var v = target.validate({
                errorElement: 'span',
                invalidHandler: function () {
                    return false;
                },
                submitHandler: function (form) {
                    var data = target.serialize();
                    data +="&id="+id;
                    $.ajax({
                        url: baseURL + "menu/update",
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
                    sort : {
                        range : [0, 99]
                    }

                },
                messages: {
                    name:  {
                        required : "请输入菜单名称",
                        maxlength : "名称长度不能超过10个字"
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
            $("#url").val('');
            $("#sort").val(50);
        }
    </script>
@stop