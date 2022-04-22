<?php

namespace Database\Seeders;
use App\Models\TypeParametre;
use App\Models\Parametre;
use Illuminate\Database\Seeder;

class TypeParametreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // TypeParametre::create([
        //    [ 'libelle'=>'depense' ,'description'=>''],
        //    [ 'libelle'=>'facture' ,'description'=>''],
        //    [ 'libelle'=>'user' ,'description'=>''],
        //    [ 'libelle'=>'patrimoine' ,'description'=>''],
        //    [ 'libelle'=>'domaine' ,'description'=>'']
         
        // ]);

        $depense= TypeParametre::create(['libelle' => 'depense']);
        $facture = TypeParametre::create(['libelle' => 'facture']);
        $user = TypeParametre::create(['libelle' => 'user']);
        $patrimoine = TypeParametre::create(['libelle' => 'patrimoine']);
        $domaine = TypeParametre::create(['libelle' => 'domaine']);
    }


}
