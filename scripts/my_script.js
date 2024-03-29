
if (document.getElementById("nav_burger") !== null) {
    // nav bar burger - activate and deactivate nav menu;
    function burgerMenuSwitch() {
        document.querySelector('.navbar-menu').classList.toggle('is-active');
    }
    let burger = document.getElementById("nav_burger");
    burger.addEventListener("click", burgerMenuSwitch);
}

// scroll back to the top of the page code!
if (document.getElementById("back_to_top_button") !== null) {
    let backToTopButton = document.getElementById("back_to_top_button");
    let documentRoot = document.documentElement;
    function backToTopOfPage() {
        documentRoot.scrollTo(0, 0);
    }
    backToTopButton.addEventListener("click", backToTopOfPage);
}

// program the date in the footer programmatically to change automatically every year!
if (document.getElementById("footer_text") !== null) {
    document.getElementById("footer_text").innerHTML = "<b>© All Content Copyright EPL Match Statistic Finder " + (new Date().getFullYear()) + "</b>";
}

// disable home and away club selection boxes 
if (document.getElementById("filter_club_name_checkbox") !== null) {
    let clubCheckbox = document.getElementById("filter_club_name_checkbox");
    function alternateClubCheckboxes() {
        let homeCheckbox = document.getElementById("filter_home_checkbox");
        let awayCheckbox = document.getElementById("filter_away_checkbox");

        if (clubCheckbox.checked) {
            homeCheckbox.disabled = false;
            awayCheckbox.disabled = false;
        } else {
            homeCheckbox.disabled = true;
            awayCheckbox.disabled = true;
        }
    }
    clubCheckbox.addEventListener("click", alternateClubCheckboxes);
}

// check the date picker for the form - add new 
if (document.getElementById("users_match_date_entry") !== null) {
    function checkUserDateEntry() {
        let userEntry = document.getElementById("users_match_date_entry").value;
        let matchDate = new Date(userEntry);
        let now = new Date();
        if (matchDate > now) {
            alert("Match results cannot be in the future, please enter a date in the past!");
            document.getElementById("users_match_date_entry").valueAsDate = null;
        }
    }
    document.getElementById("users_match_date_entry").addEventListener("change", checkUserDateEntry);
}

// disable the submit button until the user clicks the "yes" radio button
if (document.getElementById("yes_radio") !== null) {
    function radioCheckForSubmitBtn() {
        if (document.getElementById("yes_radio").checked) {
            document.getElementById("new_match_submit_button").disabled = false;
        } else if (document.getElementById("no_radio").checked) {
            document.getElementById("new_match_submit_button").disabled = true;
        } else {
            document.getElementById("new_match_submit_button").disabled = true;
        }
    }
    document.getElementById("new_match_reset_button").addEventListener("click", function () {
        document.getElementById("new_match_submit_button").disabled = true;
    })

    document.getElementById("yes_radio").addEventListener("click", radioCheckForSubmitBtn);
    document.getElementById("no_radio").addEventListener("click", radioCheckForSubmitBtn);
}

// for the fixture analysis page, 
// disable the search button if the user hasnt selected two teams
if ((document.getElementById("fixture_search_btn") !== null) 
    || (document.getElementById("userfilter_btn") !== null)
    || (document.getElementById("new_match_submit_button") !== null)
    || (document.getElementById("edit_match_submit_button") !== null)) {
    // if both the ht and at selectors are present on the page check their values 
    var htSelectValue = document.getElementById("ht_selector").value;
    var atSelectValue = document.getElementById("at_selector").value;

    // search button on fixture search page only
    if (document.getElementById("fixture_search_btn") !== null) {
        // function disables search button unless user selects values other than default
        function disableFixtureSearchBtn() {
            let htSelectValue = document.getElementById("ht_selector").value;
            let atSelectValue = document.getElementById("at_selector").value;
            
            // if either select values are default, disable the search button
            if (htSelectValue === atSelectValue) {
                document.getElementById("fixture_search_btn").disabled = true;
            } else {
                document.getElementById("fixture_search_btn").disabled = false;
            }
        }
        if ((htSelectValue === "Select Team") || (atSelectValue === "Select Team")) {
            document.getElementById("fixture_search_btn").disabled = true;
        }
        document.getElementById("ht_selector").addEventListener("change", disableFixtureSearchBtn);
        document.getElementById("at_selector").addEventListener("change", disableFixtureSearchBtn);
    }

    // club switch button between <select> tags
    // used on both fixture analysis page and new team select page
    if (document.getElementById("switch_club_select") !== null) {
        function switchClubsAround() {
            let htSelectValue = document.getElementById("ht_selector").value;
            let atSelectValue = document.getElementById("at_selector").value;

            let tempClub = htSelectValue;
            htSelectValue = atSelectValue;
            atSelectValue = tempClub;
            document.getElementById("ht_selector").value = htSelectValue;
            document.getElementById("at_selector").value = atSelectValue;
        }
        document.getElementById("switch_club_select").addEventListener("click", switchClubsAround);
    }
    
    // function disallows the selection of the same team for both home and away
    function disallowDuplicateSelection() {
        let htSelectValue = document.getElementById("ht_selector").value;
        let atSelectValue = document.getElementById("at_selector").value;

        if (htSelectValue === atSelectValue) {
            document.getElementById("ht_selector").value = "Select Team";
        }
    }
    document.getElementById("ht_selector").addEventListener("change", disallowDuplicateSelection);
    document.getElementById("at_selector").addEventListener("change", disallowDuplicateSelection);
}

// single match page, validate an administrator when deleting a match result!
if (document.getElementById("delete_match_btn") !== null) {
    function validateDeletion() {
        let result = confirm("This will delete this match result from the records, are you sure you wish to proceed?\nThis action CANNOT be undone.");
        if (result) {
            return true;
        } else {
            return false;
        }
    }
    document.getElementById("delete_match_btn").addEventListener("click", validateDeletion);
}

// setup the collapsing information panel on advanced search page show/hide
if (document.getElementById("collapse_info") !== null) {
    let collapseBox = document.getElementById("search_info_box");
    function collapsePanel() {
        if (collapseBox.style.display === "block") {
            collapseBox.style.display = "none";
        } else {
            collapseBox.style.display = "block";
        }
    }
    document.getElementById("collapse_info").addEventListener("click", collapsePanel);
}

// copied from embla website - to make the embla scroll work
// https://codesandbox.io/s/embla-carousel-default-vanilla-gqh0n
// https://www.embla-carousel.com/examples/basic/
if (document.getElementById("embla") !== null) {
    var emblaNode = document.querySelector('.embla');
    var options = { loop: true };
    var embla = EmblaCarousel(emblaNode, options);
}