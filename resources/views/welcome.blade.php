<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token() }}">
        <div class=”title m-b-md”>
          Laratweet
        </div>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
    </head>
    <body class="antialiased">
        <div id="app" class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endif
                </div>
            @endif

        <div class="container">
      @if(isset($details))
          <p> The Search results for your query <b> {{ $query }} </b> are :</p>
      <h2>Sample User details</h2>
      <table class="table table-striped">
          <thead>
              <tr>
                  <th>Name</th>
                  <th>Username</th>
              </tr>
          </thead>
          <tbody>
              @foreach($details as $user)
              <tr>
                  <td>{{$user->name}}</td>
                 <td>{{$user->username}}</td>
              </tr>
              @endforeach
          </tbody>
      </table>
      @endif
</div>

  <script src="js/app.js"></script>
    </body>
</html>
