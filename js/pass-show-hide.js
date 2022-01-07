const pswordfild = document.querySelector(".form input[type=password]");
const toggleBtn = document.querySelector(".form .field i");

toggleBtn.onclick = () => {
    if(pswordfild.type == "password"){
        pswordfild.type = "text";
        toggleBtn.classList.add("active");
    }  else{
        pswordfild.type = "password";
        toggleBtn.classList.remove("active");
    }
}