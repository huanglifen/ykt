@extends("common.right")
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "修改密码";
        $breadcrumb = array(
                array("登录管理"),
                array("修改密码", $baseURL . '/user/password'))
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <form id="updatePasswordForm" action="#" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">原密码</label>
                                <div class="controls">
                                    <input type="password" class="span6 m-wrap" id="password" name="password"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">新密码</label>
                                <div class="controls">
                                    <input type="password" id="newpassword" name="newpassword"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">确认密码</label>
                                <div class="controls">
                                    <input type="password" id="newpassword_confirmation" name="newpassword_confirmation"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn blue">提交</button>
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
            var target = $("#updatePasswordForm");
            var v = target.validate({
                errorElement: 'span',
                invalidHandler: function () {
                    return false;
                },
                submitHandler: function (form) {
                    var data = target.serialize();
                    $.ajax({
                        url: baseURL + "user/password",
                        dataType: 'json',
                        type: "POST",
                        data: data,
                        success: function (d) {
                            if (d.status == 0) {
                                alert("修改成功");
                                window.location.reload();
                            }
                            else {
                                Common.checkError(d);
                                alert("修改失败");
                            }
                        }
                    });
                    return false;
                },
                rules: {
                    password: {
                        required : true
                    },
                    newpassword: {
                        required : true,
                        maxlength : 50,
                        minlength : 6
                    },
                    newpassword_confirmation: {
                        required : true,
                        equalTo : '#newpassword'
                    }
                },
                messages: {
                    password:  {
                        required : "请输入原密码"
                    },
                    newpassword: {
                        required : "请输入新密码",
                        maxlength : "密码长度不能超过50个字符",
                        minlength : "密码长度至少6个字符"
                    },
                    newpassword_confirmation: {
                        required : "请确认新密码",
                        equalTo : '两次密码输入不一致'
                    }
                }
            });
        });
        $("#clearForm").on('click', function() {
            clearForm();
        });
        var clearForm = function() {
            $("#password").val('');
            $("#newpassword").val('');
            $("#newpassword_confirmation").val('');
        }
    </script>
@stop