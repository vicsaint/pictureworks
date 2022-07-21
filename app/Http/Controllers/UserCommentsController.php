<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UserComments;

class UserCommentsController extends Controller
{
  
  
	//check the user session
  public function __construct() 
  {
		$this->middleware('auth');
	}

    //
  public function getIDx(Request $request)
  {
    //validation
    $id = isset($request['X'])? $request['X'] : false;
   
    if($id)
    {
      //rs recordset
        $user = UserComments::get_user_by_id($id);
        if($user == null){
          die('This URI requires valid ID, please try again');
        } else{
          return view('usercomments.index', compact('user'));
        }

    }
    //$user = get_user_by_id($_GET['id']);
    //require('view.php');
  }

  public function postNoneJsnForm(Request $request)
  {
    var_dump($_POST);

  }
  
  public function postWithJsnForm(Request $request)
  {
    if ($request->isMethod('post'))
    {
        $json = file_get_contents('php://input');

        if(sizeof($_POST) or $json or (isset($argv[1]) and isset($argv[2]))){
        
          if($json){
                if(!UserComments::is_json($json))
                UserComments::apidie('Invalid POST JSON', 422);
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
                if(UserComments::missing_post($key) or !$key)
                UserComments::apidie('Missing key/value for "'.$key.'"', 422);
            }
        
            if(strtoupper($_POST['password']) != '720DF6C2482218518FA20FDC52D4DED7ECC043AB')
            UserComments::apidie('Invalid password', 401);
        
            if(!is_numeric($_POST['id']))
                UserComments::apidie('Invalid id', 422);
        
            if($error = UserComments::append_user_comments($_POST['id'], $_POST['comments']))
            UserComments::apidie('Could not update database: '.$error, 500);
        
            UserComments::apidie('OK', 200);
        
        }
   }

  }

}
