<div class="fCols">
    @foreach($userPostCategories as $postCategory)
        @php
            if (!$postCategory->childrenCategories->count()) continue;
        @endphp

        <ul class="ul column">
            <li class="c">
                <ul class="ul">
                    <li class="t">
                        <a title="{{ $postCategory->name }}"
                            href="{{ route('user.category.parent', [$postCategory->slug]) }}"
                        >
                            {{ $postCategory->name }}
                        </a>
                    </li>
                    @foreach($postCategory->childrenCategories as $children)
                        <li class="i">
                            <a title="{{ $children->name }}" 
                                href="{{ route('user.category.children', [$postCategory->slug, $children->slug]) }}"
                            >
                                {{ $children->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    @endforeach
    <div style="clear:both"></div>
</div>
