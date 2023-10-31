<ul>
	<li>{{ _lang('Sub Total') }}<span>{!! xss_clean(show_price(\Cart::getSubTotal())) !!}</span></li>
	<!--<li>(+) Shipping<span>$10.00</span></li>-->
	@foreach(Cart::getConditions() as $condition)
	<li>
		@if($condition->getType() == 'shipping')
			{{ _lang('Shipping').' ('.$condition->getName().')' }}
		@else
			{{ $condition->getName() }}
		@endif
		<span>
			@if($condition->getType() == 'shipping')
				+ {!! xss_clean(show_price(str_replace(array("+","-"),"",$condition->getValue()))) !!}
			@elseif($condition->getType() == 'coupon')
				- {!! xss_clean(show_price(str_replace(array("+","-"),"",$condition->getValue()))) !!}
			@elseif($condition->getType() == 'tax')
				+ {!! xss_clean(show_price(str_replace(array("+","-"),"",$condition->getValue()))) !!}				
			@endif
		</span>

		@if($condition->getType() == 'coupon')
			<a href="{{ url('/remove_coupon/'.$condition->getName()) }}">
				<small class="text-danger">{{ _lang('Remove') }}</small>
			</a>
		@endif
	</li>
	@endforeach
	<li class="last">{{ _lang('Total') }}<span>{!! xss_clean(show_price(\Cart::getTotal())) !!}</span></li>
</ul>