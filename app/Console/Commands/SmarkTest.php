<?php

namespace App\Console\Commands;

use App\Events\SampleEvent;
use App\Mail\TestMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Smark\Smark\Dater;

class SmarkTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:smark-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $this->info(Smark::compute('add', [2,1]));

        // broadcast(new SampleEvent);

        print_r(Dater::getWeekdays('08-11-1999', '08-08-2024'));
    }
}
