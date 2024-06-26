<a href="{{ route('profile') }}">
    <span class="icon text-oss-royal-blue fill-current" title="{{auth()->user()->isSponsoring() ? 'You\'re awesome!' : 'Profile' }}">
        <span class="mr-2 md:hidden">Profile</span>
        @if (auth()->user()->isSponsoring())
            <span style="font-size: .6rem" class="absolute z-10 top-0 right-0 -mr-2 -mt-1 icon text-pink">
                {{ app_svg('icons/fas-heart') }}
            </span>
        @endif
        {{ $active ? app_svg('icons/fas-user') : app_svg('icons/far-user') }}
    </span>
</a>
