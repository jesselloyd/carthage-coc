$('#search input').on('keyup', $.debounce(250, handleSearchSuggestions));
$('#search').on('submit', handleSearch);
$('#search .suggestions .item').on('click', handleSearch);

function handleSearchSuggestions() {
    $.post(
        '/wp-json/directory/search-suggestions',
        { search_term: $(this).find('input').val() },
        populateSearchSuggestions
    );
}

function handleSearch(e) {
    e.preventDefault();
    search($(this).find('input').val());
}

function search(term) {
    $.post(
        '/wp-json/directory/search',
        { search_term: $(this).find('input').val() },
        populateSearchResults
    );
}

function populateSearchSuggestions(res) {
    $('#search .suggestions').html(res);
}

function populateSearchResults(res) {
    $('#search .results').html(res);
}
