<script src="/static/js/jquery.2.1.4.min.js"></script>
<script src="/static/ckplayer/ckplayer.js"></script>

<div id="playerBox">
    <img src="{$videoInfo['thumbnail']}" />
</div>

<script type="text/javascript">
    var vodUrl = "{$videoInfo['url']}";
    var params = {
        container: '#playerBox',
        variable: 'player',
        poster: '{$videoInfo["thumbnail"]}',
        video: vodUrl,
        //loaded:'loadedHandler',
        autoplay: false,
        flashplayer: false
    };

    player = new ckplayer(params);

</script>