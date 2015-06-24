@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "用户管理";
        $breadcrumb = array(
                array("权限管理"),
                array("用户管理", $baseURL . '/user/index'),
                array("新建用户", $baseURL . '/user/add'))
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <form id="addUserForm" action="#" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">账号名称</label>
                                <div class="controls">
                                    <input type="text" class="span6 m-wrap" id="name" name="name"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">真实姓名</label>
                                <div class="controls">
                                    <input type="text" class="span6 m-wrap" id="realName" name="realName" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">密码</label>
                                <div class="controls">
                                    <input type="password" class="span6 m-wrap" id="password" name="password" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">确认密码</label>
                                <div class="controls">
                                    <input type="password" class="span6 m-wrap" id="passwordConfirm" name="passwordConfirm" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">角色</label>
                                <div class="controls">
                                    <select class="span6 chosen" tabindex="1" id="roleId" name="roleId">
                                        @if(count($roles) == 0)
                                            <option value="0">请先创建角色</option>
                                        @else
                                            @foreach($roles as $role)
                                            <option value="{{{$role->id}}}">{{{$role->name}}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">部门</label>
                                <div class="controls">
                                    <select class="span6 chosen" tabindex="1" id="departmentId" name="departmentId">
                                        <option value="0">无</option>
                                       @foreach($departments as $department)
                                          <option value="{{{$department->id}}}">@if($department->level > 4)&nbsp;&nbsp;@elseif($department->level > 2)&nbsp;@endif{{{$department->name}}}</option>
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">手机号</label>
                                <div class="controls">
                                    <input type="text" class="span6 m-wrap" id="tel" name="tel" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">电子邮箱</label>
                                <div class="controls">
                                    <input type="text" id="mail" name="mail"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">是否启用</label>
                                <div class="controls">
                                    <label class="radio">
                                        <input type="radio" name="status" value="1" checked />
                                        是
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="status" value="2" />
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
            var target = $("#addUserForm");
            var v = target.validate({
                errorElement: 'span',
                invalidHandler: function () {
                    return false;
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: baseURL + "user/add",
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
                                Common.checkError(d);
                                alert("添加失败");
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
                    realName: {
                        required : true,
                        maxlength : 30
                    },
                    password: {
                        required : true,
                        maxlength : 50,
                        minlength : 6
                    },
                    passwordConfirm: {
                        required : true,
                        maxlength : 50,
                        equalTo : '#password'
                    },
                    roleName: {
                        required : true,
                        min : 1
                    },
                    departmentName: {
                        required : true
                    },
                    mail: {
                        email : true
                    },
                    tel : {
                        minlength : 6,
                        maxlength : 20
                    }
                },
                messages: {
                    name:  {
                        required : "请输入账号名称",
                        maxlength : "名称长度不能超过30个字"
                    },
                    realName: {
                        required : '请输入真实姓名',
                        maxlength : "姓名长度不能超过30个字"
                    },
                    password: {
                        required : "请输入密码",
                        maxlength : "密码长度不能超过50个字符",
                        minlength : "密码长度至少6个字符"
                    },
                    passwordConfirm: {
                        required : "请确认密码",
                        maxlength : "密码长度不能超过50个字符",
                        equalTo : '两次密码输入不一致'
                    },
                    roleName: {
                        required : "请选择角色",
                        min : "请先创建角色"
                    },
                    departmentName: {
                        required : "请选择部门"
                    },
                    mail: {
                        email : "请输入正确的邮箱地址"
                    },
                    tel : {
                        minlength : '最小长度为7',
                        maxlength : '最大长度为15'
                    }
                }
            });
        });
        $("#clearForm").on('click', function() {
            clearForm();
        });
        var clearForm = function() {
            $("#name").val('');
            $("#password").val('');
            $("#passwordConfirm").val('');
            $("#realName").val('');
            $("#roleName").val('');
            $("#departmentName").val('');
            $("#tel").val('');
            $("#mail").val('');
        }
    </script>
@stop