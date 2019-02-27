@extends('user.layout')

@section('userTitle', $data['post']->name)
@section('seoDescription', $data['post']->seo_description)
@section('seoKeyword', $data['post']->seo_keywork)

@section('content')
    <li class="mcr">
        <div class="box m">
            <div class="btitle path">
                <a title="Trang chủ" href="/">Trang chủ</a>
                @php
                    $category = $data['post']->category;
                @endphp

                @if ($data['post']->category->parentCategory)
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
            </div>
            <div class="bCt newsView">
                <h1 class="h1 nTitle">{{ $data['post']->name }}</h1>
                <span class="date">{{ $data['post']->created_at->format('d-m-Y, H:i') }} | lượt xem: 
                    <b>{{ $data['post']->total_views }}</b>
                </span>
                <div class="nDesc">
                    {!! $data['post']->description !!}
                </div>
                <div class="nContent">
                    {!! $data['post']->detail !!}
                </div>

                <ul class="ul otherNews">
                    <li class="title"><strong>Những tin mới hơn</strong></li>
                    @foreach($data['newer-news'] as $post)
                        <li class="it">
                            <a title="{{ $post->name }}" href="{{ route('user.post.detail', [$post->slug]) }}">
                                {{ $post->name }}
                            </a>
                            <span>({{ $post->created_at->format('d-m-Y, H:i') }})</span>
                        </li>
                    @endforeach
                </ul>
                <ul class="ul otherNews">
                    <li class="title"><strong>Những tin cũ hơn</strong></li>
                    @foreach($data['older-news'] as $post)
                        <li class="it">
                            <a title="{{ $post->name }}" href="{{ route('user.post.detail', [$post->slug]) }}">
                                {{ $post->name }}
                            </a>
                            <span>({{ $post->created_at->format('d-m-Y, H:i') }})</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </li>
@endsection
