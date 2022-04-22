<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Facture</title>

    <style type="text/css">

    body{
           font-family: Arial, Helvetica, sans-serif;
           background-color: #eceff1;
        },
       
        #customers{
          font-family: Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }

        #customers td, #customers th {
          border: 1px solid #ddd;
          padding: 8px;
           border-collapse: collapse;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: center;
          background-color: #eceff1;
          color: black;
        },

        p{
            margin-bottom: 0px;
        }

    </style>
</head>
    <body>

    <div style="width: 70%; background-color:white;margin-right:auto ;margin-left: auto;padding-right: 5%;padding-left: 5%; padding-top:3%;padding-bottom: 5%; margin-top: 50px;  margin-bottom: 50px;">
            
        <!-- <h2 style="text-align: center;">FACTURE</h2> -->

    <!-- logo -->
        <div> <img src="{{$entreprise->getFirstMediaUrl('image')}}"></div>

    <!-- info entreprise -->   
        <div style="float:right;  padding-left: 5px;padding-right: 5px;">
            <p><b>{{ $entreprise->libelle }}</b> <br>
            Tel:{{ $entreprise->contact }} <br>
            Email:{{ $entreprise->email }}</p>
        </div><br><br><br>

    <!-- info facture -->  
        @foreach ($detail_facture as $item)
      <div style="background-color: #eceff1; float: left; width: 100%; margin-bottom:15px" >
          <p style="padding-right:5px; padding-left:5px;"><span><b>FACTURE</b> #{{ $item->code}}</span><br>
            Date de facturation: {{ $item->date_emission}}<br>
            Date d'écheance: {{ $item->date_echeance}}
          </p>
      </div>
    @endforeach

    <!--  info du client -->
    <div style="">
        <p><b>Facturé à</b><br>
             {{ $client->nom }} <br>
             {{ $client->contact }} <br>
             {{ $client->email }}
        </p>
    </div>

       <!-- table detail facture -->
 
        <div>
            <table id="customers" border="0" style="width:100%; text-align: center;border-collapse: collapse;">
                <thead>
                    <th>#</th>
                    <th>Description</th>
                    <th>Qté</th>
                    <th>Montant</th>
                </thead>
                     @foreach ($detail_art as $key=>$item)
                  <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{$item->libelle}}</td>
                    <td>{{$item->quantite}}</td>
                    <td>{{number_format($item->prix,2,',', '.')}}</td>
                </tr>
                  @endforeach
            </table>
         </div>
            <div style="float:right; margin-bottom: 10px; margin-top: 10px;">
                <table border="0" id="customers">
                  @foreach ($detail_facture as $item)
                    <tr>
                      <td><b>Montant HT</b>:</td>
                      <td>{{ number_format($item->total_ht,2,',', '.')}} FCFA</td>
                    </tr>
                    @if ($item->total_taxe)
                    <tr>
                      <td><b>{{ $item->total_taxe}}% Taxe:</b></td>
                      <td> {{number_format($taxe = ($item->total_taxe/100)*$item->total_ht,2,',', '.') }} FCFA</td>
                    </tr>
                    @endif


                    @if ($item->remise)
                    <tr>
                      <td><b>{{ $item->remise}}% Remise:</b></td>
                       <td>{{number_format($remise= ($item->remise/100)*$item->total_ht,2,',', '.') }} FCFA</td>
                    </tr>
                    @endif
                    
                      <tr>
                      <td><b>Montant TTC</b>:</td>
                       <td>{{ number_format($item->total_ttc,2,',', '.')}} FCFA</td>
                    </tr>
                    @endforeach
                </table>
            </div>


           <!--  Note -->
           @foreach ($detail_facture as $item)
            <div style="width: 100%; margin-top: 30%; text-align:center;">
                <p><b>Note:</b><span>{{ $item->description}}.</span></p>
            </div>
            @endforeach
 

    </div>
          
    </body>
</html>