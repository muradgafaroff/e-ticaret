<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="{{route('panel.index')}}">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <i class="icon-layout menu-icon"></i>
          <span class="menu-title">Slider</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('panel.slider.index')}}">Slider</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('panel.slider.create')}}">Slider Add</a></li>
          </ul>
        </div>
      </li>



      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
          <i class="icon-layout menu-icon"></i>
          <span class="menu-title">Categories</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic1">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('panel.category.index')}}">Category</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('panel.category.create')}}">Category Add</a></li>
          </ul>
        </div>
      </li>


      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic2">
          <i class="icon-layout menu-icon"></i>
          <span class="menu-title">Praducts</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic2">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('panel.product.index')}}">Products</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('panel.product.create')}}">Product Add</a></li>
          </ul>
        </div>
      </li>


      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic2">
          <i class="icon-layout menu-icon"></i>
          <span class="menu-title">Orders</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic2">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('panel.order.index')}}">Orders</a></li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{route('panel.about.index')}}">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">About</span>
        </a>
      </li>



      <li class="nav-item">
        <a class="nav-link" href="{{route('panel.contact.index')}}">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Inbox</span>
        </a>
      </li>


      <li class="nav-item">
        <a class="nav-link" href="{{route('panel.setting.index')}}">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Site Settings</span>
        </a>
      </li>



      <li class="nav-item">
        <a class="nav-link" href="{{route('panel.pageseo.index')}}">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Page Seo Settings</span>
        </a>
      </li>


      <li class="nav-item">
        <a class="nav-link" href="{{route('panel.imageseo.index')}}">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Page Seo</span>
        </a>
      </li>


      <li class="nav-item">
        <a class="nav-link" href="{{route('panel.coupons.index')}}">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Coupon</span>
        </a>
      </li>

    </ul>
  </nav>
