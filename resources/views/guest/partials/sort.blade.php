<div class="col text-end">
    <i class="fa-solid fa-list me-3 view-List-toggle" id="btnListView"></i>
    <i class="fa-solid fa-table-cells view-grid-toggle" id="btnGridView"></i>
</div>
    <div class="col text-end pro-filter-text-dropdown">
    {{ $properties->count() . ' ' . \Str::plural('Property', $properties->count()) }} |
    <a href="#" id="sortDropdownToggle">Sort <i class="fa-solid fa-angle-down ps-1" aria-hidden="true"></i></a>

    <div id="sortDropdown" class="custom-dropdown-sort-button">
        <a class="pb-3 d-flex align-items-center btn" href="{{ url(\Request::fullUrlWithQuery(['price' => 'asc'])) }}"><i class="fa-solid fa-arrow-up me-2"></i> Price: Low to High</a>
        <a class="pb-3 d-flex align-items-center btn" href="{{ url(\Request::fullUrlWithQuery(['price' => 'desc'])) }}"><i class="fa-solid fa-arrow-down me-2"></i> Price: High to Low</a>
    </div>
</div>

@section('partial_script')
<script>
// // JavaScript to toggle the chart display 'Properties in DHA' added by Hamza Amjad
// document.querySelector('.display-states-links').addEventListener('click', function() {
//     const chart = document.querySelector('.property-type-charts');
//     const link = document.querySelector('.display-states-links');
    
//     if (chart.classList.contains('show')) {
//         chart.classList.remove('show');
//         link.textContent = 'Display States';
//     } else {
//         chart.classList.add('show');
//         link.textContent = 'Hide States';
//     }
// });

// // JavaScript to toggle the chart display 'Properties Types in DHA' added by Hamza Amjad
// document.querySelector('.display-states-link').addEventListener('click', function() {
//     const chart = document.querySelector('.property-type-chart');
//     const link = document.querySelector('.display-states-link');
    
//     if (chart.classList.contains('show')) {
//         chart.classList.remove('show');
//         link.textContent = 'Display States';
//     } else {
//         chart.classList.add('show');
//         link.textContent = 'Hide States';
//     }
// });
// Sort btn code from properties page, Done by Hamza Amjad
document.getElementById('sortDropdownToggle').addEventListener('click', function(event) {
    event.preventDefault();
    this.classList.toggle('active');
    document.getElementById('sortDropdown').classList.toggle('active');
});
</script>
@endsection