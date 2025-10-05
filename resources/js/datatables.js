// resources/js/datatables.js
import $ from 'jquery';
import 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';

// Reusable DataTable setup
export function createDataTable(selector, options = {}) {
    return $(selector).DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        responsive: true,
        ...options,
    });
}
