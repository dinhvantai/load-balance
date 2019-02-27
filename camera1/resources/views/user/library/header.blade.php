@php
    $options = '';
    if($userSetups) {
        $options = json_decode($userSetups->option, true);
    }
@endphp

<div class="hdr">
    <div class="hdr_top" style="position:relative;">
        <a title="Trang chủ" class="logo" href="/">
            @if ($options && $options['logo'] && $options['logo'] != 'images/icons/logo.png')
                <img src="{{ Croppa::url('/' . $options['logo'], null, 76, array('resize')) }}" 
                    alt="Camera289" border="0" class="png"
                    style="border:none"
                />
            @else
                <img src="/images/icons/logo.png" alt="Camera289" 
                    border="0" class="png"
                    style="border:none"
                />
            @endif
        </a>
        <div id="support-header-right">
            <span style="font-size: large; color: #333399;" data-mce-mark="1">
                <strong>Địa chỉ : </strong>
                Số 5, ngõ 289 Hoàng Mai, Hà Nội
            </span>
            <br/>
            <span style="font-size: 15px; color: #ff0000;" data-mce-mark="1">
                <strong>Điện thoại: 0975.801.420 - 0944.375.603 - 0943.044.115</strong>
            </span>
        </div>
        <div style="clear:both"></div>
    </div>
    <div class="navbar">
        <ul class="ul nav">
            <li>
                <div class="c">
                    <a title="Trang chủ" href="/">Trang chủ</a>
                </div>
            </li>
            @foreach($userMenu['left'] as $menu)
            <li>
                <div class="c">
                    <a title="{{ $menu->name }}" href="{{ $menu->path }}">
                        {{ $menu->name }}
                    </a>
                </div>
            </li>
            @endforeach

            @foreach($userMenu['right'] as $menu)
            <li>
                <div class="c">
                    <a title="{{ $menu->name }}" href="{{ $menu->path }}">
                        {{ $menu->name }}
                    </a>
                </div>
            </li>
            @endforeach
        </ul>
        <form method="get" action="/search" class="search">
            <ul class="ul png search">
                <li class="ip">
                    <input type="text" class="cssInput" name="key" placeholder="Từ khóa cần tìm kiếm...">
                    <input type="submit" class="cssSubmit" id="search" value="" style="height: 22px">
                </li>
            </ul>
        </form>
        <div style="clear:both"></div>
    </div>
</div>
<div style="clear:both"></div>

@if ($userBanners['partner']->count())
    <div id="list-hotline-header">
        <div style="background: #f3f3f3; color: rgb(84, 84, 84);word-spacing: -1px;text-indent: 20px;font-weight: normal;padding: 10px 0px">
            <span style="color:rgb(0, 0, 205);font-size: 18px">Khách hàng - Đối tác chính</span>
        </div>
        <div style="height: 70px; width: 970px; margin: 0 auto; overflow: hidden;">
            <div 
                style="height: 70px; width: 1200px; 
                    margin: 0 0;animation: notify_textmove 25s linear infinite;
                    -webkit-animation: notify_textmove 25s linear infinite;"
            >
                @foreach($userBanners['partner'] as $partner)
                    <a href="{{ $partner->link }}">
                        <img alt="{{ $partner->name }}" height="50" src="/{{ $partner->image }}">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif
