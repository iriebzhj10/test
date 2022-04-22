<?php

namespace Database\Seeders;
use App\Models\TypeParametre;
use App\Models\Parametre;
use Illuminate\Database\Seeder;

class ParametreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(TypeParametre $type_parametre)
    {
        //
        $type_parametre = TypeParametre::all();

        foreach ($type_parametre as $type_parametres) {
          switch ($type_parametres->libelle) {
              case 'depense':
                 Parametre::create(['libelle' => 'eau','type_parametre_id'=>$type_parametre->id]);
                 Parametre::create(['libelle' => 'loyer','type_parametre_id'=>$type_parametre->id]);
                 Parametre::create(['libelle' => 'salaire','type_parametre_id'=>$type_parametre->id]);
                 Parametre::create(['libelle' => 'voyage','type_parametre_id'=>$type_parametre->id]);
                 Parametre::create(['libelle' => 'prime','type_parametre_id'=>$type_parametre->id]);
                 Parametre::create(['libelle' => 'electricite','type_parametre_id'=>$type_parametre->id]);
                 Parametre::create(['libelle' => 'transport','type_parametre_id'=>$type_parametre->id]);
                 break;

                  case 'facture':
                    Parametre::create(['libelle' => 'devis', 'type_parametre_id'=>$type_parametre->id]);
                    Parametre::create(['libelle' => 'proforma',  'type_parametre_id'=>$type_parametre->id]);
                    break;

                    case 'user':
                        Parametre::create(['libelle' => 'client', 'type_parametre_id'=>$type_parametre->id]);
                        Parametre::create(['libelle' => 'personnel',  'type_parametre_id'=>$type_parametre->id]);
                        Parametre::create(['libelle' => 'administrateur',  'type_parametre_id'=>$type_parametre->id]);
                        break;
              
              default:
                 'ok';
                  break;
          }
         
        }
    }
}
