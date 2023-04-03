<?php

if ($_POST['increment'] ?? false) {
    $count = (int) get_post_meta(get_the_ID(), 'count2', true);

    update_post_meta(get_the_ID(), 'count2', ++$count);
}

if ($_POST['reset'] ?? false) {
    delete_post_meta(get_the_ID(), 'count2');
}

$count = (int) get_post_meta(get_the_ID(), 'count2', true);
?>

<div x-data>
    <h3>Procedural</h3>

    <p><?= $count; ?></p>

    <button x-on:click="$wpMorph('increment')">Increment</button>
    <button x-on:click="$wpMorph('reset')">Reset</button>
</div>