$('#search input').on('keyup click', $.debounce(300, handleSearchSuggestions));
$('#search').on('submit', handleSearch);
$('#search .suggestions').on('click', '.item', handleGetUserById);
$('html').on('click', handleDismissSearchSuggestionsIfOutside);

function handleSearchSuggestions() {
    var term = $('#search').find('input').val();
    if (term.length > 2) {  
        $.post(
            '/wp-json/directory/search-suggestions',
            { term: term },
            populateSearchSuggestions
        );
    } else {
        emptySearchSuggestions();
    }
}

function handleSearch(e) {
    e.preventDefault();
    var term = $(this).find('input').val();
    if (term.length > 2) {
        emptySearchSuggestions();
        search($(this).find('input').val());
        $("#search input#searchterm").val('');
    }
}

function handleGetUserById() {
    getUserById($(this).attr('id'));
}

function handleDismissSearchSuggestionsIfOutside(e) {
    if (!$(e.currentTarget).is('.suggestions .item')) {
        $('#search .suggestions').hide();
    }
}

function getUserById(id) {
    $.get(
        '/wp-json/directory/user/' + id,
        function(res) {
            populateSearchResults(res);
            $('#search .suggestions').empty();
        }
    )
}

function search(term) {
    $.post(
        '/wp-json/directory/search',
        { term: term },
        populateSearchResults
    );
}

function populateSearchSuggestions(res) {
    var suggestions = $("#search .suggestions");
    suggestions.html(createSuggestionItems(res));
    suggestions.show();
    res.length ? 
          suggestions.css({ visibility: 'visible', opacity: 1 }) 
        : suggestions.css({ visibility: 'hidden' , opacity: 0 });
}

function emptySearchSuggestions() {
    $("#search .suggestions")
    .empty()
    .css({visibility: 'hidden', opacity: 0});
}

function populateSearchResults(res) {
    $('#search .results')
    .html(createSearchResultsItems(res)).css({visibility: 'visible', opacity: 1});
    $('#search .count')
    .html($(res).length + ' results')
    .show();
}

function createSuggestionItems(res) {
    var suggestions = "";
    res.forEach(function(item) {
        suggestions += 
            '<div class="item" id="' + item['id'] + '">' +
            '<img src="/wp-content/uploads/images/' + item['profile_picture_url'] + '" />' + 
            '<p><b>' + item['first_name'] + ' ' + item['last_name']  + '</b>, ' + 
            item['role_name'] + '</p><input type="hidden" value="' + item['first_name'] + ' ' + item['last_name'] + '"></div>';
    });
    
    return suggestions;
}

function createSearchResultsItems(res) {
    var results = "";
    res.forEach(function(item) {
        results +=
            '<div class="item group">' +
            '<img src="/wp-content/uploads/images/' + item['profile_picture_url'] + '" />' +
            '<div class="pull-left member-details"><p class="member-name"><b>' + item['first_name'] + ' ' + item['last_name']  + '</b>, ' + 
            item['role_name'] + '</p>' + 
            '<p class="phone-number">' + item['phone_number'] + '</p>' +
            '<p>' + item['address_line_1'] + (item['address_line_2'] ? '<br />' + item['address_line_2'] + '<br />' : '') + "<br />" + item['city'] + '<br />' + item['state'] + '<br />' + item['zipcode'] + '</div>' +
            '<a class="pull-right" href="mailto:' + item['user_email'] + '"><button>Email</button></a>' +
            '</div>';
    });

    return results;
}
