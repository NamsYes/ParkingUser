<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Place;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseFormatSame;
use Illuminate\Support\Facades\DB;
use function Pest\Laravel\get;

class HomeController extends Controller
{

    public function index (){

        //Recuperer l'user co
        $user= Auth::user();

        //Recuperation des resa active
        $activeresa = DB::table('reservations')
            ->where('expired',"=", false)
            ->where('user_id','=',$user->id)
            ->count();

        //resa stock l'id des reservation non expirer qui correspond à l'user
        $resa = Reservation::where('expired','=',false)->where('user_id','=',$user->id)->get();

        //RECUPERATION DE LA COLLECTION RESERVATION ACTIVE

        $reservationActive = Reservation::where('expired','=',false)
            ->where('user_id','=',$user->id)->get();


        if ($activeresa>0){
        $idPlaceActive = $reservationActive[0]->place_id;
        $place = Place::where('id','=',$idPlaceActive)->get();
        $nomplace = $place[0]->libelle;
        }

        $expired = Reservation::where('expired','=',true)->where('user_id','=',$user->id)->orderby('created_at','desc')->get();

        if ($activeresa>0){
        return view('home',[
            'reservation'=>$resa,
            'expired'=>$expired,
            'nb_resa'=>$activeresa,
            'place'=>$nomplace,
        ]);
        } else {
            return view('home',[
                'reservation'=>$resa,
                'expired'=>$expired,
                'nb_resa'=>$activeresa,

            ]);

        }
    }

    public static function cancelresa ($id)
    {
        $user= Auth::user();

        //RECUPERE LA RESERVATION ACTIVE
        $resa = Reservation::find($id);

        //RECUPERE LA PLACE DE LA RESERVATION
        $reservationActive = Reservation::where('expired','=',false)
                                        ->where ('id','=',$id)
                                        ->where('user_id','=',$user->id)->get();

        $idPlace = $reservationActive[0]->place_id;
        $place = Place::where('id','=',$idPlace)->get();

        Place::where('id',$idPlace)->update(['libre'=>true]);
        $resa->update(['expired' => true]);
        $resa->update(['end_at' => now()]);





        //recuperer la place que l'user utilise


        return redirect()->route('home');

    }

    public function deleteresa($id)
    {
        $idresa = Reservation::findOrFail($id);
        $idresa->delete();

        return redirect()->route('home');
    }

    public function giveplace()
    {
        $user= Auth::user();
        $user_id= $user->id;
        $freeplace = Place::where('libre','=',true)->get();
        $randomFreePlace = $freeplace->random();


        $reservation = new Reservation([
            'created_at'=>now(),
            'expired'=>0,
            'user_id'=>$user_id,
            'place_id'=>$randomFreePlace->id,
            'updated_at'=>now(),
        ]);
        $reservation->save();

        $resa = Place::where('id',$randomFreePlace->id);
            $resa->update(['libre' => 0]);

        return redirect()->route('home');
    }





  /*  public function addresa($id_user)
    {
        $place = Place::all();
        $user = $id_user;

        return redirect()->route('addresa');

    }*/


//    public function getexpiredresa()
//    {
//        $expired = Reservation::where('expired','=',false)->get();
//        return view('home', ['historique'=>$expired]);
//    }

}

