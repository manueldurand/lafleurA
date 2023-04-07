$(function() {
	var $dom = $('.keole-datatable');

	$dom.each(function() {
		var $this = $(this);
		var table = $(this)
			.initDataTables(
				$(this).data('settings'),
				{
					responsive: true,
					searching: true,
					initComplete: function (settings, json) {
						var _this = this;

						// Move search bar to a new DOM if provided
						var $dtSearchPlace = $(".datatable-search-place[data-datatable='" + $this.data('datatable') + "']");

						if ($dtSearchPlace.length > 0) {
							// Move search input in card header
							$(".dataTables_filter").addClass("d-none");
							$(".dataTables_filter input").removeClass("form-control-sm")
							$(".dataTables_filter input").addClass("w-250px ps-12")
							$(".dataTables_filter input").appendTo($dtSearchPlace).attr({placeholder: "Rechercher"});
							$('.datatable-search-place').addClass("d-flex")
							$('.datatable-search-place').removeClass("d-none")
						}

						$(".datatable-filter").each(function() {
							if ($(this).val() !== "") {
								// Trigger change
								$(this).trigger("change");
							}
						});
					}
				}
			)
			.then(function(dt) {
				// dt contains the initialized instance of DataTables

				dt.on('draw', function() {
					// console.log(dt, 'Redrawing datatable');

					// Reload tooltips
					var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
					var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
						return new bootstrap.Tooltip(tooltipTriggerEl)
					})
				})
			})
		;
	});

	function filterColumn(id, index, value){
		$("#"+id)
			.DataTable()
			.column(index)
			.search(
				value, false, false
			)
			.draw();
	}

	$(".datatable-filter").on("change", function() {
		var value = $(this).val();
		var columnIndex = $(this).data("column");
		var datatableId = $(this).data("id");
		filterColumn(datatableId, columnIndex, value);
	});
});