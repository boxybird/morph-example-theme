<?php

use Michelf\Markdown;

[$content] = morph_render(new class {
    public string $content = '# I am markdown, edit me.';

    protected Markdown $markdown;

    public function __construct()
    {
        $this->markdown = new Markdown();

        $this->content = $this->markdown->defaultTransform($this->content);
    }

    public function convert($value)
    {
        $this->content = $this->markdown->defaultTransform($value);
    }
});
?>

<div class="gap-8 flex flex-col h-full lg:flex-row" x-data>
    <textarea 
        class="h-full p-4 w-full lg:w-2/5"
        x-on:keyup.debounce="$wpMorph({ convert: $el.value })"># I am markdown, edit me.</textarea>

    <div class="mt-8 p-4 prose lg:mt-0 lg:w-3/5">
        <?= $content; ?>
    </div>
</div>
