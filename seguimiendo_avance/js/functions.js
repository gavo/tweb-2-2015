function validarRegistroCarrera(){
    if($('#nombreCarrera').val().length < 5){
        alert('El Nombre para la Carrera es Demaciado Corto');
        return false;
    }
    if($('#siglaCarrera').val().length < 4){    
        alert('La sigla de la Carrera es Demaciado Corta');
        return false;
    }
    if($('#planCarrera').val().length < 1){
        alert('Necesita agregar un plan a la carrera');
        return false;
    }
    return confirm('Desea Registrar la Carrera?');
}