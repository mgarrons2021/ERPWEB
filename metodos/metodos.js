function redondear(total){
  this.total=total;
    total=total.toFixed(1);
    dato=total.toString();
    ultimo=dato.charAt(dato.length - 1);
    if(parseInt(ultimo)>5)
    {total=Math.round(total);}
    else{
    if(parseInt(ultimo)==0){
        total=Math.round(total);}
    else{total=Math.round(total)+".50";}}
    return total;
    console.log("este es el total :"+total);
}