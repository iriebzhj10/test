<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>A simple, clean, and responsive HTML invoice template</title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
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

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
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
				text-align: left;
			}

      .haut p{
        display: inline-block;
        margin-right:20px;
        /* position: absolute; */
      }

      .container  {
  display: flex;
  align-items: space-between;
  justify-content: space-between;
  padding: 10px;
}
.item {
  margin:20px
}
     
		</style>
	</head>

	<body>
		<div class="invoice-box">

      <div class="container">
        <div class="item">
          <img src="{{$entreprise->getFirstMediaUrl('image')}}">
        </div>
      
      <div class="item">
        Facture N°:  {{ $details_facture->code}}<br />
        Date emision: {{ $details_facture->date_emission}}<br/>
        Date echeance: {{ $details_facture->date_echeance}}
      </div>
      </div>

     

      <div class="container">
        <div class="item">
          {{$entreprise->getFirstMediaUrl('image')}}
          {{ $entreprise->libelle }}<br />
          {{ $entreprise->email }}<br />
          {{ $entreprise->contact }}
        </div>
        <div class="item">
          {{ $client->nom }}<br />
          {{ $client->contact }}<br />
          {{ $client->email }}
        </div>
      </div>
    
			<table cellpadding="0" cellspacing="0">
				{{-- <tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									<img src="https://www.sparksuite.com/images/logo.png" style="width: 100%; max-width: 300px" />
								</td>

								<td style="text-align: right">
									Invoice #:  {{ $details_facture->code}}<br />
                  Date emision: {{ $details_facture->date_emission}}<br/>
                  Date echeance: {{ $details_facture->date_echeance}}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td style="text-align: left">
									{{ $entreprise->libelle }}<br />
                  {{ $entreprise->email }}<br />
									{{ $entreprise->contact }}
								</td>

								<td style="text-align: right">
									{{ $client->nom }}<br />
									{{ $client->contact }}<br />
									{{ $client->email }}
								</td>
							</tr>
						</table>
					</td>
				</tr> --}}

				{{-- <tr class="heading">
					<td>Payment Method</td>

					<td>Check #</td>
				</tr> --}}

				{{-- <tr class="details">
					<td>Check</td>

					<td>1000</td>
				</tr> --}}

				<tr class="heading">
          <td>N°</td>
					<td>Libelle</td>
          <td>Qte</td>
					<td>Prix</td>
				</tr>
      @foreach ($detail_art as $key=>$item)  
				<tr class="item">
          <td>{{ ++$key }}</td>
					<td>{{$item->libelle}}</td>
          <td>{{$item->quantite}}</td>
          <td>{{$item->prix}}</td>
				</tr>
        @endforeach 
			
        {{-- <div style="border:1px solid black"> --}}
          <tr class="total">
            @foreach ($total_ht as $item)
            <td></td>
            <td></td>
            <td></td>
            <td><strong>Total HT: {{ $item->total_ht}} FCFA</strong></td>
            @endforeach
          </tr>
          <tr class="total">
            @foreach ($total_taxe as $item)
            <td></td>
            <td></td>
            <td></td>
            <td><strong>Taxes: {{ $item->total_taxe}} %</strong></td>
            @endforeach
          </tr>
          <tr class="total">
            @foreach ($total_ttc as $item)
            <td></td>
            <td></td>
            <td></td>
            <td><strong>Total TTC: {{ $item->total_ttc}} FCFA</strong></td>
            @endforeach
          </tr>
        {{-- </div> --}}
			</table>
      <div>
        <p style="text-align: center">{{ $details_facture->description}}</p>
      </div>
		</div>
	</body>
</html>