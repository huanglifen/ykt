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
        $breadcrumb = array(
                array("缴费管理"),
                array("查询交易", $baseURL . '/payment/index'));
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
                                            <label class="control-label min-label">缴费日期</label>
                                            <div class="controls min-controls">
                                            <div class="span4">
                                                    <select class="chosen span12" tabindex="1" id="payDate">
                                                        @foreach($payDate as $key => $value)
                                                            <option value="{{{$key}}}">{{{$value}}}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                            <div class="span4 input-append ">
                                                <input class="m-wrap m-ctrl-medium date-picker span10" id="startTime" readonly type="text" value=""  placeholder="开始时间"/>
                                                <span class="add-on"><i class="icon-remove"></i></span>
                                            </div>
                                          <div class="span4 input-append">
                                                <input class="m-wrap m-ctrl-medium date-picker span10" id="endTime"readonly type="text" value=""  placeholder="结束时间"/>
                                                <span class="add-on"><i class="icon-remove"></i></span>
                                           </div>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <label class="control-label min-label">交易状态</label>
                                        <div class="controls min-controls">
                                            <select class="chosen span9" tabindex="1" id="status" name="status">
                                                @foreach($status as $key => $value)
                                                 <option value="{{{$key}}}">{{{$value}}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span8">
                                        <div class="control-group">
                                            <label class="control-label min-label">关键信息</label>
                                                <div class="controls min-controls">
                                                    <div class="span4">
                                                    <select class="chosen span12" tabindex="1" id="keywordType">
                                                        @foreach($keyword as $key => $value)
                                                            <option value="{{{$key}}}">{{{$value}}}</option>
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                    <div class="span7">
                                                        <input type="text" id="keyword" name="keyword"
                                                               class="span10 m-wrap popovers" data-trigger="hover"/>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <div class="control-group">
                                            <label class="control-label min-label">缴费类型</label>
                                            <div class="controls min-controls">
                                                <select class="span9 chosen" tabindex="1" id="category">
                                                    @foreach($payType as $key => $value)
                                                        <option value="{{{$key}}}">{{{$value}}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span8">
                                        <div class="control-group">
                                            <label class="control-label min-label">金额范围</label>
                                            <div class="controls min-controls">
                                            <div class="span4">
                                                    <input type="text" id="minMount" name="minMount"
                                                           class="m-wrap popovers span12" data-trigger="hover" placeholder="最小金额"/>
                                            </div>
                                            <div class="span4 input-append">
                                                    <input type="text" id="maxMount" name="maxMount"
                                                           class="m-wrap popovers span12" data-trigger="hover" placeholder="最大金额"/>
                                                <button class="btn green"  type="button" id="btnSearch">查询</button>
                                            </div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="datatable_cs">
                            <thead>
                            <tr>
                                <th style="width:10%">订单编号</th>
                                <th style="width:10%">缴费日期</th>
                                <th style="width:8%">缴费类型</th>
                                <th style="width:10%">缴费商户</th>
                                <th style="width:10%">缴费账号</th>
                                <th style="width:10%">缴费流水号</th>
                                <th style="width:10%">缴费金额</th>
                                <th style="width:10%">客户名称</th>
                                <th style="width:10%">支付方式</th>
                                <th style="width:10%">支付账号</th>
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
            var payTypeArr = <?php echo json_encode($payType); ?>;
            var statusArr = <?php echo json_encode($status); ?>;
            App.init();
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
                "sAjaxDataProp": 'payment',
                "sAjaxSource": baseURL + 'payment/payment',
                "aoColumns": [{
                    "mData": 'order_no',
                    "aTargets": [0]
                },{
                    "mData": 'created_at',
                    "aTargets": [1]
                }, {
                    "mData": null,
                    "aTargets": [2],
                    "fnRender" : function(obj) {
                        return payTypeArr[obj.aData.category];
                    }
                }, {
                    "mData": 'businessName',
                    "aTargets": [3]
                }, {
                    "mData": 'account',
                    "aTargets": [3]
                }, {
                    "mData": 'serial_number',
                    "aTargets": [4]
                },{
                    "mData": 'mount',
                    "aTargets": [5]
                },  {
                    "mData": 'customerName',
                    "aTargets": [6]
                },{
                    "mData": null,
                    "aTargets": [7],
                    "fnRender" : function(obj) {
                        return "河北一卡通";
                    }
                }, {
                    "mData": 'pay_account',
                    "aTargets": [8]
                },  ]
            });

            $("#btnSearch").click(function () {
                var oSettings = tbl.fnSettings();
                var status = $("#status").val();
                var keywordType = $("#keywordType").val();
                var keyword = $("#keyword").val();
                var category = $("#category").val();
                var minMount = $("#minMount").val();
                var maxMount = $("#maxMount").val();
                var payDate = $("#payDate").val();
                if(payDate == 0) {
                    var startTime = $("#startTime").val();
                    var endTime = $("#endTime").val();
                }else{
                    var startTime = "";
                    var endTime = "";
                }

                oSettings.sAjaxSource = baseURL + "payment/payment?payDate="+payDate+"&startTime="+startTime+"&endTime="+endTime+"&status="+status+"&type="+keywordType+"&keyword="+keyword+"&category="+category+"&minMount="+minMount+"&maxMount="+maxMount;
                oSettings._iDisplayStart = 0;
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });
        });
    </script>
@stop