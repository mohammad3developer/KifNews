<div class="collapse  nav-desk" id="navbarToggleExternalContent">
    <ul class="nav-cat title-font">
        @foreach($categories as $item)
            <li><a href="/product/category/{{$item->id}}/1/12">محصول - {{$item->title}}</a></li>
        @endforeach
    </ul>
</div>
