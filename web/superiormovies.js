function highlightMenuItem(id) {
    document.getElementById(currentSelection).setAttribute("class", "menu");
    document.getElementById(currentSelection+"_page").hidden = true;

    document.getElementById(id).setAttribute("class", "menuselected");
    document.getElementById(id+"_page").hidden = false;

    currentSelection = id;
}

function displayHome(e) {
    highlightMenuItem(e.id);
}

function rateMovies(e) {
    highlightMenuItem(e.id);

    // TBD code to fetch movies records from database and display in the 'rate_movies_page' div
}

function viewRankings(e) {
    highlightMenuItem(e.id);

    // TBD code to fetch rankings from database and display in the 'view_rankings_page' div
}

function about(e) {
    highlightMenuItem(e.id);
}

function saveData () {
    var data = new FormData(document.getElementById("rate_movies_form"));

    fetch("insert.php", { method: "POST", body: data })
        .then(saveSuccess)
        .catch(saveFail);
    return false;
}

function saveSuccess(resp) {
    console.log(resp.text());
    alert("Ratings saved successfully");
    window.location.reload();
}

function saveFail(resp) {
    console.log(resp);
}
