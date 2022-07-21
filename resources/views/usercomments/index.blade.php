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
        <header>
            <span class="avatar"><img src="images/users/<?=$user->id?>.jpg" alt="" /></span>
            <h1><?=$user->name?></h1>
            <p><?=nl2br($user->comments)?></p>
        </header>

        <form class="form-horizontal" role="form" action="{{ route('comment_form_nojsn') }}" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="company_no" class="col-md-2 control-label">Comment via Form</label>
                <div class="col-md-4">
                    <textarea class="form-control" name="nojson_new_comment" id="new_comments" placeholder="Add Comments"></textarea> 
                    </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-1 col-md-10">
                    <button type="submit" class="btn blue">Save</button>
                </div>
            </div>

        </form>
<br /><br /><br />
        <form class="form-horizontal" role="form" action="{{ route('comment_form_withjsn') }}" method="POST" enctype="application/json">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="company_no" class="col-md-2 control-label">Comment via Json</label>
                <div class="col-md-4">
                    <textarea class="form-control" name="json_new_comment" id="new_comments" placeholder="Add Comments"></textarea> 
                </div>
            </div>

            <div class="form-group">
                                            <div class="col-md-offset-1 col-md-10">
                                                <button type="submit" class="btn blue">Save</button>
                                            </div>
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