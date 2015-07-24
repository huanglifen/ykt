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
                array("数据备份", $baseURL . '/app/index'));
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box">
                    <div class="portlet-body">
                        <div class="clearfix">
                            <form id="jsFileUpload" name="fileUpload" enctype="multipart/form-data">
                                <div class="control-group">
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
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
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
                            alert('上传成功!');
                        }
                    }
                };
                form.ajaxSubmit(options);
            });
        });
    </script>
@stop