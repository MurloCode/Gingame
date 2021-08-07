window.addEventListener("load",function(){
  
const btnToggle = document.getElementById('btnToggle');
const img = document.getElementById('imgToggle')


//  Listen the Event Click to Switch from Light to Dark and from Dark to Light
btnToggle.addEventListener('click', ()=> {

    const body = document.body;

    if(body.classList.contains('dark')){

        body.classList.add('light')
        body.classList.remove('dark')
        imgToggle.classList.add('nuit')
        imgToggle.classList.remove('jour')
        document.cookie = "darkMode=on"

    } else if(body.classList.contains('light')){

        body.classList.add('dark')
        body.classList.remove('light')
        imgToggle.classList.add('jour')
        imgToggle.classList.remove('nuit')
        document.cookie = "darkMode=off"
    }

}) 
    
})
