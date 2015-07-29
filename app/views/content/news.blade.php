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
        $breadTitle = "新闻公告";
        $breadcrumb[] = array("内容管理");
        $breadcrumb[] = array("新闻公告", $baseURL . '/news/index');
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box">
                    <div class="portlet-body">
                        <div class="clearfix">
                            <div class="btn-group span2">
                                <a href="{{{$baseURL}}}/news/add" class="btn margin-right-10 green">
                                    新增<i class="icon-plus"></i>
                                </a>
                            </div>
                            <div class="row-fluid span10 pull-right" >
                                <div class="control-group span3">
                                        <div class="control-label" style="float: left;width:63px;padding-top:5px;">类型</div>
                                        <div class="controls">
                                            <select class="span7 chosen" tabindex="1" id="type" name="type">
                                                <option value="0">全部</option>
                                                @foreach($contentType as $key => $value)
                                                    <option value="{{{$key}}}">{{{$value}}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                                <div class="control-group span3">
                                    <div class="controls input-append">
                                        <input class="span12 m-wrap m-ctrl-medium date-picker" id="startTime" readonly
                                               type="text" value="" placeholder="请输入开始时间"/>
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                    </div>
                                </div>
                                <div class="control-group span3">
                                    <div class="controls input-append">
                                        <input class="span12 m-wrap m-ctrl-medium date-picker" id="endTime" readonly
                                               type="text" value="" placeholder="请输入结束时间"/>
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                    </div>
                                </div>
                                <div class="control-group span2">
                                    <div class="input-append">
                                        <input class="span12 m-wrap" type="text" id="title" name="title" placeholder="标题">
                                        <button class="btn green btnSearch" type="button" id="btnSearch">搜索</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="datatable_content">
                            <thead>
                            <tr>
                                <th style="width:30%">标题</th>
                                <th style="width:25%">公告类型</th>
                                <th style="width:20%">是否显示</th>
                                <th >操作</th>
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
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/daterangepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/chosen.jquery.min.js"></script>
    <script src="{{{$mediaURL}}}js/select2.min.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/DT_bootstrap.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/table-managed.js" type="text/javascript"></script>
    <script>
        $(function () {
            var displayArr = {"1" :"显示", "2" : "不显示"};
            var newsType = <?php  echo json_encode($contentType); ?>;
            App.init();
            if (jQuery().datepicker) {
                $('.date-picker').datepicker({
                    rtl : App.isRTL()
                });
            }
            $(".icon-remove").on("click", function() {
                $(this).parent().siblings("input").val("");
            });
            var tbl = $('#datatable_content').dataTable({
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
                "sAjaxDataProp": 'content',
                "sAjaxSource": baseURL + 'news/content',
                "aoColumns": [{
                    "mData": "title",
                    "aTargets": [0]
                }, {
                    "mData": null,
                    "aTargets": [1],
                    "fnRender" : function(obj) {
                        return newsType[obj.aData.type];
                    }
                },{
                    "mData": "display",
                    "aTargets": [2],
                    "fnRender" : function(obj) {
                        return displayArr[obj.aData.display];
                    }
                },{
                    "mData": null,
                    "aTargets": [3],
                    "fnRender" : function(obj) {
                        return '<span data-id="' + obj.aData.id + '"><a title="编辑" href="' + baseURL + 'news/update/' + obj.aData.id  + '" class="btn mini green margin-right-10"><i class="icon-edit"></i></a><a title="删除" href="javascript:;" class="JsDelete btn mini red"><i class="icon-trash"></i></a></span>';
                    }
                }]
            });

            $("#btnSearch").click(function () {
                var oSettings = tbl.fnSettings();
                var title = $("#title").val();
                var type = $("#type").val();
                var startTime = $("#startTime").val();
                var endTime = $("#endTime").val();
                oSettings.sAjaxSource = baseURL + "news/content?title=" + title +"&type="+type+"&startTime="+startTime+"&endTime="+endTime;
                oSettings._iDisplayStart = 0;
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });
            $("body").on('click','.JsDelete', function(){
                if(! confirm('确定要删除该新闻公告？')) {
                    return false;
                }
                var id = $(this).parent().attr('data-id');
                $.ajax({
                    'type' : 'post',
                    'dataType' : 'json',
                    'data' : 'id='+id,
                    'url' : baseURL + 'news/delete',
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