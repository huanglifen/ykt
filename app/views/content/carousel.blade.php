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
        $breadTitle = "内容管理";
        $breadcrumb = array(
                array("内容管理"),
                array("ETC和旅游页广告", $baseURL . '/carousel/index/0'));
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
                                <a href="{{{$baseURL}}}/carousel/add/0" class="btn margin-right-10 green">
                                    新增<i class="icon-plus"></i>
                                </a>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="datatable_carousel">
                            <thead>
                            <tr>
                                <th style="width:25%">图片</th>
                                <th style="width:25%">路径</th>
                                <th style="width:17%">链接</th>
                                <th style="width:8%">类型</th>
                                <th style="width:5%">顺序</th>
                                <th style="width:10%">备注</th>
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
            var typeArr = {"2" : "ETC页", "3" : "旅游页"};
            App.init();
            var tbl = $('#datatable_carousel').dataTable({
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
                "sAjaxDataProp": 'carousel',
                "sAjaxSource": baseURL + 'carousel/carousel?type=0',
                "aoColumns": [{
                    "mData": null,
                    "aTargets": [0],
                    "fnRender" : function(obj) {
                        return "<img style='height:40px;' src='"+baseURL+obj.aData.picture+"'/>"
                    }
                }, {
                    "mData": null,
                    "aTargets": [1],
                    "fnRender" : function(obj) {
                        return "<span title='"+obj.aData.picture+"'>"+obj.aData.picture+"</span>";
                    }
                }, {
                    "mData": null,
                    "aTargets": [2],
                    "fnRender" : function(obj) {
                        return "<span title='"+obj.aData.url+"'>"+obj.aData.url+"</span>";
                    }
                }, {
                    "mData": null,
                    "aTargets": [2],
                    "fnRender" : function(obj) {
                        return typeArr[obj.aData.type];
                    }
                }, {
                    "mData": "sort",
                    "aTargets": [3]
                },{
                    "mData": null,
                    "aTargets": [4],
                    "fnRender" : function(obj) {
                        return "<span title='"+obj.aData.remark+"'>"+obj.aData.remark+"</span>";;
                    }
                }, {
                    "mData": null,
                    "aTargets": [5],
                    "fnRender" : function(obj) {
                        return '<span data-id="' + obj.aData.id + '"><a title="编辑" href="' + baseURL + 'carousel/update/' + obj.aData.id + '" class="btn mini green margin-right-10"><i class="icon-edit"></i></a><a title="删除" href="javascript:;" class="JsDelete btn mini red"><i class="icon-trash"></i></a></span>';
                    }
                }]
            });
            $("body").on('click','.JsDelete', function(){
                if(! confirm('确定要删除该轮播图？')) {
                    return false;
                }
                var id = $(this).parent().attr('data-id');
                $.ajax({
                    'type' : 'post',
                    'dataType' : 'json',
                    'data' : 'id='+id,
                    'url' : baseURL + 'carousel/delete',
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