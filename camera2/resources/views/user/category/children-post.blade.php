@extends('user.layout')

@section('userTitle', $category->name)
@section('seoDescription', $category->seo_description)
@section('seoKeyword', $category->seo_keywork)

@section('content')
<li class="mcr">
    <div class="box m">
        <div class="btitle path">
            <a title="Trang chủ" href="/">Trang chủ</a>
            <span class="breakcolumn">»</span>
            <a href="{{ route('user.category.parent', [$categoryParent->slug]) }}" 
                title="{{ $categoryParent->name }}"
            >
                {{ $categoryParent->name }}
            </a>
            <span class="breakcolumn">»</span>
            <a href="{{ route('user.category.children', [$categoryParent->slug,$category->slug]) }}"
                title="{{ $category->name }}"
            >
                {{ $category->name }}
            </a>      
        </div>
        <div class="bCt nsList">
            @foreach ($posts as $post)
                <div style="{{ ($loop->index ===  0) ? 'border:none; padding-top:15px' : '' }}" class="it">
                    <a href="{{ route('user.post.detail', [$post->slug]) }}" title="{{ $post->name }}">
                        <img alt="{{ $post->name }}" src="{{ Croppa::url('/' . $post->image, 130, null, array('resize')) }}"
                            style="max-width:130px; max-height:100px;" border="0" class="float"
                        />
                    </a>
                    <a href="{{ route('user.post.detail', [$post->slug]) }}" title="{{ $post->name }}">
                        <h3 class="title">{{ $post->name }}</h3>
                    </a>
                    <span class="date">{{ $post->created_at->format('d-m-Y, H:i') }}</span>
                    <div class="desc">
                        {!! $post->description !!}
                    </div>
                    <div class="details">
                        <a href="{{ route('user.post.detail', [$post->slug]) }}" title="{{ $post->name }}">Xem tiếp »</a>
                    </div>
                    <div style="clear:both"></div>
                </div>
            @endforeach
            <div class="clear"></div>
            <div style="text-align:center;" class="pages">
                <div style="display:inline-block;">
                    {{ $posts->links('user.component.custom-paginate') }}
                </div>
            </div>
        </div>
    </div>
</li>
@endsection
