<div class="row-fluid">
    <div class="span12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            {{{$breadTitle or '菜单管理'}}}
        </h3>
        <ul class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{{$baseURL}}}/main/welcome">主页</a>

                <i class="icon-angle-right"></i>
            </li>
            <?php $breadcrumb = isset($breadcrumb) ? $breadcrumb : array();
                   $breadLength = count($breadcrumb);
            ?>
            @foreach($breadcrumb as $key => $bread)
                <li>
                    <a href="{{{$bread[1] or 'javascript:;'}}}">{{{$bread[0]}}}</a>
                    @if($key < $breadLength - 1)
                    <i class="icon-angle-right"></i>
                    @endif
                </li>
            @endforeach
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>