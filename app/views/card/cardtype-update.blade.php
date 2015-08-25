@extends("common.right")
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle="卡类型管理";
        $breadcrumb = array(
                array("卡片管理"),
                array("卡类型管理", $baseURL . '/card/type'),
                array("编辑类型", $baseURL . '/card/type-update/' . $cardtype->id));
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
                                        <input type="text" id="name" name="name" value="{{{$cardtype->name}}}"
                                               class="span6 m-wrap popovers" data-trigger="hover"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">操作类别</label>
                                    <div class="controls">
                                        @foreach($types as $key => $type)
                                            <label class="checkbox">
                                                <input type="checkbox" name="type[]" value="{{{$key}}}" @if(in_array($key, $cardtype->type)) checked @endif/>
                                                {{{$type}}}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">排序</label>
                                    <div class="controls">
                                        <input type="text" id="sort" name="sort" value="{{{$cardtype->sort}}}"
                                               class="span6 m-wrap popovers" data-trigger="hover"/>
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
            var target = $("#updateTypeForm");
            var id = '<?php echo $cardtype->id; ?>';
            var v = target.validate({
                errorElement: 'span',
                invalidHandler: function () {
                    return false;
                },
                submitHandler: function (form) {
                    var data = target.serialize();
                    data +="&id="+id;
                    $.ajax({
                        url: baseURL + "card/type-update",
                        dataType: 'json',
                        type: "POST",
                        data: data,
                        success: function (d) {
                            Common.checkLogin(d);
                            if (d.status == 0) {
                                alert("修改成功");
                            }else {
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
                        range : [0, 99]
                    }

                },
                messages: {
                    name:  {
                        required : "请输入类型名称",
                        maxlength : "名称长度不能超过20个字"
                    },
                    sort : {
                        required : "请输入排序值",
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