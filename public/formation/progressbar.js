// Récupérer les éléments
document.addEventListener('DOMContentLoaded', function() {
    // Sélectionne toutes les vidéos
    const videos = document.querySelectorAll('.formation-video');
    let idvideo = 0;
    
    const debounce = (func, wait) => {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    };
    

    const sendProgressToServer = debounce(async (videoId, progress,moduleid) => {
        try {
            await fetch('/progress/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    video_id: videoId,
                    progresse: progress,
                    module_id: moduleid, 
                })
            });

        } catch (error) {
            console.error('Erreur lors de l\'envoi de la progression:', error);
        }
    }, 1000);

    videos.forEach((video, index) => {
        const progressBar = video.parentElement.querySelector('.progress-bar');
        const progressPercentage = video.parentElement.querySelector('.progressPercentage');
        
        // Met à jour la barre de progression pendant la lecture
        video.addEventListener('timeupdate', function() {
            const progress = (video.currentTime / video.duration) * 100;
            progressBar.style.width = progress + '%';
            let poucent = progress
            progressPercentage.innerHTML = parseInt(poucent) + '%';
            idvideo = index;

            sendProgressToServer(idvideo,progress,getIdFromUrl());
        });
        
        // Réinitialise la barre quand la vidéo se termine
        video.addEventListener('ended', function() {
            setTimeout(() => {
                progressBar.style.width = '0%';
            }, 1000);
        });
    });
});

function getIdFromUrl() {
  const path = window.location.pathname;
  const segments = path.split('/');
  const id = segments.pop();

  if (!id) throw new Error("ID manquant dans l'URL");
  
  return id; // ou parseInt(id, 10) pour un nombre
}

// Fonction optionnelle pour sauvegarder la progression
async function saveProgressToServer(progress) {
  try {
    await fetch('/progress/create', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        video_id: videoId,
        progress: progress,
        idmodul: moduleid, 
      })
    });
  } catch (error) {
    console.error('Erreur de sauvegarde :', error);
  }
}