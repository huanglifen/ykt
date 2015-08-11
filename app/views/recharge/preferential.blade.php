@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/select2_metro.css" />
    <link rel="stylesheet" href="{{{$mediaURL}}}css/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/halflings.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/datetimepicker.css" />
    <style>
        .min-controls {
            margin-left:125px !important;
        }
        .input-append.min-controls {
            margin-left : 10px !important;
        }
        .min-label {
            width : 100px !important;
        }
    </style>
@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "查询交易";
        $breadcrumb = array( );
        $breadcrumb[] = array("交易管理");
        if($tradeTyp == 1) {
            $breadcrumb[] = array("充值优惠", $baseURL . '/preferential/index/'.$tradeTyp);
        }elseif($tradeTyp == 2) {
            $breadcrumb[] = array("消费优惠", $baseURL . '/preferential/index/'.$tradeTyp);
        }else{
            $breadcrumb[] = array("优惠记录", $baseURL . '/preferential/index/'.$tradeTyp);
        }
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box">
                    <div class="portlet-body">
                        <div class="clearfix">
                            <form action="#" class="form-horizontal">
                                <div class="row-fluid">
                                    <div class="span8">
                                        <div class="control-group ">
                                            <label class="control-label min-label ">优惠策略</label>
                                            <div class="controls min-controls">
                                                <div class="span5">
                                                    <select class="chosen" tabindex="1" id="strategy">
                                                        @foreach($strategy as $key => $value)
                                                            <option value="{{{$key}}}">{{{$value}}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="span5">
                                                <input type="text" id="preferMount" name="preferMount"
                                                       class="m-wrap popovers" placeholder="优惠金额" data-trigger="hover"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <label class="control-label min-label">优惠来源</label>
                                        <div class="controls min-controls">
                                            <select class="chosen span9" tabindex="1" id="source" name="source">
                                                @foreach($source as $key => $value)
                                                    <option value="{{{$key}}}">{{{$value}}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span8">
                                        <div class="control-group ">
                                            <label class="control-label min-label">优惠时间</label>
                                            <div class="controls min-controls">
                                                <div class="span5 input-append ">
                                                    <input class="m-wrap m-ctrl-medium date-picker" id="startTime" readonly type="text" value=""  placeholder="开始时间"/>
                                                    <span class="add-on"><i class="icon-remove"></i></span>
                                                </div>
                                                <div class="span5 input-append">
                                                    <input class="m-wrap m-ctrl-medium date-picker" id="endTime"readonly type="text" value=""  placeholder="结束时间"/>
                                                    <span class="add-on"><i class="icon-remove"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                            <label class="control-label min-label">优惠对象</label>
                                            <div class="controls min-controls">
                                                <select class="chosen span9" tabindex="1" id="target" name="target">
                                                    @foreach($target as $key => $value)
                                                        <option value="{{{$key}}}">{{{$value}}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span8">
                                        <div class="control-group ">
                                            <label class="control-label min-label">最低/最高限额</label>
                                            <div class="controls min-controls">
                                                <div class="span5">
                                                <input type="text" id="lowest" name="lowest"
                                                       class="m-wrap popovers" data-trigger="hover" placeholder="最低限额"/>
                                                </div>
                                                <div class="span5">
                                                <input type="text" id="highest" name="highest"
                                                       class="m-wrap popovers" data-trigger="hover" placeholder="最高限额"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <div class="control-group">
                                            <label class="control-label min-label">活动名称</label>
                                            <div class="controls min-controls">
                                                <input type="text" id="name" name="name"
                                                       class="m-wrap popovers span12" data-trigger="hover" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span1"></div>
                                    <button class="btn green"  type="button" id="btnSearch">查询</button>
                                    <button class="btn green"  type="button" id="btnDownloadExcel">下载Excel</button>
                                    <button class="btn green"  type="button" id="btnDownloadTxt">下载txt</button>
                                </div>
                            </form>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="datatable_cs">
                            <thead>
                            <tr>
                                <th style="width:8%">创建时间</th>
                                <th style="width:8%">创建人</th>
                                <th style="width:7%">活动名称</th>
                                <th style="width:9%">开始时间</th>
                                <th style="width:9%">结束时间</th>
                                <th style="width:7%">交易类型</th>
                                <th style="width:7%">支付方式</th>
                                <th style="width:7%">支付金额</th>
                                <th style="width:7%">优惠来源</th>
                                <th style="width:7%">优惠金额</th>
                                <th style="width:8%">总交易金额</th>
                                <th style="width:7%">最低限额</th>
                                <th style="width:7%">最高限额</th>
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
            App.init();
            var tradeType = <?php echo json_encode($tradeType); ?>;
            var payType = <?php echo json_encode($payType); ?>;
            var source = <?php echo json_encode($source); ?>;
            if (jQuery().datepicker) {
                $('.date-picker').datepicker({
                    rtl : App.isRTL()
                });
            }
            var tbl = $('#datatable_cs').dataTable({
                "sScrollXInner": "100%",
                "bServerSide": true,
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
                "sAjaxDataProp": 'preferential',
                "sAjaxSource": baseURL + 'preferential/preferential?tradeType=' + <?php echo $tradeTyp; ?>,
                "aoColumns": [{
                    "mData": "created_at",
                    "aTargets": [0]
                },{
                    "mData": "creator",
                    "aTargets": [1]
                }, {
                    "mData": "name",
                    "aTargets": [2]
                }, {
                    "mData": "start_time",
                    "aTargets": [3]
                }, {
                    "mData": 'end_time',
                    "aTargets": [4]
                }, {
                    "mData": null,
                    "aTargets": [5],
                    "fnRender" : function(obj) {
                        return tradeType[obj.aData.trade_type];
                    }
                }, {
                    "mData": "pay_type",
                    "aTargets": [6],
                    "fnRender" : function(obj) {
                        return payType[obj.aData.pay_type];
                    }
                }, {
                    "mData": "pay_mount",
                    "aTargets": [7]
                }, {
                    "mData": null,
                    "aTargets": [8],
                    "fnRender" : function(obj) {
                        return source[obj.aData.source];
                    }
                }, {
                    "mData": "prefer_mount",
                    "aTargets": [9]
                }, {
                    "mData": "total_mount",
                    "aTargets": [10]
                },  {
                    "mData": "lowest_mount",
                    "aTargets": [11]
                }, {
                    "mData": "highest_mount",
                    "aTargets": [12]
                }]
            });

            $("#btnSearch").click(function () {
                var oSettings = tbl.fnSettings();
                var data = getData();
                oSettings.sAjaxSource = baseURL + "preferential/preferential?" + data;
                oSettings._iDisplayStart = 0;
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });
            $(".icon-remove").on("click", function() {
                $(this).parent().siblings("input").val("");
            });

            $("#btnDownloadExcel").on("click", function() {
                var data =getData();
                var url = baseURL + "preferential/download/xlsx?"+data;
                window.open(url);
            });
            $("#btnDownloadTxt").on("click", function() {
                var data =getData();
                var url = baseURL + "preferential/download/txt?"+data;
                window.open(url);
            });
        });

        function getData(){
            var data = "strategy=" + $("#strategy").val();
            data += "&preferMount=" + $("#preferMount").val();
            data += "&source=" + $("#source").val();
            data += "&startTime=" + $("#startTime").val();
            data += "&endTime=" + $("#endTime").val();
            data += "&target=" + $("#target").val();
            data += "&lowest=" + $("#lowest").val();
            data += "&highest=" + $("#highest").val();
            data += "&name=" + $("#name").val();
            data += "&tradeType=" + <?php echo $tradeTyp; ?>;
            return data;
        }
    </script>
@stop