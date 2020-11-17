<div>
  <div class="panel-heading">Search for users here</div>
<ul class="navbar-nav ml-auto">
  <form action="/search" method="POST" role="search">
{{ csrf_field() }}
<div class="input-group">
  <input type="text" class="form-control" name="q"
      placeholder="Search users"> <span class="input-group-btn">
        <button type="submit" class="btn btn-default">Search
          <span class="glyphicon glyphicon-search"></span>
      </button>
  </span>
</div>
</div>
</form>

<div class="panel-body">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    {{ Auth::user()->name }} <span class="caret"></span>
                  <form method="POST" action="/tweet">
        {{ csrf_field() }}
         @if ($errors->has('tweet_body'))
          <div class="form-group input-group has-error">
        @else
        <div class="form-group input-group">
        @endif
          <div class="form-group input-group">
            <input type="text" class="form-control" id="tweet_body" name="tweet_body" placeholder="What's popping?">
            <div class="container">
              <div class="row">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit">Tweet</button>
            </span>
          </div>
        </div>
      </div>
      </div>
    </div>
    </form>
  </div>

<div class="panel-body">
  <div class="panel-heading">Timeline</div>
    @forelse ($user->timeline() as $tweet)
        <a href="#" class="list-group-item">
          <p class="list-group-item-heading">{{ $tweet->author->username }}</p>
            <h4 class="list-group-item-heading">{{ $tweet->body }}</h4>
            <p class="list-group-item-text">{{ $tweet->created_at }}</p>

            <div class = "interaction">
              @section('content')
              <!--like button goes here-->
              @if(Auth::check())

          @if ($is_follow_button ?? '')
            <a href="{{ url('/follows/' . $user->username) }}" class="navbar-btn navbar-right">
                <button type="button" class="btn btn-default">Follow</button>
            </a>
            @else
            <a href="{{ url('/unfollows/' . $user->username) }}" class="navbar-btn navbar-right">
                <button type="button" class="btn btn-default">Unfollow</button>
            </a>
            @endif
@endif
              <a href="#">Retweet</a>

            </div>
        </a>
    @empty
        <p>No tweet</p>
    @endforelse
</div>
</div>

@extends ('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                  <div class="panel-body" id="list-1" v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="10">
                  <template v-for="tweet in items">
                     <div class="list-group-item">
                         <h4 class="list-group-item-heading">@{{ tweet.author.name}}</h4>
                         <p>@{{ tweet.body }}</p>
                         <div class="list-group-item-text panel panel-default">
                             <div class="media">
                                 <div class="media-middle">
                                     <img class="media-object center-block" src="https://cdn.boogiecall.com/media/images/872398e3d9598c494a2bed72268bf018_1440575488_7314_s.jpg">
                                 </div>
                                 <div class="media-body panel-body">
                                     <h3 class="media-heading">
                                         Events, parties & live concerts in Melbourne
                                     </h3>
                                     <div>
                                         List of events in Melbourne. Nightlife, best parties and concerts in Melbourne, event listings and reviews.
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <p class="list-group-item-text">@{{ tweet.created_at }}</p>
                     </div>
                  </template>

                </div>
                <template v-for="item in items">
                  <tweet-component :tweet="item"></tweet-component>
              </template>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://unpkg.com/vue-resource@1.2.0/dist/vue-resource.min.js"></script>
<script src="https://unpkg.com/vue-infinite-scroll@2.0.0"></script>
<script type="text/javascript">
    var page = 1;
    Vue.component('tweet-component', {
  props: ['tweet'],
  template: '\
    <div v-if="tweet.author" class="list-group-item">\
        <h4 class="list-group-item-heading">@{{ tweet.author.name }}</h4>\
        <p v-if="tweet.link && tweet.link.short_url">@{{ tweet.link.url }}</p>\
        <p v-else>@{{ tweet.body }}</p>\
        <div class="list-group-item-text panel panel-default" v-if="tweet.link">\
            <a v-bind:href="tweet.link.short_url || tweet.link.url" target="_blank" style="text-decoration: none;">\
                <div class="media">\
                    <div class="media-middle">\
                        <img class="media-object center-block" style="max-width: 100%;" v-bind:src="tweet.link.cover">\
                    </div>\
                    <div class="media-body panel-body">\
                        <h3 class="media-heading">\
                            @{{ tweet.link.title }}\
                        </h3>\
                        <div>\
                            @{{ tweet.link.description }}\
                        </div>\
                    </div>\
                </div>\
            </a>\
        </div>\
        <p class="list-group-item-text">@{{ tweet.created_at }}</p>\
    </div>\
  '
});
       new Vue({
      el: '#list-1',
      data: {
        page: 1,
        items: [],
        busy: false
      },
      methods: {
        loadMore: function() {
            this.busy = true;
                var url = '/timeline' + (this.page > 1 ? '?page=' + this.page : '');
                         this.$http.get(url)
            .then(response => {
                var data = response.body;
                      // Push the response data into items
                for (var i = 0, j = data.length; i < j; i++) {
                  this.items.push(data[i]);
                }                // If the response data is empty,
                // disable the infinite-scroll
                this.busy = (j < 1);
                 // Increase the page number
                this.page++;
            });
        }
      }
    });
</script>
@endsection
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top no-bottom">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>

                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                                <li><a href="{{ url('/login') }}">Login</a></li>
                                <li><a href="{{ url('/register') }}">Register</a></li>
                            @else
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ url('/logout') }}"
                                                onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </ul>
                  </div>
            </div>
            <div class="jumbotron no-bottom"></div>
        </nav>

@inject('trending', 'App\Helpers\Trending')

@php
    $trendings = $trending::weekly();
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Trending</div>
                    <div class="card-body">
                        @if($trendings->count())
                            <ul>
                                @foreach($trendings as $key => $each)
                                   <li>
                                        <div class="article">
                                            <a href="{{ asset($each->url) }}" title="{{ $each->views }}">
                                                <span class="text-muted">{{ $each->tweet->created_at->format('d M, Y') }}</span><br>
                                                {{ $each->tweet->body }}
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
