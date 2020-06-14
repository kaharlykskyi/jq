/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

function countdown() {
    var i = document.getElementById('counter');
    if (parseInt(i.innerHTML) <= 0) {
        location.href = '/home';
    }
    if (parseInt(i.innerHTML)!=0) {
        i.innerHTML = parseInt(i.innerHTML) - 1;
    }
}
setInterval(function(){ countdown(); },1000);
