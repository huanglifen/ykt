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
                array("交易管理"),
                array("在线售卡", $baseURL . '/sale-card/index'));
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
                                            <label class="control-label min-label">购卡日期</label>
                                            <div class="controls min-controls">
                                                <div class="span4">
                                                    <select class="chosen span12" tabindex="1" id="payDate">
                                                        @foreach($date as $key => $value)
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
                                            <label class="control-label min-label">邮寄类型</label>
                                            <div class="controls min-controls">
                                                <select class="span9 chosen" tabindex="1" id="postStatus">
                                                    @foreach($postStatus as $key => $value)
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
                                <th style="width:9%">购卡日期</th>
                                <th style="width:15%">卡号</th>
                                <th style="width:9%">客户名称</th>
                                <th style="width:9%">联系电话</th>
                                <th style="width:5%">卡费</th>
                                <th style="width:5%">押金</th>
                                <th style="width:6%">充值金额</th>
                                <th style="width:6%">优惠金额</th>
                                <th style="width:6%">实付金额</th>
                                <th style="width:8%">邮寄地址</th>
                                <th style="width:6%">交易状态</th>
                                <th style="width:6%">邮寄状态</th>
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
            var postStatusArr = <?php echo json_encode($postStatus); ?>;
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
                "sAjaxDataProp": 'salecards',
                "sAjaxSource": baseURL + 'sale-card/sale',
                "aoColumns": [{
                    "mData": null,
                    "aTargets": [0],
                    "fnRender" : function(obj) {
                        return "<div title='" + obj.aData.order_no + "'> " + obj.aData.order_no + "</div>";
                    }
                },{
                    "mData": null,
                    "aTargets": [1],
                    "fnRender" : function(obj) {
                        return "<div title='" + obj.aData.created_at + "'> " + obj.aData.created_at + "</div>";
                    }
                }, {
                    "mData": "cardno",
                    "aTargets": [2],
                    "fnRender" : function(obj) {
                        return "<div title='" + obj.aData.cardno + "'> " + obj.aData.cardno + "</div>";
                    }
                }, {
                    "mData": null,
                    "aTargets": [3],
                    "fnRender" : function(obj) {
                        return "<div title='" + obj.aData.customer_name + "'> " + obj.aData.customer_name + "</div>";
                    }
                }, {
                    "mData": 'tel',
                    "aTargets": [4],
                    "fnRender" : function(obj) {
                        return "<div title='" + obj.aData.tel + "'> " + obj.aData.tel + "</div>";
                    }
                }, {
                    "mData": 'card_fee',
                    "aTargets": [5]
                },{
                    "mData": 'deposit',
                    "aTargets": [6]
                }, {
                    "mData": 'recharge_mount',
                    "aTargets": [7]
                },{
                    "mData": 'discount',
                    "aTargets": [8]
                },{
                    "mData": 'pay_mount',
                    "aTargets": [9]
                }, {
                    "mData": null,
                    "aTargets": [10],
                    "fnRender" : function(obj) {
                        return "<div title='" + obj.aData.address + "'> " + obj.aData.address + "</div>";
                    }
                },{
                    "mData": null,
                    "aTargets": [11],
                    "fnRender" : function(obj) {
                        return statusArr[obj.aData.status];
                    }
                }, {
                    "mData": null,
                    "aTargets": [12],
                    "fnRender" : function(obj) {
                        return postStatusArr[obj.aData.post_status];
                    }
                },  ]
            });

            $("#btnSearch").click(function () {
                var oSettings = tbl.fnSettings();
                var status = $("#status").val();
                var keywordType = $("#keywordType").val();
                var keyword = $("#keyword").val();
                var minMount = $("#minMount").val();
                var maxMount = $("#maxMount").val();
                var date = $("#payDate").val();
                var postStatus = $("#postStatus").val();
                if(date == 0) {
                    var startTime = $("#startTime").val();
                    var endTime = $("#endTime").val();
                }else{
                    var startTime = "";
                    var endTime = "";
                }

                oSettings.sAjaxSource = baseURL + "sale-card/sale?date="+date+"&startTime="+startTime+"&endTime="+endTime+"&status="+status+"&type="+keywordType+"&keyword="+keyword+"&minMount="+minMount+"&maxMount="+maxMount+"&postStatus="+postStatus;
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