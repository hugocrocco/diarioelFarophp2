function actualizarRelojFecha() {
    const ahora = new Date();
  
    const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                   'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  
    const diaSemana = dias[ahora.getDay()];
    const dia = ahora.getDate().toString().padStart(2, '0');
    const mes = meses[ahora.getMonth()];
    const año = ahora.getFullYear();
  
    const horas = ahora.getHours().toString().padStart(2, '0');
    const minutos = ahora.getMinutes().toString().padStart(2, '0');
    const segundos = ahora.getSeconds().toString().padStart(2, '0');
  
    const relojFechaTexto = `${diaSemana}, ${dia} de ${mes} de ${año} - ${horas}:${minutos}:${segundos}`;
  
    const relojElemento = document.getElementById('relojFecha');
    if (relojElemento) {
      relojElemento.innerText = relojFechaTexto;
    }
  }
  
  // Actualizar cada segundo
  setInterval(actualizarRelojFecha, 1000);
  
  // Mostrar inmediatamente
  actualizarRelojFecha();