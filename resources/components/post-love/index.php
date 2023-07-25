<?php

[$loves, $temperature] = morph_render(new class() {
    public int $loves = 0;

    public string $temperature = '';

    public function __construct()
    {
        $this->loves = get_post_meta(get_the_ID(), 'loves', true) ?: 0;

        $this->setTemperature();
    }

    public function love(): void
    {
        update_post_meta(get_the_ID(), 'loves', ++$this->loves);

        $this->loves = get_post_meta(get_the_ID(), 'loves', true);

        $this->setTemperature();
    }

    protected function setTemperature(): void
    {
        switch (true) {
            case $this->loves >= 1 && $this->loves < 10:
                $this->temperature = 'fill-yellow-500';
                break;
            case $this->loves >= 10 && $this->loves < 20:
                $this->temperature = 'fill-orange-500';
                break;
            case $this->loves >= 20:
                $this->temperature = 'fill-red-500';
                break;
            default:
                $this->temperature = 'fill-gray-500';
                break;
        }
    }
});
?>

<div 
    x-data
    class="flex select-none space-x-2">
    <span><?= $loves; ?></span>

    <svg 
        @click="$wpMorph('love')"
        class="cursor-pointer duration-300 h-6 w-6 hover:scale-110 <?= $temperature; ?>"
        xmlns="http://www.w3.org/2000/svg" 
        viewBox="0 0 512 512">
        <path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/>
    </svg>
</div>
