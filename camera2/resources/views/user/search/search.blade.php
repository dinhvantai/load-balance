@extends('user.layout')

@section('userTitle', 'Tìm kiếm')
@section('seoDescription', 'Tìm kiếm')
@section('seoKeyword', 'Tìm kiếm')

@section('content')
    <li class="mcr">
        <div class="box m">
            <div class="btitle path">
                <a title="Trang chủ" href="/">Trang chủ</a>&nbsp;»&nbsp;
                <span>Tìm kiếm cho từ khóa "{{ url()->getRequest()->key }}"</span>
                - Có <b>{{ $products->total() }}</b> sản phẩm
            </div>
            <div class="bCt productLs">
                @if(!$products->count())
                    <div
                        style="font-size: 15px; padding: 20px; margin: 10px 10px 25px;text-align:center; width: 708px"
                    >
                        Không có sản phẩm nào với từ khóa bạn vừa nhập vào
                    </div>
                @endif
                @foreach ($products as $product)
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
                <div style="text-align:center;" class="pages">
                    <div style="display:inline-block;">
                        {{ $products->appends(['key' => url()->getRequest()->key])->links('user.component.custom-paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </li>
@endsection
