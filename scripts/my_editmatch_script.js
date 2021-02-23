function changeTextColour() {
    this.style.color = "red";
}

document.getElementById("users_match_date_entry").addEventListener("input", changeTextColour);
document.getElementById("userkickofftime").addEventListener("input", changeTextColour);
document.getElementById("select_ref").addEventListener("input", changeTextColour);
document.getElementById("ht_selector").addEventListener("input", changeTextColour);
document.getElementById("at_selector").addEventListener("input", changeTextColour);

document.getElementById("ht_ht_goals").addEventListener("input", changeTextColour);
document.getElementById("ht_ft_goals").addEventListener("input", changeTextColour);
document.getElementById("ht_total_shots").addEventListener("input", changeTextColour);
document.getElementById("ht_shots_on_target").addEventListener("input", changeTextColour);
document.getElementById("ht_corners").addEventListener("input", changeTextColour);
document.getElementById("ht_total_fouls").addEventListener("input", changeTextColour);
document.getElementById("ht_yellow_cards").addEventListener("input", changeTextColour);
document.getElementById("ht_red_cards").addEventListener("input", changeTextColour);

document.getElementById("at_ht_goals").addEventListener("input", changeTextColour);
document.getElementById("at_ft_goals").addEventListener("input", changeTextColour);
document.getElementById("at_total_shots").addEventListener("input", changeTextColour);
document.getElementById("at_shots_on_target").addEventListener("input", changeTextColour);
document.getElementById("at_corners").addEventListener("input", changeTextColour);
document.getElementById("at_total_fouls").addEventListener("input", changeTextColour);
document.getElementById("at_yellow_cards").addEventListener("input", changeTextColour);
document.getElementById("at_red_cards").addEventListener("input", changeTextColour);