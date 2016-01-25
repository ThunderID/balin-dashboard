{!! HTML::style('plugins/select2/select2.css') !!}
{!! HTML::style('plugins/select2/select2-bootstrap.css') !!}
{!! HTML::script('plugins/select2/select2.min.js') !!}

<script>
	var max_input = {{ isset($max_input) ? $max_input : '0' }};

	$('.select2').select2();

@if($section == "tag")
	$('.select-tag').select2({
		placeholder: 'Masukkan nama kategori',
		minimumInputLength: 3,
		maximumSelectionSize: max_input,
		tags: false,
		ajax: {
			url: "{{ route('ajax.tag.findName') }}",
			dataType: 'json',
			data: function (term, path) {
				return {
					name: term,
					path : '{{ isset($data['path']) ? $data['path'] : '' }}'
				};
			},
		   	results: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							text: item.name,
							id: item.id,
							path: item.path
						}
					})
				};
			},
			query: function (query){
				var data = {results: []};

				$.each(preload_data_tag, function(){
					if(query.term.length == 0 || this.text.toUpperCase().indexOf(query.term.toUpperCase()) >= 0 ){
						data.results.push({id: this.id, text: this.text });
					}
				});
	
				query.callback(data);
			}
		}
	});	
	$('.select-tag').select2('data', preload_data_tag);
@endif

@if($section == "category")
	$('.select-category').select2({
		placeholder: 'Masukkan nama kategori',
		minimumInputLength: 3,
		maximumSelectionSize: max_input,
		tags: false,
		ajax: {
			url: "{{ route('ajax.category.findName') }}",
			dataType: 'json',
			data: function (term, path) {
				return {
					name: term,
					path : '{{ isset($data['category_id']) ? $data['category_id'] : '' }}'
				};
			},
		   results: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							text: item.name,
							id: item.id,
							path: item.path
						}
					})
				};
			},
			query: function (query){
				var data = {results: []};
				 
				$.each(preload_data_category, function(){
					if(query.term.length == 0 || this.text.toUpperCase().indexOf(query.term.toUpperCase()) >= 0 ){
						data.results.push({id: this.id, text: this.text });
					}
				});
	
				query.callback(data);
			}
		}
	});	
	$('.select-category').select2('data', preload_data_category);
@endif

@if($section == "label")
	$('.select-label').select2({
		placeholder: 'Masukkan nama label',
		minimumInputLength: 3,
		maximumSelectionSize: max_input,
		tags: false,
		ajax: {
			url: "{{ route('ajax.label.findName') }}",
			dataType: 'json',
			data: function (term, path) {
				return {
					name: term,
					path : '{{ isset($data['path']) ? $data['path'] : '' }}'
				};
			},
		   results: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							text: item.name,
							id: item.id,
							path: item.path
						}
					})
				};
			},
			query: function (query){
				var data = {results: []};
				 
				$.each(preload_data_label, function(){
					if(query.term.length == 0 || this.text.toUpperCase().indexOf(query.term.toUpperCase()) >= 0 ){
						data.results.push({id: this.id, text: this.text });
					}
				});
	
				query.callback(data);
			}
		}
	});	
	$('.select-label').select2('data', preload_data_label);
@endif

@if($section == "product")
	$('.select-product').select2({
		placeholder: 'Masukkan nama product',
		minimumInputLength: 3,
		maximumSelectionSize: max_input,
		tags: false,
		ajax: {
			url: "{{ route('ajax.product.findName') }}",
			dataType: 'json',
			data: function (term, path) {
				return {
					name: term,
					path : '{{ isset($data['path']) ? $data['path'] : '' }}'
				};
			},
		   results: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							text: item.name,
							id: item.id,
							path: item.path
						}
					})
				};
			},
			query: function (query){
				var data = {results: []};
				 
				$.each(preload_data, function(){
					if(query.term.length == 0 || this.text.toUpperCase().indexOf(query.term.toUpperCase()) >= 0 ){
						data.results.push({id: this.id, text: this.text });
					}
				});
	
				query.callback(data);
			}
		}
	});	
@endif

@if($section == "customer")
	$('.select-customer').select2({
		placeholder: 'Masukkan nama kostumer',
		minimumInputLength: 3,
		maximumSelectionSize: max_input,
		tags: false,
		ajax: {
			url: "{{ route('ajax.customer.findName') }}",
			dataType: 'json',
			data: function (term, path) {
				return {
					name: term,
					path : '{{ isset($data['customer_id']) ? $data['customer_id'] : '' }}'
				};
			},
		   results: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							text: item.name,
							id: item.id,
							path: item.path
						}
					})
				};
			},
			query: function (query){
				var data = {results: []};
				 
				$.each(preload_data_customer, function(){
					if(query.term.length == 0 || this.text.toUpperCase().indexOf(query.term.toUpperCase()) >= 0 ){
						data.results.push({id: this.id, text: this.text });
					}
				});
	
				query.callback(data);
			}
		}
	});	
	$('.select-customer').select2('data', preload_data_customer);
@endif

</script>