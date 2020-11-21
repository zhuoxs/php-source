<?php
function hex2rgb($color){
        $color = str_replace('#', '', $color);
        if (strlen($color) > 3) {
            $title_bg = hexdec(substr($color, 0, 2)).",".hexdec(substr($color, 2, 2)).",".hexdec(substr($color, 4, 2));
        } else {
            $color = $color;
            $r = substr($color, 0, 1) . substr($color, 0, 1);
            $g = substr($color, 1, 1) . substr($color, 1, 1);
            $b = substr($color, 2, 1) . substr($color, 2, 1);
            $title_bg = hexdec($r).",".hexdec($g).",".hexdec($b);
        }
        return $title_bg;
    }