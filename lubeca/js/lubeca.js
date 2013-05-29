show_left=true;
show_right=true;

function init_sidebars() {

	show_left_cookie=$.cookie("show_left");
	if (show_left_cookie=='hide') {
		toggle_left();
	}
	show_right_cookie=$.cookie("show_right");
	if (show_right_cookie=='hide') {
		toggle_right();
	}	
	
	$('#searchInput').blur(function() {
		var searchstring=$('#searchInput').val();
		if (searchstring=='') {
			$('#searchInput').val('Modul durchsuchen');
			$('#searchInput').css('color','#a5acc1');
			}
		});
	$('#searchInput').focus(function() {
		var searchstring=$('#searchInput').val();
		if (searchstring=='Modul durchsuchen') {
			$('#searchInput').removeAttr("value"); 
			}	
		$('#searchInput').css('color','#000000');
		});	
	
	$('#content_main div.biblio').html('');
	
	/*
	$('span.editsection').html( 
			function(index, oldhtml) {
				editspan_content=$(this).html();    
				editspan_len=editspan_content.length;
				editspan_corrected=editspan_content.substr(1,editspan_len-2);
				$(this).html(editspan_corrected);
			} 
	); 
	$('span.editsection a').html('<div class="editicon"></div>').css('width','20px').css('height','20px'); 
	*/
	

}


function highlight_bib(bib) {
	$(bib).css('background-color','#e1ddd4');
}
function unhighlight_bib(bib) {
	$(bib).css('background-color','transparent');
}



function toggle_left() {
	$('#sidebar_left').toggle();
	$('#footer_left').toggle();
	$('#content_footer_left').toggle();
	$('#navbar1_left').toggle();
	$('#navbar2_left').toggle();
	if (show_left) {
		show_left=false;
		$.cookie("show_left","hide", { path: '/' });
		$('#toggle_sidebar_left').removeClass('toggle_sidebar_left_open').addClass('toggle_sidebar_left_closed');
	} else {
		show_left=true;
		$.cookie("show_left","show", { path: '/' });
		$('#toggle_sidebar_left').removeClass('toggle_sidebar_left_closed').addClass('toggle_sidebar_left_open');
	}
	
	
	if (show_right && show_left) {
		$('#wrapper').css('width','1340px').removeClass('bg840').removeClass('bg1090left').removeClass('bg1090right').removeClass('bg1340').addClass('bg1340');
		document.getElementById("viewport").setAttribute("content","width=1380");	
	} else if (!show_right && show_left) {
		$('#wrapper').css('width','1090px').removeClass('bg840').removeClass('bg1090left').removeClass('bg1090right').removeClass('bg1340').addClass('bg1090left');
		document.getElementById("viewport").setAttribute("content","width=1130");
	} else if (show_right && !show_left) {
		$('#wrapper').css('width','1090px').removeClass('bg840').removeClass('bg1090left').removeClass('bg1090right').removeClass('bg1340').addClass('bg1090right');
		document.getElementById("viewport").setAttribute("content","width=1130");
	} else if (!show_right && !show_left) {
		$('#wrapper').css('width','840px').removeClass('bg840').removeClass('bg1090left').removeClass('bg1090right').removeClass('bg1340').addClass('bg840');
		document.getElementById("viewport").setAttribute("content","width=880");
	}
}
function toggle_right() {
	$('#sidebar_right').toggle();
	$('#content_footer_right').toggle();
	$('#footer_right').toggle();
	$('#navbar1_right').toggle();
	$('#navbar2_right').toggle();
	if (show_right) {
		show_right=false;	
		$.cookie("show_right","hide", { path: '/' });
		$('#toggle_sidebar_right').removeClass('toggle_sidebar_right_open').addClass('toggle_sidebar_right_closed');
	} else {
		show_right=true;
		$.cookie("show_right","show", { path: '/' });
		$('#toggle_sidebar_right').removeClass('toggle_sidebar_right_closed').addClass('toggle_sidebar_right_open');
	}
	
	
	if (show_right && show_left) {
		$('#wrapper').css('width','1340px').removeClass('bg840').removeClass('bg1090left').removeClass('bg1090right').removeClass('bg1340').addClass('bg1340');;
		document.getElementById("viewport").setAttribute("content","width=1380");	
	} else if (!show_right && show_left) {
		$('#wrapper').css('width','1090px').removeClass('bg840').removeClass('bg1090left').removeClass('bg1090right').removeClass('bg1340').addClass('bg1090left');
		document.getElementById("viewport").setAttribute("content","width=1130");
	} else if (show_right && !show_left) {
		$('#wrapper').css('width','1090px').removeClass('bg840').removeClass('bg1090left').removeClass('bg1090right').removeClass('bg1340').addClass('bg1090right');
		document.getElementById("viewport").setAttribute("content","width=1130");
	} else if (!show_right && !show_left) {
		$('#wrapper').css('width','840px').removeClass('bg840').removeClass('bg1090left').removeClass('bg1090right').removeClass('bg1340').addClass('bg840');
		document.getElementById("viewport").setAttribute("content","width=880");
	}
}





