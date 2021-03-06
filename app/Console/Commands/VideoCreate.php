<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Video;

class VideoCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:create {title? : Video title} {realisator? : Video realisator} {date? : Creation date of video} {--force=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a video description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get title from input or optionnal parameter
        $title = $this->argument('title');
        if($title === null) {
            $title = $this->ask('What is the video title?');
        }

        // Get realisator from input
        $realisator = $this->argument('realisator');
        if($realisator === null){
            $realisator = $this->ask('Who is the video realisator?');
        }

        // Get date from input
        $date = $this->argument('date');
        while($date === null || !preg_match('/([0-9]{2,4})-([0-1][0-9])-([0-3][0-9])(?:( [0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?/', $date)){
            if($date !== null && !preg_match('/([0-9]{2,4})-([0-1][0-9])-([0-3][0-9])(?:( [0-2][0-9]):([0-5][0-9]):([0-5][0-9]))?/', $date)){
                $this->info('Expected format: Y-m-d H:i:s');
            }
            $date = $this->ask('What is release date of the video?');
        }

        $this->info('Title: '       . $date);
        $this->info('Realisator: '  . $realisator);
        $this->info('Date: '        . $date);

        $force = $this->option('force');

        if ($force === 'true' || $this->confirm('Do you wish to continue?')) {
            $video              = new Video;
            $video->title       = $title;
            $video->realisator  = $realisator;
            $video->date        = $date;
            if($video->save()) {
                $this->info('Video saved!');
            }
            else {
                $this->info('Un truc bizarre s\'est passé...');
            }
        }
    }
}
