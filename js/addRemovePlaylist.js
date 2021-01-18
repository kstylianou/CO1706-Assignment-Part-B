/* Kyriakos Stylianou
 * This javascript is used in tracks page artist page and album to add or remove playlist from database
 */

// Add track to playlist table in database
function addPlaylist(trackId, i) {
    fetch("action_addPlaylist.php?track_id="+trackId+"&remove=false")
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            if(data.suc == true){
                // if row is inserted on database change the button to remove from playlist
                let button = document.getElementsByClassName('addPlaylist')[i];
                button.innerHTML = "Remove from playlist";
                button.removeAttribute('onclick');
                button.setAttribute('onclick' , "removePlaylist("+trackId+", "+i+")");
            }
        });
}

// Remove track from playlist table in database
function removePlaylist(trackId, i , reload) {
    fetch("action_addPlaylist.php?track_id="+trackId+"&remove=true")
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            if(data.suc == true){
                // if row is inserted on database change the button to add to playlist
                let button = document.getElementsByClassName('addPlaylist')[i];
                button.innerHTML = "Add from playlist";
                button.removeAttribute('onclick');
                button.setAttribute('onclick' , "addPlaylist("+trackId+", "+i+")");
                if(reload === true){
                    location.reload();
                }
            }
        });
}