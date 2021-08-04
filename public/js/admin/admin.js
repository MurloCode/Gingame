window.addEventListener("load", function () {
	let BtnQuestion = document.getElementsByClassName("field-collection-add-button")[0];
	BtnQuestion.click();
	let btnProposition = document.getElementsByClassName("field-collection-add-button")[0];
	doClick(btnProposition);

	BtnQuestion.addEventListener("click", function () {
		btnProposition = document.getElementsByClassName("field-collection-add-button")[0];
		doClick(btnProposition);
	});
});

function doClick(elem, time = 4) {
	for (let i = 0; i < time; i++) {
		elem.click();
	}
	elem.remove();
}
