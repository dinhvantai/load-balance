@extends('user.layout')

@section('userTitle', $category->name)
@section('seoDescription', $category->seo_description)
@section('seoKeyword', $category->seo_keywork)

@section('content')
    <li class="mcr">
        <div class="box m">
            <div class="btitle path" style="margin-bottom: 20px">
                <a title="Trang chủ" href="/">Trang chủ</a>&nbsp;»&nbsp;
                <a href="{{ route('user.category.parent', [$category->slug]) }}" title="{{ $category->name }}">
                    {{ $category->name }}
                </a>
            </div>

            @foreach ($categories as $childrenCategory)
                @php
                    if (!$childrenCategory->posts->count()) { continue; }
                @endphp
                <div class="btitle" style="margin-top: 10px">
                    @if ($childrenCategory->parentCategory)
                        <a 
                            title="{{ $category->name }}" 
                            href="{{ route('user.category.children', [$category->slug, $childrenCategory->slug]) }}"
                        >
                    @else
                        <a 
                            title="{{ $childrenCategory->name }}" 
                            href="{{ route('user.category.parent', [$childrenCategory->slug]) }}"
                        >
                    @endif
                        <span>
                            <span>{{ $childrenCategory->name }}</span>
                        </span>
                    </a>
                </div>
                <div class="bCt highLightNews">
                    <div class="cols_bg">
                        <ul class="ul" style="float:left; width:414px;">
                            @php
                                $firstPost = $childrenCategory->posts->first();
                            @endphp
                            <li class="f">
                                <a title="{{ $firstPost->name }}" href="{{ route('user.post.detail', [$firstPost->slug]) }}">
                                    <span class="t">{{ $firstPost->name }}</span>
                                    <img 
                                        style="max-width:130px; max-height:100px; float:left;" 
                                        border="0" alt="{{ $firstPost->name }}"
                                        src="{{ Croppa::url('/' . $firstPost->image, 100, null, array('resize')) }}"
                                    />    
                                </a>
                                <p>{!! $firstPost->description !!}</p>
                            </li>
                        </ul>
                        @php
                            $posts = $childrenCategory->posts->where('id', '<>', $firstPost->id);
                        @endphp

                        @if ($posts->count())
                            <ul class="ul" style="float:right; width:305px;">
                                @foreach ($posts as $post)
                                    <li  class="i">
                                        <a title="{{ $post->name }}" href="{{ route('user.post.detail', [$post->slug]) }}">
                                            {{ $post->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif    
                        <div style="clear:both"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </li>
@endsection
