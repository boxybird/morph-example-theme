<?php

[$count] = morph_render(new class {
    public $count;

    public function __construct()
    {
        $this->count = (int) get_option('count', 0);
    }

    public function increment()
    {
        update_option('count', ++$this->count);
    }
});
?>

<div x-data>
    <span><?= $count; ?></span>
    <button x-on:click="$wpMorph('increment')">Increment</button>
</div>