<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Facture</title>

		<style>
          
@font-face {
    font-family: 'montserratblack';
    src: url('fonts/montserrat-black-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}
            body{
                font-family: 'montserratblack';
				color: #555;
            }
			.invoice-box {
				/* max-width: 800px; */
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				/* font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; */
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				/* text-align: center; */
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			/*.invoice-box table tr td:nth-child(2) {
				text-align: center;
			}
*/
			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 25px;
				line-height: 45px;
				color: #333;
				float: left;
			}
            

			.invoice-box table tr.top table td.invoice-info {
				
/*				line-height: 45px;
*/				float: right;
			}

			.invoice-box table tr table td.info-client {
				
/*				line-height: 45px;
*/				float: right;
			}

				.invoice-box table tr table td.info-entreprise {
				
/*				line-height: 45px;
*/				float: left;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(4) {
				border-top: 2px solid #eee;
				font-weight: bold;
				text-align: center;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
/*				text-align: left;
*/			}

.logo{
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    .logo img{
        display: table;
        position: relative;
        margin: auto;
   }
	.logo img {
filter: sepia(1);
-webkit-filter: sepia(1);
}
.logo img:hover {
filter: sepia(0);
-webkit-filter: sepia(0);
}
		</style>
	</head>

	<body>
		 <!-- info entete facture -->  
		<div style="margin-bottom: 20%">
			<div style="float: :left"> <img src="{{$entreprise->getFirstMediaUrl('logo')}}"style="width: 70%; max-width: 100px"></div>
			<div style="float:right;  padding-left: 5px;padding-right: 5px;">
               

				@foreach ($detail_facture as $item)
			@if ($item->status=='devis')
			<div>
				<p><span><b>DEVIS</b> n<sup>0</sup> {{ $item->code}}</span><br>
				  Date d'??mission {{ $item->date_emission}}<br>
				  {{-- Date d'??cheance: {{ $item->date_echeance}} --}}
				</p>
			</div>
			@else
			<div>
				<p><span><b>FACTURE</b> n<sup>0</sup> {{ $item->code}}</span><br>
				  Date de facturation: {{ $item->date_emission}}<br>
				  Date d'??cheance: {{ $item->date_echeance}}
				</p>
			</div>
			@endif
         
        @endforeach
            </div>
		</div>

		{{-- objet --}}
    @if ($item->libelle)
		<div style="">
<h4>Objet: {{ $item->libelle }} </h4>
</div>
	@endif


        <!--  info du client -->
		<div style="margin-bottom: 25%">
			 <div style="float:left">
            <p>
				@if ($item->status=='devis')
				Devis ??
			@else
			Factur?? ??:
			@endif
				<br><br>
			<b>	Mr/Mme: {{ $client->nom }}</b> <br>
                 Tel: {{ $client->contact }} <br>
                 Email: {{ $client->email }}
            </p>
        </div>

 <!-- info entreprise -->   
		<div style="float: right">
 		<p>
			 Entreprise:
			 <br><br>
			 <b>Nom: {{ $entreprise->libelle }}</b> <br>
                Tel: {{ $entreprise->contact }} <br>
                Email: {{ $entreprise->email }}</p>
		</div>
		</div>
       

 {{-- Detail de la facture --}}
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="heading">
					<td>#</td>
					<td>Libelle</td>
					<td>Qt??</td>
					<td>Prix</td>
				</tr>
                @foreach ($detail_art as $key=>$item)
				<tr class="item">
                    <td>{{ ++$key }}</td>
                    <td>{{$item->libelle}}</td>
                    <td>{{$item->quantite}}</td>
                    <td>{{number_format($item->prix,2,',', '.')}}</td>
				</tr>
                @endforeach

                @foreach ($detail_facture as $item)
				
				<tr class="total">
					<td colspan="3" style="text-align: right; font-weight:bold">Total HT:</td>
                    <td style="font-weight:bold;text-align:left">{{ number_format($item->total_ht,2,',', '.')}} {{ $devise }}</td>
				</tr>
				<tr class="total">
					<td colspan="3" style="text-align: right; font-weight:bold">Taxe:</td>
                    @if ($item->total_taxe)
                      {{-- <td style="font-weight:bold; text-align:left">{{ $item->total_taxe}} % : {{number_format($taxe = ($item->total_taxe/100)*$item->total_ht,2,',', '.') }} {{ $devise }}</td> --}}
					  <td style="font-weight:bold; text-align:left">{{ $item->total_taxe}} % </td>

					  @else
				   <td>0 %</td>
					  @endif
				</tr>
				<tr class="total">
					<td colspan="3" style="text-align: right; font-weight:bold">Remise:</td>
                    @if ($item->remise)
                       {{-- <td style="font-weight:bold;text-align:left">{{ $item->remise}} % : {{number_format($remise= ($item->remise/100)*$item->total_ht,2,',', '.') }} {{ $devise }}</td> --}}
					   <td style="font-weight:bold;text-align:left">{{ $item->remise}} % </td>

					   @else
				   <td> 0 %</td>
					   @endif
				</tr>
                <tr class="total">
					<td colspan="3" style="text-align: right; font-weight:bold">Total TTC:</td>
                    <td style="font-weight:bold;text-align:left">{{ number_format($item->total_ttc,2,',', '.')}} {{ $devise }}</td>
				</tr>
                @endforeach
			</table>
             <!--  Note -->
           @foreach ($detail_facture as $item)
           <div style="width: 100%; margin-top: 10%; text-align:center;">
               <p><b>Note:</b><span>{{ $item->description}}.</span></p>
           </div>
           @endforeach
		</div>
		<div class="logo">
				<a href="https://ediqia.com" title="logo" target="_blank">
				  <img width="60" style=" filter: grayscale(10); "  src="{{ asset('images/logo.png') }}" title="logo" alt="logo">
				</a>
		</div>
	</body>
</html>