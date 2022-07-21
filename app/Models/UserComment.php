<?php

namespace App\Models;

use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Exception;


class UserComment extends Model
{
    use HasFactory;

    protected $table="userscomments";

    protected $fillable =[
        'fk_user_id',
        'fk_comment_id',
        'name',
        'comments',
    ];


    public static function apidie($string, $code = 200){
       
        try{
            $string .= "";
            http_response_code($code);
            
            if(defined('SCRIPT') && SCRIPT)
                throw new Exception($string);

            die($string);
            abort(404);

        }catch(Exception $e)
        {
            FacadesLog::error($e);
        }
    }
    
    public static function missing_request($field){
        return (!isset($_REQUEST[$field]) or !$_REQUEST[$field]);
    }
    
    public static function missing_post($field){
        return (!isset($_POST[$field]) or !$_POST[$field]);
    }
    
    public static function missing_get($field){
        return (!isset($_GET[$field]) or !$_GET[$field]);
    }
    
    public static function is_json($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    
    public static function dbconnect(){
        $mydb = mysqli_connect(getenv('DB_SERVER'), getenv('DB_USER'), getenv('DB_PWD'), getenv('DB_NAME'));
        if(mysqli_connect_error())
        self::apidie('Could not connect: '.mysqli_connect_error(), 500);
        if(mysqli_error($mydb))
        self::apidie('Error on connection: '.mysqli_error(), 500);
        return $mydb;
    }
    
    public static function append_user_comments($id, $comments){
        global $mydb;
    
        $result = mysqli_query($mydb, 'SELECT usercomments FROM users WHERE id = "'.mysqli_real_escape_string($mydb, $id).'"');
       
        if(mysqli_error($mydb))
            self::apidie('DB Error: '.mysqli_error($mydb), 500);

        if(mysqli_num_rows($result) <= 0)
        self::apidie('No such user (1)', 404);
    
        $row = mysqli_fetch_object($result);
        $row->comments .= "\n".$comments;
    
        mysqli_query($mydb, 'UPDATE usercomments SET comments = "'.mysqli_real_escape_string($mydb, $row->comments).'"');
        return mysqli_error($mydb);
    }
    
    public static function contains($haystack, $needle, $case_sensitive = true){
        if(!$case_sensitive)
            return (strpos(strtolower($haystack), strtolower($needle)) !== FALSE);
        return (strpos($haystack, $needle) !== FALSE);
    }
    
    public static function startswith($haystack, $needle, $case_sensitive = true){
        if(!$case_sensitive)
            return (strpos(strtolower($haystack), strtolower($needle)) === 0);
        return (strpos($haystack, $needle) === 0);
    }
    
    public static function get_user_by_id($id){
        /*global $mydb;
        $result = mysqli_query($mydb, 'SELECT * FROM usercomments WHERE id = "'.mysqli_real_escape_string($mydb, $id).'"');
        if(mysqli_error($mydb))
            apidie('DB Error: '.mysqli_error($mydb), 500);
        if(mysqli_num_rows($result) <= 0)
            apidie('No such user (2)', 404);
            
        return mysqli_fetch_object($result); */
       
        //Laravel ORM online line  
        //this will retrieve all the comment done by a user
        return UserComment::find($id);
    }


    public static function insertRecord($d){
        $ok = UserComment::create([
            'fk_user_id'         => $d[1],
            'fk_comment_id'      => $d[0],
            'name'               => $d[2],
            'comments'           => $d[3],
            'created_at'         => date('Y-m-d H:i:s'),
            'updated_at'         => date('Y-m-d H:i:s'),
          ]);
        return $ok;  
    }
}
