<?php

[$count] = morph_render(new class {
    public int $count;

    protected int $post_id;

    public function __construct()
    {
        $this->post_id = get_the_ID();

        $this->count = (int) get_post_meta($this->post_id, 'count', true);
    }

    public function increment()
    {
        update_post_meta($this->post_id, 'count', ++$this->count);
    }

    public function reset()
    {
        delete_post_meta($this->post_id, 'count');

        $this->count = 0;
    }
});
?>

<div x-data>
    <h3>Class</h3>

    <p><?= $count; ?></p>

    <button x-on:click="$wpMorph('increment')">Increment</button>
    <button x-on:click="$wpMorph('reset')">Reset</button>
</div>
