<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UserComment;
use App\Models\Comment;

use Illuminate\Support\Facades\Auth;

class UserCommentsController extends Controller
{
  
  
	//check the user session
  public function __construct() 
  {
		$this->middleware('auth');
	}

  //http://127.0.0.1:8000/id/1
  public function getIDx(Request $request)
  {
    //validation
    $signID = Auth::id(); //session of the login person

    $id = isset($request['X'])? $request['X'] : false;
   
    if($id)
    {
        $user = Comment::get_user_by_id($id);
        if($user == null){
          die('This URI requires valid ID, please try again');
        } else{
          
          $rs_comments = UserComment::where('fk_comment_id', $user->id)->get();
          return view('usercomments.index', compact('user', 'rs_comments'));
        }

    }
    //$user = get_user_by_id($_GET['id']);
    //require('view.php');
  }

  public function postNoneJsnForm(Request $request)
  {
    //var_dump($_POST); exit;
   
    //validation
    $signID = Auth::id(); //user login id

    $this->validate($request, [
      'nojson_new_comment' => 'required|string|min:1|max:1000',
    ]);
    
    if(strtoupper($_POST['password']) != '720DF6C2482218518FA20FDC52D4DED7ECC043AB')
    UserComment::apidie('Invalid password', 401);

    $fk_comment_id =  $request->input('fk_comment_id');
    $fk_user_id =  $signID; //session of the one commenting
    $comment =  $request->input('nojson_new_comment');
    $owner_id =  $request->input('fk_user_id');; //owner of the main comment
    
    $user = Comment::get_user_by_id($owner_id);
    $data = array($fk_comment_id, $fk_user_id, $user->name, $comment);

    //saving process
    $ok = UserComment::insertRecord($data);

    if($ok){
    //edirect after saving, with splash message
      return redirect('/id/'.$owner_id)->with('status', 'You have succesfully saved comment.');
    }

  }
  
  public function postWithJsnForm(Request $request)
  {
    if ($request->isMethod('post'))
    {
        $json = file_get_contents('php://input');

        if(sizeof($_POST) or $json or (isset($argv[1]) and isset($argv[2]))){
        
          if($json){
                if(!UserComment::is_json($json))
                UserComment::apidie('Invalid POST JSON', 422);
                $_POST = json_decode($json, true);
            }
            else if(isset($argv[1]) and isset($argv[2])){
                $_POST['id'] = $argv[1];
        
                unset($argv[0]);
                unset($argv[1]);
                $_POST['comments'] = implode(' ', $argv);
        
                $_POST['password'] = '720DF6C2482218518FA20FDC52D4DED7ECC043AB';
            }
        
            foreach(['password', 'id', 'comments'] as $key){
                if(UserComment::missing_post($key) or !$key)
                UserComment::apidie('Missing key/value for "'.$key.'"', 422);
            }
        
            if(strtoupper($_POST['password']) != '720DF6C2482218518FA20FDC52D4DED7ECC043AB')
            UserComment::apidie('Invalid password', 401);
        
            if(!is_numeric($_POST['id']))
                UserComment::apidie('Invalid id', 422);
        
            if($error = UserComment::append_user_comments($_POST['id'], $_POST['comments']))
            UserComment::apidie('Could not update database: '.$error, 500);
        
            UserComment::apidie('OK', 200);
        
        }
   }

  }

}
