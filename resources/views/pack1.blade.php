@extends('base')

@section('accueil')
<section class="slice slice-lg bg-lavande" data-offset-top="#header-main">
    <div class="container pt-5 pt-xl-6 pb-xl-5 mb-4">
      <div class="row row-grid align-items-center">
        <div class="col-lg-5">
          <h5 class="h1">Simple d'accès et riche en fonctionnalités.</h5>
          <p class="lead my-4">Lorsque vous achetez, vous obtenez un pack de gestion haute qualité pour commencer à gérer votre entreprise facilement.</p>
          <small class="text-indigo">Essayez gratuitement pendant 14 jours, aucune carte de crédit requise.</small>
          <div class="mt-5">
            {{-- <a href="#" class="btn btn-primary rounded-pill hover-translate-y-n3 mr-lg-4"></a> --}}
            <button type="button" class="btn btn-soft-indigo mr-lg-4">
                Commencer
            </button>
          </div>
        </div>
        <div class="col-xl-6 col-lg-7 offset-xl-1">
          <div class="row">
            <div class="col-sm-6">
              <div class="card card-pricing border-md border-jaune text-center scale-110 popular bg-indigo">
                <span class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-jaune-ambre text-white">Premium</span>
                <div class="card-header py-5 border-0">
                  <div class="h1 text-lavande text-center mb-0" data-pricing-value="396">
                      <span class="price">25.000<span class="h5 ml-1 mr-1 text-lavande">XOF</span></span><span class="h6 m-0 text-jaune-ambre">/ mois</span></div>
                </div>
                <div class="card-body delimiter-top text-lavande">
                  <ul class="list-unstyled mb-4">
                    <li>- Gestion d'utilisateurs -</li>
                    <li>- Création de relances -</li>
                    <li>- Crétaion de factures -</li>
                    <li>- Création de Devis -</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="card card-pricing text-center bg-indigo">
                <span class="h6 w-60 mx-auto px-4 py-1 rounded-bottom bg-jaune-ambre text-lavande">Gratuit</span>
                <div class="card-header py-5 border-0">
                  <div class="h1 text-lavande text-center mb-0" data-pricing-value="196"><span class="price ">14</span><span class="h6 ml-2 text-jaune-ambre">Jours</span></div>
                </div>
                <div class="card-body delimiter-top text-lavande">
                  <ul class="list-unstyled mb-4">
                    <li>- Gestion d'utilisateurs -</li>
                    <li>- Gestion de relances -</li>
                    <li>- Gestion de factures -</li>
                    <li>- Création de Devis -</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
<h1 class="text-indigo text-center pb-2">Comparaison</h1>
<section class="bg-lavande">
    <div class="container">
        <div class="row">
            <div class="table-responsive">
                <table class="table mt-2">
                    <thead>
                    <tr>
                        <th class="px-0 bg-transparent" scope="col"><span class="text-muted font-weight-700">Fonctionnalités</span></th>
                        <th class="text-center bg-transparent" scope="col"><span>Plan Premium</span></th>
                        <th class="text-center bg-transparent" scope="col"><span>Plan Gratuit</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="px-0">Créer des factures</td>
                        <td class="text-center"><i class="fas fa-check text-indigo"></i></td>
                        <td class="text-center"><i class="fas fa-check text-jaune-ambre"></i></td>
                    </tr>
                    <tr>
                        <td class="px-0">Établir des relances</td>
                        <td class="text-center"><i class="fas fa-check text-indigo"></i></td>
                        <td class="text-center"><i class="fas fa-check text-jaune-ambre"></i></td>
                    </tr>
                    <tr>
                        <td class="px-0">Créer des Devis</td>
                        <td class="text-center"><i class="fas fa-check text-indigo"></i></td>
                        <td class="text-center"><i class="fas fa-check text-jaune-ambre"></i></td>
                    </tr>
                    <tr>
                        <td class="px-0">Créer de multiples utilisateurs</td>
                        <td class="text-center"><i class="fas fa-check text-indigo"></i></td>
                        <td class="text-center"><i class="fas fa-check text-jaune-ambre"></i></td>
                    </tr>
                    <tr>
                        <td class="px-0">Gestion de catalogues</td>
                        <td class="text-center"><i class="fas fa-check text-indigo"></i></td>
                        <td class="text-center"><i class="fas fa-check text-jaune-ambre"></i></td>
                    </tr>
                    <tr>
                        <td class="px-0">Gestion des clients</td>
                        <td class="text-center"><i class="fas fa-check text-indigo"></i></td>
                        <td class="text-center"><i class="fas fa-check text-jaune-ambre"></i></td>
                    </tr>
                    <tr>
                        <td class="px-0">Abonnement mensuel</td>
                        <td class="text-center"><i class="fas fa-check text-indigo"></i></td>
                        <td class="text-center"><small class="text-muted">Gratuit pendant 14 jours</small></td>
                    </tr>
                    <tr>
                        <td class="px-0">Gestion de trésorerie</td>
                        <td class="text-center"><i class="fas fa-check text-indigo"></i></td>
                        <td class="text-center"><i class="fas fa-check text-jaune-ambre"></i></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
