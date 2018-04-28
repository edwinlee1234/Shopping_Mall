@extends('Page/Customer/App')

@section('title', $title)

@section('content')
<div id="Home">
    <div class="row">
        <div class="col-xl-12">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="https://placeimg.com/1080/500/animals" alt="First slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>My Caption Title (1st Image)</h5>
                            <p>The whole caption will only show up if the screen is at least medium size.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="https://placeimg.com/1080/500/arch" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="https://placeimg.com/1080/500/nature" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    <div class="showcase">
        <div class="row">
            <div class="col-xl-12">
                <h1 class="ser1-title">XXXXX</h1>
                <hr>
            </div>
        </div>
        <div class="showcase-img">
            <div class="row">
                <div class="col">
                    <img class="ser1-img" src="https://placeimg.com/1080/500/nature" alt="">
                </div>
                <div class="col">
                    <img class="ser1-img" src="https://placeimg.com/1080/500/nature" alt="">
                </div>
                <div class="col">
                    <img class="ser1-img" src="https://placeimg.com/1080/500/nature" alt="">
                </div>
            </div>
        </div>
    </div>


</div>
@endsection

@section('script')
@parent
<script type="text/javascript">
    $('.carousel').carousel({
        interval: 2000
    })
</script>

@endsection