<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        DB::table('diffusion')->insert([
            ['libelle' => 'Public'],
            ['libelle' => 'Privé'],
            ['libelle' => 'Communautaire'],
        ]);

        DB::table('categorie')->insert([
            ['libelle' => 'Sport'],
            ['libelle' => 'Voyage'],
            ['libelle' => 'Art'],
            ['libelle' => 'Technologie'],
            ['libelle' => 'Cuisine'],
            ['libelle' => 'Mode'],
            ['libelle' => 'Vie quotidienne'],
            ['libelle' => 'Nature'],
            ['libelle' => 'Artisanat'],
            ['libelle' => 'Santé'],
            ['libelle' => 'Politique'],
            ['libelle' => 'Éducation'],
            ['libelle' => 'Environnement'],
            ['libelle' => 'Finances'],
            ['libelle' => 'Sciences'],
            ['libelle' => 'Histoire'],
            ['libelle' => 'Religion'],
            ['libelle' => 'Photographie'],
            ['libelle' => 'Vie de famille'],
            ['libelle' => 'Économie'],
            ['libelle' => 'Informatique'],
            ['libelle' => 'Politique'],
            ['libelle' => 'Rencontre'],
            ['libelle' => 'Réseautage'],
            ['libelle' => 'Entreprenariat'],
            ['libelle' => 'Fête'],
        ]);

        /*
        DB::table('badge')->insert([
            ['libelle' => 'Utilisateur'],
            ['libelle' => 'Annonciateur Vérifié'],
            ['libelle' => 'Profil Vérifié'],
            ['libelle' => 'Professionnel Vérifié'],
        ]);
        */
    }
}
