@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/select2_metro.css" />
    <link rel="stylesheet" href="{{{$mediaURL}}}css/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/halflings.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "数据备份";
        $breadcrumb = array(
                array("站点管理"),
                array("数据备份", $baseURL . '/dump/index'));
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <div class="portlet box">
                    <div class="portlet box">
                        <div class="portlet-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th colspan="2" style="text-align:center;font-size:18px;font-weight: bold;">数据库备份</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td  style="text-align:center;">
                                        <a href="javascript:;" class="btn green" id="jsDump">
                                            数据备份
                                        </a>
                                    </td>
                                    <td  style="text-align:center;">
                                        <a href="javascript:;" class="btn  green" id="jsRecover">
                                            数据恢复
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan = '2'  style="text-align:center; color:#ff0000;">
                                        <span id="jsResult" ></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="portlet box">
                        <div class="portlet-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>文件名</th>
                                    <th>文件类型</th>
                                    <th>文件大小</th>
                                    <th>备份路径</th>
                                    <th>最近备份时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr id="jsTableResult">
                                    <td>
                                        {{{$fileName}}}
                                    </td>
                                    <td>
                                        {{{$ext}}}
                                    </td>
                                    <td>
                                        {{{$dump->size ? $dump->size ."kb" : ''}}}
                                    </td>
                                    <td>
                                        {{{$path}}}
                                    </td>
                                    <td>
                                        {{{$dump->created_at}}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
    <script src="{{{$mediaURL}}}js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/DT_bootstrap.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/table-managed.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script>
        $(function () {
            App.init();
            //数据备份
            $("#jsDump").on('click', function() {
                $.ajax({
                    'dataType' : 'json',
                    'type' : 'post',
                    'url' : baseURL + 'dump/dump',
                    'success' : function(d) {
                        Common.checkLogin(d);
                        if(d.status == 0) {
                            alert('备份成功');
                            window.location.reload();
                        }else{
                            alert('备份失败！')
                            $("#jsResult").text('备份失败！');
                        }
                    }
                })
            });

            //数据恢复
            $("#jsRecover").on('click', function() {
                if(! confirm("确定要将数据恢复到最近一次备份！")) {
                    return  false;
                }
                $("#jsResult").text("数据备份中，请耐心等待！");
                $.ajax({
                    'dataType' : 'json',
                    'type' : 'post',
                    'url' : baseURL + 'dump/recovery',
                    'success' : function(d) {
                        Common.checkLogin(d);
                        if(d.status == 0) {
                            alert('恢复数据成功');
                            $("#jsResult").text("数据恢复成功");
                        }else{
                            alert('恢复数据失败！')
                            $("#jsResult").text(d.result);
                        }
                    }
                })
            })
        });
    </script>
@stop