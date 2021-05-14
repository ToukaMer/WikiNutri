function showHideRechercheAvancee() {
    if (window.getComputedStyle(document.getElementById("panel")).display === "block"){
        document.getElementById("panel").style.display = "none";
    } else {
        document.getElementById("panel").style.display = "block";
    }
}