<div class="welcome-panel">
    <div class="welcome-panel-content">
        <b> [ Total Post {{\App\Models\Tblarticle::count()}} ]</b>
        <b>[ Total Page {{\App\Models\Page::count()}} ]</b>
        <b>[ Total category {{\App\Models\Tblarticle_categorie::count()}} ]</b>
        <div id="msgBox"></div>


        <h1>Step 1 </h1>
        <h4><b>@if(\App\Models\Tpage::where('id','1337')->value('last') >= \App\Models\Page::count())
                    (Finished) @else (Not Finished) @endif</b></h4>
        <b style="color: darkgreen">[ {{\App\Models\Tpage::where('id','1337')->value('last')}} Migrated ] </b><br>
        <button id="migratePage" class="button button-primary">Start Page Migration</button>


        <hr>
        <div style="border: solid 1px black; padding:10px">


            <h1>Step 2 </h1>


            <b><u>Total Objects in
                    Post/Pages {{\App\Models\WpPost::where('post_content','LIKE','%'.'##IDOBJECT'.'%')->count()}} ||
                    Total Random Objects in
                    Post/Pages {{\App\Models\WpPost::where('post_content','LIKE','%'.'##RANDOMOBJECT'.'%')->count()}} ||
                    Total Objects in
                    Objects <span
                            style="color: green"> {{\App\Models\Tblobject::where('DESCRIPTION','LIKE','%'.'##RANDOMOBJECT'.'%')->count() + \App\Models\Tblobject::where('DESCRIPTION','LIKE','%'.'##IDOBJECT'.'%')->count()}} </span>
                    ||
                    Random Objects in Objects <span
                            style="color:blue"> {{\App\Models\Tblobject::where('DESCRIPTION','LIKE','%'.'##RANDOMOBJECT'.'%')->count()}}</span>


                </u></b>
            <br>
            <hr>
            <span>Objects found in these pages/posts : </span>
            <div style="overflow-y: scroll; background: lightyellow; border: solid 1px blue; padding:5px; height:150px;">
                @foreach(\App\Models\WpPost::where('post_content','LIKE','%'.'##IDOBJECT'.'%')->get() as $postContent)
                    # <a target="_blank"
                         href="{{get_site_url().'/'.$postContent->post_name.".html"}}">{{$postContent->post_title}}</a>
                    <br>
                @endforeach

            </div>
            <br>

            <hr>
            <span>Random objects found in these pages/posts</span>
            <div style="overflow-y: scroll; background: lightyellow; border: solid 1px blue; padding:5px; height:150px;">
                @foreach(\App\Models\WpPost::where('post_content','LIKE','%'.'##RANDOMOBJECT'.'%')->get() as $postContent)
                    # <a target="_blank"
                         href="{{get_site_url().'/'.$postContent->post_name.".html"}}">{{$postContent->post_title}}</a>
                    <br>
                @endforeach

            </div>
            <br>


            <hr>
            <span>Objects found in Objects ( {{ \App\Models\Tblobject::where('DESCRIPTION','LIKE','%'.'##IDOBJECT'.'%')->count() }} )</span>
            <div style="overflow-y: scroll; background: lightyellow; border: solid 1px blue; padding:5px; height:150px;">
                @foreach(\App\Models\Tblobject::where('DESCRIPTION','LIKE','%'.'##IDOBJECT'.'%')->get() as $postContent)
                    # <a>{{$postContent->DESCRIPTION}}</a>
                    <br>
                @endforeach

            </div>
            <br>

            <span>Random Objects found in Objects ( {{ \App\Models\Tblobject::where('DESCRIPTION','LIKE','%'.'##RANDOMOBJECT'.'%')->count() }} )</span>
            <div style="overflow-y: scroll; background: lightyellow; border: solid 1px blue; padding:5px; height:150px;">
                @foreach(\App\Models\Tblobject::where('DESCRIPTION','LIKE','%'.'##RANDOMOBJECT'.'%')->get() as $postContent)
                    # <a>{{$postContent->DESCRIPTION}}</a>
                    <br>
                @endforeach

            </div>
            <br>


            <button id="migrateObjects" class="button button-primary">Migration Object (1)</button>
            <button id="migrateRandomObjects" class="button button-primary">Migrate Random Objects (2)</button>
            <button id="migrateRandomObjectsInObjects" class="button button-default">Migrate Random Objects in Object Table (3)</button>
            <button id="migrateObjectsInObjects" class="button button-default">Migrate Objects into Content (4)</button>

            <br>
        </div>


        <hr>

        <h1>Step 3</h1>
        <h4><b>@if(\App\Models\Tcat::count() >=\App\Models\Tblarticle_categorie::count())
                    (Finished) @else (Not Finished) @endif</b></h4>
        <b style="color:darkgreen">[ {{\App\Models\Tcat::count()}} migrated] </b><br>
        <button class="button button-primary" id="migrateCategories">Start Category Migration</button>

        <hr>

        <h1>Step 4</h1>
        <h4><b> @if(\App\Models\Tpost::where('id','1337')->value('last') >= \App\Models\Tblarticle::count())
                    (Finished) @else (Not Finished) @endif</b></h4>
        <b style="color:darkgreen">[ {{\App\Models\Tpost::where('id','1337')->value('last')}} migrated ]</b><br>
        <button class="button button-primary" id="migratePosts">Start Post Migration</button>


    </div>

    <br><br>
</div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    var URL = "{{get_site_url()}}";

    $('#migratePage').click(function () {
        $(this).html("Please wait ..");
        $.ajax({
            type: 'post',
            url: URL + '/insert/page',
            success: function (data) {

                $('#msgBox').html("Success ." + data.count + " pages migrated");

                $('#migratePage').html("Start Page Migration");
                location.reload();
            }, error: function (data) {
                $('#migratePage').html("Start Page Migration");
                alert("Something went wrong");
            }
        });


    });

    $('#migrateCategories').click(function () {
        $(this).html("Please wait ...");
        $.ajax({
            type: 'POST',
            url: URL + '/insert/category',
            success: function (data) {
                if (data.status == "ok") {
                    location.reload();
                }

            },
            error: function (data) {
                $('#migrateCategories').html("Start Category Migration");
                alert("Something went wrong");
            }
        });
    });

    $('#migratePosts').click(function () {
        $(this).html("Please Wait ..");
        $.ajax({
            type: 'POST',
            url: URL + '/insert/post',
            success: function (data) {
                if (data.status == "ok") {
                    location.reload();
                }
            },
            error: function (data) {
                $('#migratePosts').html("Start Post Migration");
                alert("Something went wrong");
                console.log(data.responseText);

            }
        });
    });

    $('#migrateRandomObjects').click(function () {
        var myPreviousText = $(this).html();
        $(this).html("Please wait ...");
        var me = $(this);

        $.ajax({
            type: 'POST',
            url: URL + '/insert/random/object',
            data: {},
            success: function (data) {
                if (data == "ok") {
                    location.reload();

                } else {
                    alert(data);
                    me.html(myPreviousText);
                }
            },
            error: function (data) {
                alert("Something went wrong");
                console.log(data.responseText);
            }
        });
    });

    $('#migrateRandomObjectsInObjects').click(function () {
        var myPreviousText = $(this).html();
        $(this).html("Please wait ...");
        var me = $(this);
        $.ajax({
            type: 'POST',
            url: URL + '/insert/random/object/in/object',
            success: function (data) {
                if (data == "ok") {

                    location.reload();


                } else {
                    me.html(myPreviousText);

                    alert(data);
                }
            },
            error: function (data) {
                alert("Check console message");
                console.log(data.responseText);
            }
        })
    });

    $('#migrateObjectsInObjects').click(function () {
        var myPreviousText = $(this).html();
        $(this).html("Please wait ...");
        var me = $(this);
        $.ajax({
            type: 'POST',
            url: URL + '/migrate/objects/to/short/code',
            success: function (data) {
                if (data == "ok") {
                    location.reload();
                } else {
                    me.html(myPreviousText);
                    alert(data);
                }
            },
            error: function (data) {
                alert("Check console message");
                console.log(data.responseText);
            }
        });
    });


    $('#migrateObjects').click(function () {
        var myPreviousText = $(this).html();
        $(this).html("Please wait ...");
        var me = $(this);
        $.ajax({
            type: 'POST',
            url: URL + '/insert/object',
            success: function (data) {
                if (data == "ok") {
                    location.reload();

                } else {
                    me.html(myPreviousText);
                    alert(data);
                }
            }, error: function (data) {
                alert("Something went wrong");
                console.log(data.responseText);
            }
        });
    });
</script>