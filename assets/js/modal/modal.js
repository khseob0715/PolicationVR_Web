// Get the modal
var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

var modal_width = document.getElementById('myModal_width');
var img_width = document.getElementById('myImg_width');
var modalImg_width = document.getElementById("img02");



function openModal(imgsrc) {
	modal.style.display = "block";
	modalImg.src = imgsrc;
}


function openModal_width(imgsrc){
	modal_width.style.display = "block";	
	modalImg_width.src = imgsrc;
}

// img.onclick = function(){	
// 	modal.style.display = "block";
// 	modalImg.src = this.src;
// 	captionText.innerHTML = this.alt;
	
// }
modalImg.onclick = function(){ // modal 종료 
	modal.style.display = "none";
}

modalImg_width.onclick = function(){ // modal 종료 
	modal_width.style.display = "none";
}
