$(function (){
    $(".confirm").click(function () {
        return confirm("Are you sure you want to delete this object?");
    });    
});
$(function (){
    $(".sure").click(function () {
       return confirm("Are you sure you want to refund this item?");
    }); 
});
// start filter sub cats.
filterSelection("all")
function filterSelection(cat) {
  var x, i;
  x = document.getElementsByClassName("filterDiv");
  if (cat == "all") cat = "";
  for (i = 0; i < x.length; i++) {
    removeClass(x[i], "show");
    if (x[i].className.indexOf(cat) > -1) addClass(x[i], "show");
  }
}

function addClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function removeClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);     
    }
  }
  element.className = arr1.join(" ");
}
// end filter sub cats.
