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
        $breadTitle = "合作网站";
        $breadcrumb = array(
                array("站点管理"),
                array("合作网站", $baseURL . '/partner/index'));
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box">
                    <div class="portlet-body">
                        <div class="clearfix">
                            <div class="btn-group">
                                <a href="{{{$baseURL}}}/partner/add" class="btn margin-right-10 green">
                                    新增<i class="icon-plus"></i>
                                </a>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="datatable_partner">
                            <thead>
                            <tr>
                                <th style="width:15%">名称</th>
                                <th style="width:20%">图片</th>
                                <th style="width:20%">路径</th>
                                <th style="width:15%">链接地址</th>
                                <th style="width:10%">显示顺序</th>
                                <th style="width:10%">是否显示</th>
                                <th style="width:10%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
    <script src="{{{$mediaURL}}}js/select2.min.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/DT_bootstrap.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/table-managed.js" type="text/javascript"></script>
    <script>
        $(function () {
            var displayArr = {"1":"是", "2" : "否"};
            App.init();
            var tbl = $('#datatable_partner').dataTable({
                "sScrollXInner": "100%",
                "bServerSide": true,
                "bDestroy": false,
                'bPaginate': true,
                "bProcessing": true,
                "bDestroy": true,
                "bLengthChange": true,
                "bSort": false,
                "bFilter": false,
                "aLengthMenu": [
                    [10, 15, 20, -1],
                    [10, 15, 20, "All"] // change per page values here
                ],
                "iDisplayLength": 10,
                "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sProcessing": "正在加载中......",
                    "sLengthMenu": "每页显示 _MENU_ 条记录",
                    "sZeroRecords": "没有数据！",
                    "sEmptyTable": "表中无数据存在！",
                    "sInfo": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条记录",
                    "sInfoEmpty": "显示0到0条记录",
                    "sInfoFiltered": "",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上一页",
                        "sNext": "下一页",
                        "sLast": "末页"
                    }
                },
                "fnDrawCallback": function () {
                    App.initUniform();
                },
                "sAjaxDataProp": 'partners',
                "sAjaxSource": baseURL + 'partner/partner',
                "aoColumns": [{
                    "mData": 'name',
                    "aTargets": [0]
                },{
                    "mData": null,
                    "aTargets": [1],
                    "fnRender" : function(obj) {
                        return "<img src= '" + baseURL + obj.aData.picture + "'/>"
                    }
                },{
                    "mData": null,
                    "aTargets": [2],
                    "fnRender" : function(obj) {
                        return '<div title="' + obj.aData.picture + '">' + obj.aData.picture + '</div>';
                    }
                }, {
                    "mData": "url",
                    "aTargets": [3]
                },{
                    "mData": "sort",
                    "aTargets": [4]
                },{
                    "mData": "display",
                    "aTargets": [5],
                    "fnRender" : function(obj) {
                        return displayArr[obj.aData.display];
                    }
                },{
                    "mData": null,
                    "aTargets": [6],
                    "fnRender" : function(obj) {
                        return '<span data-id="' + obj.aData.id + '"><a title="编辑" href="' + baseURL + 'partner/update/' + obj.aData.id + '" class="btn mini green margin-right-10"><i class="icon-edit"></i></a><a title="删除" href="javascript:;" class="JsDelete btn mini red"><i class="icon-trash"></i></a></span>';
                    }
                }]
            });
            $("body").on('click','.JsDelete', function(){
                if(! confirm('确定要删除该合作网站？')) {
                    return false;
                }
                var id = $(this).parent().attr('data-id');
                $.ajax({
                    'type' : 'post',
                    'dataType' : 'json',
                    'data' : 'id='+id,
                    'url' : baseURL + 'partner/delete',
                    'success' : function(json) {
                        Common.checkLogin(json);
                        if(json.status == 0) {
                            alert('删除成功！');
                            window.location.reload();
                        }else{
                            alert(json.result);
                        }
                    }
                });
            });
        });
    </script>
@stop