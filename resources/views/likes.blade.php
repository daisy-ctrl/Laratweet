<div class="col-md-2">
    @if ($is_like_button)
    <a href="{{ url('/likes/' . $tweet->body) }}" class="navbar-btn navbar-right">
        <button type="button" class="btn btn-default">Like</button>
    </a>
    @else
    <a href="{{ url('/unlikes/' . $tweet->body) }}" class="navbar-btn navbar-right">
        <button type="button" class="btn btn-default">Unlike</button>
    </a>
    @endif
  </div>
  <!-- <script src="/js/app.js"></script> -->
  <script src="https://unpkg.com/vue@2.1.10/dist/vue.js"></script>
  <script src="https://unpkg.com/vue-resource@1.2.0/dist/vue-resource.min.js"></script>
  <script>
      new Vue({
          el: '#app',        data: {
              username: '{{ $user->username }}',
              isLiking: {{ $is_liking ? 1 : 0 }},
              likeBtnTextArr: ['Like', 'Unlike'],
              likeBtnText: ''
          },        methods: {
              likes: function (event) {
                  var csrfToken = Laravel.csrfToken;
                  var url = this.isLiking ? '/unlikes' : '/likes';
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
                      }                    this.togglelikeBtnText();
                  });            },            togglelikeBtnText: function() {
                  this.isLiking = (this.isLiking + 1) % this.likeBtnTextArr.length;
                  this.setlikeBtnText();
              },            setlikeBtnText: function() {
                  this.likeBtnText = this.likeBtnTextArr[this.isLiking];
              }
          },        mounted: function() {
              this.setlikeBtnText();
          }
      });
  </script>
