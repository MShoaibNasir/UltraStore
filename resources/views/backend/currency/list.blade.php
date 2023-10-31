@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="alert alert-warning">
			<strong>{{ _lang('Do not change base currecny once you made any transactions otherwise your calculation will be wrong !') }}</strong>
		</div>
		
		<div class="alert alert-info">
			<strong>{{ _lang('Base currency exchange rate will be always 1.00') }}</strong>
		</div>
		
		<div class="card no-export">
		    <div class="card-header d-flex align-items-center">
				<span class="panel-title">{{ _lang('Currency List') }}</span>
				<a class="btn btn-primary btn-xs ml-auto ajax-modal" data-title="{{ _lang('Add Currency') }}" href="{{ route('currency.create') }}">{{ _lang('Add New') }}</a>
			</div>
			<div class="card-body">
				<table id="currency_table" class="table table-bordered data-table">
					<thead>
					    <tr>
						    <th>{{ _lang('Name') }}</th>
							<th>{{ _lang('Base Currency') }}</th>
							<th>{{ _lang('Exchange Rate') }}</th>
							<th>{{ _lang('Status') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
					    </tr>
					</thead>
					<tbody>
					    @foreach($currencys as $currency)
					    <tr data-id="row_{{ $currency->id }}">
							<td class='name'>{{ $currency->name }}</td>
							<td class='base_currency'>{{ $currency->base_currency == 1 ? _lang('Yes') : _lang('No') }}</td>
							<td class='exchange_rate'>{{ $currency->exchange_rate }}</td>
							<td class='status'>{{ $currency->status == 1 ? _lang('Active') : _lang('InActive') }}</td>
							
							<td class="text-center">
								<div class="dropdown">
								  <button class="btn btn-light dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  {{ _lang('Action') }}
								  <i class="fas fa-angle-down"></i>
								  </button>
								  <form action="{{ action('CurrencyController@destroy', $currency['id']) }}" method="post">
									{{ csrf_field() }}
									<input name="_method" type="hidden" value="DELETE">
									
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<a href="{{ action('CurrencyController@edit', $currency['id']) }}" data-title="{{ _lang('Update Currency') }}" class="dropdown-item dropdown-edit ajax-modal"><i class="mdi mdi-pencil"></i> {{ _lang('Edit') }}</a>
										<a href="{{ action('CurrencyController@show', $currency['id']) }}" data-title="{{ _lang('View Currency') }}" class="dropdown-item dropdown-view ajax-modal"><i class="mdi mdi-eye"></i> {{ _lang('View') }}</a>
										<button class="btn-remove dropdown-item" type="submit"><i class="mdi mdi-delete"></i> {{ _lang('Delete') }}</button>
									</div>
								  </form>
								</div>
							</td>
					    </tr>
					    @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection