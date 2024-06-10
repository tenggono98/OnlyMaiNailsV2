<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="">
        <input type="text" name="daterange" class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg g-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
    </div>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script>
        // Function to extract query parameter values
        function getQueryParam(name) {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        $(function() {
            // Extract searchStartDate and searchEndDate from the URL
            let searchStartDate = getQueryParam('searchStartDate');
            let searchEndDate = getQueryParam('searchEndDate');

            // Initialize the default date range
            let startDate = searchStartDate ? moment(searchStartDate) : moment().subtract(0, 'days');
            let endDate = searchEndDate ? moment(searchEndDate) : moment();

            // Set default value for the input field
            $('input[name="daterange"]').val(`${startDate.format('YYYY-MM-DD')} - ${endDate.format('YYYY-MM-DD')}`);

            // Initialize the date range picker
            $('input[name="daterange"]').daterangepicker({
                "autoApply": true,
                startDate: startDate,
                endDate: endDate,
                opens: 'center',
                ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            "alwaysShowCalendars": true,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            }, function(start, end, label) {
                // Update the URL query parameters and reload the page
                let params = {
                    searchStartDate: start.format('YYYY-MM-DD'),
                    searchEndDate: end.format('YYYY-MM-DD')
                };
                updateQueryParamsAndReload(params);
            });
        });

        // Function to update query parameters and reload the page
        function updateQueryParamsAndReload(paramsObject) {
            let currentUrl = window.location.href;
            let url = new URL(currentUrl);
            let params = new URLSearchParams(url.search);

            for (let [key, value] of Object.entries(paramsObject)) {
                params.set(key, value);
            }

            url.search = params.toString();
            window.location.href = url.toString(); // This will reload the page
        }
    </script>
</div>
