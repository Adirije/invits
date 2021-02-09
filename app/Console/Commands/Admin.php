<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Admin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:make 
                                {email : email of the admin} 
                                {--reset : whether to reset existing admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin';

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
        $admin = new \App\Models\Admin;

        $admin->email = $this->argument('email');
        $admin->password = '$2y$10$FoD6wOPACkntvaJHwdsS7Ojk4VDSCNAdLlnkf4aSSt3v92D2.1INm';
        
        $admin->save();

        $this->info('Admin created succesfully');
    }
}
