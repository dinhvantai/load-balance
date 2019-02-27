@extends('user.layout')

@section('userTitle', $category->name)
@section('seoDescription', $category->seo_description)
@section('seoKeyword', $category->seo_keywork)

@section('content')
    <li class="mcr">
        <div class="box m">
            <div class="btitle path">
                <a title="Trang chủ" href="/">Trang chủ</a>&nbsp;»&nbsp;
                <a href="{{ route('user.category.parent', [$category->slug]) }}" title="{{ $category->name }}">
                    {{ $category->name }}
                </a>
            </div>
            <div class="bCt productLs">
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
                <div class="clear"></div>
                <div style="text-align:center;" class="pages">
                    <div style="display:inline-block;">
                        {{ $products->links('user.component.custom-paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </li>
@endsection
