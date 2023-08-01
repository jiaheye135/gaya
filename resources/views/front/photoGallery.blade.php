@extends('front.layouts.main')

@section('content')

@include('front.include.breadcrumb')

<!-- END MAIN CONTENT -->
<div class="main_content">
    <!-- START SECTION -->
    <div class="section pb_40 photo-gallery">
        <div class="container">
            @if ($category)
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="select-search-bar">
                        <div class="custom-select" style="width: 100%;">
                            <select id="categorySelect" onchange="changeSelect()">
                                @foreach ($categorySelect as $i => $v)
                                <option value="{{ $i }}" {{ $v->selected }}>{{ $v->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="intro">
                <h2 class="text-center" style="margin-bottom: 20px;">{{ $category->name }}</h2>
                @if ($category->introduction)
                <p class="text-center">{{ $category->introduction }}</p>
                @endif
            </div>
            <div class="row photos">
                @foreach ($photoData as $v)
                <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="{{ $basePath . $v->img }}" data-lightbox="photos" class="limited-photo"><img class="img-fluid" src="{{ $basePath . $v->img }}"></a></div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
<!-- END MAIN CONTENT -->

<script>
    function changeSelect(){
        var s = $('#categorySelect').val();
        if({{ $selectedI }} == s) return;

        location.href = @json($categorySelect)[s].href;
    }
</script>
@endsection