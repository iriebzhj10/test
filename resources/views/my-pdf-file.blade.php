<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">

  {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
<style>
  @import url('https://fonts.googleapis.com/css2?family=Maven+Pro&display=swap');

body {
    font-family: 'Maven Pro', sans-serif;
    background-color: #cfcfcf
}

hr {
    color: #0000004f;
    margin-top: 5px;
    margin-bottom: 5px
}

.add td {
    color: #292828;
    text-transform: uppercase;
    font-weight: bold;
    font-size: 12px
}

.content {
    font-size: 14px
}
</style>

</head>


<body>
  <div class="container mt-5 mb-3">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="d-flex flex-row p-2"> <img src="https://i.imgur.com/vzlPPh3.png" width="48">
                    <div class="d-flex flex-column"> <span class="font-weight-bold">
                        
                       @if ($type_facture[0]->type_facture_id==0)
                           Devis
                           @elseif($type_facture[0]->type_facture_id==1)
                               Facture
                       @endif
                      
                        </span> <small>N°:{{ $details_facture->code}}</small> </div>
                </div>
                <hr>
                <div class="table-responsive p-2">
                    <table class="table table-borderless">
                        <tbody>
                            <tr class="add">
                                <td>De</td>
                                <td>A</td>
                            </tr>
                            <tr class="content">
                                <td class="font-weight-bold"> <br>Nom: {{ $entreprise->libelle }} <br> Contact: {{ $entreprise->contact }}<br> Email: {{ $entreprise->email }}</td>
                                <td class="font-weight-bold"> Nom:{{ $client->nom }}<br> Contact: {{ $client->contact }}<br> Email: {{ $client->email }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="products p-2">
                    <table class="table table-borderless">
                        <tbody>
                            <tr class="add">
                                <td>N°</td>
                                <td>Libelle</td>
                                <td>Qté</td>
                                <td>Prix</td>
                                <td class="text-center">Total</td>
                            </tr>
                            
                          

                           
                            @foreach ($detail_art as $key=>$item)
                          
                            <tr class="content">
                              <td>{{ ++$key }}</td>
                                <td>{{$item->libelle}}</td>
                                <td>{{ $item->quantite }}</td>
                                <td>{{ $item->prix }} FCFA</td>
                          </tr>
                          @endforeach 
                         
                            {{-- @foreach ($detail_articles as $item)
                           
                                <td>{{ $item->quantite }}</td>
                        
                                 
                              @endforeach  --}}
                      
                            {{-- <tr class="content">
                              <td>Website Redesign</td>
                              <td>15</td>
                              <td>$1,500</td>
                              <td>$1,500</td>
                              <td class="text-center">$22,500</td>
                          </tr> --}}

                          
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="products p-2">
                    <table class="table table-borderless">
                        <tbody>
                            <tr class="add">
                                <td></td>
                                <td>Total</td>
                                <td>Remise(%)</td>
                                <td class="text-center">Total TTC</td>
                            </tr>
                            <tr class="content">
                                <td></td>
                                <td>2%</td>
                                @foreach ($total_ttc as $item)
                                <td class="text-center">{{ $item->total_ttc }} FCFA</td>
                                @endforeach

                                @foreach ($total_ht as $item)
                                <td class="text-center">{{ $item->total_ht}} FCFA</td>
                                @endforeach
                               
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                {{-- <div class="address p-2">
                    <table class="table table-borderless">
                        <tbody>
                            <tr class="add">
                                <td>Bank Details</td>
                            </tr>
                            <tr class="content">
                                <td> Bank Name : ADS BANK <br> Swift Code : ADS1234Q <br> Account Holder : Jelly Pepper <br> Account Number : 5454542WQR <br> </td>
                            </tr>
                        </tbody>
                    </table>
                </div> --}}
            </div>
        </div>
    </div>
</div>
</body>
</html>