const form = document.querySelector(".chat-area .typing-area");
const sendBtn = form.querySelector("button");
const inputField = form.querySelector(".input-field");
const chatBox = document.querySelector(".chat-area .chat-box");

form.onsubmit = (e)=>{
    e.preventDefault();
}

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open('POST','php/insert-chat.php',true);

    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                inputField.value = "";
            }
        }
    }

    let formData = new FormData(form);
    xhr.send(formData);
}

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open('POST','php/get-chat.php',true);

    xhr.onload = () => {
        if(xhr.readyState == XMLHttpRequest.DONE){
            if(xhr.status == 200){
                let data = xhr.response;
                
                chatBox.innerHTML = data;
            }
        }
    }

    let formData = new FormData(form);
    xhr.send(formData);
}, 500); // This function will run frequently after 500ms

