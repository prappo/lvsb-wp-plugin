@if(isset($post))
    <h1>Enable/Disable LVSB meta</h1>
    <p>Post Date: {{ $post->post_modified }}</p>
    <p>Meta Tag Status : @if($post->getMeta('lvsb_option')=="no") <b style="color: red">Not active</b> @else <b
                style="color: green">Active</b> @endif</p>
    <p>
        <label>Active : <input id="chk" type="checkbox" @if($post->getMeta('lvsb_option') != "no") checked @endif>
        </label>
    </p>
@endif
<p><textarea style="display: none" id="lvsb_option" name="lvsb_option"
             class="regular-text">{{ $post->getMeta('lvsb_option') }}</textarea></p>
<div style="border: solid 1px black; padding:10px">
    <u>Meta Keywords:</u>
    <p><b style="color: blue">@foreach(get_the_tags($post->ID) as $no => $con)
                {{$con->name}},
            @endforeach

        </b></p>
    <u>Meta Description :</u>
    <p>
        <b>{{$metaDescription}}</b>
    </p>

</div>

<script>
    $('#chk').change(function () {
        if (this.checked) {
            $('#lvsb_option').val("yes");
        } else {
            $('#lvsb_option').val("no");
        }
    });
</script>
