<?php

function gmt_helper_localize($key_word) {
    global $gmt_vocabulary;
    $result = @$gmt_vocabulary[$key_word];
    if (!empty($result)) {
        return $result;
    } else {
        return $key_word;
    }
}
