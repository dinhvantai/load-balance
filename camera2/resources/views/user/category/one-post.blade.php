@extends('user.layout')

@section('userTitle', $post->name)
@section('seoDescription', $post->seo_description)
@section('seoKeyword', $post->seo_keywork)

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
            <div id="news_detail" style="padding-top: 20px; width: 768px">
                {!! $post->detail !!}
            </div>
        </div>
    </div>
</li>
@endsection
