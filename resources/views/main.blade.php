<div style="background: black; height: 600px ; width: 100%;padding:20px;margin-top:20px;">

    <br>
    @if(get_option('lvsb_status') == "running")
        <img src="http://www.angelfire.com/super/badwebs/3-AsciiGuy-Matrix.gif">
    @endif
    <br>
    <h4 style="color:#65AA52">
        @if(\App\Models\Page::all()->count() == get_option('lvsb_pages'))
            *Page Migration done <br>
        @else
            <span style="color: yellow">*Page Migration pending </span><br>
        @endif



        @if(\App\Models\Tblarticle_categorie::all()->count() == get_option('lvsb_categories'))
            *Categories Migration done <br>
        @else
            <span style="color:yellow">*Categories Migration Pending</span><br>
        @endif

        @if(\App\Models\Tblarticle::all()->count() == get_option('lvsb_posts'))
            *Article Migration done<br>
        @else
            <span style="color:yellow"> *Article Migration pending . Migrated {{get_option('lvsb_posts')}} articles</span><br>
        @endif
    </h4>

    <fieldset style="border: 3px dashed yellow;padding:10px">
        <legend style="color: black;background: yellow;font-size:20px">Status</legend>
        <h2 id="msgBox" style="color:#65AA52"></h2>
    </fieldset>
    <br>


    <button id="fire"
            style="background: #65AA52 ; border: none; font-weight: 800;color: black;height: 30px;width: 250px">
        @if(get_option('lvsb_status'))
            @if(get_option('lvsb_status') == "running")
                Progress Running ... (stop)
            @else
                Start Progress

            @endif

        @else
            Start Progress


        @endif
    </button>

</div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>


    var URL = "{{get_site_url()}}";

    var status = "{{get_option('lvsb_status')}}";
    if (status == "running") {
        fuck();

    }


    function fuck() {

        var totalPage = "{{\App\Models\Page::count()}}";
        var migratedPage = "{{get_option('lvsb_pages')}}";


        var totalPost = "{{\App\Models\Tblarticle::count()}}";
        var migratedPosts = "{{get_option('lvsb_posts')}}";

        var totalCategory = "{{\App\Models\Tblarticle_categorie::count()}}";
        var migratedCategory = "{{get_option('lvsb_categories')}}";

        var totalObjectInPost = "{{}}";

        if (totalPage != migratedPage) {
            $('#msgBox').html("Running Page Migration .... <br><img height='50' width='50' src='https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif'>");
            $('#msgBox').html("Total page " + totalPage + " and migrated " + migratedPage);
            $.ajax({
                type: 'post',
                url: URL + '/insert/page',
                success: function (data) {

                    $('#msgBox').html("Success ." + data.count + " pages migrated");


                    location.reload();
                }, error: function (data) {
                    $('#msgBox').html(data.responseText);
                }
            });
        }
        else if (totalCategory != migratedCategory) {
            $('#msgBox').html("Running Category Migration ... <br><img height='50' width='50' src='https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif'>");
            $.ajax({
                type: 'POST',
                url: URL + '/insert/category',
                success: function (data) {
                    if (data.status == "ok") {
                        location.reload();
                    }

                },
                error: function (data) {

                    $('#msgBox').html("Something went wrong while trying to migrate categories");

                }
            });
        }
        else if (totalPost != migratedPosts) {

                $('#msgBox').html("Now running article migration . Please wait .... <br><img height='50' width='50' src='https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif'>");
                $.ajax({
                    type: 'POST',
                    url: URL + '/insert/post',
                    success: function (data) {
                        if (data.status == "ok") {
                            $('#msgBox').html(data.count + " article Migrated ");
                            location.reload();
                        }
                    },
                    error: function (data) {
                        $('#migratePosts').html("Start Post Migration");
                        $('#msgBox').html("Something went wrong");
                        console.log(data.responseText);

                    }
                });


        }
        else{
            $('#msgBox').html("Migration Done");
        }


    }
    $('#fire').click(function () {
        $.ajax({
            url: URL + '/lvsb/fire',
            type: 'POST',
            data: {},
            success: function (data) {
                if (data == "success") {
                    location.reload()
                } else {
                    alert("Error :" + data);
                }
            },
            error: function (data) {
                alert("Something went wrong");
                console.log(data.responseText);
            }
        });
    });
</script>
