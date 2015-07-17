@extends("common.right")
@section('otherCss')
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/chosen.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/jquery.nestable.css" />
    <link rel="stylesheet" type="text/css" href="{{{$mediaURL}}}css/multi-select-metro.css" />

@stop
@section("context")
    <!-- BEGIN PAGE -->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <?php
        $breadTitle = "内容管理";
        $breadcrumb = array(
                array("内容管理"),
                array("微信自定义菜单", $baseURL . '/wmenu/index'));
        ?>
        @include('common.bread')
            <div class="row-fluid">
                    <div class="portlet box">
                        <div class="portlet-body ">
                            <div class="clearfix">
                                <div class="row-fluid span12" style="margin-bottom: 20px;">
                                    <div class="span2">
                                        <div class="control-group">
                                            <div class="controls">
                                                <select class="span12" tabindex="1" id="cardType" name="cardType">
                                                    <option value="0">选择父级</option>
                                                    @foreach($tree as $parent)
                                                        <option value="{{{$parent->id}}}">{{{$parent->name}}}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="control-group">
                                            <div class="controls">
                                                <select class="span12" tabindex="1" id="type" name="type">
                                                    <option value="{{{\App\Module\WeixinMenuModule::TYPE_CLICK}}}">点击事件</option>
                                                    <option value="{{{\App\Module\WeixinMenuModule::TYPE_VIEW}}}">跳转URL</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span3">
                                        <div class="control-group">
                                            <div class="controls">
                                                <select data-placeholder="选择关联内容数据" class="chosen span12" tabindex="-1" id="category">
                                                    <option value=""></option>
                                                    <optgroup label="单个图文">
                                                        @foreach($sources['single'] as $single)
                                                            <option value="{{{$single->id}}}">{{{$single->title}}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                    <optgroup label="多条图文">
                                                        @foreach($sources['multi'] as $multi)
                                                            <option value="{{{$multi->id}}}">{{{$multi->title}}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                    <optgroup label="自定义图文">
                                                        @foreach($sources['custom'] as $custom)
                                                            <option value="{{{$custom->id}}}">{{{$custom->title}}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="control-group">
                                            <div class="controls">
                                                <input type="text" id="name" name="name"
                                                       class="span12 m-wrap popovers" data-trigger="hover" placeholder="名称"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span2">
                                        <div class="control-group">
                                            <div class="controls">
                                                <input type="text" id="key" name="key"
                                                       class="span12 m-wrap popovers" data-trigger="hover" placeholder="URL OR KEY"/>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="menuId" />
                                    <div class="span1">
                                        <div class="control-group">
                                            <div class="controls">
                                                <button class="btn green"  type="button" id="btnEdit">新增</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                            <div class="span6">
                            <div class="dd" id="nestable_list_1">
                                @foreach($tree as $t)
                                <ol class="dd-list">
                                    <li class="dd-item" >
                                        <div class="dd-handle">
                                            <span style="padding-right:20px;">{{{$t->name}}}</span>
                                            <i class="icon-plus"></i>
                                            <i class="icon-pencil"></i>
                                            <i class="icon-trash"></i>
                                        </div>

                                        @if(count($t->children))
                                        <ol class="dd-list">
                                            @foreach($t->children as $child)
                                            <li class="dd-item">
                                                <div class="dd-handle">
                                                    <span style="padding-right:20px;">{{{$child->title}}}</span>
                                                    <i class="icon-pencil"></i>
                                                    <i class="icon-trash"></i>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ol>
                                        @endif
                                    </li>
                                </ol>
                                    @endforeach
                            </div>
                        </div>
                            <div class="span6">

                                <textarea style="height:200px;"class="m-wrap span10">{{{$json}}}</textarea>
                                <div class="control-group">
                                    <div class="controls">
                                        <button class="btn green"  type="button" id="btnSysc">创建更新菜单</button>
                                    </div>
                                </div>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
    </div>
@stop
@section('otherJs')
    <script type="text/javascript" src="{{{$mediaURL}}}js/chosen.jquery.min.js"></script>
    <script src="{{{$mediaURL}}}js/jquery.nestable.js"></script>
    <script src="{{{$mediaURL}}}js/ui-nestable.js"></script>
    <script type="text/javascript" src="{{{$mediaURL}}}js/jquery.multi-select.js"></script>
    <script src="{{{$jsURL}}}app.js" type="text/javascript"></script>
    <script>
        $(function() {
            App.init();
            $('#nestable_list_1').nestable({
                group: 1
            })
        })
    </script>
@stop