<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserComments;

class UserCommentsController extends Controller
{
    //
  public function getIDx(Request $request)
  {
    //validation
    $id = isset($request['X'])? $request['X'] : false;
   
    if($id)
    {
      //rs recordset
        $user = UserComments::find($id);
        if($user == null){
          die('This URI requires valid ID, please try again');
        } else{
          return view('usercomments.index', compact('user'));
        }

    }
    //$user = get_user_by_id($_GET['id']);
    //require('view.php');

  }
}
