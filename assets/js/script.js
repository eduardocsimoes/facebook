function addFriend(id, obj){

	if(id != ''){
		$(obj).closest('.sugestaoitem').slideUp('fast');

		$.ajax({
			type:'POST',
			url:'ajax/add_friend',
			data:{id:id}
		});
	}
}

function aceitarFriend(id, obj){

	if(id != ''){
		$(obj).closest('.requisicaoitem').slideUp('fast');

		$.ajax({
			type:'POST',
			url:'ajax/aceitar_friend',
			data:{id:id}
		});
	}
}