@include('layout.head')

<div class="container">

    <div class="blog-header">
    </div>

    <div class="row">
            @yield('content')
            @include('layout.slider')

</div>    </div><!-- /.row -->
</div><!-- /.container -->

@include('layout.footer')
