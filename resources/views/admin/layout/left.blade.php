<div class="left-sidebar dis-flex">
    <!-- 一级菜单 -->
    <ul class="sidebar-nav">
        <li class="sidebar-nav-heading">后台管理系统</li>
        <li class="sidebar-nav-link">
            <a href="{{ url('/admins') }}" class="{{ empty($left['menu_id']) ? 'active' : ''  }}">
                <i class="iconfont sidebar-nav-link-logo icon-home"></i>
                首页
            </a>
        </li>
        @foreach($left['one'] as $entity)
            <li class="sidebar-nav-link">
                <a href="{{ url($entity->getUrl())  }}" class="{{ ($left['menu_parent_id'] == $entity->id) ? 'active' : ''  }}">
                    <i class="iconfont sidebar-nav-link-logo {{ $entity->icon  }}"></i>
                    {{ $entity->getShrotName()  }}
                </a>
            </li>
        @endforeach
    </ul>
    <!-- 子级菜单-->
    @if(!empty($left['two']))
    <ul class="left-sidebar-second">
        <li class="sidebar-second-title">{{ $left['one_name']  }}</li>
        @foreach($left['two'] as $entity)
            <li class="sidebar-second-item">
                <a href="{{ url($entity->getUrl())  }}" class="{{ ($left['menu_id'] == $entity->id) ? 'active' : ''  }}">
                    {{ $entity->getShrotName()  }}
                </a>
            </li>
        @endforeach
    </ul>
    @endif
</div>