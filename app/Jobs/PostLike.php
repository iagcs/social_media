<?php

namespace App\Jobs;

use App\Models\Likes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PostLike implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private array $request, private int $id){}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Likes::create([
            'user_id'       => $this->id,
            'post_id'       => $this->request['post_id'],
            'like_reaction'   => $this->request['like_reaction']
        ]);
    }
}
