@extends('layouts.app')

@section('content')

<!-- CSS Libraries -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Table Styles */
    #tableBarangCrud tbody tr {
        cursor: pointer;
    }

    /* Select2 Customization */
    .select2-container--default .select2-selection--single {
        height: 38px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
        padding-left: 12px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #6c757d;
    }

    /* Card Styles */
    .card {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .card-header h4 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #495057;
    }

    /* Form Styles */
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    /* Input Group Styles */
    .input-group {
        width: 100%;
    }

    .input-group .btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    /* Badge Styles */
    .badge {
        font-size: 0.9rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .col-md-8 {
            width: 100%;
        }
    }
</style>

<div class="page-header">
    <h3 class="page-title">Modul 4 - Javascript & jQuery</h3>
</div>

<div class="row">
    <!-- Card 1: Spinner Button -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h4>1. Spinner Button (Loader)</h4>
            </div>
            <div class="card-body">
                <form id="formSpinner">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Email</label>
                        <input type="email" class="form-control" required>
                    </div>
                </form>
                <button type="button" id="btnSubmit" class="btn btn-success mt-3">
                    <span id="btnText">Submit</span>
                    <span id="btnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Card 2: Tambah Barang -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h4>2. Tambah Barang + Table HTML</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-5">
                        <label>Nama Barang</label>
                        <input type="text" id="namaBarang" class="form-control">
                    </div>
                    <div class="col-md-5">
                        <label>Harga Barang</label>
                        <input type="number" id="hargaBarang" class="form-control">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-success w-100" id="btnTambah">Submit</button>
                    </div>
                </div>
                <table class="table table-bordered" id="tableBarang">
                    <thead>
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga Barang</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Card 3: CRUD Row dengan Modal -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h4>3. CRUD Row dengan Modal</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="tableBarangCrud">
                    <thead>
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Laptop</td>
                            <td>8000000</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Mouse</td>
                            <td>100000</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Keyboard</td>
                            <td>300000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Card 4: Select Biasa -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h4>Select</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Kota:</label>
                        <input type="text" id="inputKota" class="form-control" placeholder="Masukkan nama kota">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-success" id="btnTambahKota">Tambahkan</button>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Select Kota:</label>
                    <select class="form-control" id="selectKota">
                        <option value="">-- Pilih Kota --</option>
                    </select>
                </div>
                <div>
                    <strong>Kota Terpilih :</strong>
                    <span id="kotaTerpilih">-</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 5: Select2 -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h4>Select 2</h4>
            </div>
            <div class="card-body">
                <!-- Input Row -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Kota:</label>
                        <div class="input-group">
                            <input type="text" id="inputKota2" class="form-control" placeholder="Masukkan nama kota">
                            <button type="button" class="btn btn-success" id="btnTambahKota2">Tambahkan</button>
                        </div>
                    </div>
                </div>

                <!-- Select Row -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Select Kota:</label>
                        <select id="selectKota2" class="form-control" style="width:100%">
                            <option value="">-- Pilih Kota --</option>
                        </select>
                    </div>
                </div>

                <!-- Selected City Row -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <strong class="me-2">Kota Terpilih :</strong>
                            <span id="kotaTerpilih2" class="badge bg-primary p-2">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal CRUD -->
<div class="modal fade" id="modalCrud">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Barang</h5>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>ID Barang</label>
                    <input type="text" id="crudId" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label>Nama Barang</label>
                    <input type="text" id="crudNama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Harga Barang</label>
                    <input type="number" id="crudHarga" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button class="btn btn-danger" id="btnDeleteCrud">Hapus</button>
                <button class="btn btn-success" id="btnUpdateCrud">Ubah</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    (function() {
        'use strict';

        // ==================== UTILITY FUNCTIONS ====================
        const utils = {
            getElement: (id) => document.getElementById(id),
            showAlert: (message) => alert(message),
            validateInput: (value, fieldName) => {
                if (!value || value.trim() === '') {
                    utils.showAlert(`${fieldName} harus diisi`);
                    return false;
                }
                return true;
            }
        };

        // ==================== STUDY CASE 1: SPINNER BUTTON ====================
        (function setupSpinnerButton() {
            const btnSubmit = utils.getElement('btnSubmit');
            if (!btnSubmit) return;

            btnSubmit.addEventListener('click', function() {
                const form = utils.getElement('formSpinner');
                const text = utils.getElement('btnText');
                const spinner = utils.getElement('btnSpinner');
                
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                text.classList.add('d-none');
                spinner.classList.remove('d-none');
                this.disabled = true;

                setTimeout(() => form.submit(), 1500);
            });
        })();

        // ==================== STUDY CASE 2: TAMBAH BARANG ====================
        (function setupTambahBarang() {
            let idBarang = 1;
            const btnTambah = utils.getElement('btnTambah');
            
            if (!btnTambah) return;

            btnTambah.addEventListener('click', function() {
                const nama = utils.getElement('namaBarang').value;
                const harga = utils.getElement('hargaBarang').value;

                if (!utils.validateInput(nama, 'Nama Barang') || 
                    !utils.validateInput(harga, 'Harga Barang')) {
                    return;
                }

                const tbody = document.querySelector('#tableBarang tbody');
                const row = tbody.insertRow();
                
                row.insertCell(0).innerHTML = idBarang++;
                row.insertCell(1).innerHTML = nama;
                row.insertCell(2).innerHTML = harga;

                utils.getElement('namaBarang').value = '';
                utils.getElement('hargaBarang').value = '';
            });
        })();

        // ==================== STUDY CASE 3: CRUD MODAL ====================
        (function setupCrudModal() {
            let selectedRowCrud = null;
            const tbody = document.querySelector('#tableBarangCrud tbody');
            
            if (!tbody) return;

            // Open modal on row click
            tbody.addEventListener('click', function(e) {
                const row = e.target.closest('tr');
                if (!row) return;
                
                selectedRowCrud = row;

                utils.getElement('crudId').value = row.cells[0].innerText;
                utils.getElement('crudNama').value = row.cells[1].innerText;
                utils.getElement('crudHarga').value = row.cells[2].innerText;

                new bootstrap.Modal(utils.getElement('modalCrud')).show();
            });

            // Update button
            utils.getElement('btnUpdateCrud').addEventListener('click', function() {
                if (!selectedRowCrud) return;
                
                const nama = utils.getElement('crudNama');
                const harga = utils.getElement('crudHarga');

                if (!nama.value || !harga.value) {
                    utils.showAlert('Semua field harus diisi!');
                    return;
                }

                selectedRowCrud.cells[1].innerText = nama.value;
                selectedRowCrud.cells[2].innerText = harga.value;

                bootstrap.Modal.getInstance(utils.getElement('modalCrud')).hide();
            });

            // Delete button
            utils.getElement('btnDeleteCrud').addEventListener('click', function() {
                if (confirm('Yakin ingin menghapus data ini?')) {
                    selectedRowCrud.remove();
                    bootstrap.Modal.getInstance(utils.getElement('modalCrud')).hide();
                }
            });
        })();

        // ==================== CARD 4: SELECT BIASA ====================
        (function setupSelectBiasa() {
            const btnTambahKota = utils.getElement('btnTambahKota');
            const selectKota = utils.getElement('selectKota');
            const kotaTerpilih = utils.getElement('kotaTerpilih');
            const inputKota = utils.getElement('inputKota');

            if (!btnTambahKota || !selectKota) return;

            // Add city
            btnTambahKota.addEventListener('click', function() {
                const kota = inputKota.value.trim();

                if (!utils.validateInput(kota, 'Kota')) return;

                // Check for duplicates
                for (let i = 0; i < selectKota.options.length; i++) {
                    if (selectKota.options[i].value === kota) {
                        utils.showAlert('Kota sudah ada dalam daftar!');
                        return;
                    }
                }

                // Add option
                const option = document.createElement('option');
                option.value = kota;
                option.text = kota;
                selectKota.appendChild(option);
                
                // Select and update
                selectKota.value = kota;
                kotaTerpilih.innerText = kota;

                // Reset input
                inputKota.value = '';
                inputKota.focus();
            });

            // Handle selection change
            selectKota.addEventListener('change', function() {
                kotaTerpilih.innerText = this.value || '-';
            });
        })();

        // ==================== CARD 5: SELECT2 ====================
        $(document).ready(function() {
            console.log('Document Ready - Initializing Select2...');

            const SELECTOR = {
                select: '#selectKota2',
                input: '#inputKota2',
                button: '#btnTambahKota2',
                selected: '#kotaTerpilih2'
            };

            // Select2 configuration
            const select2Config = {
                placeholder: '-- Pilih Kota --',
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: -1
            };

            // Initialize Select2
            function initSelect2() {
                try {
                    const $select = $(SELECTOR.select);
                    
                    if ($select.data('select2')) {
                        $select.select2('destroy');
                    }
                    
                    $select.select2(select2Config);
                    console.log('Select2 initialized successfully');
                } catch (error) {
                    console.error('Error initializing Select2:', error);
                }
            }

            // Update selected city display
            function updateSelectedCity(city) {
                const $badge = $(SELECTOR.selected);
                
                if (city) {
                    $badge.text(city).removeClass('bg-secondary').addClass('bg-primary');
                } else {
                    $badge.text('-').removeClass('bg-primary').addClass('bg-secondary');
                }
            }

            // Check for duplicates
            function isDuplicate(city) {
                let exists = false;
                $(`${SELECTOR.select} option`).each(function() {
                    if ($(this).val() === city) {
                        exists = true;
                        return false;
                    }
                });
                return exists;
            }

            // Initialize
            initSelect2();

            // Add city button click handler
            $(SELECTOR.button).on('click', function(e) {
                e.preventDefault();
                
                const kota = $(SELECTOR.input).val().trim();
                
                if (!kota) {
                    alert('Kota harus diisi');
                    return;
                }

                if (isDuplicate(kota)) {
                    alert(`Kota '${kota}' sudah ada dalam daftar!`);
                    return;
                }

                // Destroy and recreate Select2
                if ($(SELECTOR.select).data('select2')) {
                    $(SELECTOR.select).select2('destroy');
                }
                
                // Add new option
                $(SELECTOR.select).append($('<option>', {
                    value: kota,
                    text: kota
                }));
                
                // Reinitialize Select2
                $(SELECTOR.select).select2(select2Config);
                
                // Select new city
                $(SELECTOR.select).val(kota).trigger('change');
                
                // Update display
                updateSelectedCity(kota);

                // Reset input
                $(SELECTOR.input).val('').focus();
            });

            // Change handler
            $(SELECTOR.select).on('change', function() {
                updateSelectedCity($(this).val());
            });
        });

        // ==================== FALLBACK INITIALIZATION ====================
        setTimeout(function() {
            if (typeof jQuery !== 'undefined' && 
                typeof jQuery.fn.select2 !== 'undefined' && 
                $('#selectKota2').length && 
                !$('#selectKota2').data('select2')) {
                
                console.log('Fallback: Reinitializing Select2');
                $('#selectKota2').select2({
                    placeholder: '-- Pilih Kota --',
                    allowClear: true,
                    width: '100%'
                });
            }
        }, 1000);

    })();
</script>

@endsection