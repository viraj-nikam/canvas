<?php

namespace Canvas\Console;

use Canvas\Mail\WeeklyDigest;
use Canvas\Models\Post;
use Canvas\Models\UserMeta;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Mail;

class DigestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canvas:digest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the weekly email digest';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $startDate = today()->subDays(7)->startOfDay();
        $endDate = today()->endOfDay();

        $recipients = User::whereIn('id', Post::published()->pluck('user_id')->unique())->get();

        foreach ($recipients as $user) {
            $meta = UserMeta::forUser($user)->first();

            if (optional($meta)->digest != true) {
                continue;
            }

            $posts = Post::forUser($user)
                         ->published()
                         ->withCount('views')
                         ->withCount('visits')
                         ->get();

            $data = [
                'posts' => $posts->toArray(),
                'totals' => [
                    'views' => $posts->sum('views_count'),
                    'visits' => $posts->sum('visits_count'),
                ],
                'startDate' => $startDate->format('M j'),
                'endDate' => $endDate->format('M j'),
                'locale' => $meta->locale,
            ];

            try {
                Mail::to($user->email)->send(new WeeklyDigest($data));
            } catch (Exception $exception) {
                logger()->error($exception->getMessage());
            }
        }
    }
}
