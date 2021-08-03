window.addEventListener("load", function () {

	let addButton = document.getElementsByClassName("field-collection-add-button")[0];
	addButton.click();
	let addButton2 = document.getElementsByClassName("field-collection-add-button")[0];
	doClick(addButton2);

	addButton.addEventListener("click", function () {
		addButton2 = document.getElementsByClassName("field-collection-add-button")[0];
		doClick(addButton2);
	});
});

function doClick(elem, time = 4) {
	for (let i = 0; i < time; i++) {
		elem.click();
	}
	elem.remove();
}
