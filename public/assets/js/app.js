window.addEventListener('load', function(){
    document.getElementById("texto").addEventListener("keyup", () => {
        if ((document.getElementById("texto").value.length) >= 1){
            document.getElementById("resultados").style.display = "block";
            fetch(`/admin/qr/buscador?texto=${document.getElementById("texto").value}`,{ method:'get' })
            .then(response  =>  response.text() )
            .then(html      =>  {   document.getElementById("resultados").innerHTML = html  })
        }else{
            document.getElementById("resultados").style.display = "none";
            document.getElementById("resultados").innerHTML = "";
        }
    })
});    

