@extends('frontend.layouts.master')

@section('content')

    <!-- Quick View Modal Area -->
    <div class="modal fade" id="quickview" tabindex="-1" role="dialog" aria-labelledby="quickview" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <div class="quickview_body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-lg-5">
                                    <div class="quickview_pro_img">
                                        <img class="first_img" src="frontend/img/product-img/new-1-back.png" alt="">
                                        <img class="hover_img" src="frontend/img/product-img/new-1.png" alt="">
                                        <!-- Product Badge -->
                                        <div class="product_badge">
                                            <span class="badge-new">New</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-7">
                                    <div class="quickview_pro_des">
                                        <h4 class="title">Boutique Silk Dress</h4>
                                        <div class="top_seller_product_rating mb-15">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </div>
                                        <h5 class="price">$120.99 <span>$130</span></h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia expedita quibusdam aspernatur, sapiente consectetur accusantium perspiciatis praesentium eligendi, in fugiat?</p>
                                        <a href="#">View Full Product Details</a>
                                    </div>
                                    <!-- Add to Cart Form -->
                                    <form class="cart" method="post">
                                        <div class="quantity">
                                            <input type="number" class="qty-text" id="qty" step="1" min="1" max="12" name="quantity" value="1">
                                        </div>
                                        <button type="submit" name="addtocart" value="5" class="cart-submit">Add to cart</button>
                                        <!-- Wishlist -->
                                        <div class="modal_pro_wishlist">
                                            <a href="wishlist.html"><i class="icofont-heart"></i></a>
                                        </div>
                                        <!-- Compare -->
                                        <div class="modal_pro_compare">
                                            <a href="compare.html"><i class="icofont-exchange"></i></a>
                                        </div>
                                    </form>
                                    <!-- Share -->
                                    <div class="share_wf mt-30">
                                        <p>Share with friends</p>
                                        <div class="_icon">
                                            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                            <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                                            <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                                            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                            <a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View Modal Area -->

    <!-- Breadcumb Area -->
    <div class="breadcumb_area">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <h5>Shop Grid</h5>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{$categories->title}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcumb Area -->

    <section class="shop_grid_area section_padding_100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Shop Top Sidebar -->
                    <div class="shop_top_sidebar_area d-flex flex-wrap align-items-center justify-content-between">
                        <div class="view_area d-flex">
                            <div class="grid_view">
                                <a href="shop-grid-left-sidebar.html" data-toggle="tooltip" data-placement="top" title="Grid View"><i class="icofont-layout"></i></a>
                            </div>
                            <div class="list_view ml-3">
                                <a href="shop-list-left-sidebar.html" data-toggle="tooltip" data-placement="top" title="List View"><i class="icofont-listine-dots"></i></a>
                            </div>
                        </div>
{{--                        <select class="small right">--}}
{{--                            <option selected>Short by Popularity</option>--}}
{{--                            <option value="1">Short by Newest</option>--}}
{{--                            <option value="2">Short by Sales</option>--}}
{{--                            <option value="3">Short by Ratings</option>--}}
{{--                        </select>--}}

                        <select id="sortBy" class="small right">
                            <option selected>Default</option>
                            <option value="priceASC" >Price - Lower to Higher</option>
                            <option value="priceDesc">Price - Higher to Lower</option>
                            <option value="titleASC">Alphabetical Ascending</option>
                            <option value="titleDesc">Alphabetical Descending</option>
                            <option value="discASC">Discount - Lower to Higher</option>
                            <option value="discDesc">Discount - Higher to Lower</option>
                        </select>
                    </div>


                    <div class="shop_grid_product_area">
                        <div class="row justify-content-center" id="product-data">

                            @include('frontend.layouts.single-product')


                        </div>
                    </div>

                    <div class="ajax-load text-center" style="display: none">
                        <img src="{{asset('frontend/img/loader.gif')}}" style="width: 6%;">

                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

    <script>

        $('#sortBy').change(function(){
            var sort=$('#sortBy').val();
            window.location="{{url(''.$route.'')}}/{{$categories->slug}}?sort="+sort;
        });

    </script>

    <script>

        function loadmoreData(page){
            $.ajax({
                url:'?page='+page,
                type:'get',
                beforeSend:function (){
                    $('.ajax-load').show();
                },
            })
                .done(function (data){
                    if(data.html==''){
                        $('.ajax-load').html('No More Product Available');
                        return;
                    }
                    $('.ajax-load').hide();
                    $('#product-data').append(data.html);
                })
                .fail(function (){
                    alert('Something Went Wrong! Please Try Again Later');
                });
        }
        var page=1;
        $(window).scroll(function (){
            if($(window).scrollTop()+$(window).height()+120>=$(document).height()){
                page ++;
                loadmoreData(page);
            }
        })
    </script>
@endsection
