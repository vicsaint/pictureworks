<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\UserComment;
use App\Models\Comment;

class AddComment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:comment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Picture-Works Adding Comment in CLI';

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
     * @return int
     */
    public function handle()
    {
       $id =  $this->ask("Enter ID:");
       
       $user = Comment::get_user_by_id($id);

       if($user == null){
           $this->error('Invalid ID');
       } else {
 
        $comment =  $this->ask("Enter your comments");
        $data = array($user->id, $user->fk_user_id, $user->name, $comment);
    
        //saving process
        $ok = UserComment::insertRecord($data);
        if($ok){
            $this->info("Done, Success in saving");
        }

       }  
       
    }
}
