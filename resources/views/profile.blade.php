<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta id="token" name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <style type="text/css">
        .no-bottom {
            bottom: 0;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
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
                  </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
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
                  </div>
            </div>
            <div class="jumbotron no-bottom"></div>
        </nav>

        <nav class="navbar navbar-default">
          <div class="container">
            <div class="navbar-header col-md-2">
                <a href="{{ url('/' . $user->username) }}">
                    <h4><strong>{{ $user->username }}</strong></h4>
                </a>
                <a href="{{ url('/' . $user->username) }}">
                    <small>&#64;{{ $user->username }}</small>
                </a>
            </div>
            <div class="col-md-8">
              <ul class="nav navbar-nav">
              @if ($is_edit_profile ?? '')
              <li class="{{ !Route::currentRouteNamed('following') ?: 'active' }}">
                  <a href="{{ url('/' . $user->username . '/following') }}" class="text-center">
                      <div class="text-uppercase">Following</div>
                      <div>{{ $following_count }}</div>
                  </a>
              </li>
              @endif
              <li class="{{ !Route::currentRouteNamed('followers') ?: 'active' }}">
                  <a href="{{ url('/' . $user->username . '/followers') }}" class="text-center">
                      <div class="text-uppercase">Followers</div>
                      <div>{{ $followers_count ?? '' }}</div>
                  </a>
              </li>

             </ul>
            </div>
            <div class="col-md-2">
                @if (Auth::check())
                  @if ($is_edit_profile ?? '')
                  <a href="#" class="navbar-btn navbar-right">
                      <button type="button"  class="btn btn-default">LARATWEET
                        </button>
                  </a>
                      @else
                    <button type="button" v-on:click="follows" class="navbar-btn navbar-right btn btn-default">@{{ followBtnText }}</button>
                  </a>
                  @endif
                @endif
            </div>
          </div>
        </nav>

        @yield('content')
      </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <!-- <script src="/js/app.js"></script> -->
  <script src="https://unpkg.com/vue@2.1.10/dist/vue.js"></script>
  <script src="https://unpkg.com/vue-resource@1.2.0/dist/vue-resource.min.js"></script>
  <script>
      new Vue({
          el: '#app',
             data: {
              username: '{{ $user->username }}',
              isFollowing: {{ $is_following ?? '' ? 1 : 0 }},
              followBtnTextArr: ['Follow', 'Unfollow'],
              followBtnText: ''
          },        methods: {
              follows: function (event) {
                  var csrfToken = Laravel.csrfToken;
                  var url = this.isFollowing ? '/unfollows' : '/follows';
                         this.$http.post(url, {
                      'username': this.username
                  }, {
                      headers: {
                          'X-CSRF-TOKEN': csrfToken
                      }
                  })
                  .then(response => {
                      var data = response.body;
                        if (!data.status) {
                          alert(data.message);
                          return;
                      }
                                this.toggleFollowBtnText();
                  });
                   },
                      toggleFollowBtnText: function() {
                  this.isFollowing = (this.isFollowing + 1) % this.followBtnTextArr.length;
                  this.setFollowBtnText();
              },            setFollowBtnText: function() {
                  this.followBtnText = this.followBtnTextArr[this.isFollowing];
              }
          },        mounted: function() {
              this.setFollowBtnText();
          }
      });
  </script>
</body>
</html>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Tweets</div>

                <div class="panel-body">
                   <div class="list-group">
                    @forelse ($user->tweets()->get() as $tweet)
                      <a href="#" class="list-group-item">
                        <h4 class="list-group-item-heading">{{ $tweet->body }}</h4>
                        <p class="list-group-item-text">{{ $tweet->created_at }}</p>

                          <div class = "ShowTimeline">
                            <div class = "interaction">
                              @if ($is_edit_profile ?? '')
                              <li>
                                <!-- Delete -->
                                <a href="{{ route('tweet.delete', ['tweet_id' => $tweet->id]) }}">Delete</a>

                        </li>
                        @endif
                      </a>

                    @empty
                      <p>No tweet</p>
                    @endforelse
                  </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Messages</h2>

            <div
                class="clearfix"
                v-for="message in messages"
            >
                @{{ message.user.name }}: @{{ message.message }}
            </div>

            <div class="input-group">
                <input
                    type="text"
                    name="message"
                    class="form-control"
                    placeholder="Type your message here..."
                    v-model="newMessage"
                    @keyup.enter="sendMessage"
                >

                <button
                    class="btn btn-primary"
                    @click="sendMessage"
                >
                    Send
                </button>
            </div>
        </div>
    </div>
</div>
@endsection