// Bootstrap ve jQuery temel yüklemeleri
import $ from "jquery";
import * as bootstrap from "bootstrap";
import "datatables.net-bs5/css/dataTables.bootstrap5.min.css";
import "datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css";

window.$ = window.jQuery = $; // global tanımlama


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});
// Global SCSS (burada tüm SCSS dosyaları birleştirilir)
import "../scss/app.scss";

// Sayfa bazlı scriptler
import "./pages/customers.js";
import "./pages/trashedCustomers.js"; 


import './pages/customerForm.js';