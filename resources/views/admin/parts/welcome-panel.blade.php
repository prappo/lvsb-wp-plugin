<div class="welcome-panel">
    <div class="welcome-panel-content">
        <div id="msgBox"></div>

        <h1>Step 1</h1>
        <button id="migratePage" class="button button-primary">Start Page Migration</button>
        <b style="color: darkgreen">[ {{\App\Models\Tpage::where('id','1337')->value('last')}} Migrated ] </b>

        <h1>Step 2</h1>
        <button class="button button-primary" id="migrateCategories">Start Category Migration</button>
        <b style="color:darkgreen">[ {{\App\Models\Tcat::count()}} migrated] </b>
        <h1>Step 3</h1>
        <button class="button button-primary" id="migratePosts">Start Post Migration</button>
        <b style="color:darkgreen">[ {{\App\Models\Tpost::where('id','1337')->value('last')}} migrated ]</b>


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