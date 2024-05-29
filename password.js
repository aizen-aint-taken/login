const SeePassword = () => {
    const pass = document.getElementById("Password");
        // console.log(pass);

     if(pass.type === "password"){
        pass.type = "text";
     }else{
        pass.type = "password";
     }   
}

