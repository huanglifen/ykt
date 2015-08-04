<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', "App\Controllers\MainController@getIndex");
Route::get('login', "App\Controllers\MainController@getLogIn");
Route::get('logout', "App\Controllers\MainController@getLogOut");

Route::controller("main", "App\Controllers\MainController");
Route::controller("menu", "App\Controllers\MenuController");
Route::controller("role", "App\Controllers\RoleController");
Route::controller("user", "App\Controllers\UserController");
Route::controller("department", "App\Controllers\DepartmentController");

Route::controller("log", "App\Controllers\LogController");
Route::controller("card", "App\Controllers\CardController");
Route::controller("customer", "App\Controllers\CustomerController");
Route::controller("import", "App\Controllers\ImportController");
Route::controller("paycode", "App\Controllers\PayCodeController");
Route::controller("pay", "App\Controllers\PayController");
Route::controller("industry", "App\Controllers\IndustryController");
Route::controller("circle", "App\Controllers\BusinessDistrictController");
Route::controller("business", "App\Controllers\BusinessController");
Route::controller("activity", "App\Controllers\ActivityController");
Route::controller("coupon", "App\Controllers\CouponController");
Route::controller("help", "App\Controllers\HelpController"); //帮助
Route::controller("news", "App\Controllers\NewsController"); //新闻
Route::controller("product", "App\Controllers\ProductController"); //产品介绍
Route::controller("contentType", "App\Controllers\ContentTypeController"); //内容类型
Route::controller("carousel", "App\Controllers\CarouselController");//轮播图
Route::controller('weichat', "App\Controllers\WeichatController"); //微信接收消息服接口
Route::controller('wmenu', "App\Controllers\WeixinMenuController");
Route::controller('wsource', "App\Controllers\WeixinSourceController");
Route::controller('site', "App\Controllers\SiteController");
Route::controller('web', "App\Controllers\WebController");
Route::controller('partner', "App\Controllers\PartnerController");
Route::controller('cs', "App\Controllers\CustomerServiceController");
Route::controller('dump', "App\Controllers\DumpController");
Route::controller('app', "App\Controllers\AppController");
Route::controller('paySet', "App\Controllers\PaySetController");//生活缴费业务设置
Route::controller('payment', "App\Controllers\PaymentController");//生活缴费




