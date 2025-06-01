<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index(){
        Carbon::setLocale('fr');
        //evenements de comptes suivis
        $evenementsAbonnements = [];
        $suivis = [];
        if (Auth::check()) {
            /*$evenementsAbonnements = DB::table('evenement')
            ->join('suivre', 'evenement.user_id', '=', 'suivre.followed_id')
            ->where('suivre.follower_id', Auth::user()->id)
            ->select('evenement.*')
            ->get()
            ->map(function($evenement) {
                $evenement->date = Carbon::parse($evenement->date)->isoFormat('D MMMM YYYY');
                return $evenement;
            });

            $evenements = DB::table('evenement')
            ->leftJoin('suivre', 'evenement.user_id', '=', 'suivre.followed_id')
            //->where('suivre.follower_id', '!=',Auth::user()->id)
            ->select('evenement.*', 'suivre.follower_id')
            ->get()
            ->map(function($evenement) {
                $evenement->date = Carbon::parse($evenement->date)->isoFormat('D MMMM YYYY');
                return $evenement;
            });            
            */
            /*
            $evenements = DB::table('evenement')
            ->join('suivre', 'evenement.user_id', '=', 'suivre.followed_id')
            ->join('invitation', 'evenement.id', '=', 'invitation.evenement_id')
            ->where('invitation.user_id', Auth::user()->id)
            ->where('suivre.follower_id', '!=', Auth::user()->id)
            ->where('date', '>=', Carbon::now())
            ->where('diffusion_id', '=', 1)
            ->orderBy('date', 'asc')
            ->get()
            ->map(function($evenement) {
                $evenement->date = Carbon::parse($evenement->date)->isoFormat('D MMMM YYYY');
                return $evenement;
                });*/
                    $evenements = DB::table('evenement')
                        ->leftJoin('suivre', 'evenement.user_id', '=', 'suivre.followed_id')
                        ->leftJoin('etre_invite', 'evenement.id', '=', 'etre_invite.evenement_id')
                        ->where(function($query) {
                            $query->where('evenement.diffusion_id', '=', 1)
                                ->orWhere('evenement.user_id', '=', Auth::user()->id)
                                ->orWhere(function($q) {
                                    $q->where('suivre.follower_id', '=', Auth::user()->id)
                                      ->where('evenement.diffusion_id', '=', 3);
                                })
                                ->orWhere(function($q) {
                                    $q->where('etre_invite.user_id', '=', Auth::user()->id)
                                      ->where('evenement.diffusion_id', '=', 2);
                                });
                        })
                        ->select('evenement.*')
                        ->distinct()
                        ->get()
                        ->map(function($evenement) {
                            $evenement->date = Carbon::parse($evenement->date)->isoFormat('D MMMM YYYY');
                            return $evenement;
                        });
                        $suivis = DB::table('suivre')->where('follower_id', Auth::user()->id)->get();
            }
            else{
                $evenements = DB::table('evenement')
                    ->where('date', '>=', Carbon::now())
                    ->where('diffusion_id', '=', 1)
                    ->orderBy('date', 'asc')
                    ->get()
                    ->map(function($evenement) {
                        $evenement->date = Carbon::parse($evenement->date)->isoFormat('D MMMM YYYY');
                        return $evenement;
                    });
            
        }
        
        return view('welcome', [
            'evenements' => $evenements, 'evenementsAbonnements' => $evenementsAbonnements, 'suivis' => $suivis
        ]);
    }
}
