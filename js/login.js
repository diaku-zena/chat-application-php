const form = document.querySelector(".login form");
const continueBtn = form.querySelector(".button input");
const errorText = form.querySelector(".error-txt");

form.onsubmit = (e) => {
    e.preventDefault(); // preventing form from submiting
}

continueBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open('POST','php/login.php',true);
   
    
    xhr.onload = () => {

        if(xhr.readyState == XMLHttpRequest.DONE){
            if(xhr.status == 200){
                let data = xhr.response;

                if(data == "success"){
                    location.href = "users.php";
                } else {
                    errorText.style.display = "block";
                    errorText.textContent = data;
                    
                }
            }
        }
        
    }
    
    // We have to send the form data through ajax to php
    let formData = new FormData(form);
    xhr.send(formData); 
    
}