<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvenementRequest;
use App\Models\Evenement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Core\Dictionnaires;

class EvenementController extends Controller
{
    //
    public function creer(){
        if(Auth::check()){
            return view('evenement.creer');
        }
        else{
            return redirect()->route('connexion');
        }
    }

    public function participants($id)
    {
        $evenement = Evenement::with('inscriptions')->find($id);
        
        if (!$evenement) {
            abort(404);
        }
        elseif ($evenement->user_id != Auth::id()) {
            abort(403);
        }

        return view('evenement.participants', ['evenement' => $evenement]);
    }


    public function inviter($id) {
        $evenement = Evenement::find($id);
        if (!$evenement || $evenement->user_id != Auth::id()) {
            abort(403);
        }
        $users = DB::table('users')->join('suivre', 'users.id', '=', 'suivre.followed_id')
        ->whereNotIn('users.id', function($query) use ($id) {
            $query->select('user_id')
                ->from('etre_invite')
                ->where('evenement_id', $id);
        })
        ->where('suivre.follower_id', Auth::id())
        ->select('users.*')
        ->get();
        return view('evenement.inviter', ['evenement' => $evenement, 'users' => $users]);
    }

    public function doInviter(Request $request, $id) {
        $evenement = Evenement::find($id);
        if (!$evenement || $evenement->user_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id'
        ]);

        foreach($request->users as $userId) {
            DB::table('etre_invite')->insert([
                'user_id' => $userId,
                'evenement_id' => $id
            ]);
        }

        return redirect()->route('evenement', $id)->with('success', 'Invitations envoyées avec succès');
    }

    public function supprimer(Request $request,$id)
        {
            $evenement = Evenement::find($id);
    
            if (!$evenement) {
                abort(404);
            }
    
            if ($evenement->user_id != Auth::id()) {
                abort(403);
            }
    
            if ($evenement->image) {
                $imagePath = public_path('images/evenements/' . $evenement->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
    
            DB::table('enregistrer')->where('evenement_id', $id)->delete();
            DB::table('s_inscrire')->where('evenement_id', $id)->delete();
            
            $evenement->delete();
    
            return redirect()->route('accueil')->with('success', 'Événement supprimé avec succès');
        }
    

    public function doCreer(EvenementRequest $request)
        {
            $evenement = new Evenement();
            $evenement->nom = $request->nom;
            $evenement->num_rue = $request->num_rue;
            $evenement->allee = $request->allee;
            $evenement->ville = $request->ville;
            $evenement->code_postal = $request->code_postal;
            $evenement->pays = $request->pays;
            $evenement->date = $request->date;
            $evenement->heure = $request->heure;
            $evenement->description = $request->description;
            $evenement->user_id = Auth::id();
            $evenement->diffusion_id = $request->diffusion;
            $evenement->annonciateur = $request->has('annonciateur');
            $evenement->max_participants = $request->max_participants;
            
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                $imageName = date('YmdHi') . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/evenements'), $imageName);

                $evenement->image =  $imageName;
            }
            
            $evenement->save();
             foreach ($request->categorie as $categorie){

                 DB::table('etre')->insert([
                     'evenement_id' => $evenement->id,
                     'categorie_id' => $categorie
                 ]);
             }
            //$evenement->categories()->attach($request->categorie);
    
            return redirect()->route('accueil')->with('success', 'Événement créé avec succès');
        }    
    public function consulter($id){
        Carbon::setLocale('fr');
        $evenement = Evenement::find($id);
        $autorise = true;
        if (!$evenement) {
            abort(404);
        }
        elseif ($evenement->diffusion_id != 1 && $evenement->user_id  != Auth::id()) {
            if ($evenement->diffusion_id == 2) {
                $autorise = DB::table('etre_invite')->where('evenement_id', $id)->where('user_id', Auth::id())->exists();
            }
            elseif ($evenement->diffusion_id == 3) {
                $autorise = DB::table('suivre')->where('followed_id', $evenement->user_id)->where('follower_id', Auth::id())->exists();
            }
        }
        $owned = false;
        $passed = false;
        if (!$autorise) {
            abort(403);
        }
        if ($evenement->user_id == Auth::id()) {
            $owned = true;
        }
        if ($evenement->date < now()) {
            $passed = true;
        }
        $date = Carbon::parse($evenement->date)->isoFormat('D MMMM YYYY');
        $enregistre =  DB::table('enregistrer')->where('evenement_id', $id)->where('user_id', Auth::id())->exists();
        $inscrit = DB::table('s_inscrire')->where('evenement_id', $id)->where('user_id', Auth::id())->exists();
        $participantsSuivis = DB::table('s_inscrire')->join('users', 's_inscrire.user_id', '=', 'users.id')->join('suivre', 's_inscrire.user_id', '=', 'suivre.followed_id')->where('suivre.follower_id', '=', Auth::id())->where('s_inscrire.evenement_id', '=', $id)->select('users.name')->get();
        $nbParticipants = DB::table('s_inscrire')->where('evenement_id', $id)->count();
        return view('evenement.consulter', ['evenement' => $evenement, 'owned' => $owned, 'passed' => $passed, 'enregistre' => $enregistre, 'inscrit' => $inscrit, 'date' => $date, 'participantsSuivis' => $participantsSuivis, 'nbParticipants' => $nbParticipants]);
    }

    public function enregistres()
        {
            if(Auth::check()){
                Carbon::setLocale('fr');
                $evenements = DB::table('evenement')
                    ->join('enregistrer', 'evenement.id', '=', 'enregistrer.evenement_id')
                    ->where('enregistrer.user_id', '=', Auth::id())
                    ->select('evenement.*')
                    ->get()
                    ->map(function($evenement) {
                        $evenement->date = Carbon::parse($evenement->date)->isoFormat('D MMMM YYYY');
                        return $evenement;
                    });
                return view('evenement.enregistres', ['evenements' => $evenements]);
            }
            return redirect()->route('connexion');
        }
    public function inscriptions()
        {
            if(Auth::check()){
                Carbon::setLocale('fr');
                $evenements = DB::table('evenement')
                    ->join('s_inscrire', 'evenement.id', '=', 's_inscrire.evenement_id')
                    ->where('s_inscrire.user_id', '=', Auth::id())
                    ->select('evenement.*')
                    ->get()
                    ->map(function($evenement) {
                        $evenement->date = Carbon::parse($evenement->date)->isoFormat('D MMMM YYYY');
                        return $evenement;
                    });
                return view('evenement.inscriptions', ['evenements' => $evenements]);
            }
            return redirect()->route('connexion');
        }
    
    public function crees(){
        if(Auth::check()){
            Carbon::setLocale('fr');
            $evenements = DB::table('evenement')
                ->where('user_id', '=', Auth::id())
                ->get()
                ->map(function($evenement) {
                    $evenement->date = Carbon::parse($evenement->date)->isoFormat('D MMMM YYYY');
                    return $evenement;
                });
            return view('evenement.crees', ['evenements' => $evenements]);
        }
        return redirect()->route('connexion');
    }
    

    public function sInscrire(Request $request, $id){
        if(Auth::check()){
            $evenement = Evenement::find($id);
            if($evenement->diffusion_id == 2){
                if(!DB::table('etre_invite')->where('evenement_id', $id)->where('user_id', Auth::id())->exists()){
                    return redirect()->back()->with('error', 'Vous n\'êtes pas invité à cet événement');
                }
            }
            elseif($evenement->diffusion_id == 3){
                if(!DB::table('suivre')->where('followed_id', $evenement->user_id)->where('follower_id', Auth::id())->exists()){
                    return redirect()->back()->with('error', 'Vous ne suivez pas cet utilisateur');
                }
            }
            elseif($evenement->inscriptions->count() >= $evenement->nb_participants && $evenement->nb_participants != null){
                return redirect()->back()->with('error', 'Nombre de participants maximum atteint');
            }
            DB::table('s_inscrire')->insert([
                'user_id' => Auth::id(),
                'evenement_id' => $id
            ]);
            return redirect()->back()->with('success', 'Inscription réussie à l\'événement');
        }
        return redirect()->route('connexion');
    }
    public function enregistrer(Request $request, $id){
        if(Auth::check()){
            $evenement = Evenement::find($id);
            DB::table('enregistrer')->insert([
                'user_id' => Auth::id(),
                'evenement_id' => $id
            ]);
            return redirect()->back()->with('success', 'Inscription réussie à l\'événement');
        }
        return redirect()->route('connexion');
    }

    public function desenregistrer(Request $request, $id){
        if(Auth::check()){
            DB::table('enregistrer')
                ->where('user_id', Auth::id())
                ->where('evenement_id', $id)
                ->delete();
            return redirect()->back()->with('success', 'Événement retiré des favoris');
        }
        return redirect()->route('connexion');
    }
    public function seDesinscrire(Request $request, $id){
            if(Auth::check()){
                DB::table('s_inscrire')
                    ->where('user_id', Auth::id())
                    ->where('evenement_id', $id)
                    ->delete();
                return redirect()->back()->with('success', 'Désinscription réussie de l\'événement');
            }
            return redirect()->route('connexion');
        }
        
        public function rechercher(Request $request){
            Carbon::setLocale('fr');
            $search = $request->input('search');
            $searchTerms = explode(' ', $search);
            
            // Recherche des mois en français et conversion en anglais
            $moisFrancais = Dictionnaires::getMoisFrancais();
            $searchMois = $searchTerms;
            foreach ($searchTerms as $key => $term) {
                foreach ($moisFrancais as $mois) {
                    if (stripos($mois, $term) !== false) {
                        $searchMois[$key] = Dictionnaires::getMois($mois);
                        break;
                    }
                }
            }
    
            // Recherche des jours en français et conversion en anglais
            $joursFrancais = Dictionnaires::getJoursFrancais();
            $searchJour = $searchTerms;
            foreach ($searchTerms as $key => $term) {
                foreach ($joursFrancais as $jour) {
                    if (stripos($jour, $term) !== false) {
                        $searchJour[$key] = Dictionnaires::getJours($jour);
                        break;
                    }
                }
            }
    
            $evenements = DB::table('evenement')
                ->select('evenement.*', 'categorie.libelle as categorie_libelle')
                ->distinct()
                ->leftJoin('etre', 'evenement.id', '=', 'etre.evenement_id')
                ->leftJoin('categorie', 'etre.categorie_id', '=', 'categorie.id')
                ->where(function($query) {
                    $query->where('diffusion_id', 1);
                    if (Auth::check()) {
                        $query->orWhere(function($q) {
                            $q->where('diffusion_id', 2)
                            ->whereExists(function($subquery) {
                                $subquery->select(DB::raw(1))
                                    ->from('etre_invite')
                                    ->whereRaw('etre_invite.evenement_id = evenement.id')
                                    ->where('etre_invite.user_id', Auth::id());
                            });
                        })
                            ->orWhere(function($q) {
                                $q->where('diffusion_id', 3)
                                ->whereExists(function($subquery) {
                                    $subquery->select(DB::raw(1))
                                        ->from('suivre')
                                        ->whereRaw('suivre.followed_id = evenement.user_id')
                                        ->where('suivre.follower_id', Auth::id());
                                });
                            });
                    }
                })
                ->selectRaw('
                    CASE 
                        WHEN ' . implode(' AND ', array_fill(0, count($searchTerms), 'evenement.nom LIKE ?')) . ' THEN 5
                        WHEN ' . implode(' AND ', array_fill(0, count($searchTerms), 'categorie.libelle LIKE ?')) . ' THEN 4
                        WHEN ' . implode(' AND ', array_fill(0, count($searchTerms), 'evenement.description LIKE ?')) . ' THEN 3
                        WHEN ' . implode(' AND ', array_fill(0, count($searchTerms), '(evenement.ville LIKE ? OR evenement.code_postal LIKE ? OR evenement.allee LIKE ?)')) . ' THEN 2
                        WHEN ' . implode(' AND ', array_fill(0, count($searchTerms), 'DATE_FORMAT(evenement.date, "%d %M %Y") LIKE ?')) . ' THEN 1
                        WHEN ' . implode(' AND ', array_fill(0, count($searchTerms), 'DATE_FORMAT(evenement.date, "%W") LIKE ?')) . ' THEN 1
                        ELSE 0
                    END as pertinence', 
                    array_merge(
                        array_map(function($term) { return "%{$term}%"; }, $searchTerms),
                        array_map(function($term) { return "%{$term}%"; }, $searchTerms),
                        array_map(function($term) { return "%{$term}%"; }, $searchTerms),
                        array_map(function($term) { return "%{$term}%"; }, $searchTerms),
                        array_map(function($term) { return "%{$term}%"; }, $searchTerms),
                        array_map(function($term) { return "%{$term}%"; }, $searchTerms),
                        array_map(function($term) { return "%{$term}%"; }, $searchMois),
                        array_map(function($term) { return "%{$term}%"; }, $searchJour)
                    )
                )
                ->where(function($query) use ($searchTerms, $searchMois, $searchJour) {
                    foreach ($searchTerms as $key => $term) {
                        $query->where(function($q) use ($term, $searchMois, $searchJour, $key) {
                            $q->where('evenement.nom', 'LIKE', "%{$term}%")
                                ->orWhere('categorie.libelle', 'LIKE', "%{$term}%")
                                ->orWhere('evenement.description', 'LIKE', "%{$term}%")
                                ->orWhere('evenement.ville', 'LIKE', "%{$term}%")
                                ->orWhere('evenement.code_postal', 'LIKE', "%{$term}%")
                                ->orWhere('evenement.allee', 'LIKE', "%{$term}%")
                                ->orWhere(DB::raw("DATE_FORMAT(evenement.date, '%d %M %Y')"), 'LIKE', "%{$term}%")
                                ->orWhere(DB::raw("DATE_FORMAT(evenement.date, '%W')"), 'LIKE', "%{$searchJour[$key]}%");
                        });
                    }
                })
                ->orderBy('pertinence', 'desc')
                ->get()
                ->unique('id')
                ->map(function($evenement) {
                    $evenement->date = Carbon::parse($evenement->date)->isoFormat('D MMMM YYYY');
                    return $evenement;
                });
    
            $profils = User::where(function($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('name', 'LIKE', "%{$term}%");
                }
            })->get();
                
            return view('evenement.recherche', ['evenements' => $evenements,'users' => $profils, 'search' => $search]);
        }
        }