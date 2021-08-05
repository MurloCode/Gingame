window.addEventListener("load", function () {
	let BtnQuestion = document.getElementsByClassName("field-collection-add-button")[0];
	BtnQuestion.click();
	let btnProposition = document.getElementsByClassName("field-collection-add-button")[0];
	addPropositions(btnProposition);

	BtnQuestion.addEventListener("click", function () {
		btnProposition = document.getElementsByClassName("field-collection-add-button")[0];
		addPropositions(btnProposition);

		// scroll to the bottom of the page
		//https://stackoverflow.com/questions/11715646/scroll-automatically-to-the-bottom-of-the-page
		var scrollingElement = document.scrollingElement || document.body;
		scrollingElement.scrollTop = scrollingElement.scrollHeight;
	});
});

function addPropositions(elem, time = 4) {
	for (let i = 0; i < time; i++) {
		elem.click();
		if (i == 0) {
			answerField;
			// Check the first Checkbox of the new added proposition & add class on it
			var checkbox = document.getElementsByClassName("isValid");
			checkbox[checkbox.length - 1].checked = true;
			var answerField = document.getElementsByClassName("answerField");
			answerField[checkbox.length - 1].classList.add("propsIsValid");
		}
	}
	// remove de button for add new proposition
	elem.remove();
}
