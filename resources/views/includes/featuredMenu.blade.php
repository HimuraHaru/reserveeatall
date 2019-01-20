<!--== 12. Our Featured Dishes Menu ==-->
<section id="featured-dish" class="featured-dish">
    <img class="img-responsive section-icon hidden-sm hidden-xs" src="{{ asset('assets/images/icons/food_black.png') }}">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row dis-table">
                <div class="col-xs-6 col-sm-6 dis-table-cell color-bg">
                    <h2 class="section-title">Featured Reviews & Feedbacks</h2>
                </div>
                <div class="col-xs-6 col-sm-6 dis-table-cell section-bg">

                </div>
            </div> <!-- /.dis-table -->
        </div> <!-- /.row -->
    </div> <!-- /.wrapper -->
</section> <!-- /#featured-dish -->

<!--== 13. Menu List ==-->
<section id="menu-list" class="menu-list">
    <div class="container" id="feedbacks">
        <div class="row menu">
            <div class="col-md-10 col-md-offset-1 col-sm-9 col-sm-offset-2 col-xs-12">
                <div class="row">
                    <div class="row">
                        <div class="menu-catagory">
                            {{--<h3>Filter by:--}}
                                {{--<a href="?filter=latestDate">Latest date</a> |--}}
                                {{--<a href="?filter=mostLikes">Most likes</a> |--}}
                                {{--<a href="?filter=mostDislikes">Most dislikes</a>--}}
                            {{--</h3>--}}
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        @foreach($feedbacks as $feedback)
                        <div class="row">
                            <div class="menu-item">
                                <h3 class="menu-title">{{ ucwords(\App\User::findOrFail($feedback->userID)->name) }}</h3>
                                <p class="menu-about">{{ $feedback->created_at->format('M. d, Y') }}</p>
                                <p class="menu-about">{{ $feedback->feedbackMessage }}</p>

                                <div class="menu-system">
                                    @if(Auth::check())
                                    <div class="half">
                                        <p class="per-head">
                                            @if(\App\Like::where('userID', \App\Http\Helpers::userID())->where('feedbackID', $feedback->feedbackID)->count() == 0)
                                                <a style="text-decoration: none; color:inherit;"  href="{{ route('like-feedback', [$feedback->feedbackID, $restaurant->restaurantID, 'featured'] ) }}">
                                                    <span style="font-size: 20px;"><i class="fa fa-thumbs-up" aria-hidden="true"></i></span>
                                                </a>
                                                ({{ \App\Like::where('feedbackID', $feedback->feedbackID)->count()}})
                                            @else
                                                <span style="font-size: 20px;"><i class="fa fa-thumbs-up" style="color:#337ab7" aria-hidden="true"></i></span>
                                                ({{ \App\Like::where('feedbackID', $feedback->feedbackID)->count() }})
                                            @endif
                                        </p>
                                    </div>
                                    <div class="half">
                                        <p class="price">
                                            @if(\App\Dislike::where('userID', \App\Http\Helpers::userID())->where('feedbackID', $feedback->feedbackID)->count() == 0)
                                            <a style="text-decoration: none; color:inherit;" href="{{ route('dislike-feedback', [$feedback->feedbackID, $restaurant->restaurantID, 'featured'] ) }}">
                                                <span style="font-size: 20px;"><i class="fa fa-thumbs-down" aria-hidden="true"></i></span>
                                            </a>
                                                ({{ \App\Dislike::where('feedbackID', $feedback->feedbackID)->count() }})
                                            @else
                                                <span style="font-size: 20px;"><i class="fa fa-thumbs-down" style="color:#337ab7" aria-hidden="true"></i></span>
                                                ({{ \App\Dislike::where('feedbackID', $feedback->feedbackID)->count() }})
                                            @endif
                                        </p>
                                    </div>
                                    @else
                                        <div class="half">
                                            <p class="per-head">
                                                <span><i class="fa fa-thumbs-up" aria-hidden="true"></i></span>
                                                    Like({{ \App\Like::where('feedbackID', $feedback->feedbackID)->count() }})
                                            </p>
                                        </div>
                                        <div class="half">
                                            <p class="price">
                                                <span><i class="fa fa-thumbs-down" aria-hidden="true"></i></span>
                                                    Dislike({{ \App\Dislike::where('feedbackID', $feedback->feedbackID)->count() }})
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div id="moreMenuContent"></div>
                <div class="text-center">
                    <a href="{{ route('view-feedback', $restaurant->restaurantID) }}" class="btn btn-middle hidden-sm hidden-xs">View All</a>
                </div>

                {{--<!--Paginate-->--}}
                {{--<div>{{ $feedbacks->appends($_GET)->links() }}</div>--}}
                {{--<!--End of Paginate-->--}}
            </div>
        </div>
    </div>
</section>