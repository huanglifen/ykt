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
        $breadTitle = "活动专题";
        $breadcrumb = array(
                array("内容管理"),
                array("活动列表", $baseURL . '/subject/index'),
                array('报名信息', $baseURL . '/subject/participator/' . $subjectId)
        );
        ?>
        @include('common.bread')
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box">
                    <div class="portlet-body">
                        <div class="clearfix">
                            <div class="row-fluid span6 pull-right" style="margin-bottom: 20px;">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label"><h4>活动标题：{{{$subject->title}}}</h4></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="datatable_content">
                            <thead>
                            <tr>
                                <th style="width:5%">ID</th>
                                <th style="width:60%">用户信息</th>
                                <th style="width:35%">报名时间</th>
                            </tr>
                            @if(count($participators))
                            @foreach($participators as $participator)
                                <?php $jsonInfo = json_decode($participator->info, true);?>
                                <tr>
                                    <td>
                                        {{{$participator->id}}}
                                    </td>
                                    <td>
                                        @if(is_array($jsonInfo))
                                        @foreach($jsonInfo as $key => $info)
                                            <div>{{{$key}}} ：{{{$info}}}</div><br/>
                                            @endforeach
                                            @else
                                            无信息
                                        @endif
                                    </td>
                                    <td>
                                        {{{$participator->created_at}}}
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr><td colspan="3">无数据！</td></tr>
                            @endif
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
        }
    </script>
@stop