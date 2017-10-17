if (navigator.geolocation) {
navigator.geolocation.watchPosition(showPosition);
//navigator.geolocation.getCurrentPosition(showPosition);
} else {
//alert("Geolicalizacion no soportada.");
}

function showPosition(position) {
var geo_info = "lat=" + position.coords.latitude + "&lon=" + position.coords.longitude;

window.localStorage.setItem("User_Lat", position.coords.latitude);
window.localStorage.setItem("User_Lon", position.coords.longitude);

function user_lat(){
return position.coords.latitude;
}
function user_lon(){
return position.coords.longitude;
}

$("#User_Lat").val(position.coords.latitude);
$("#User_Lon").val(position.coords.longitude);
$(".User_Lat").val(position.coords.latitude);
$(".User_Lon").val(position.coords.longitude);
$(".User_LatLon_print").html(position.coords.latitude+","+position.coords.longitude);
$(".User_Lat_print").html(position.coords.latitude);
$(".User_Lon_print").html(position.coords.longitude);

}