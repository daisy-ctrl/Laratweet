@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Tweets</div>

                <div class="panel-body">
                    <div class="list-group">
                    @forelse ($list as $tweets)
                        <a href="{{ url('/' . $tweets->user_id) }}" class="list-group-item">
                            <h4 class="list-group-item-heading">{{ $tweets->body }}</h4>
                            <p class="list-group-item-text">{{ $tweets->user_id }}</p>
                        </a>
                    @empty
                        <p>No users</p>
                    @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}" />

<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-12">
           <div class="card">
               <div class="card-header">Tweets</div>

               <div class="card-body">
                   @if($tweets->count())
                       @foreach($tweets as $tweet)
                           <article class="col-xs-12 col-sm-6 col-md-3">
                               <div class="panel panel-info" data-id="{{ $tweet->id }}">
                                   <div class="panel-body">
                                       <a href="https://www.codechief.org/user/img/user.jpg" title="Nature Portfolio" data-title="Amazing Nature" data-footer="The beauty of nature" data-type="image" data-toggle="lightbox">
                                   <img src="https://www.codechief.org/user/img/user.jpg" style="height: 50px; width: 50px; border-radius: 50%;">
                                           <span class="overlay"><i class="fa fa-search"></i></span>
                                       </a>
                                   </div>
                                   <div class="panel-footer">
                                       <h4><a href="#" title="Nature Portfolio">{{ $tweet->body }}</a></h4>
                                       <span class="pull-right">
                                           <span class="like-btn">
                                               <i id="like{{$tweet->id}}" class="glyphicon glyphicon-thumbs-up {{ auth()->user()->hasLiked($tweet) ? 'like-tweet' : '' }}"></i> <div id="like{{$tweet->id}}-bs3">{{ $tweet->likers()->get()->count() }}</div>
                                           </span>
                                       </span>
                                   </div>
                               </div>
                           </article>
                       @endforeach
                   @endif
               </div>
           </div>
       </div>
   </div>
</div>

<script type="text/javascript">
   $(document).ready(function() {

       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });

       $('i.glyphicon-thumbs-up, i.glyphicon-thumbs-down').click(function(){
           var id = $(this).parents(".panel").data('id');
           var c = $('#'+this.id+'-bs3').html();
           var cObjId = this.id;
           var cObj = $(this);

           $.ajax({
              type:'POST',
              url:'/like',
              data:{id:id},
              success:function(data){
                 if(jQuery.isEmptyObject(data.success.attached)){
                   $('#'+cObjId+'-bs3').html(parseInt(c)-1);
                   $(cObj).removeClass("like-post");
                 }else{
                   $('#'+cObjId+'-bs3').html(parseInt(c)+1);
                   $(cObj).addClass("like-post");
                 }
              }
           });

       });

       $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
           event.preventDefault();
           $(this).ekkoLightbox();
       });
   });
</script>
@endsection
