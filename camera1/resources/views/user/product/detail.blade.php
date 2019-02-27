@extends('user.layout')

@section('userTitle', $data['product']->name)
@section('seoDescription', $data['product']->seo_description)
@section('seoKeyword', $data['product']->seo_keywork)

@section('content')
<li class="mcr">
    <div class="box m proView">
        <div class="btitle path">
            <a title="Trang chủ" href="/">Trang chủ</a>
            @php
                $category = $data['product']->category;
            @endphp
            @if ($data['product']->category->parentCategory)
                <span class="breakcolumn">»</span>
                <a 
                    href="{{ route('user.category.parent', [$category->parentCategory->slug]) }}" 
                    title="{{ $category->parentCategory->name }}"
                >
                    {{ $category->parentCategory->name }}
                </a>
                <span class="breakcolumn">»</span>
                <a 
                    href="{{ route('user.category.children', [$category->parentCategory->slug, $category->slug]) }}" 
                    title="{{ $category->name }}"
                >
                    {{ $category->name }}
                </a>
            @else
                <span class="breakcolumn">»</span>
                <a 
                    href="{{ route('user.category.parent', [$category->slug]) }}" 
                    title="{{ $category->name }}"
                >
                    {{ $category->name }}
                </a>
            @endif
            <div class="clear"></div>
        </div>
        <div class="bCt">
            <h1>{{ $data['product']->name }}</h1>
            <ul class="ul view">
                <li class="img">
                    <a href="javascript:void(0)" class="group1 cboxElement">
                        <img src="{{ Croppa::url('/' . $data['product']->image, 240, null, array('resize')) }}" 
                            alt="{{ $data['product']->name }}" width="140px" 
                            style="max-width:240px; max-height:200px;" border="0" 
                        />
                    </a>
                    <div class="clear"></div>
                    <div class="pr"></div>
                </li>
                <li class="buy_frm">
                    <div class="frm_t">Thông tin sản phẩm</div>
                    <span style="color: #bcbcbc;">
                        Đăng ngày {{ $data['product']->created_at->format('d-m-Y, H:i') }}
                            - {{ $data['product']->total_views }} lượt xem
                    </span>
                    <p>
                        Giá : <span style="color: #119EB2;font-weight: bold;font-size: 13px;">{{ $data['product']->price }}</span>
                    </p>
                        
                    @if ($data['product']->guarantee)
                        <span class="time_up" style="font-weight:bold">
                            Bảo hành: {{ $data['product']->guarantee }}
                        </span>
                    @endif
                    <br>
                        
                    <div style="margin-top:10px">
                        {{ $data['product']->description }}
                    </div>
                </li>
            </ul>
            <div style="clear:both"></div>
        </div>
    </div>

    <div class="box m detail-product">
        <script>
            function changeProductTab(event) {
                let parents = document.getElementsByClassName('user-product-tab');
                for(let i = 0; i < parents.length; i++) {
                    parents[i].classList.remove('active');
                }
                event.classList.add('active')
                
                let children = document.getElementsByClassName('user-product-tab-view');
                for(let i = 0; i < children.length; i++) {
                    children[i].style.display = 'none';
                }

                let id = event.getAttribute('data-target')
                let element = document.getElementById(id)
                if (element) {
                    element.style.display = 'block';
                }
            }
        </script>
        <div style="color:#0000ff; padding-left: 0px" class="btitle">
            <a href="javascript:void(0)" class="active user-product-tab" data-target="user-product-detail"
                onclick="changeProductTab(this)"
            >
                Chi tiết sản phẩm
            </a>
            <a href="javascript:void(0)" class="user-product-tab" data-target="user-product-guide"
                onclick="changeProductTab(this)"
            >
                Hướng dẫn sử dụng
            </a>
        </div>
        <div class="user-product-tab-view bCt" id="user-product-detail" style="display: block; text-align:justify; line-height:20px">
            {!! $data['product']->detail !!}
        </div>
        <div class="user-product-tab-view bCt" id="user-product-guide" style="display: none; text-align:justify; line-height:20px">
            {!! $data['product']->guide !!}
        </div>
    </div>
    <div style="margin-top:10px" class="box m">
        <div style="color:#0000ff" class="btitle">SẢN PHẨM CÙNG LOẠI</div>
        <div class="bCt productLs">
            @foreach ($data['productRelation'] as $product)
                <div class="it">
                    <a title="{{ $product->name }}" href="{{ route('user.product.detail', [$product->slug]) }}">
                        <span class="t">{{ $product->name }}</span>
                        <img 
                            style="max-width:120px; max-height:100px;" border="0"
                            src="{{ Croppa::url('/' . $product->image, 120, null, array('resize')) }}" alt="{{ $product->name }}" 
                        />
                    </a>
                    <div class="pr">{{ $product->price }}</div>
                    <p>
                        {{ $product->description }}
                    </p>
                </div>
                @if ($loop->index % 4 === 3)
                    <div class="clear"></div>
                @endif
            @endforeach
        </div>
    </div>
</li>

@endsection
