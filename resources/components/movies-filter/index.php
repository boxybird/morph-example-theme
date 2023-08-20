<?php

[$movies, $genres] = morph_render(new class {
    public array $movies = [];

    public array $genres = [];

    public function mount()
    {
        $this->setMovies();
        $this->setGenres();
    }

    public function filterMovies(string $genre = '')
    {
        $this->setMovies($genre);
        $this->setGenres();
    }

    protected function setMovies(string $genre = ''): void
    {
        $args = [
            'posts_per_page' => 18,
            'post_status'    => 'publish',
            'post_type'      => 'movie',
            'orderby'        => 'title',
            'order'          => 'ASC',

        ];

        if ($genre) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'genre',
                    'field'    => 'slug',
                    'terms'    => $genre,
                ]
            ];
        }

        // Get and format movies
        $this->movies = array_map(function ($movie) {
            return [
                'id'    => $movie->ID,
                'title' => get_the_title($movie->ID),
                'image' => get_the_post_thumbnail_url($movie->ID, 'large'),
            ];
        }, get_posts($args));
    }

    protected function setGenres(): void
    {
        // Get genres terms
        $genres_terms = get_terms([
            'taxonomy'   => 'genre',
            'hide_empty' => true,
        ]);

        // Format genres
        $this->genres = array_map(function ($genre) {
            return [
                'id'   => $genre->term_id,
                'name' => $genre->name,
                'slug' => $genre->slug
            ];
        }, $genres_terms);
    }
});
?>

<div 
    x-data="{
        isLoading: false
    }"
    class="grid grid-cols-1 h-full lg:grid-cols-[250px_1fr]">
        <section class="bg-zinc-300 border-r border-zinc-400 h-full p-4">
            <h3 class="font-bold">Genres</h3>
            <div class="mt-4 space-y-2">
                <?php foreach ($genres as $genre) : ?>
                    <button
                        class="bg-emerald-500 inline-block duration-150 px-3 py-1 tracking-widest uppercase disabled:opacity-75 disabled:pointer-events-none focus:outline-none focus:ring-4 focus:ring-emerald-600 hover:bg-emerald-600 lg:w-full"
                        x-on:click="$wpMorph({ filterMovies: '<?= $genre['slug']; ?>' }, {
                            onStart() { isLoading = true },
                            onFinish() { isLoading = false }
                        })">
                        <?= $genre['name']; ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </section>
        
        <section 
            :class="{ 'opacity-75 pointer-events-none': isLoading }"
            class="auto-rows-max duration-300 gap-4 grid grid-cols-2 p-4 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-6">
            <?php foreach ($movies as $movie) : ?>
                <div
                    class="overflow-hidden relative"
                    x-data="{
                        contentHeight: 0,
                    }"
                    x-on:mouseover="$el.querySelector('img').style.transform = `translateY(-${contentHeight}px)`"
                    x-on:mouseout="$el.querySelector('img').style.transform = 'translateY(0)'">
                    <img
                        class="aspect-[2/3] duration-[510ms] object-cover relative w-full z-10"
                        src="<?= $movie['image']; ?>">
                    <div 
                        class="absolute bg-zinc-200 border-b border-zinc-400 bottom-0 p-4 left-0 w-full"
                        x-init="contentHeight = $el.offsetHeight">
                        <h4><?= $movie['title']; ?></h4>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </div>
</div>