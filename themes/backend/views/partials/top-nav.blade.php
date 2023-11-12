<ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
        <div class="d-flex">

            <div class="info">
                <div class="image" role="button" data-toggle="dropdown">
                    <img src="{{ URL::asset('/images/image4.png') }}" class="img-circle elevation-2" alt="User Image"
                        width="40" height="40">
                </div>
                <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">

                    <div class="d-flex align-items-center account">
                        <img src="{{ URL::asset('/images/image4.png') }}" class="img-circle elevation-2 mr-4"
                            alt="User Image" width="40" height="40">
                        <div>
                            <h3 class="mb-0">Tên tài khoản</h3>
                            <p>{{ $currentUser->name }}</p>
                        </div>
                    </div>
                    <div class="mt-4 mb-3 d-flex align-items-center">
                        <img class="mr-3" src="{{ URL::asset('/images/user.svg') }}" alt="">

                        <a href="{{ route('admin.profile.edit')}}">
                            <p>
                                {{ trans('backend::profile.label.profile') }}
                            </p>
                        </a>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="d-flex justify-content-between align-items-center my-3 langauge">
                        <div class="d-flex align-items-center">
                            <img class="mr-3" src="{{ URL::asset('/images/global.svg') }}" alt="">
                        <p>Ngôn ngữ</p>
                        </div>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn active">
                                <input type="radio" name="options" id="option1" autocomplete="off" checked> EN
                            </label>
                            <label class="btn">
                                <input type="radio" name="options" id="option2" autocomplete="off"> VI
                            </label>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="mt-3 mb-2 d-flex align-items-center">
                            <img class="mr-3" src="{{ URL::asset('/images/logout.svg') }}" alt="">
                            <p>
                            <a href="{{ route('logout') }} " style="color: #E60019"
                                onclick="event.preventDefault();
                                                     document.getElementById('admin-logout-form').submit();">
                                {{ __('Đăng xuất') }}
                            </a>
                        </p>
                    </div>
                    <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>


    </li>


</ul>
