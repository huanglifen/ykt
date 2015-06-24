@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/select2_metro.css" />
    <link rel="stylesheet" href="{{{$mediaURL}}}css/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/halflings.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "日志查询";
        $breadcrumb = array(
                array("登录管理"),
                array("日志查询", $baseURL . '/log/index'));
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box">
                    <div class="portlet-body">
                        <div class="clearfix">
                            <form action="#" class="form-search ">
                                <div class="row-fluid" style="margin-bottom: 20px;">
                                    <div class="span5 ">
                                        <div class="control-group">
                                            <label class="control-label " style="float: left;width:63px;padding-top:5px;">账号</label>
                                            <div class="controls">
                                                <select class="span6 chosen" tabindex="1" id="userId" name="userId">
                                                    <option value="0">无</option>
                                                        @foreach($users as $user)
                                                            <option value="{{{$user->id}}}">{{{$user->name}}}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row-fluid">
                                    <div class="span4">
                                        <div class="control-group">
                                            <label class="control-label">开始时间</label>
                                            <div class="controls input-append">
                                                <input class="m-wrap m-ctrl-medium date-picker" id="beginTime" readonly size="16" type="text" value=""  placeholder="请输入开始时间"/>
                                                <span class="add-on"><i class="icon-remove"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span5">
                                        <div class="control-group">
                                        <label class="control-label">结束时间</label>
                                        <div class="controls input-append">
                                            <input class="m-wrap m-ctrl-medium date-picker" id="endTime"readonly size="16" type="text" value=""  placeholder="请输入结束时间"/>
                                            <span class="add-on"><i class="icon-remove"></i></span>
                                            <button class="btn green"  type="button" id="btnSearch">搜索</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <table class="table table-striped table-bordered table-hover" id="datatable_logs">
                            <thead>
                            <tr>
                                <th style="width:20%">账号</th>
                                <th style="width:20%">角色</th>
                                <th style="width:20%">部门</th>
                                <th style="width:20%">操作时间</th>
                                <th style="width:20%">操作内容</th>
                                <th style="width:9%">结果</th>
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
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/daterangepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-timepicker.js"></script>
    <script src="{{{$mediaURL}}}js/select2.min.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/DT_bootstrap.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/table-managed.js" type="text/javascript"></script>
    <script>
        $(function () {
            var statusArr = {"1":"成功", "2" : "失败", "0":"成功"};
            App.init();
            if (jQuery().datepicker) {
                $('.date-picker').datepicker({
                    rtl : App.isRTL()
                });
            }

            var tbl = $('#datatable_logs').dataTable({
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
                "sAjaxDataProp": 'logs',
                "sAjaxSource": baseURL + 'log/logs',
                "aoColumns": [{
                    "mData": "accountName",
                    "aTargets": [0]
                }, {
                    "mData": "roleName",
                    "aTargets": [1]
                }, {
                    "mData": "departmentName",
                    "aTargets": [2]
                }, {
                    "mData": "time",
                    "aTargets": [3]
                }, {
                    "mData": "content",
                    "aTargets": [4]
                }, {
                    "mData": "result",
                    "aTargets": [5],
                    "fnRender" : function(obj) {
                        return '<button type="button" class="btn mini" data-id="' + obj.aData.id + '">' + statusArr[obj.aData.result] + '</button>'
                    }
                }]
            });

            $("#btnSearch").click(function () {
                var oSettings = tbl.fnSettings();
                var userId = $("#userId").val();
                var beginTime = $("#beginTime").val();
                var endTime = $("#endTime").val();
                oSettings.sAjaxSource = baseURL + "log/logs?userId=" + userId + "&beginTime=" + beginTime + "&endTime=" + endTime;
                oSettings._iDisplayStart = 0;
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });
            $(".icon-remove").on("click", function() {
                $(this).parent().siblings("input").val("");
            });
        });
    </script>
@stop