$(document).ready(function(){
    $("button[value='avancee']".click(function(){
            $("#panel").slideUp();
        })
    );});

function showHidePanel() {
    if (window.getComputedStyle(document.getElementById("panel")).display === "block"){
        document.getElementById("panel").style.display = "none";
    } else {
        document.getElementById("panel").style.display = "block";
    }
}

function hidePanel(){
    panel = document.getElementById("panel").style;
    if(panel.hasClass("ferme")){
        document.getElementById("panel");
    }

}