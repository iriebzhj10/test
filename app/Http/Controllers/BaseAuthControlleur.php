<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class BaseAuthControlleur extends Controller
{
    //for AuthController




    public function sidebar($email,$user,$allpermissions,$role,$all_users_with_all_their_roles,$entreprise_check,$user_connecte,$checker)
    {
        //return response()->json([ $email  ]);

       // $user = User::where('email', $data['email'])->first(); //Auth::user()
        $user = User::where('email', $email )->first(); //Auth::user()




            //collect des permissions
        $connected_user_permission = User::with('Permissions')
            ->where('id', $user->id)
            ->get();

        $user_connected_details = [];
        array_push($user_connected_details, $connected_user_permission);
        array_push($user_connected_details, $allpermissions);






        $sideperm = $user_connected_details[1];
        $permissionsFront = [];
        for ($i = 0; $i < count($sideperm); $i++) {
            array_push($permissionsFront, $sideperm[$i]->name);
        }


        // --------------------------------------------------------------------------------------------------------------

        // les liens dans la sidebar du module facture
        $facture = [];
        $devis = [];
        $relance = [];
        $versement = [];
        $taxe = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'facture')) {
                array_push($facture, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'devis')) {
                array_push($devis, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'relance')) {
                array_push($relance, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'versement')) {
                array_push($versement, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'taxe')) {
                array_push($taxe, $permissionsFront[$i]);
            }
        }
        if (count($facture) > 0 || count($devis) > 0 || count($versement) > 0 || count($relance) > 0 || count($taxe) > 0) {
            if (count($facture) > 0) {
                $factureChildren = [
                    'title' => "Facture",
                    'route' => "FactureList",
                    'icon' => "FileTextIcon",
                ];
            }
            if (count($devis) > 0) {
                $devisChildren = [
                    'title' => "Devis",
                    'route' => "",
                    'icon' => "FileMinusIcon",
                ];
            }
            if (count($versement) > 0) {
                $versementChildren = [
                    'title' => "Versement",
                    'route' => "versements",
                    'icon' => "DollarSignIcon",
                ];
            }
            if (count($taxe) > 0) {
                $taxeChildren = [
                    'title' => "Taxe",
                    'route' => "taxes",
                    'icon' => "PaperclipIcon",
                ];
            }
            if (count($relance) > 0) {
                $relanceChildren = [
                    'title' => "Relance",
                    'route' => "relance",
                    'icon' => "RotateCwIcon",
                ];
            }
            $childrenFacturation = [];
            if (isset($factureChildren)) {
                array_push($childrenFacturation, $factureChildren);
            }
            if (isset($devisChildren)) {
                array_push($childrenFacturation, $devisChildren);
            }
            if (isset($taxeChildren)) {
                array_push($childrenFacturation, $taxeChildren);
            }
            if (isset($relanceChildren)) {
                array_push($childrenFacturation, $relanceChildren);
            }
            if (isset($versementChildren)) {
                array_push($childrenFacturation, $versementChildren);
            }
            $facturation = [
                'title' => 'Facturation',
                'icon' => "LayersIcon",
                'children' => $childrenFacturation,
            ];
        }
        //Facturation children
        $childrenFacturation = [];
        if (isset($factureChildren)) {
            array_push($childrenFacturation, $factureChildren);
        }
        if (isset($devisChildren)) {
            array_push($childrenFacturation, $devisChildren);
        }
        if (isset($taxeChildren)) {
            array_push($childrenFacturation, $taxeChildren);
        }
        if (isset($relanceChildren)) {
            array_push($childrenFacturation, $relanceChildren);
        }
        if (isset($versementChildren)) {
            array_push($childrenFacturation, $versementChildren);
        }
        $facturation = [
            'title' => 'Facturation',
            'icon' => "LayersIcon",
            'children' => $childrenFacturation,
        ];

        // --------------------------------------------------------------------------------------------------------------

        //Module Trésorerie liens de la side bar
        $depense = [];
        $transaction = [];
        $compte = [];
        $emprunt = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'depense')) {
                array_push($depense, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'transaction')) {
                array_push($transaction, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'compte')) {
                array_push($compte, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'emprunt')) {
                array_push($emprunt, $permissionsFront[$i]);
            }
        }
        if (count($depense) > 0 || count($transaction) > 0 || count($compte) > 0 || count($emprunt) > 0) {
            if (count($depense) > 0) {
                $depenseChildren = [
                    'title' => "Dépense",
                    'route' => "depenses",
                    'icon' => "CornerLeftUpIcon",
                ];
            }
            if (count($transaction) > 0) {
                $transactionChildren = [
                    'title' => "Transaction",
                    'route' => "",
                    'icon' => "TrendingUpIcon",
                ];
            }
            if (count($compte) > 0) {
                $compteChildren = [
                    'title' => "Compte",
                    'route' => "",
                    'icon' => "LockIcon",
                ];
            }

            $budgetChildren = [
                'title' => "Budget",
                'route' => "",
                'icon' => "LayersIcon",
            ];

            if (count($emprunt) > 0) {
                $empruntChildren = [
                    'title' => "Emprunt",
                    'route' => "emprunt",
                    'icon' => "CornerRightDownIcon",
                ];
            }
        }
        //Trésorrerie Children
        $childrenTresorerie = [];
        if (isset($depenseChildren)) {
            array_push($childrenTresorerie, $depenseChildren);
        }
        if (isset($transactionChildren)) {
            array_push($childrenTresorerie, $transactionChildren);
        }
        if (isset($compteChildren)) {
            array_push($childrenTresorerie, $compteChildren);
        }
        if (isset($budgetChildren)) {
            array_push($childrenTresorerie, $budgetChildren);
        }
        if (isset($empruntChildren)) {
            array_push($childrenTresorerie, $empruntChildren);
        }

        $tresorerie = [
            'title' => 'Trésorerie',
            'icon' => "DollarSignIcon",
            'children' => $childrenTresorerie,
        ];
        // --------------------------------------------------------------------------------------------------------------

        //Module Catalogue liens de la sidebar
        $article = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'article')) {
                array_push($article, $permissionsFront[$i]);
            }
        }

        //Catalogue Children
        if (count($article) > 0) {
            if (count($article) > 0) {
                $articleChildren = [
                    'title' => "Article",
                    'route' => "articles",
                    'icon' => "ShoppingBagIcon",
                ];
            }

            $codepromoChildren = [
                'title' => "Code promo",
                'route' => "",
                'icon' => "TagIcon",
            ];

            $categorieChildren = [
                'title' => "Catégorie d'article",
                'route' => "",
                'icon' => "GridIcon",
            ];

            $packChildren = [
                'title' => "Pack",
                'route' => "",
                'icon' => "CopyIcon",
            ];
        }
        $childrenCatalogue = [];
        if (isset($articleChildren)) {
            array_push($childrenCatalogue, $articleChildren);
        }
        if (isset($codepromoChildren)) {
            array_push($childrenCatalogue, $codepromoChildren);
        }
        if (isset($categorieChildren)) {
            array_push($childrenCatalogue, $categorieChildren);
        }
        if (isset($packChildren)) {
            array_push($childrenCatalogue, $packChildren);
        }

        $catalogue = [
            'title' => 'Catalogue',
            'icon' => "ShoppingBagIcon",
            'children' => $childrenCatalogue,
        ];

        // --------------------------------------------------------------------------------------------------------------

        //Module CRM liens de la sidebar
        $client = [];
        $prospection = [];
        $prospect = [];
        $fournisseur = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'client')) {
                array_push($client, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'prospection')) {
                array_push($prospection, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'prospect')) {
                array_push($prospect, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'fournisseur')) {
                array_push($fournisseur, $permissionsFront[$i]);
            }
        }
        if (count($client) > 0 || count($prospection) > 0 || count($prospect) > 0 || count($fournisseur) > 0) {
            if (count($client) > 0) {
                $clientChildren = [
                    'title' => "Client",
                    'route' => "clients",
                    'icon' => "UserCheckIcon",
                ];
            }
            if (count($prospection) > 0) {
                $prospectionChildren = [
                    'title' => "Prospection",
                    'route' => "prospection",
                    'icon' => "Minimize2Icon",
                ];
            }
            if (count($prospect) > 0) {
                $prospectChildren = [
                    'title' => "Prospect",
                    'route' => "prospect",
                    'icon' => "MehIcon",
                ];
            }
            if (count($fournisseur) > 0) {
                $fournisseurChildren = [
                    'title' => "Fournisseur",
                    'route' => "fournisseurs",
                    'icon' => "TruckIcon",
                ];
            }
        }
        $childrenCRM = [];
        if (isset($clientChildren)) {
            array_push($childrenCRM, $clientChildren);
        }
        if (isset($prospectionChildren)) {
            array_push($childrenCRM, $prospectionChildren);
        }
        if (isset($prospectChildren)) {
            array_push($childrenCRM, $prospectChildren);
        }
        if (isset($fournisseurChildren)) {
            array_push($childrenCRM, $fournisseurChildren);
        }

        $crm = [
            'title' => 'CRM',
            'icon' => "UsersIcon",
            'children' => $childrenCRM,
        ];
        // --------------------------------------------------------------------------------------------------------------
        //Entreprise les liens de la sidebar

            $personnel = [];
            $infopersonnel = [];
            $module = [];
            $historiquefacture = [];
            $departement = [];
            $agence = [];
            $projet = [];

            for ($i = 0; $i < count($permissionsFront); $i++) {
                if (strpos($permissionsFront[$i], 'personnel')) {
                    array_push($personnel, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'infopersonnel')) {
                    array_push($infopersonnel, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'achatmodule')) {
                    array_push($module, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'historiquefacture')) {
                    array_push($historiquefacture, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'departement')) {
                    array_push($departement, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'agence')) {
                    array_push($agence, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'projet')) {
                    array_push($projet, $permissionsFront[$i]);
                }
            }
            if (count($personnel) > 0 || count($infopersonnel) > 0 || count($module) > 0 || count($historiquefacture) > 0  || count($departement) > 0  || count($agence) > 0  || count($projet) > 0) {
                if (count($personnel) > 0) {
                    $personnelChildren = [
                        'title' => "Personnel",
                        'route' => "employes",
                        'icon' => "UserIcon",
                    ];
                }
                if (count($infopersonnel) > 0) {
                    $infopersonnelChildren = [
                        'title' => "Info entreprise",
                        'route' => "",
                        'icon' => "FolderIcon",
                    ];
                }
                if (count($module) > 0) {
                    $moduleChildren = [
                        'title' => "Module",
                        'route' => "",
                        'icon' => "CommandIcon",
                    ];
                }
                if (count($historiquefacture) > 0) {
                    $historiquefactureChildren = [
                        'title' => "Historique des factures",
                        'route' => "",
                        'icon' => "LayersIcon",
                    ];
                }
                if (count($departement) > 0) {
                    $departementChildren = [
                        'title' => "Département",
                        'route' => "",
                        'icon' => "LayoutIcon",
                    ];
                }
                if (count($agence) > 0) {
                    $agenceChildren = [
                        'title' => "Agence",
                        'route' => "",
                        'icon' => "MapIcon",
                    ];
                }
                if (count($projet) > 0) {
                    $projetChildren = [
                        'title' => "Projet",
                        'route' => "",
                        'icon' => "PlusSquareIcon",
                    ];
                }
            }
            $childrenEntreprise = [];
            if (isset($personnelChildren)) {
                array_push($childrenEntreprise, $personnelChildren);
            }
            if (isset($infopersonnelChildren)) {
                array_push($childrenEntreprise, $infopersonnelChildren);
            }
            if (isset($moduleChildren)) {
                array_push($childrenEntreprise, $moduleChildren);
            }
            if (isset($historiquefactureChildren)) {
                array_push($childrenEntreprise, $historiquefactureChildren);
            }
            if (isset($departementChildren)) {
                array_push($childrenEntreprise, $departementChildren);
            }
            if (isset($agenceChildren)) {
                array_push($childrenEntreprise, $agenceChildren);
            }
            if (isset($projetChildren)) {
                array_push($childrenEntreprise, $projetChildren);
            }

            $entreprise = [
                'title' => 'Entreprise',
                'icon' => "BriefcaseIcon",
                'children' => $childrenEntreprise,
            ];
        // --------------------------------------------------------------------------------------------------------------
            //Ediqia liens de la sidebar
            $roles = [];
            $permission = [];
            $modules = [];
            $parametre = [];
            $typeparametre = [];

            for ($i = 0; $i < count($permissionsFront); $i++) {
                if (strpos($permissionsFront[$i], 'role')) {
                    array_push($roles, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'permission')) {
                    array_push($permission, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'module')) {
                    array_push($modules, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'parametre')) {
                    array_push($parametre, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'typeparametre')) {
                    array_push($typeparametre, $permissionsFront[$i]);
                }
            }
            if (count($roles) > 0 || count($permission) > 0 || count($modules) > 0 || count($parametre) > 0 || count($typeparametre) > 0) {
                if (count($roles) > 0) {
                    $rolesChildren = [
                        'title' => "Rôles",
                        'route' => "",
                        'icon' => "FramerIcon",
                    ];
                }
                if (count($permission) > 0) {
                    $permissionChildren = [
                        'title' => "Permissions",
                        'route' => "",
                        'icon' => "KeyIcon",
                    ];
                }
                if (count($modules) > 0) {
                    $modulesChildren = [
                        'title' => "Modules",
                        'route' => "",
                        'icon' => "CommandIcon",
                    ];
                }
                if (count($parametre) > 0) {
                    $parametreChildren = [
                        'title' => "Paramètres",
                        'route' => "",
                        'icon' => "SettingsIcon",
                    ];
                }
                if (count($typeparametre) > 0) {
                    $typeparametreChildren = [
                        'title' => "Type paramètres",
                        'route' => "",
                        'icon' => "ServerIcon",
                    ];
                }
            }
            $childrenEdiqia = [];
            if (isset($rolesChildren)) {
                array_push($childrenEdiqia, $rolesChildren);
            }
            if (isset($permissionChildren)) {
                array_push($childrenEdiqia, $permissionChildren);
            }
            if (isset($modulesChildren)) {
                array_push($childrenEdiqia, $modulesChildren);
            }
            if (isset($parametreChildren)) {
                array_push($childrenEdiqia, $parametreChildren);
            }
            if (isset($typeparametreChildren)) {
                array_push($childrenEdiqia, $typeparametreChildren);
            }

            $ediqia = [
                'title' => 'Ediqia',
                'icon' => "ZapIcon",
                'children' => $childrenEdiqia,
            ];

        // --------------------------------------------------------------------------------------------------------------


        $sidebar = [['title' => 'Tableau de bord', 'route' => "home", 'icon' => "HomeIcon"]];
        array_push($sidebar, $facturation);
        array_push($sidebar, $tresorerie);
        array_push($sidebar, $catalogue);
        array_push($sidebar, $crm);
        array_push($sidebar, $entreprise);
        array_push($sidebar, $ediqia);
        // --------------------------------------------------------------------------------------------------------------


        //end check abonnements

        $token = $user->createToken('monappareil')->plainTextToken;

        // $all_users_with_all_their_roles = User::with('permissions')->where('id',$user->id)->get();
        // // $list=DB::table('nom_permissions')->select('libelle')->get();

        //    for($i=0;$i<count($list);$i++)
        //    {
        //        $list2[$i] =  $list[$i]->libelle;
        //        $permissions[$i] = Permission::where('name','like' ,'%-'.$list2[$i])->get();
        //        //$permission_et_nom[$i] = Arr::add(['permissions'=>$permissions[$i]], 'nom', $list[$i]->libelle);
        //        if(count($permissions)>0){

        //            $factureChildren[$i] = [
        //                'title'=> $list[$i]->libelle,
        //                'route'=> "FactureList", //doit etre dynamic
        //                'icon'=> "FileTextIcon", //doit etre dynamic
        //            ];

        //        }

        //    }

        $response = [
            'role' => $role,
            'user_connected_details' => $user_connected_details,
            //$all_users_with_all_their_roles,
            'allpermissions' => $allpermissions,
            'sidebar' => $sidebar,
            'entre' => $entreprise_check->id,
            'connected_user_permission' => $connected_user_permission,
            'user_connecte' => $user_connecte,
            'all_users_with_all_their_roles' => $all_users_with_all_their_roles,
            'checker' => $checker,
            'user' => $user,
            'token' => $token,
        ];

       // return response(['jojo'=>$response], 201);
        return response($response, 201);
    }







































    public function sidebar1($allpermissions,$email)
    {
        //return response()->json([ $email  ]);
  
       // $user = User::where('email', $data['email'])->first(); //Auth::user()
        $user = User::where('email', $email )->first(); //Auth::user()




            //collect des permissions
        $connected_user_permission = User::with('Permissions')
            ->where('id', $user->id)
            ->get();

        $user_connected_details = [];
        array_push($user_connected_details, $connected_user_permission);
        array_push($user_connected_details, $allpermissions);






        $sideperm = $user_connected_details[1];
        $permissionsFront = [];
        for ($i = 0; $i < count($sideperm); $i++) {
            array_push($permissionsFront, $sideperm[$i]->name);
        }


        // --------------------------------------------------------------------------------------------------------------

        // les liens dans la sidebar du module facture
        $facture = [];
        $devis = [];
        $relance = [];
        $versement = [];
        $taxe = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'facture')) {
                array_push($facture, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'devis')) {
                array_push($devis, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'relance')) {
                array_push($relance, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'versement')) {
                array_push($versement, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'taxe')) {
                array_push($taxe, $permissionsFront[$i]);
            }
        }
        if (count($facture) > 0 || count($devis) > 0 || count($versement) > 0 || count($relance) > 0 || count($taxe) > 0) {
            if (count($facture) > 0) {
                $factureChildren = [
                    'title' => "Facture",
                    'route' => "FactureList",
                    'icon' => "FileTextIcon",
                ];
            }
            if (count($devis) > 0) {
                $devisChildren = [
                    'title' => "Devis",
                    'route' => "",
                    'icon' => "FileMinusIcon",
                ];
            }
            if (count($versement) > 0) {
                $versementChildren = [
                    'title' => "Versement",
                    'route' => "versements",
                    'icon' => "DollarSignIcon",
                ];
            }
            if (count($taxe) > 0) {
                $taxeChildren = [
                    'title' => "Taxe",
                    'route' => "taxes",
                    'icon' => "PaperclipIcon",
                ];
            }
            if (count($relance) > 0) {
                $relanceChildren = [
                    'title' => "Relance",
                    'route' => "relance",
                    'icon' => "RotateCwIcon",
                ];
            }
            $childrenFacturation = [];
            if (isset($factureChildren)) {
                array_push($childrenFacturation, $factureChildren);
            }
            if (isset($devisChildren)) {
                array_push($childrenFacturation, $devisChildren);
            }
            if (isset($taxeChildren)) {
                array_push($childrenFacturation, $taxeChildren);
            }
            if (isset($relanceChildren)) {
                array_push($childrenFacturation, $relanceChildren);
            }
            if (isset($versementChildren)) {
                array_push($childrenFacturation, $versementChildren);
            }
            $facturation = [
                'title' => 'Facturation',
                'icon' => "LayersIcon",
                'children' => $childrenFacturation,
            ];
        }
        //Facturation children
        $childrenFacturation = [];
        if (isset($factureChildren)) {
            array_push($childrenFacturation, $factureChildren);
        }
        if (isset($devisChildren)) {
            array_push($childrenFacturation, $devisChildren);
        }
        if (isset($taxeChildren)) {
            array_push($childrenFacturation, $taxeChildren);
        }
        if (isset($relanceChildren)) {
            array_push($childrenFacturation, $relanceChildren);
        }
        if (isset($versementChildren)) {
            array_push($childrenFacturation, $versementChildren);
        }
        $facturation = [
            'title' => 'Facturation',
            'icon' => "LayersIcon",
            'children' => $childrenFacturation,
        ];

        // --------------------------------------------------------------------------------------------------------------

        //Module Trésorerie liens de la side bar
        $depense = [];
        $transaction = [];
        $compte = [];
        $emprunt = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'depense')) {
                array_push($depense, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'transaction')) {
                array_push($transaction, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'compte')) {
                array_push($compte, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'emprunt')) {
                array_push($emprunt, $permissionsFront[$i]);
            }
        }
        if (count($depense) > 0 || count($transaction) > 0 || count($compte) > 0 || count($emprunt) > 0) {
            if (count($depense) > 0) {
                $depenseChildren = [
                    'title' => "Dépense",
                    'route' => "depenses",
                    'icon' => "CornerLeftUpIcon",
                ];
            }
            if (count($transaction) > 0) {
                $transactionChildren = [
                    'title' => "Transaction",
                    'route' => "",
                    'icon' => "TrendingUpIcon",
                ];
            }
            if (count($compte) > 0) {
                $compteChildren = [
                    'title' => "Compte",
                    'route' => "",
                    'icon' => "LockIcon",
                ];
            }

            $budgetChildren = [
                'title' => "Budget",
                'route' => "",
                'icon' => "LayersIcon",
            ];

            if (count($emprunt) > 0) {
                $empruntChildren = [
                    'title' => "Emprunt",
                    'route' => "emprunt",
                    'icon' => "CornerRightDownIcon",
                ];
            }
        }
        //Trésorrerie Children
        $childrenTresorerie = [];
        if (isset($depenseChildren)) {
            array_push($childrenTresorerie, $depenseChildren);
        }
        if (isset($transactionChildren)) {
            array_push($childrenTresorerie, $transactionChildren);
        }
        if (isset($compteChildren)) {
            array_push($childrenTresorerie, $compteChildren);
        }
        if (isset($budgetChildren)) {
            array_push($childrenTresorerie, $budgetChildren);
        }
        if (isset($empruntChildren)) {
            array_push($childrenTresorerie, $empruntChildren);
        }

        $tresorerie = [
            'title' => 'Trésorerie',
            'icon' => "DollarSignIcon",
            'children' => $childrenTresorerie,
        ];
        // --------------------------------------------------------------------------------------------------------------

        //Module Catalogue liens de la sidebar
        $article = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'article')) {
                array_push($article, $permissionsFront[$i]);
            }
        }

        //Catalogue Children
        if (count($article) > 0) {
            if (count($article) > 0) {
                $articleChildren = [
                    'title' => "Article",
                    'route' => "articles",
                    'icon' => "ShoppingBagIcon",
                ];
            }

            $codepromoChildren = [
                'title' => "Code promo",
                'route' => "",
                'icon' => "TagIcon",
            ];

            $categorieChildren = [
                'title' => "Catégorie d'article",
                'route' => "",
                'icon' => "GridIcon",
            ];

            $packChildren = [
                'title' => "Pack",
                'route' => "",
                'icon' => "CopyIcon",
            ];
        }
        $childrenCatalogue = [];
        if (isset($articleChildren)) {
            array_push($childrenCatalogue, $articleChildren);
        }
        if (isset($codepromoChildren)) {
            array_push($childrenCatalogue, $codepromoChildren);
        }
        if (isset($categorieChildren)) {
            array_push($childrenCatalogue, $categorieChildren);
        }
        if (isset($packChildren)) {
            array_push($childrenCatalogue, $packChildren);
        }

        $catalogue = [
            'title' => 'Catalogue',
            'icon' => "ShoppingBagIcon",
            'children' => $childrenCatalogue,
        ];

        // --------------------------------------------------------------------------------------------------------------

        //Module CRM liens de la sidebar
        $client = [];
        $prospection = [];
        $prospect = [];
        $fournisseur = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'client')) {
                array_push($client, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'prospection')) {
                array_push($prospection, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'prospect')) {
                array_push($prospect, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'fournisseur')) {
                array_push($fournisseur, $permissionsFront[$i]);
            }
        }
        if (count($client) > 0 || count($prospection) > 0 || count($prospect) > 0 || count($fournisseur) > 0) {
            if (count($client) > 0) {
                $clientChildren = [
                    'title' => "Client",
                    'route' => "clients",
                    'icon' => "UserCheckIcon",
                ];
            }
            if (count($prospection) > 0) {
                $prospectionChildren = [
                    'title' => "Prospection",
                    'route' => "prospection",
                    'icon' => "Minimize2Icon",
                ];
            }
            if (count($prospect) > 0) {
                $prospectChildren = [
                    'title' => "Prospect",
                    'route' => "prospect",
                    'icon' => "MehIcon",
                ];
            }
            if (count($fournisseur) > 0) {
                $fournisseurChildren = [
                    'title' => "Fournisseur",
                    'route' => "fournisseurs",
                    'icon' => "TruckIcon",
                ];
            }
        }
        $childrenCRM = [];
        if (isset($clientChildren)) {
            array_push($childrenCRM, $clientChildren);
        }
        if (isset($prospectionChildren)) {
            array_push($childrenCRM, $prospectionChildren);
        }
        if (isset($prospectChildren)) {
            array_push($childrenCRM, $prospectChildren);
        }
        if (isset($fournisseurChildren)) {
            array_push($childrenCRM, $fournisseurChildren);
        }

        $crm = [
            'title' => 'CRM',
            'icon' => "UsersIcon",
            'children' => $childrenCRM,
        ];
        // --------------------------------------------------------------------------------------------------------------
        //Entreprise les liens de la sidebar

            $personnel = [];
            $infopersonnel = [];
            $module = [];
            $historiquefacture = [];
            $departement = [];
            $agence = [];
            $projet = [];

            for ($i = 0; $i < count($permissionsFront); $i++) {
                if (strpos($permissionsFront[$i], 'personnel')) {
                    array_push($personnel, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'infopersonnel')) {
                    array_push($infopersonnel, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'achatmodule')) {
                    array_push($module, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'historiquefacture')) {
                    array_push($historiquefacture, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'departement')) {
                    array_push($departement, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'agence')) {
                    array_push($agence, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'projet')) {
                    array_push($projet, $permissionsFront[$i]);
                }
            }
            if (count($personnel) > 0 || count($infopersonnel) > 0 || count($module) > 0 || count($historiquefacture) > 0  || count($departement) > 0  || count($agence) > 0  || count($projet) > 0) {
                if (count($personnel) > 0) {
                    $personnelChildren = [
                        'title' => "Personnel",
                        'route' => "employes",
                        'icon' => "UserIcon",
                    ];
                }
                if (count($infopersonnel) > 0) {
                    $infopersonnelChildren = [
                        'title' => "Info entreprise",
                        'route' => "",
                        'icon' => "FolderIcon",
                    ];
                }
                if (count($module) > 0) {
                    $moduleChildren = [
                        'title' => "Module",
                        'route' => "",
                        'icon' => "CommandIcon",
                    ];
                }
                if (count($historiquefacture) > 0) {
                    $historiquefactureChildren = [
                        'title' => "Historique des factures",
                        'route' => "",
                        'icon' => "LayersIcon",
                    ];
                }
                if (count($departement) > 0) {
                    $departementChildren = [
                        'title' => "Département",
                        'route' => "",
                        'icon' => "LayoutIcon",
                    ];
                }
                if (count($agence) > 0) {
                    $agenceChildren = [
                        'title' => "Agence",
                        'route' => "",
                        'icon' => "MapIcon",
                    ];
                }
                if (count($projet) > 0) {
                    $projetChildren = [
                        'title' => "Projet",
                        'route' => "",
                        'icon' => "PlusSquareIcon",
                    ];
                }
            }
            $childrenEntreprise = [];
            if (isset($personnelChildren)) {
                array_push($childrenEntreprise, $personnelChildren);
            }
            if (isset($infopersonnelChildren)) {
                array_push($childrenEntreprise, $infopersonnelChildren);
            }
            if (isset($moduleChildren)) {
                array_push($childrenEntreprise, $moduleChildren);
            }
            if (isset($historiquefactureChildren)) {
                array_push($childrenEntreprise, $historiquefactureChildren);
            }
            if (isset($departementChildren)) {
                array_push($childrenEntreprise, $departementChildren);
            }
            if (isset($agenceChildren)) {
                array_push($childrenEntreprise, $agenceChildren);
            }
            if (isset($projetChildren)) {
                array_push($childrenEntreprise, $projetChildren);
            }

            $entreprise = [
                'title' => 'Entreprise',
                'icon' => "BriefcaseIcon",
                'children' => $childrenEntreprise,
            ];
        // --------------------------------------------------------------------------------------------------------------
            //Ediqia liens de la sidebar
            $roles = [];
            $permission = [];
            $modules = [];
            $parametre = [];
            $typeparametre = [];

            for ($i = 0; $i < count($permissionsFront); $i++) {
                if (strpos($permissionsFront[$i], 'role')) {
                    array_push($roles, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'permission')) {
                    array_push($permission, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'module')) {
                    array_push($modules, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'parametre')) {
                    array_push($parametre, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'typeparametre')) {
                    array_push($typeparametre, $permissionsFront[$i]);
                }
            }
            if (count($roles) > 0 || count($permission) > 0 || count($modules) > 0 || count($parametre) > 0 || count($typeparametre) > 0) {
                if (count($roles) > 0) {
                    $rolesChildren = [
                        'title' => "Rôles",
                        'route' => "",
                        'icon' => "FramerIcon",
                    ];
                }
                if (count($permission) > 0) {
                    $permissionChildren = [
                        'title' => "Permissions",
                        'route' => "",
                        'icon' => "KeyIcon",
                    ];
                }
                if (count($modules) > 0) {
                    $modulesChildren = [
                        'title' => "Modules",
                        'route' => "",
                        'icon' => "CommandIcon",
                    ];
                }
                if (count($parametre) > 0) {
                    $parametreChildren = [
                        'title' => "Paramètres",
                        'route' => "",
                        'icon' => "SettingsIcon",
                    ];
                }
                if (count($typeparametre) > 0) {
                    $typeparametreChildren = [
                        'title' => "Type paramètres",
                        'route' => "",
                        'icon' => "ServerIcon",
                    ];
                }
            }
            $childrenEdiqia = [];
            if (isset($rolesChildren)) {
                array_push($childrenEdiqia, $rolesChildren);
            }
            if (isset($permissionChildren)) {
                array_push($childrenEdiqia, $permissionChildren);
            }
            if (isset($modulesChildren)) {
                array_push($childrenEdiqia, $modulesChildren);
            }
            if (isset($parametreChildren)) {
                array_push($childrenEdiqia, $parametreChildren);
            }
            if (isset($typeparametreChildren)) {
                array_push($childrenEdiqia, $typeparametreChildren);
            }

            $ediqia = [
                'title' => 'Ediqia',
                'icon' => "ZapIcon",
                'children' => $childrenEdiqia,
            ];

        // --------------------------------------------------------------------------------------------------------------


        $sidebar = [['title' => 'Tableau de bord', 'route' => "home", 'icon' => "HomeIcon"]];
        array_push($sidebar, $facturation);
        array_push($sidebar, $tresorerie);
        array_push($sidebar, $catalogue);
        array_push($sidebar, $crm);
        array_push($sidebar, $entreprise);
        array_push($sidebar, $ediqia);
        // --------------------------------------------------------------------------------------------------------------


        //end check abonnements

        $token = $user->createToken('monappareil')->plainTextToken;

        // $all_users_with_all_their_roles = User::with('permissions')->where('id',$user->id)->get();
        // // $list=DB::table('nom_permissions')->select('libelle')->get();

        //    for($i=0;$i<count($list);$i++)
        //    {
        //        $list2[$i] =  $list[$i]->libelle;
        //        $permissions[$i] = Permission::where('name','like' ,'%-'.$list2[$i])->get();
        //        //$permission_et_nom[$i] = Arr::add(['permissions'=>$permissions[$i]], 'nom', $list[$i]->libelle);
        //        if(count($permissions)>0){

        //            $factureChildren[$i] = [
        //                'title'=> $list[$i]->libelle,
        //                'route'=> "FactureList", //doit etre dynamic
        //                'icon'=> "FileTextIcon", //doit etre dynamic
        //            ];

        //        }

        //    }

        $response = [
         //   'role' => $role,
            'sidebar' => $sidebar,
            'user_connected_details' => $user_connected_details,
            //$all_users_with_all_their_roles,
            'allpermissions' => $allpermissions,
            'sidebar' => $sidebar,
           // 'entre' => $entreprise_check->id,
            'connected_user_permission' => $connected_user_permission,
            //'user_connecte' => $user_connecte,
           // 'all_users_with_all_their_roles' => $all_users_with_all_their_roles,
           // 'checker' => $checker,
            'user' => $user,
            'token' => $token,
        ];

       // return response(['jojo'=>$response], 201);
        return response()->json($response, 201);
    }
}
