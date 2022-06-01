<header class="header" id="header-sroll">
    <div class="container-lg">
        <div class="row">
            <div class="col-xs-12">
                <div class="desk-menu">
                    <div class="logo">
                        <h1 class="logo-adn">
                            <a href="{{route('store.slug',$store->slug)}}">
                                @if(!empty($store->logo))
                                    <img alt="lmsgo-logo" src="{{asset(Storage::url('uploads/store_logo/'.$store->logo))}}" id="img-fluid">
                                @else
                                    <img alt="lmsgo-logo" src="{{asset(Storage::url('uploads/store_logo/logo.png'))}}" id="img-fluid">
                                @endif
                            </a>
                        </h1>
                    </div>
                    <nav class="box-menu">
                        <div class="over-menu"></div>
                        <div class="menu-container">
                            <div class="menu-head">
                                <a href="{{route('store.slug',$store->slug)}}" class="e1">
                                    @if(!empty($store->logo) && asset(Storage::url('uploads/store_logo/'.$store->logo)))
                                        <img alt="lmsgo-logo" src="{{asset(Storage::url('uploads/store_logo/'.$store->logo))}}" id="img-fluid">
                                    @else
                                        <img alt="lmsgo-logo" src="{{asset(Storage::url('uploads/store_logo/logo.png'))}}" id="img-fluid">
                                    @endif
                                </a>
                            </div>
                            <div class="menu-header-container">
                                <ul id="cd-primary-nav" class="menu">
                                    <li class="contact menu-item ">
                                        <a href="{{route('store.slug',$store->slug)}}">{{__('Home')}}</a>
                                    </li>
                                    @if($page_slug_urls->count()>0)
                                        <li class="contact menu-item d-flex about_link">
                                            @foreach($page_slug_urls as $k=>$page_slug_url)
                                                @if($page_slug_url->enable_page_header == 'on')
                                                    <a href="{{env('APP_URL') . '/page/' . $page_slug_url->slug}}">{{ucfirst($page_slug_url->name)}}</a>
                                                @endif
                                            @endforeach
                                        </li>
                                    @endif
                                    @if($store->blog_enable == 'on' && $blog->count()>0)
                                        <li class="contact menu-item">
                                            <a href="{{route('store.blog',$store->slug)}}">{{__('Blog')}}</a>
                                        </li>
                                    @endif
                                    <li class="line"></li>
                                </ul>
                            </div>
                        </div>
                        <div class="hamburger-menu">
                            <div class="bar"></div>
                        </div>
                    </nav>
                    <div class="right-section">
                        <!-- search icon -->
                        <div class="search-icon custom">
                            <button class="btn" data-toggle="modal" data-target="#demo3">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="notification custom">
                            <a href="{{route('store.cart',$store->slug)}}">
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M19.4574 7.64289H5.61459C4.22404 7.64289 3.12183 8.8161 3.20857 10.204L3.81125 19.8468C3.89066 21.1174 4.94426 22.1072 6.21727 22.1072H18.8547C20.1277 22.1072 21.1813 21.1174 21.2607 19.8468L21.8634 10.204C21.9501 8.8161 20.8479 7.64289 19.4574 7.64289ZM5.61459 5.23218C2.83349 5.23218 0.62907 7.57867 0.80255 10.3544L1.40523 19.9972C1.56405 22.5383 3.67125 24.5179 6.21727 24.5179H18.8547C21.4007 24.5179 23.5079 22.5383 23.6667 19.9972L24.2694 10.3544C24.4429 7.57867 22.2385 5.23218 19.4574 5.23218H5.61459Z"
                                          fill="url(#paint0_linear)"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M6.50879 6.43743C6.50879 3.10893 9.2071 0.410637 12.5356 0.410637C15.8641 0.410637 18.5624 3.10893 18.5624 6.43743V8.8481C18.5624 9.5138 18.0227 10.0535 17.357 10.0535C16.6913 10.0535 16.1516 9.5138 16.1516 8.8481V6.43743C16.1516 4.44033 14.5327 2.82136 12.5356 2.82136C10.5385 2.82136 8.9195 4.44033 8.9195 6.43743V8.8481C8.9195 9.5138 8.3798 10.0535 7.71415 10.0535C7.04845 10.0535 6.50879 9.5138 6.50879 8.8481V6.43743Z"
                                          fill="url(#paint1_linear)" fill-opacity="0.5"/>
                                    <defs>
                                        <linearGradient id="paint0_linear" x1="1.85408" y1="7.95734" x2="24.719"
                                                        y2="9.5154" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="var(--theme-bg-color)"/>
                                            <stop offset="1" stop-color="var(--theme-bg-color)"/>
                                        </linearGradient>
                                        <linearGradient id="paint1_linear" x1="7.05338" y1="1.77322"
                                                        x2="18.7853" y2="2.59379" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="var(--primary-color)"/>
                                            <stop offset="1" stop-color="var(--primary-color)"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <span class="cart_item_count">
                                    @php
                                        $cart = session()->get($slug);
                                        $total_item = 0;
                                        if(isset($cart['products']))
                                        {
                                            foreach($cart['products'] as $item)
                                            {
                                                if(isset($cart) && !empty($cart['products']))
                                                {
                                                    $total_item = count($cart['products']);
                                                }
                                            }
                                        }
                                    @endphp
                                    {{$total_item}}
                                </span>
                            </a>
                        </div>
                        @if( Utility::StudentAuthCheck($store->slug)==true)
                            <div class="notification custom">
                                <a href="{{route('student.wishlist',$store->slug)}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                         width="30" height="30"
                                         viewBox="0 0 172 172"
                                         style=" fill:#000000;">
                                        <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                            <path d="M0,172v-172h172v172z" fill="none"></path>
                                            <g fill="var(--primary-color)">
                                                <path
                                                    d="M116.50133,21.53583c-19.64383,0.80267 -30.50133,14.9425 -30.50133,14.9425c0,0 -10.8575,-14.13983 -30.50133,-14.9425c-13.17233,-0.5375 -25.24817,6.02 -33.20317,16.5335c-27.67767,36.57867 24.725,79.37083 37.05167,90.859c7.3745,6.87283 16.47617,15.03567 21.9085,19.87317c2.71617,2.42233 6.76533,2.42233 9.4815,0c5.43233,-4.8375 14.534,-13.00033 21.9085,-19.87317c12.32667,-11.48817 64.7365,-54.28033 37.05167,-90.859c-7.94783,-10.5135 -20.02367,-17.071 -33.196,-16.5335z"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    <span class="wishlist_item_count">{{\App\Models\Wishlist::wishCount()}}</span>
                                </a>
                            </div>
                            <div class="profile-dropdown custom">
                                <button onclick="myDropdown()" class="profile-dropdown-btn dropbtn">
                                    <div class="dropbtn-main d-flex align-items-center">
                                        <div class="user-profile-img">
                                            @if(!empty(Auth::guard('students')->user()->avatar) )
                                                <img src="{{asset(Storage::url('uploads/profile/'.Auth::guard('students')->user()->avatar))}}" alt="user" class="img-fluid">
                                            @else
                                                <img src="{{asset('assets/img/user.png')}}" alt="user" class="img-fluid">
                                            @endif
                                        </div>
                                        <span>{{Auth::guard('students')->user()->name}}</span>
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </div>
                                </button>
                                <div id="myDropdown" class="dropdown-content">
                                    <a href="{{route('student.home',$slug)}}">
                                        <span>
                                            <img src="{{asset('assets/img/layer.svg')}}" alt="layer" class="img-fluid">
                                        </span>
                                            {{__('My Courses')}}
                                    </a>
                                    {{-- <a href="{{route('store.slug',$slug)}}">
                                        <span>
                                             <img src="{{asset('assets/img/cube.svg')}}" alt="setting" class="img-fluid">
                                        </span>
                                        {{__('My Dashboard')}}
                                    </a> --}}
                                    <a href="" data-url="{{route('student.profile',[$slug,\Illuminate\Support\Facades\Crypt::encrypt(Auth::guard('students')->user()->id)])}}" data-size="lg" data-ajax-popup-blur="true" data-title="{{__('Edit Profile')}}" data-toggle="modal">
                                    <span>
                                        <img src="{{asset('assets/img/user.svg')}}" alt="user" class="img-fluid">
                                    </span>
                                        {{__('My Profile')}}
                                    </a>
                                    @if(Utility::StudentAuthCheck($store->slug) == false)
                                        <a href="{{route('student.login',$store->slug)}}">
                                        <span>
                                            <img src="{{asset('assets/img/signup.svg')}}" alt="login" class="img-fluid">
                                        </span>
                                            {{__('Sign in')}}
                                        </a>
                                    @else
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('student-frm-logout').submit();">
                                        <span>
                                            <img src="{{asset('assets/img/logout.svg')}}" alt="logout" class="img-fluid">
                                        </span>
                                            {{__('Logout')}}
                                        </a>
                                        <form id="student-frm-logout" action="{{ route('student.logout',$store->slug)  }}" method="POST" class="d-none">
                                            {{ csrf_field() }}
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="profile-dropdown custom">
                                <a href="{{route('student.login',$store->slug)}}" class="profile-dropdown-btn dropbtn p-2 w-auto">
                                    <span>{{__('Sign in')}}</span>
                                </a>
                            </div>
                        @endif
                        <div class="languages custom">
                            <div class="dropdown">
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M12.5 20C16.9183 20 20.5 16.4183 20.5 12C20.5 7.58172 16.9183 4 12.5 4C8.08172 4 4.5 7.58172 4.5 12C4.5 16.4183 8.08172 20 12.5 20ZM12.5 22C18.0228 22 22.5 17.5228 22.5 12C22.5 6.47715 18.0228 2 12.5 2C6.97715 2 2.5 6.47715 2.5 12C2.5 17.5228 6.97715 22 12.5 22Z"
                                          fill="url(#paint0_linear)"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M14.2467 18.1766C14.9854 16.6992 15.5 14.5183 15.5 12C15.5 9.48174 14.9854 7.30077 14.2467 5.82336C13.4482 4.22632 12.7151 4 12.5 4C12.2849 4 11.5518 4.22632 10.7533 5.82336C10.0146 7.30077 9.5 9.48174 9.5 12C9.5 14.5183 10.0146 16.6992 10.7533 18.1766C11.5518 19.7737 12.2849 20 12.5 20C12.7151 20 13.4482 19.7737 14.2467 18.1766ZM12.5 22C15.2614 22 17.5 17.5228 17.5 12C17.5 6.47715 15.2614 2 12.5 2C9.73858 2 7.5 6.47715 7.5 12C7.5 17.5228 9.73858 22 12.5 22Z"
                                          fill="url(#paint1_linear)" fill-opacity="0.5"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M22.4506 13C22.4833 12.6711 22.5 12.3375 22.5 12C22.5 11.6625 22.4833 11.3289 22.4506 11H2.54938C2.51672 11.3289 2.5 11.6625 2.5 12C2.5 12.3375 2.51672 12.6711 2.54938 13H22.4506Z"
                                          fill="url(#paint2_linear)" fill-opacity="0.5"/>
                                    <defs>
                                        <linearGradient id="paint0_linear" x1="3.40361" y1="4.82609"
                                                        x2="22.9041" y2="5.91723" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="var(--primary-color)"/>
                                            <stop offset="1" stop-color="var(--primary-color)"/>
                                        </linearGradient>
                                        <linearGradient id="paint1_linear" x1="7.95181" y1="4.82609"
                                                        x2="17.7249" y2="5.09951" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="var(--primary-color)"/>
                                            <stop offset="1" stop-color="var(--primary-color)"/>
                                        </linearGradient>
                                        <linearGradient id="paint2_linear" x1="3.40361" y1="11.2826"
                                                        x2="18.3009" y2="19.6183" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="var(--primary-color)"/>
                                            <stop offset="1" stop-color="var(--primary-color)"/>
                                        </linearGradient>
                                    </defs>
                                </svg>

                                <div class="select">
                                    <span>{{Str::upper($currantLang)}}</span>
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </div>
                                <input type="hidden" name="gender">
                                <ul class="dropdown-menu">
                                    @foreach($languages as $language)
                                        <a href="{{route('change.languagestore',[$store->slug,$language])}}" class="dropdown-item @if($language == $currantLang) active-language @endif">
                                            <li>{{Str::upper($language)}}</li>
                                        </a>
                                    @endforeach
                                </ul>
                            </div>
                            <span class="msg"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="modal fade search-modal" id="demo3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog opacity-animate3 ">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{route('store.search',[$store->slug])}}" method="get">
                    <input type="search" placeholder="{{__('Type and hit enter ...')}}" name="search" id="search_box">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <img src="{{asset('assets/img/close.svg')}}" alt="close" class="img-fluid">
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


