@extends("common.common")
<!-- BEGIN BODY -->
@section("content")
    <body class="page-header-fixed">
    @include("common.header")
    <!-- BEGIN CONTAINER -->
    <div class="page-container row-fluid" >
        @include("common.left")
        @yield("context")
    </div>
    <!-- END CONTAINER -->
    @stop
    @section("footer")
        <div class="footer">

            <div class="copyright">
                河北一卡通互联网后台管理系统      v1.0

                河北一卡通电子支付有限公司      版权所有 2015-2016      意见反馈：master@966009.com
            </div>

            <div class="footer-tools">

			<span class="go-top">

			<i class="icon-angle-up"></i>

			</span>

            </div>

        </div>
    @stop
    @section("otherJs")
        <script src="{{{$jsURL}}}/app.js"></script>
        <script>
            jQuery(document).ready(function() {
                App.init();
            });
        </script>
            @stop
