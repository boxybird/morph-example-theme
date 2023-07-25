<?php

use MorphTheme\Deploy\Job;

[$is_deploying, $deployed_ago] = morph_render(new class {

    public bool $is_deploying = false;

    public int $deployed_ago = 0;

    public function __construct()
    {
        $this->setIsDeploying();
        $this->setDeployedAgo();
    }

    public function deploy(): void
    {
        waffle_queue()->push(Job::class, [
            'how_long' => 30,
        ], 'deploy_queue');

        $this->setIsDeploying();
        $this->setDeployedAgo();
    }

    protected function setIsDeploying(): void
    {
        $this->is_deploying = (int) waffle_queue()->size('deploy_queue');
    }

    protected function setDeployedAgo(): void
    {
        if (!$this->is_deploying) {
            return;
        }

        $created_at = waffle_db()->table('waffle_queue')
            ->select('created_at')
            ->where('queue', 'deploy_queue')
            ->first()
            ->created_at;

        $this->deployed_ago = time() - $created_at;
    }
});
?>

<style>
    .wp-morph-transition {
        transform: translateY(-0.1rem);
        transition: all 680ms ease-in-out;
    }

    .wp-morph-transition-in {
        transform: translateY(0);
    }
</style>

<section>
    <div 
        class="text-center"
        x-data="{ interval: null }">
        <button
            class="<?= $is_deploying ? 'animate-pulse' : ''; ?> bg-emerald-500 duration-150 mt-4 px-3 py-1 select-none tracking-widest uppercase disabled:opacity-75 disabled:pointer-events-none focus:outline-none focus:ring-4 focus:ring-emerald-600 hover:bg-emerald-600"
            <?= $is_deploying ? 'disabled' : ''; ?>
            x-on:click="$wpMorph('deploy')">
            <?php if ($is_deploying): ?>
                <span x-init="interval = setInterval(() => $wpMorph(), 3000)">Deploying</span>
            <?php else: ?>
                <span x-init="clearInterval(interval)">Deploy</span>
            <?php endif; ?>
        </button>
    </div>

    <?php if ($is_deploying): ?>
        <div class="my-8 text-center" wp-morph-transition>
            <h3 class="font-bold">What's going on here?</h3>
            <ul class="mt-4">
                <li class="space-y-4">
                    <p>The goal here is to simulate a long-running background task.</p>
                    <p>If the button above is displaying "DEPLOYING", you or someone else triggered a database queue using 
                        <a
                            class="underline"
                            href="https://github.com/boxybird/waffle#waffle_queue--waffle_worker"
                            target="_blank">
                            Waffle</a>.
                        The job will take 30 seconds to complete (kinda).
                    </p>
                    <p>While the job will complete in the noted time. The WordPress CRON scheduler will only run once every minute.</p>
                    <p><strong>But here's the cool part.</strong> Morph is polling the server every 3 seconds to see if the job has finished. Check out the network requests in dev tools.</p>
                    <p>Deployed <strong class="font-bold"><?= $deployed_ago; ?></strong> seconds ago.</p>
                    <p>If the job completes the polling stops and this message is not rendered.</p>
                    <p>But here's the cool, cool part. Refresh the page. If the queue is still being processed, you'll see this message.</p>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</section>
