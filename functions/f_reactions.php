<?php
function interactions($total_reactions, $post_clicks){
    $interactions[] = [$total_reactions,$post_clicks];
    foreach ($interactions as $key) {
        foreach ($key as $values) {
            $items = [$values];
            foreach ($items as $item) {
                 $interaction[] =$item;
            }
        }
    }
    return array_sum($interaction);
}

 