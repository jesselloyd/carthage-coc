<?php 

add_action('youtube_live_stream', 'get_youtube_live_stream');

function get_youtube_live_stream() {
    echo '<div class="video-container"><iframe class="video" src="https://www.youtube.com/embed/live_stream?channel=UCH_sJHkYxpuLcetdFD3Vvbg&modestbranding=1&color=red" autoplay=1" frameborder="0" allowfullscreen></iframe></div>';
}
