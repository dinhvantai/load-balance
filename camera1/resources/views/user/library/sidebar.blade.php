<li class="mcl">
    @foreach($userCategories as $category)
        <div class="box s">
            <div class="btitle">
                <a style="color:#FFFFFF" title="{{ $category->name }}" href="{{ route('user.category.parent', [$category->slug]) }}">
                    <span>{{ $category->name }}</span>
                </a>
            </div>
            <div class="bCt">
                @if ($category->childrenCategories)
                    <ul class="ul catLs">
                        @foreach($category->childrenCategories as $children)
                            <li class="f">
                                <a title="{{ $children->name }}" href="{{ route('user.category.children', [$category->slug, $children->slug]) }}">
                                    {{ $children->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endforeach

        <div class="box s">
            <div class="btitle" style="background: #DCDCDC">
                <a href="{{ route('user.post.list') }}" style="color: #bb0404">Tin nổi bật</a>
            </div>
            <div class="blocknews-hots">
                <ul>
                    @foreach($userHotPosts as $post)
                        <li>
                            <a title="{{ $post->name }}" href="{{ route('user.post.detail', [$post->slug]) }}">
                                <img src="{{ Croppa::url('/' . $post->image, 40, null, array('resize')) }}" 
                                    alt="{{ $post->name }}"
                                />
                                <h3>{{ $post->name }}</h3>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    <div class="box adsBox">
        <ul class="ul">
            <li>
                @foreach($userBanners['ad'] as $bannerAd)
                    <a href="{{ $bannerAd->link }}" title="{{ $bannerAd->name }}" target="_blank"  rel="nofollow">
                        <img src="{{ Croppa::url('/' . $bannerAd->image, 190, null, array('resize')) }}" 
                            style="width: 190px" alt="{{ $bannerAd->name }}" 
                        />
                    </a>
                @endforeach
            </li>
        </ul>
    </div>
</li>
