function remove_from_watch(btn)
{
	btn.attr("disabled", true);
	btn.find("i").show();

	var movie_id = btn.attr("data-id");

	$.ajax({
		url: btn.attr("data-url") + btn.attr("data-id"),
		method:'DELETE',
		data: {
				'movie_id': movie_id,
				'_token': $('meta[name="csrf-token"]').attr('content'),
			  },
		dataType:'json',
		success:function(data)
		{
			  btn.find("i").hide();
			  btn.attr("disabled", false);
			  window.location.reload();
		}
	});
}