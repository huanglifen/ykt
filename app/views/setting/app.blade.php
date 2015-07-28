@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/select2_metro.css" />
    <link rel="stylesheet" href="{{{$mediaURL}}}css/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/halflings.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/bootstrap-fileupload.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "站点管理";
        $breadcrumb = array(
                array("站点管理"),
                array("APP发布", $baseURL . '/app/index'));
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <div id="addProductForm" action="#" class="form-horizontal">
                            <div class="row-fluid">
                                <div class="span10 ">
                                    <form id="jsFileUpload" name="fileUpload" enctype="multipart/form-data">
                                        <div class="control-group">
                                            <label class="control-label">上传APP</label>
                                            <div class="controls">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="input-append">
                                                        <div class="uneditable-input">
                                                            <i class="icon-file fileupload-exists"></i>
                                                            <span class="fileupload-preview"></span>
                                                        </div>
													<span class="btn btn-file">
													<span class="fileupload-new">选择APP</span>
													<span class="fileupload-exists">修改选择</span>
													<input type="file" class="default" name="file" />
													</span>
                                                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">重置</a>
                                                        <a href="javascript:;" id="jsImport" class="btn green margin-right-10">
                                                            <i class="icon-upload"></i>开始导入
                                                        </a>
                                                    </div>
                                                </div>
                                                @if($app->path != '')
                                                    <div class="alert alert-success" id="JsPath" >当前路径： {{{$app->path or ''}}}</div>
                                                @else
                                                    <div  id="JsPath" class="alert">您还未上传APP</div>
                                                @endif
                                            </div>
                                        </div>
                                        <input type="hidden" id="path" name="path" value="{{{$app->url or ''}}}"
                                               class="span6 m-wrap popovers" data-trigger="hover"/>
                                    </form>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">备注</label>
                                <div class="controls">
                                    <input type="text" id="remark" name="remark" value="{{{$app->remark or ''}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">版本</label>
                                <div class="controls">
                                    <input type="text" id="version" name="version" value="{{{$app->version or ''}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">下载链接</label>
                                <div class="controls">
                                    <input type="text" id="appUrl" name="appUrl" value="{{{$app->url or ''}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">分享项</label>
                                <div class="controls">
                                    <input type="text" id="share" name="share" value="{{{$app->share or ''}}}"
                                           class="span6 m-wrap popovers" data-trigger="hover"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" id="JsSaveBtn" class="btn blue">保存</button>
                                <button type="button" class="btn" id="clearForm">清空</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->
@stop
@section('otherJs')
    <script src="{{{$mediaURL}}}js/select2.min.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/DT_bootstrap.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-fileupload.js"></script>
    <script src="{{{$mediaURL}}}js/table-managed.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}jquery.form.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script>
        $(function () {
            App.init();
            //上传APP
            $("#jsImport").on('click', function() {
                if(! $("input[name=file]").val()) {
                    alert('请选择要上传的APP');
                    return false;
                }
                var form = $("form[name=fileUpload]");
                var options  = {
                    url : '/app/app',
                    type : 'post',
                    dataType : 'json',
                    success:function(json) {
                        if(json.status != 0) {
                            alert(json.result);
                        }else{
                            $("#JsPath").addClass("alert-success").text("当前APP路径：" + json.result);
                            $("#path").val(json.result);
                        }
                    }
                };
                form.ajaxSubmit(options);
            });

            $("#JsSaveBtn").on('click', function() {
                var data = "path=" + $("#path").val();
                data += "&remark=" + $("#remark").val();
                data += "&version=" + $("#version").val();
                data += "&url=" + $("#appUrl").val();
                data += "&share=" + $("#share").val();
                $.ajax({
                    'dataType' : 'json',
                    'type' : 'post',
                    'data' : data,
                    'url' : baseURL + "app/add",
                    'success' : function(d) {
                        if(d.status == 0) {
                            alert('发布成功！');
                        }else{
                            if(d.status == 1001) {
                                Common.checkError(d);
                            }else if(d.status == 1000) {
                                alert(d.result);
                            }else{
                                alert('发布失败，请重试！');
                            }
                        }
                    }
                });
            });
        });
    </script>
@stop