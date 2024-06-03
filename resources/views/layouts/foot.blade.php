<a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

<!-- JQUERY JS -->
{{-- <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- BOOTSTRAP JS -->
<script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- MOMENT JS -->
<script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>

<!-- STICKY JS -->
<script src="{{ asset('assets/js/sticky.js') }}"></script>

<!-- P-SCROLL JS -->
<script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/plugins/perfect-scrollbar/p-scroll.js') }}"></script>

<!-- SIDEBAR JS -->
<script src="{{ asset('assets/plugins/side-menu/sidemenu.js') }}"></script>

<!-- Chart-circle js -->
<script src="{{ asset('assets/plugins/circle-progress/circle-progress.min.js') }}"></script>

<!-- Internal Chart.Bundle js-->
<script src="{{ asset('assets/plugins/chartjs/Chart.bundle.min.js') }}"></script>

<!-- Moment js -->
<script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>

<!-- INTERNAL Apexchart js -->
<script src="{{ asset('assets/js/apexcharts.js') }}"></script>

<!--Internal Sparkline js -->
<script src="{{ asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

<!--Internal  index js -->
<script src="{{ asset('assets/js/index.js') }}"></script>

<!-- Chart-circle js -->
<script src="{{ asset('assets/js/chart-circle.js') }}"></script>

<!-- Internal Data tables -->
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/table-data.js') }}"></script>

<!-- Internal Select2 js-->
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

<!-- INTERNAL Select2 js -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.js') }}"></script>

<!-- EVA-ICONS JS -->
<script src="{{ asset('assets/plugins/eva-icons/eva-icons.min.js') }}"></script>

<!-- THEME-COLOR JS -->
<script src="{{ asset('assets/js/themecolor.js') }}"></script>

<!-- CUSTOM JS -->
<script src="{{ asset('assets/js/custom.js') }}"></script>

<!-- exported JS -->
<script src="{{ asset('assets/js/exported.js') }}"></script>

<!-- Jquery Confirm -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js" integrity="sha512-zP5W8791v1A6FToy+viyoyUUyjCzx+4K8XZCKzW28AnCoepPNIXecxh9mvGuy3Rt78OzEsU+VCvcObwAMvBAww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- Toastify --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

@stack('script')
@stack('modal-scripts')

<script>

    // new DataTable('#responsive-datatable');    

    $(document).ready(function() {
        // var socket = io('http://localhost:3000',{ transports: ["websocket"] });

        // socket.on('notif-order', (msg) => {
        //     console.log('DATA::',msg);
        // })
        // setInterval(() => {
        //     socket.emit('message', 'datas');
        // }, 1000);
    // Fakes the loading setting a timeout
    setTimeout(function() {
        $('body').addClass('loaded');
    }, 1000);

    });

    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('list-stock')) {
            $('list-stock').DataTable().destroy(); // Destroy the existing DataTable instance
        }

        var table = $('list-stock').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'pdfHtml5',
                // 'print'
            ]
        });
    });

    $(document).ready(function() {
    var table = $('#dataTableStock').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: ''
        },
        dom: 'Bfrtip', // Show buttons (B) and other elements (frtip)
        buttons: [
            {
                extend: 'excelHtml5', // Excel button
                text: 'Excel',
                exportOptions: {
                    columns: ':visible' // Export only visible columns
                }
            },
            {
                extend: 'pdfHtml5', // PDF button
                text: 'PDF',
                exportOptions: {
                    columns: ':visible' // Export only visible columns
                }
            },
            // {
            //     extend: 'print', // Print button
            //     text: 'Print',
            //     exportOptions: {
            //         columns: ':visible' // Export only visible columns
            //     }
            // }
        ],
        lengthMenu: [10, 25, 50, 75, 100], // Define custom length menu
        pageLength: 10 // Set initial page length
    });
});




    $(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#tableReport')) {
        $('#tableReport').DataTable().destroy(); // Destroy the existing DataTable instance
    }

    var table = $('#tableReport').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    format: {
                        body: function(data, row, column, node) {
                            if (column === 6) {
                                var listItems = $(node).find('li').map(function() {
                                    return $(this).text();
                                }).get().join(', '); // Menggabungkan semua teks <li> menjadi satu teks terpisah oleh koma
                                return listItems;
                            } else {
                                return data;
                            }
                        }
                    }
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    format: {
                        body: function(data, row, column, node) {
                            if (column === 6) {
                                var listItems = $(node).find('li').map(function() {
                                    return $(this).text();
                                }).get().join(', '); // Menggabungkan semua teks <li> menjadi satu teks terpisah oleh koma
                                return listItems;
                            } else {
                                return data;
                            }
                        }
                    }
                }
            },
            // 'print'
        ]
    });
});



    $(document).ready(function () {
        var table = $('#tableDetail').DataTable( {
            responsive: true,
            "lengthMenu": [[100, 50, 25], [100, 50, 25]],
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'pdfHtml5',
                // 'print'
            ]
        });
    });

    $(document).ready(function () {
        var table = $('#tableMeja').DataTable( {
            responsive: true,
            "lengthMenu": [[100, 50, 25], [100, 50, 25]],
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'pdfHtml5',
                // 'print'
            ]
        });
    });

    $(document).ready(function () {
        var table = $('#dataTableStockIn').DataTable( {
            responsive: true,
            "lengthMenu": [[100, 50, 25], [100, 50, 25]],
        });
    });

    function detailModal(title, url, width) {
        $.confirm({
            title: title,
            theme : 'material',
            backgroundDismiss: true, // this will just close the modal
            content: 'URL:'+url,
            animation: 'zoom',
            closeAnimation: 'scale',
            animationSpeed: 400,
            closeIcon: true,
            columnClass: width,
            buttons: {
                close: {
                    btnClass: 'btn-dark font-bold',
                }
            },
        });
    }

    function createForm(title,url) {
        $.confirm({
            title: title,
            content: 'URL:'+url,
                buttons: {
                    // confirm: function () {
                    //     $.alert('Confirmed!');
                    // },
                    cancel: function () {
                        $.alert('Canceled!');
                    },
                    // somethingElse: {
                    //     text: 'Something else',
                    //     btnClass: 'btn-blue',
                    //     keys: ['enter', 'shift'],
                    //     action: function(){
                    //         $.alert('Something else?');
                    //     }
                    // }
                }
        });
    }

    function editForm(title,url) {
        $.confirm({
            title: title,
            content: 'URL:'+url,
                buttons: {
                    // confirm: function () {
                    //     $.alert('Confirmed!');
                    // },
                    cancel: function () {
                        $.alert('Canceled!');
                    },
                    // somethingElse: {
                    //     text: 'Something else',
                    //     btnClass: 'btn-blue',
                    //     keys: ['enter', 'shift'],
                    //     action: function(){
                    //         $.alert('Something else?');
                    //     }
                    // }
                }
        });
    }

    function modalDelete(title, name, url, link) {
        $.confirm({
            title: `Delete ${title}?`,
            content: `Are you sure want to delete ${name}`,
            autoClose: 'cancel|8000',
            buttons: {
                delete: {
                    text: 'delete',
                    action: function () {
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_method": 'delete',
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                window.location.href = link
                            },
                            error: function (data) {
                                $.alert('Failed!');
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function () {

                }
            }
        });

    }

    function modalDeleteResto(title, name, url, link) {
        $.confirm({
            title: `Delete ${title}?`,
            content: `Are you sure want to delete ${name}`,
            autoClose: 'cancel|8000',
            buttons: {
                delete: {
                    text: 'delete',
                    action: function () {
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_method": 'delete',
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                window.location.href = link
                            },
                            error: function (data) {
                                $.alert('Failed!');
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function () {

                }
            }
        });

    }
</script>

<script>
    function logout() {
        $.confirm({
            icon: 'fas fa-sign-out-alt',
            title: 'Logout',
            theme: 'supervan',
            content: 'Are you sure want to logout?',
            autoClose: 'cancel|800000',
            buttons: {
                logout: {
                    text: 'logout',
                    btnClass: 'btn-danger',

                    action: function () {
                        $.ajax({
                            type: 'POST',
                            url: "{{ secure_url(route('logout')) }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                location.reload();
                            },
                            error: function (data) {
                                $.alert('Failed!');
                                console.log(data);
                            }
                        });
                    }
                },
                cancel: function () {

                }
            }
        });
    }
</script>

@if(session()->has('success'))
    <script>
            Toastify({
                text: "{{ session()->get('success') }}",
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "center", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "#D5F3E9",
                    color: "#1f7556"
                },
                duration: 3000
            }).showToast();
    </script>
@endif

@if(session()->has('cash'))
    <script>
            Toastify({
                text: "{{ session()->get('cash') }}",
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "center", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "#D5F3E9",
                    color: "#1f7556"
                },
                duration: 8000
            }).showToast();
    </script>
@endif

@if(session()->has('warning'))
<script>
        Toastify({
            text: "{{ session()->get('warning') }}",
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "center", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "#FBEFDB",
                color: "#916c2e"
            },
            duration: 3000
        }).showToast();
</script>
@endif

@if(session()->has('failed'))
<script>
    Toastify({
        text: "🚨 {{ session()->get('failed') }}",
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        theme: "dark",
        style: {
            background: "#fde1e1",
            color: "#924040"
        },
        duration: 4000
    }).showToast();
</script>

<script>
    function phoneMask() {
        var num = $(this).val().replace(/\D/g,'');
        $(this).val(num.substring(0,13));
    }
    $('[type="tel"]').keyup(phoneMask);
</script>

@endif

<script>
    function downloadImage(id) {
    // Get the barcode image element
    const barcodeImage = document.getElementById('barcode-image');

    // Create a canvas element
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');

    // Set the canvas dimensions to match the image
    canvas.width = barcodeImage.width;
    canvas.height = barcodeImage.height;

    // Draw the image onto the canvas
    context.drawImage(barcodeImage, 0, 0);

    // Convert the canvas content to a data URL
    const dataUrl = canvas.toDataURL('image/jpeg');

    // Create a temporary anchor element for downloading
    const downloadLink = document.createElement('a');
    downloadLink.href = dataUrl;
    downloadLink.download = 'barcode.jpg';

    // Trigger the download
    downloadLink.click();
}
</script>

@yield('javascript')
@stack('script_bot')





