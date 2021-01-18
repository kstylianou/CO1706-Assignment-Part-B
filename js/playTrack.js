/* Kyriakos Stylianou
 * This page is to load, play and pause the tracks
 */

var x = document.getElementById("trackPlayer"); // Get the audio tag
var loaded; // loaded can be set to true or false
let play = document.getElementsByClassName('far'); // get all the buttons tha hava far class
let pause = document.getElementsByClassName('far fa-pause-circle'); // get all pause buttons

let length = play.length; // class length

// if the user click on play button the track is loaded and play and the button change to pause
for(let i = 0; i < length; i++) {
    play[i].onclick = function () {
        if(play[i].className.includes("fa-play-circle")){
            play[i].className = "far fa-pause-circle "+i+"";
            if(loaded === i) {
                x.play();
            }else{
                playSong(samples[i], i);
            }
        }else{
            play[i].className = "far fa-play-circle";
            x.pause();
        }

        if(pause.length != 0){
            for (let x = 0; x < pause.length; x++){
                if(pause[x].className != "far fa-pause-circle "+i+""){
                    pause[x].className = "far fa-play-circle"
                }
            }
        }
    };
}

// load the song and play it
function playSong(song, id) {
    loaded = id;
    x.style.display = 'block';
    if (x.canPlayType(song)) {
        x.setAttribute("src",song);
    } else {
        x.setAttribute("src",song);
    }
    if(song != null) {
        x.play();
    }
}

// check if the track has ended
x.addEventListener("ended", function () {
    for (let x = 0; x < pause.length; x++){
        pause[x].className = "far fa-play-circle"
    }
});

// Shuffle play random tracks
function randomTrack() {
    if(randPlay === false) {
        randPlay = true;
        document.getElementById('randPlay').style.color = "#DB53FB";
        randomSample = Math.floor(Math.random() * samples.length);
        playSong(samples[randomSample]);
        newTrack();
    }else{
        randPlay = false;
        document.getElementById('randPlay').style.color = "white";
        newTrack();
    }
}
// load new track for shuffle play
function newTrack() {
    x.addEventListener("ended", function () {
        if (randPlay === true) {
            randomSample = Math.floor(Math.random() * samples.length);
            playSong(samples[randomSample]);
        }
    });
}