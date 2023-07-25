<?php

namespace MorphTheme\Deploy;

class Job
{
    public function fire($job, $data)
    {
        sleep($data['how_long']);

        $job->delete();
    }
}
