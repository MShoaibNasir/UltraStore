(function($) {
    "use strict";

    window.onload = function() {

		var link = _url + "/dashboard/weekly_sales_widget";
	    $.ajax({
	        url: link, 
			success: function (data) {
				var json = JSON.parse(data);

	            var barChartData = {
					labels: $days,
					datasets: [{
						label: $lang_sales,
						backgroundColor: 'rgba(77, 77, 253, .5)',
						data: [
							typeof json[$days[0]] !== "undefined" ? json[$days[0]]['amount'] : 0, 
							typeof json[$days[1]] !== "undefined" ? json[$days[1]]['amount'] : 0, 
							typeof json[$days[2]] !== "undefined" ? json[$days[2]]['amount'] : 0, 
							typeof json[$days[3]] !== "undefined" ? json[$days[3]]['amount'] : 0, 
							typeof json[$days[4]] !== "undefined" ? json[$days[4]]['amount'] : 0, 
							typeof json[$days[5]] !== "undefined" ? json[$days[5]]['amount'] : 0, 
							typeof json[$days[6]] !== "undefined" ? json[$days[6]]['amount'] : 0, 

						]
					}, {
						label: $lang_order,
						backgroundColor: 'rgba(29, 209, 161, .5)',
						data: [
							typeof json[$days[0]] !== "undefined" ? json[$days[0]]['order_count'] : 0, 
							typeof json[$days[1]] !== "undefined" ? json[$days[1]]['order_count'] : 0, 
							typeof json[$days[2]] !== "undefined" ? json[$days[2]]['order_count'] : 0, 
							typeof json[$days[3]] !== "undefined" ? json[$days[3]]['order_count'] : 0, 
							typeof json[$days[4]] !== "undefined" ? json[$days[4]]['order_count'] : 0, 
							typeof json[$days[5]] !== "undefined" ? json[$days[5]]['order_count'] : 0, 
							typeof json[$days[6]] !== "undefined" ? json[$days[6]]['order_count'] : 0, 
						]
					}]

				};

				
				var ctx = document.getElementById('weekly_sales').getContext('2d');
				window.myBar = new Chart(ctx, {
					type: 'bar',
					data: barChartData,
					options: {
						title: {
							display: false,
							text: 'Weekly Sales Report'
						},
						legend: {
				            display: false,
				        },
						tooltips: {
							mode: 'index',
							intersect: false
						},
						responsive: true,
						scales: {
							xAxes: [{
								stacked: true,
							}],
							yAxes: [{
								stacked: true
							}]
						}
					}
				});
			

	        }
	    });
	};

})(jQuery);	

