<?php

namespace App\Console\Commands;

use App\Events\SampleEvent;
use App\Mail\TestMail;
use App\Smark\Smark;
use App\Smark\Smark2;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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

        $enc = Smark2::encrypter('Haha', 'mysecretkey');

        $this->info('Encrypted: '.$enc);

        $dec = Smark2::decrypter($enc, 'mysecretkey');

        $this->info('Decrypted: '.$dec);
    }
}
