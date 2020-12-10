const peticion = new XMLHttpRequest();
const camposCateg = document.querySelectorAll(".campoCatx");
const campoTodos = document.querySelector(".allCheckB");

const funcionCambio = ()=>{
    let requestData="";

    if (campoTodos.checked===true){
        requestData="total=all";
    }else{
        let acum=0;
        let indicador=0;
        for (let checkbx of camposCateg){
            if (checkbx.checked===true){
                acum++;
                requestData+=("cat"+indicador+"="+checkbx.value+"&");
                indicador++;
            }
        }
        requestData+="total="+acum;
    }
    let peticion = new XMLHttpRequest();

    peticion.onreadystatechange=()=>{
        if (peticion.status===200&&peticion.readyState===4){
            //YA AQUI TENEMOS EL ARRAY DE PRODUCTOS LISTO
            console.log(peticion.responseText);
            const arrayProductos = JSON.parse(peticion.responseText);
            const areaGeneral=document.querySelector("#areaProductos");

            areaGeneral.innerHTML="";
            for (let producto of arrayProductos){
                let divProd=document.createElement("div");
                let imagen=document.createElement("img");
                let subt =document.createElement("h3");
                let precio = document.createElement("p");
                precio.className="precio";
                precio.innerText="$"+producto["Precio"];
                subt.className="nombreProducto";
                subt.innerText=producto["nombre"];
                divProd.className="prod-container";
                imagen.className="img-prod";
                ///appweb/images/prodPics/".$row["IDProducto"].".png'
                imagen.src="/appweb/images/prodPics/"+producto["IDProducto"]+".png";
                imagen.width=300;
                imagen.height=250;
                areaGeneral.append(divProd);
                divProd.append(imagen);
                divProd.append(subt);
                divProd.append(precio);


            }

        }
    }

    peticion.open ("GET","/appweb/responses/categResponse.php?"+requestData);
    peticion.send();


}

campoTodos.addEventListener("change",funcionCambio)
for (let campoCate of camposCateg){
    campoCate.addEventListener ("change",funcionCambio);
}