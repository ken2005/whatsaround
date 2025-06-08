<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UtilisateurController extends Controller
{
    //
    public function profil($id){
        Carbon::setLocale('fr');
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }
        if (!Auth::check() ) {
            return redirect()->route('connexion');
        }
        $suivi = false;
        $demande = false;
        if (Auth::check()) {
            $suivi = DB::table('suivre')->where('follower_id', Auth::user()->id)->where('followed_id', $id)->where('validee', 1)->exists();
            $demande = DB::table('suivre')->where('follower_id', Auth::user()->id)->where('followed_id', $id)->where('validee', 0)->exists();
            $evenements = DB::table('evenement')
                        ->leftJoin('suivre', 'evenement.user_id', '=', 'suivre.followed_id')
                        ->leftJoin('etre_invite', 'evenement.id', '=', 'etre_invite.evenement_id')
                        ->where('evenement.user_id', $id)
                        ->where(function($query) {
                            $query->where('evenement.diffusion_id', '=', 1)
                                ->orWhere('evenement.user_id', '=', Auth::user()->id)
                                ->orWhere(function($q) {
                                    $q->where('suivre.follower_id', '=', Auth::user()->id)
                                      ->where('suivre.validee', 1)
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
        }
        else{
            $evenements = DB::table('evenement')->where('user_id', $id)
            ->where('diffusion_id', '=', 1)
                ->get()
                ->map(function($evenement) {
                    $evenement->date = Carbon::parse($evenement->date)->isoFormat('D MMMM YYYY');
                    return $evenement;
                });
        }
        /*
        $evenements = DB::table('evenement')->where('user_id', $id)
        ->where('diffusion_id', '=', 1)
            ->get()
            ->map(function($evenement) {
                $evenement->date = Carbon::parse($evenement->date)->isoFormat('D MMMM YYYY');
                return $evenement;
            });*/
        $user->evenements = $evenements;
        $nbSuivi = DB::table('suivre')->where('followed_id', $id)->where('validee', 1)->count();
        return view('user.profil', ['user' => $user, 'suivi' => $suivi, 'nbSuivi' => $nbSuivi, 'demande' => $demande]);
    }

    public function suivre(Request $request, $id){
        if (Auth::check()) {
            // Vérifier si l'utilisateur suit déjà l'utilisateur cible
            $suivi = DB::table('suivre')->where('follower_id', Auth::user()->id)->where('followed_id', $id)->exists();
            if ($suivi) {
                return redirect()->back(); // L'utilisateur suit déjà, pas besoin de faire quoi que ce soit
            }
            DB::table('suivre')->insert([
                'follower_id' => Auth::user()->id,
                'followed_id' => $id,
            ]);
            return redirect()->back();
        }
        return redirect()->route('connexion');
    }
    
    public function seDesabonner(Request $request, $id){
        if (Auth::check()) {
            DB::table('suivre')
                ->where('follower_id', Auth::user()->id)
                ->where('followed_id', $id)
                ->delete();
            return redirect()->back();
        }
        return redirect()->route('connexion');
    }
    
    public function abonnements(){
        if(Auth::check()){
            Carbon::setLocale('fr');
            $following = DB::table('users')
                ->join('suivre', 'users.id', '=', 'suivre.followed_id')
                ->where('suivre.follower_id', Auth::user()->id)
                ->where('suivre.validee', 1)
                ->select('users.name', 'users.id', 'users.image')
                ->get();
                
            return view('user.abonnements', ['following' => $following]);
        }
        return redirect()->route('connexion');
    }

    public function demandes()
        {
            if (Auth::check()) {
                if (Auth::user()->est_prive == 0) {
                    return redirect()->route('abonnements');
                }
                $demandes = DB::table('suivre')
                    ->join('users', 'suivre.follower_id', '=', 'users.id')
                    ->where('suivre.followed_id', Auth::user()->id)
                    ->where('suivre.validee', 0)
                    ->select( 'users.*')
                    ->get()
                    ->map(function($demande) {
                        $demande->follower = (object)[
                            'name' => $demande->name,
                            'image' => $demande->image
                        ];
                        return $demande;
                    });
    
                return view('user.demandes', ['demandes' => $demandes]);
            }
            return redirect()->route('connexion');
        }
    
        public function accepterDemande(Request $request, $id)
        {
            if (Auth::check()) {
                DB::table('suivre')
                    ->where('follower_id', $id)
                    ->where('followed_id', Auth::user()->id)
                    ->update(['validee' => 1]);
                return redirect()->back();
            }
            return redirect()->route('connexion');
        }
    
        public function refuserDemande(Request $request, $id)
        {
            if (Auth::check()) {
                DB::table('suivre')
                    ->where('follower_id', $id)
                    ->where('followed_id', Auth::user()->id)
                    ->delete();
                return redirect()->back();
            }
            return redirect()->route('connexion');
        }

        public function passerPrive(Request $request, $id)
        {
            if (Auth::check()) {
                DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->update(['est_prive' => 1]);
                return redirect()->back();
            }
            return redirect()->route('connexion');
        }
        public function passerPublic(Request $request, $id)
        {
            if (Auth::check()) {
                DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->update(['est_prive' => 0]);
                return redirect()->back();
            }
            return redirect()->route('connexion');
        }
    
    
}
