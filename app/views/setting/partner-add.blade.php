@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/bootstrap-fileupload.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "新增合作网站";
        $breadcrumb = array(
                array("站点管理"),
                array("合作网站", $baseURL . '/partner/index'),
                array("新增合作网站", $baseURL . '/partner/add'),
        )
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <div id="addProductForm" action="#" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">站点名称</label>
                                <div class="controls">
                                    <input type="text" id="name" name="name"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span10 ">
                                    <form id="jsPicUpload" name="picUpload" enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label">选择图片</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input">
                                                            <i class="icon-file fileupload-exists"></i>
                                                            <span class="fileupload-preview"></span>
                                                        </div>
													<span class="btn btn-file">
													<span class="fileupload-new">选择图片</span>
													<span class="fileupload-exists">修改选择</span>
													<input type="file"  class="default" name="file" />

													</span>
                                                        <a href="#" class="btn fileupload-exists" id="jsReset" data-dismiss="fileupload">重置</a>
                                                        <a href="javascript:;" id="jsPic" class="btn green margin-right-10">
                                                            <i class="icon-upload"></i>上传
                                                        </a>
                                                    </div>
                                                    <input type="hidden" id="picture"/>
                                                </div>

                                            </div>

                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group" style="height:200px;border:1px solid #ccc;margin-left:180px;text-align:center;vertical-align: middle">
                                        <img id="jsPicImg" style="max-height: 190px;margin:5px;" data=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">链接地址</label>
                                <div class="controls">
                                    <input type="text" id="url" name="url" value=""
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">显示顺序</label>
                                <div class="controls">
                                    <input type="text" id="sort" name="sort" value="50"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
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
                                <button type="submit" id="JsSaveBtn" class="btn blue">保存</button>
                                <button type="button" class="btn" id="clearForm">清空</button>
                            </div>
                        </div>
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
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-fileupload.js"></script>
    <script src="{{{$jsURL}}}jquery.form.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            App.init();
            $("#JsSaveBtn").on('click', function() {
                var data = "name=" + $("#name").val();
                data += "&sort=" + $("#sort").val();
                data += "&picture=" + $("#jsPicImg").attr('data');
                data += "&display=" + $("input[name=display]:checked").val();
                data += "&url=" + $("#url").val();

                $(".JsErrorTarget").removeClass('error');
                $(".JsErrorTip").text('').hide();

                $.ajax({
                    url: baseURL + "partner/add",
                    dataType: 'json',
                    type: "POST",
                    data: data,
                    success: function (d) {
                        Common.checkLogin(d);
                        if (d.status == 0) {
                            alert("添加成功");
                            window.location.reload();
                        } else if(d.status == 1001) {
                            Common.checkError(d);
                        }else if(d.status == 1000) {
                            alert(d.result);
                        } else {
                            alert("添加失败");
                        }
                    }
                });
            });

            //上传图片
            $("#jsPic").on('click', function() {
                var form = $("form[name=picUpload]");
                if(! $("form[name=picUpload] input[name=file]").val()) {
                    alert('请选择要上传的图片');
                    return false;
                }

                uploadPic(form, '#jsPicImg');
            });
            $("#clearForm").on('click', function() {
                clearForm();
            });
        });

        var clearForm = function() {
            $("#name").val('');
            $("#sort").val('50');
            $("#jsReset").click();
            $("#jsPicImg").attr('src', baseURL+json.result);
            $("#jsPicImg").attr('data', json.result);
        }

        //上传图片
        function uploadPic(form, target) {
            var options  = {
                url : '/import/picture',
                type : 'post',
                dataType : 'json',
                success:function(json) {
                    if(json.status != 0) {
                        alert(json.result);
                    }else{
                        $(target).attr('src', baseURL+json.result);
                        $(target).attr('data', json.result);
                    }
                }
            };
            form.ajaxSubmit(options);
        }
    </script>
@stop