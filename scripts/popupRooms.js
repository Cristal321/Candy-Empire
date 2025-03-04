document.getElementById("rules").addEventListener("click", function() {
    document.getElementById("popup").style.visibility = "visible";
    document.getElementById("popup").style.opacity = "1";
});

document.getElementById("closePopup").addEventListener("click", function() {
    document.getElementById("popup").style.visibility = "hidden";
    document.getElementById("popup").style.opacity = "0";
});


