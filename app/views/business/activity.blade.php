@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/select2_metro.css" />
    <link rel="stylesheet" href="{{{$mediaURL}}}css/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/halflings.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "商户管理";
        $breadcrumb = array(
                array("商家信息"),
                array("商户管理", $baseURL . '/business/index'),
                array("活动列表", $baseURL . '/activity/index/'.$businessId));
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
                                <a href="{{{$baseURL}}}/activity/add/{{{$businessId}}}" class="btn margin-right-10 green">
                                    新增<i class="icon-plus"></i>
                                </a>
                            </div>

                            <div class="row-fluid span6 pull-right" style="margin-bottom: 20px;">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label"><h4>商户名称：{{{$business->name}}}</h4></label>
                                    </div>
                                </div>
                                <div class="span3">
                                    <div class="control-group">
                                        <form action="#" class="form-search">
                                            <div class="input-append">
                                                <input class="m-wrap" type="text" id="keyword" placeholder="活动标题"><button class="btn green btnSearch" type="button" id="btnSearch" >搜索</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="datatable_activity">
                            <thead>
                            <tr>
                                <th style="width:25%">编号</th>
                                <th style="width:25%">活动名称</th>
                                <th style="width:30%">开始时间 - 结束时间</th>
                                <th style="width:20%">操作</th>
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
    <script type="text/javascript" src="{{{$mediaURL}}}js/chosen.jquery.min.js"></script>
    <script src="{{{$mediaURL}}}js/select2.min.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/DT_bootstrap.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}common.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/table-managed.js" type="text/javascript"></script>
    <script>
        $(function () {
            App.init();
            var businessId = <?php echo $businessId; ?>;
            var tbl = $('#datatable_activity').dataTable({
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
                "sAjaxDataProp": 'activity',
                "sAjaxSource": baseURL + 'activity/activity/'+businessId,
                "aoColumns": [{
                    "mData": "id",
                    "aTargets": [0]
                },{
                    "mData": "title",
                    "aTargets": [1]
                },{
                    "mData": null,
                    "aTargets": [2],
                    "fnRender" : function(obj) {
                        var begin = Common.formatDate(obj.aData.start_time);
                        var end = Common.formatDate(obj.aData.end_time);
                        return begin+" - "+end;
                    }
                },{
                    "mData": null,
                    "aTargets": [3],
                    "fnRender" : function(obj) {
                        return '<span data-id="' + obj.aData.id + '"><a title="编辑" href="' + baseURL + 'activity/update/'+businessId+"/" + obj.aData.id + '" class="btn mini green margin-right-10"><i class="icon-edit"></i></a><a title="删除" href="javascript:;" class="JsDelete btn mini red"><i class="icon-trash"></i></a></span>';
                    }
                }]
            });
            $("#btnSearch").click(function () {
                var oSettings = tbl.fnSettings();
                var keyword = $("#keyword").val();
                oSettings.sAjaxSource = baseURL + "activity/activity/"+businessId+"?keyword=" + keyword;
                oSettings._iDisplayStart = 0;
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });
            $("body").on('click','.JsDelete', function(){
                if(! confirm('确定要删除该活动？')) {
                    return false;
                }
                var id = $(this).parent().attr('data-id');
                $.ajax({
                    'type' : 'post',
                    'dataType' : 'json',
                    'data' : 'id='+id,
                    'url' : baseURL + 'activity/delete',
                    'success' : function(json) {
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