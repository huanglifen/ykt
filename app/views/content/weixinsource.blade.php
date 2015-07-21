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
        $breadTitle = "内容管理";
        $breadcrumb[] = array("内容管理");
        $breadcrumb[] = array("微信素材管理", $baseURL . '/wsource/index');
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box">
                    <div class="portlet-body">
                        <div class="clearfix">
                            <div class="btn-group ">
                                <a href="{{{$baseURL}}}/wsource/add/{{{\App\Module\ContentModule::TYPE_SINGLE}}}" class="btn margin-right-10 green">
                                    单条图文<i class="icon-plus"></i>
                                </a><a href="{{{$baseURL}}}/wsource/add/{{{\App\Module\ContentModule::TYPE_MULTI}}}" class="btn margin-right-10 green">
                                    多条图文<i class="icon-plus"></i>
                                </a>
                                <a href="{{{$baseURL}}}/wsource/add/{{{\App\Module\ContentModule::TYPE_CUSTOM}}}" class="btn margin-right-10 green">
                                    自定义页面<i class="icon-plus"></i>
                                </a>
                            </div>
                            <div class="row-fluid span6 pull-right" >
                                <div class="control-group span6">
                                        <div class="control-label" style="float: left;width:63px;padding-top:5px;">素材类型</div>
                                        <div class="controls">
                                            <select class="span7 chosen" tabindex="1" id="type" name="type">
                                                <option value="0">全部</option>
                                                <option value="{{{\App\Module\ContentModule::TYPE_SINGLE}}}">单条图文</option>
                                                <option value="{{{\App\Module\ContentModule::TYPE_MULTI}}}">多条图文</option>
                                                <option value="{{{\App\Module\ContentModule::TYPE_CUSTOM}}}">自定义图文</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="control-group span6">
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
                                <th style="width:25%">ID</th>
                                <th style="width:25%">分类</th>
                                <th style="width:25%">标题</th>
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
    <script type="text/javascript" src="{{{$mediaURL}}}js/chosen.jquery.min.js"></script>
    <script src="{{{$mediaURL}}}js/select2.min.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/DT_bootstrap.js" type="text/javascript"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script src="{{{$mediaURL}}}js/table-managed.js" type="text/javascript"></script>
    <script>
        $(function () {
            var typeArr = {"1":"单条图文","2":"多条图文","3":"自定义图文"};
             App.init();
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
                "sAjaxDataProp": 'contents',
                "sAjaxSource": baseURL + 'wsource/sources',
                "aoColumns": [{
                    "mData": "id",
                    "aTargets": [0]
                }, {
                    "mData": null,
                    "aTargets": [1],
                    "fnRender" :function(obj) {
                        return typeArr[obj.aData.type];
                    }
                },{
                    "mData": "title",
                    "aTargets": [2]
                },{
                    "mData": null,
                    "aTargets": [3],
                    "fnRender" : function(obj) {
                        return '<span data-id="' + obj.aData.id + '"><a title="编辑" href="' + baseURL + 'wsource/update/' + obj.aData.id + '" class="btn mini green margin-right-10"><i class="icon-edit"></i></a><a title="删除" href="javascript:;" class="JsDelete btn mini red"><i class="icon-trash"></i></a></span>';
                    }
                }]
            });

            $("#btnSearch").click(function () {
                var oSettings = tbl.fnSettings();
                var title = $("#title").val();
                var type = $("#type").val();
                oSettings.sAjaxSource = baseURL + "wsource/sources?title=" + title +"&type="+type;
                oSettings._iDisplayStart = 0;
                tbl.fnClearTable(0);
                tbl.fnDraw();
            });

            $("body").on('click','.JsDelete', function(){
                if(! confirm('确定要删除该素材？')) {
                    return false;
                }
                var id = $(this).parent().attr('data-id');
                $.ajax({
                    'type' : 'post',
                    'dataType' : 'json',
                    'data' : 'id='+id,
                    'url' : baseURL + 'wsource/delete',
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