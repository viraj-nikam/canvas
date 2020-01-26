<?php

namespace Canvas\Console;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Support\Facades\Route;

class SetupCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'canvas:setup {--data : Specifies that demo data should be seeded}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold the frontend controller, views, and routes';

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'layouts/app.stub'     => 'layouts/app.blade.php',
        'partials/navbar.stub' => 'partials/navbar.blade.php',
        'partials/styles.stub' => 'partials/styles.blade.php',
        'index.stub'           => 'index.blade.php',
        'show.stub'            => 'show.blade.php',
    ];

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $this->createDirectories();
        $this->exportViews();
        $this->buildController();
        $this->registerRoutes();

        // Optionally seed the database with demo data
        if ($this->option('data')) {
            if (\App\User::find(1)) {
                $this->seed();
            } else {
                $this->error('No users found. Please create a user and re-run the setup.');
            }
        }

        $this->info('Setup complete. Head over to <comment>'.url('/blog').'</comment> to get started.');
    }

        /**
     * Run the demo data seeder.
     *
     * @return void
     * @throws \Exception
     */
    private function seed()
    {

        // Seed the users data
        $users = factory(\App\User::class, 5)->create();
        
        // Seed the posts data
        $posts = factory(\Canvas\Post::class, 50)->create();

        // Seed the tags data
        $tags = factory(\Canvas\Tag::class, 15)->create();

        // Seed the topics data
        $topics = factory(\Canvas\Topic::class, 10)->create();

        // Associate tags and topics with the posts
        $posts->each(function ($post) use ($tags, $topics) {
            $post->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );

            $post->topic()->attach(
                $topics->random(1)->pluck('id')->toArray()
            );
        });

        // Seed the Canvas View data
        factory(\Canvas\View::class, 2500)->create();
    }

    /**
     * Create the view directories.
     *
     * @return void
     */
    private function createDirectories()
    {
        if (! is_dir($directory = resource_path('views/blog/layouts'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = resource_path('views/blog/partials'))) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Export the default blog views.
     *
     * @return void
     */
    private function exportViews()
    {
        foreach ($this->views as $key => $value) {
            if (file_exists($view = resource_path('views/blog/'.$value))) {
                if (! $this->confirm("The [blog/{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(
                sprintf('%s/resources/stubs/views/blog/%s', dirname(__DIR__, 2), $key),
                $view
            );
        }
    }

    /**
     * Build the new controller.
     *
     * @return void
     */
    private function buildController()
    {
        if (! file_exists($controller = app_path('Http/Controllers/BlogController.php'))) {
            $this->exportController();
        } else {
            if ($this->confirm('The [Http/Controllers/BlogController.php] already exists. Do you want to replace it?')) {
                $this->exportController();
            }
        }
    }

    /**
     * Export the new controller.
     *
     * @return void
     */
    private function exportController()
    {
        file_put_contents(
            app_path('Http/Controllers/BlogController.php'),
            $this->compileControllerStub()
        );
    }

    /**
     * Compile the default controller stub.
     *
     * @return string
     */
    private function compileControllerStub()
    {
        return str_replace(
            '{{namespace}}',
            $this->getAppNamespace(),
            file_get_contents(dirname(__DIR__, 2).'/resources/stubs/controllers/BlogController.stub')
        );
    }

    /**
     * Register the new routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        if (! Route::has('blog.index')) {
            file_put_contents(
                base_path('routes/web.php'),
                file_get_contents(dirname(__DIR__, 2).'/resources/stubs/routes.stub'),
                FILE_APPEND
            );
        }
    }
}
