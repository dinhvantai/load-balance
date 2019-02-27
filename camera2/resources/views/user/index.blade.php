@extends('user.layout')

@php
    $options = '';
    if($userSetups) {
        $options = json_decode($userSetups->option, true);
    }
@endphp

@section('userTitle', $options ? $options['title'] : 'Trang chủ')
@section('seoDescription', $userSetups ? $userSetups->seo_description : 'Trang chủ')
@section('seoKeyword',  $userSetups ? $userSetups->seo_keyword : 'Trang chủ')

@section('content')
    <li class="mcr">
        @include('user.library.slider')

        <div class="clear10px"></div>

        @foreach($homeCategories as $category)
            <div class="box m">
                <div style="color:#ee344b; text-transform:uppercase" class="btitle">{{ $category->name }}</div>
                <div class="bCt productLs">
                    @foreach ($category->products as $product)
                        <div class="it  ">
                            <a href="{{ route('user.product.detail', [$product->slug]) }}" title="{{ $product->name }}">
                                <span class="t">{{ $product->name }}</span>
                                <img style="max-width:120px; max-height:100px;"
                                    src="{{ Croppa::url('/' . $product->image, 120, null, array('resize')) }}" 
                                    alt="{{ $product->name }}" border="0"
                                    style="max-height:80px;max-width:80px;"
                                />
                            </a>
                            {{--  <div class="pr_old">
                                <del>5.000.000</del>
                            </div>  --}}
                            <div class="pr">{{ $product->price }}</div>
                            @if ($product->guarantee)
                                <p class="time_up">Bảo hành: {{ $product->guarantee }}</p>
                            @endif
                            <p>
                                {{ $product->description }}
                            </p>
                        </div>
                    @endforeach
                    @if ($loop->index % 4 === 3)
                        <div class="clear"></div>
                    @endif
                </div>
            </div>
            <div class="clear10px"></div>
        @endforeach
    </li>
@endsection
