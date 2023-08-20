<?php

$count = (int) get_option('count', 0);

if ($_POST['increment'] ?? false) {
    update_option('count', ++$count);
}
?>

<div x-data>
    <span><?= $count; ?></span>
    <button x-on:click="$wpMorph('increment')">Increment</button>
</div>