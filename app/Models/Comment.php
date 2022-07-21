<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    
    protected $table="comments";

    protected $fillable =[
        'fk_user_id',
        'name',
        'comments',
    ];


    public static function get_user_by_id($id){
        return self::find($id);
    }

}
