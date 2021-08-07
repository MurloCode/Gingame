const btnToggle = document.querySelector('.btn-toggle');
//  Listen the Event Click to Switch from Light to Dark and from Dark to Light
btnToggle.addEventListener('click', ()=> {

    const body = document.body;

    if(body.classList.contains('dark')){

        body.classList.add('light')
        body.classList.remove('dark')
        btnToggle.innerHTML = "N"


    } else if(body.classList.contains('light')){

        body.classList.add('dark')
        body.classList.remove('light')
        btnToggle.innerHTML = "J"
    }
})