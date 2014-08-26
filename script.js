function evalDelete(evaluateID){
	var myForm = document.getElementById('evalForm');
	var deleteValue = document.getElementById('delete');
	deleteValue.value = evaluateID;
	myForm.submit();
}