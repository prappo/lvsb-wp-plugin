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

        <button id="stopMigratePage" class="button button-delete">Stop Page Migration</button>

        <hr>

        <h1>Step 2</h1>
        <h4><b>@if(\App\Models\Tcat::count() >=\App\Models\Tblarticle_categorie::count())
                    (Finished) @else (Not Finished) @endif</b></h4>
        <b style="color:darkgreen">[ {{\App\Models\Tcat::count()}} migrated] </b><br>
        <button class="button button-primary" id="migrateCategories">Start Category Migration</button>
        <button class="button button-default" id="stopMigrateCategory">Stop Category Migration</button>
        <hr>

        <h1>Step 3</h1>
        <h4><b> @if(\App\Models\Tpost::where('id','1337')->value('last') >= \App\Models\Tblarticle::count())
                    (Finished) @else (Not Finished) @endif</b></h4>
        <b style="color:darkgreen">[ {{\App\Models\Tpost::where('id','1337')->value('last')}} migrated ]</b><br>
        <button class="button button-primary" id="migratePosts">Start Post Migration</button>
        <button class="button button-default" id="stopMigratePosts">Stop Post Migration</button>


    </div>

    <br><br>
</div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $('#migratePage').click(function () {
        $(this).html("Please wait ..");
        $.ajax({
            type: 'post',
            url: 'http://localhost/wp/insert/page',
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
            url: 'http://localhost/wp/insert/category',
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
            url: 'http://localhost/wp/insert/post',
            success: function (data) {
                if (data.status == "ok") {
                    location.reload();
                }
            },
            error: function (data) {
                $('#migratePosts').html("Start Post Migration");
                alert("Something went wrong");
            }
        });
    });
</script>