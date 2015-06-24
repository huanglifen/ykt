<div class="page-sidebar nav-collapse collapse">
    <ul class="page-sidebar-menu hidden-phone hidden-tablet">
        <li>
            <div class="sidebar-toggler hidden-phone"></div>
        </li>
        <?php $count = count($global_menus['menus']); ?>
        @foreach($global_menus['menus'] as $key => $menu)
            @if($menu->level == 1)
            <li class="menu @if($key == 0)start  @endif">
                <a  @if($menu->url)href="{{{$baseURL}}}/{{{$menu->url}}}" @else href="javascript:;"@endif target="rightMain">
                    <i class="icon-cog"></i>
                    <span class="selected "></span>
                    <span class="title">{{{$menu->name}}}</span>
                    <span class="arrow "></span>
                </a>
                @if($key < $count -1 && $global_menus['menus'][$key+1]->level == 2 )
                    <ul class="sub-menu">
                  @endif
            @endif
            @if($menu->level == 2)
                 <li class="" >
                    <a @if($menu->url)href="{{{$baseURL}}}/{{{$menu->url}}}" @else href="javascript:;"@endif target="rightMain">
                         {{{$menu->name}}}
                        @if($key < $count -1 && $global_menus['menus'][$key+1]->level == 3)
                            <span class="arrow"></span>
                        @endif
                     </a>

                  @if($key < $count -1 && $global_menus['menus'][$key+1]->level == 3)
                     <ul class="sub-menu">
                    @else
                     </li>
                  @endif
            @endif
            @if($menu->level == 3)
                <li>
                   <a @if($menu->url)href="{{{$baseURL}}}/{{{$menu->url}}}" @else href="javascript:;"@endif target="rightMain">
                                {{{$menu->name}}}
                    </a>
                   </li>
                   @if($key >= $count -1 || $global_menus['menus'][$key+1]->level != 3)
                     </ul>
                      </li>
                   @endif
            @endif
            @if( $menu->level != 1 && ($key >= $count -1 || $global_menus['menus'][$key+1]->level == 1))
                    </ul>
            @endif
            @if($key == $count -1 || $global_menus['menus'][$key+1]->level == 1)
              </li>
            @endif
        @endforeach
    </ul>
</div>