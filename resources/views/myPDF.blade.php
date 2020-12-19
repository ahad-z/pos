<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>DH</title>
		<link rel="stylesheet" href="{{ asset('/css/stylesheet.css') }}"/>
    	<link rel="stylesheet" href="{{ asset('/css/b.css') }}"/>
	</head>
	<body>
		<div class="container-fluid invoice-container">
		<header>
			<div class="row align-items-center">
				<div class="col-sm-7 text-center text-sm-left mb-3 mb-sm-0">
					<img id="logo" style="width: 150px; height: 150px;" src="{{asset('/uploads/logo_img/hardwaresuperstore-logo.jpg') }}" title="Koice" alt="DH" />
				</div>
				<div class="col-sm-5 text-center text-sm-right">
					<h4 class="text-7 mb-0">Invoice</h4>
				</div>
			</div>
			<hr>
		</header>
		
		<main>
			<div class="row">
				<div class="col-sm-6"><strong>Date:</strong> {{ date('Y-m-d') }}</div>
				<div class="col-sm-6 text-sm-right"> <strong>Invoice No:</strong> {{ $order->invoice_number }}</div>
				
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-6 text-sm-right order-sm-1"> <strong>Pay To:</strong>
					@if($order->customer)
					<address>
						{{ $order->customer->cust_name}}<br />
						{{ $order->customer->cust_phone}}<br />	
						{{ $order->customer->cust_address}}
					</address>
					@else
					<address>
						Walk-in-Customer
					</address>
					@endif
				</div>
				<div class="col-sm-6 order-sm-0"> <strong>Invoiced To:</strong>
					<address>
						Md.Mohouddin Dewan<br />
						Chowrastta Bazar<br />
						Shop #102<br />
						Bagadi
					</address>
				</div>
			</div>
			<div class="card">
				<div class="card-header">
					<h5 class="text-center" style="color: red">Don't Lose your Invoice. It Will need in future</h5>
				</div>
				<div class="card-body  px-2">
					<table class="table">
						<thead>
							<tr style="width: 100px">
								<th scope="col">#</th>
								<th scope="col">Product Name</th>
								<th scope="col">Unit</th>
								<th scope="col">Selling price</th>
								<th scope="col">Qty</th>
								<th scope="col">Dis-Type</th>
								<th scope="col">Dis-Amount</th>
								<th scope="col">Amount</th>
							</tr>
						</thead>
						<tbody>
							@foreach($order->orderDetails as $orderDetail)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{$orderDetail->product->product_name }}</td>
								<td>{{$orderDetail->product->units->unit }}</td>
								<td>{{$orderDetail->product->selling_price }}</td>
								<td>{{$orderDetail->qty }}</td>
								<td>{{ $orderDetail->discount_type == '%' ? 'percent':'cash' }}</td>
								<td>{{$orderDetail->discount_amount }}</td>
								<td>{{$orderDetail->product_subtotal }}</td>
							</tr>
							@endforeach
							<tr>
								<td colspan="7" class="bg-light-2 text-right"><strong>Sub Total : </strong></td>
								<td class="bg-light-2 text-right">{{ $order->sub_total  }}</td>
							</tr>
							<tr>
								<td colspan="7" class="bg-light-2 text-right"><strong>Discoutn Type : </strong><strong> {{ ucfirst($discount_type) }}</strong></td>
								<td class="bg-light-2 text-right">{{$order->discount_amount}}</td>
							</tr>
							<tr>
								<td colspan="7" class="bg-light-2 text-right"><strong>Total : </strong></td>
								<td class="bg-light-2 text-right">{{ $order->total }}</td>
							</tr>
							@foreach($order->payments as $payment)
							<tr>
								<td>Date:</td>
								<td colspan="3">{{ $payment->created_at->format('d/m/Y')  }}</td>
								<td colspan="3" class="bg-light-2 text-right"><strong>Paid : </strong></td>
								<td class="bg-light-2 text-right">{{ $payment->amount }}</td>
							</tr>
							@endforeach
							<tr>
								<td colspan="7" class="bg-light-2 text-right">
									<strong  class="badge {{ ( $order->status == 'due' ? 'badge-danger' : ( $order->status == 'return' ? 'badge-success' : 'badge-info')) }}">
										{{ ( $order->status == 'due' ? 'Due' : ( $order->status == 'return' ? 'Return' : 'Paid'))}}
							      </strong>
						      </td>
								<td class="bg-light-2 text-right">{{ $order->due ? $order->due : 'Yeas'  }}</td>
							</tr>
							
						</tbody>
					</table>
				</div>
			</div>
		</main>
		<footer class="text-center mt-4">
			<p class="text-1"><strong>NOTE :</strong> This is computer generated receipt and does not require physical signature.</p>
			<div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print</a> <a href="" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-download"></i> Download</a> </div>
		</footer>
	</div>
	</body>
	<script type="text/javascript">
		// window.print()
	</script>
</html>
