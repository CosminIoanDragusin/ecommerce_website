const open_menu = document.querySelector('#open_menu');
const close_menu = document.querySelector('#close_menu');
const nav_bottom = document.querySelector(".nav_bottom");

open_menu.addEventListener('click', function(){
    nav_bottom.classList.add('active');
});

close_menu.addEventListener('click', function(){
    nav_bottom.classList.remove('active');
});

