document.addEventListener('DOMContentLoaded', function() {
    const banner = document.getElementById('bannerAvisos');

    fetch('/data/noticias.json')
      .then(response => response.json())
      .then(data => {
        if (data.avisos && data.avisos.length > 0) {
          let index = 0;
          banner.textContent = data.avisos[index];

          setInterval(() => {
            index = (index + 1) % data.avisos.length;
            banner.textContent = data.avisos[index];
          }, 5000); // cada 5 segundos
        } else {
          banner.textContent = "No hay avisos disponibles.";
        }
      })
      .catch(error => {
        console.error('Error cargando avisos:', error);
        banner.textContent = "Error cargando avisos.";
      });
});