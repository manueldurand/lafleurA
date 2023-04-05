$(function () {
	$("*[data-control='select2']").each((i, select) => {
		if (select.value && select.value !== null) {
			let selection = select.parentElement.querySelector(
				".select2-selection__rendered"
			);
			selection.style.color = "black";
		}
		select.onchange = function () {
			let selection = select.parentElement.querySelector(
				".select2-selection__rendered"
			);
			if (select.value && select.value !== null) {
				selection.style.color = "black";
			} else {
				selection.style.color = "#A1A5B7";
			}
		};
	});
});
