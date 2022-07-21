<!DOCTYPE HTML>
<html>
<head>
    <title>User Card - <?=$user->name?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
</head>
<body class="is-preload">
<div id="wrapper">
    <section id="main">

@if (session('status'))
<div class="alert alert-success">
  {{ session('status') }}
</div>
@endif
@if (session('message'))
<div class="alert alert-danger">
    {{ session('message') }}
</div>
@endif

@if ($errors->any())
  <div class="alert alert-danger">
     <ul>
        @foreach ($errors->all() as $error)
           <li>{{ $error }}</li>
        @endforeach
     </ul>

  </div>
@endif

        <header>
            <span class="avatar"><img src="images/users/<?=$user->id?>.jpg" alt="" /></span>
            <h1><?=$user->name?></h1>
            <p><?=nl2br($user->comments)?></p>
                <div style="margin-left: 20px;">
                    <!-- displaying other comments -->    

@foreach ($rs_comments as $key => $value) 
<p>
 Comment: {{ $value->comments }} <br />
 ID: <b> {{ $value->fk_user_id }} </b> <br />
 Password: 720DF6C2482218518FA20FDC52D4DED7ECC043AB
 
</p>
<hr /> <br /> 
@endforeach 

                </div>
        </header>

        <form class="form-horizontal" role="form" action="{{ route('comment_form_nojsn') }}" method="POST">
            {{ csrf_field() }}

            <input type="hidden" value="{{ $user->id ?? '' }}" name="fk_comment_id">
            <input type="hidden" value="{{ $user->fk_user_id ?? '' }}" name="fk_user_id">
            
            <div class="form-group">
                <label for="company_no" class="col-md-2 control-label">Comment via Form</label>
                <div class="col-md-4">
                    <textarea class="form-control" name="nojson_new_comment" id="new_comments" placeholder="Add Comments"></textarea> 
                </div>
            </div>

            <div class="form-group">
                    <button type="submit" class="btn blue">Save</button>
            </div>
        </form>


        </section>
    <footer id="footer">
        <ul class="copyright">
            <li>&copy; Pictureworks</li>
        </ul>
    </footer>

</div>
<script>
    if ('addEventListener' in window) {
        window.addEventListener('load', function() { document.body.className = document.body.className.replace(/\bis-preload\b/, ''); });
        document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
    }
</script>
</body>
</html>