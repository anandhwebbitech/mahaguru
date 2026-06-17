@extends('admin.layouts.app')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

    <style>
        .select2-container .select2-selection--single,
        .select2-container .select2-selection--multiple {
            height: auto !important;
        }

        #productModal .modal-body {
            max-height: 80vh;
            overflow-y: auto;
        }

        #productModal textarea {
            min-height: 120px;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-selection--multiple {
            min-height: 38px !important;
            border: 1px solid #ced4da !important;
        }

        .select2-selection__choice {
            margin-top: 4px !important;
        }
    </style>

    <section class="content-inner">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="clearfix">
                        <button class="btn btn-success mb-3" onclick="openAddModal()">
                            Add Product
                        </button>
                        <div class="table-responsive">
                            <table id="productTable" class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Material</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= MODAL START ================= --}}
            <div class="modal fade" id="productModal" tabindex="-1">
                <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width:95%;">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Add Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <form id="addProductForm" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" id="product_id" name="product_id">

                                <div class="row g-4">
                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold">Product Name *</label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Enter product name" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Main Thumbnail *</label>
                                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                                        <div id="mainThumbnailPreviewContainer" class="mt-2" style="display: none;">
                                            <img id="mainThumbnailPreview" src="" width="60" height="60"
                                                class="img-thumbnail" style="object-fit: cover;">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Category *</label>
                                        <select name="category_id" class="form-control" id="category" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Subcategory</label>
                                        <select name="sub_category_id" class="form-control" id="subcategory">
                                            <option value="">Select Sub Category</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Material Type *</label>
                                        <select name="material_id" id="material" class="form-control" required>
                                            <option value="">Select Material</option>
                                            @foreach ($materials as $mat)
                                                <option value="{{ $mat->id }}">{{ $mat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold d-block">Status</label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" name="status" value="1"
                                                checked>
                                            <label class="form-check-label fw-semibold text-success">Active Product</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold d-block">Product Labels</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_new_arrival"
                                                    value="1">
                                                <label class="form-check-label text-primary fw-semibold">New Arrival</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_best_selling"
                                                    value="1">
                                                <label class="form-check-label text-warning fw-semibold">Best
                                                    Selling</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_featured"
                                                    value="1">
                                                <label class="form-check-label text-success fw-semibold">Featured</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Product Tag</label>
                                        <select name="tags" class="form-select">
                                            <option value="">Select Tag</option>
                                            <option value="Limited">Limited</option>
                                            <option value="Offered">Offered</option>
                                            <option value="Trending">Trending</option>
                                            <option value="Hot Deal">Hot Deal</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Colors Selection</label>
                                        <div class="border rounded p-3" style="max-height:130px; overflow-y:auto;">
                                            @foreach ($colors as $color)
                                                <div class="form-check">
                                                    <input class="form-check-input color-checkbox" type="checkbox"
                                                        value="{{ $color->id }}" data-name="{{ $color->name }}">
                                                    <label class="form-check-label">{{ $color->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Sizes Selection (Optional)</label>
                                        <div class="border rounded p-3" style="max-height:130px; overflow-y:auto;">
                                            @foreach ($sizes as $size)
                                                <div class="form-check">
                                                    <input class="form-check-input size-checkbox" type="checkbox"
                                                        value="{{ $size->id }}" data-name="{{ $size->name }}">
                                                    <label class="form-check-label">{{ $size->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-dark btn-sm mb-2"
                                            id="generateVariants">Generate Variants Matrix</button>
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle" id="variantTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Color</th>
                                                        <th>Size</th>
                                                        <th style="width: 13%;">Original Price *</th>
                                                        <th style="width: 10%;">Discount %</th>
                                                        <th style="width: 13%;">Offer Price</th>
                                                        <th style="width: 10%;">GST % *</th>
                                                        <th style="width: 10%;">Stock *</th>
                                                        <th>Image</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Short Description</label>
                                        <textarea name="short_description" class="form-control" rows="2"></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Full Description</label>
                                        <textarea name="description" class="form-control" rows="4"></textarea>
                                    </div>

                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-primary px-5">Save Product</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // DataTables Setup
            $('#productTable').DataTable({
                processing: true,
                destroy: true,
                ajax: {
                    url: "{{ route('admin.fetchProductslist') }}",
                    type: "GET",
                    dataSrc: "products"
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'thumbnail',
                        render: function(data) {
                            let imageUrl = "{{ asset('assets/images/no-image.png') }}";
                            if (data) {
                                imageUrl = "{{ asset('public/uploads/products/') }}/" + data;
                            }
                            return `<img src="${imageUrl}" width="50" height="50" class="img-thumbnail" style="object-fit: cover;">`;
                        }
                    },
                    {
                        data: 'product_name'
                    },
                    {
                        data: 'category',
                        render: function(data) {
                            return data ? data.name : '-';
                        }
                    },
                    {
                        data: 'material',
                        render: function(data) {
                            return data ? data.name : '-';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `
                                <button class="btn btn-sm btn-warning" onclick="openEditModal(${data.id})">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteProduct(${data.id})">Delete</button>
                            `;
                        }
                    }
                ]
            });

            $('.select2').select2({
                width: '100%'
            });

            // Generate Variants Matrix Functionality (மாற்றியமைக்கப்பட்டுள்ளது 👈)
            $('#generateVariants').on('click', function() {
                let selectedColors = [];
                let selectedSizes = [];

                $('.color-checkbox:checked').each(function() {
                    selectedColors.push({
                        id: $(this).val(),
                        name: $(this).data('name')
                    });
                });

                $('.size-checkbox:checked').each(function() {
                    selectedSizes.push({
                        id: $(this).val(),
                        name: $(this).data('name')
                    });
                });

                // குறைந்தது வண்ணமாவது தேர்ந்தெடுக்கப்பட வேண்டும்
                if (selectedColors.length === 0 && selectedSizes.length === 0) {
                    Swal.fire('Warning!', 'Please select at least one Color or Size.', 'warning');
                    return;
                }

                let tbody = $('#variantTable tbody');
                tbody.empty();
                let vIndex = 0;

                // வண்ணங்கள் மற்றும் அளவுகள் இரண்டையும் இணைப்பதற்கான லாஜிக்
                if (selectedColors.length > 0) {
                    selectedColors.forEach(function(color) {
                        if (selectedSizes.length > 0) {
                            // வண்ணமும் அளவும் இரண்டும் இருந்தால்
                            selectedSizes.forEach(function(size) {
                                appendVariantRow(tbody, vIndex, color, size);
                                vIndex++;
                            });
                        } else {
                            // சாரி போன்ற பொருட்களுக்கு அளவு இல்லை, வண்ணம் மட்டும் இருந்தால்
                            appendVariantRow(tbody, vIndex, color, null);
                            vIndex++;
                        }
                    });
                } else if (selectedSizes.length > 0) {
                    // வண்ணம் இல்லாமல் அளவு மட்டும் இருந்தால் (தேவைப்பட்டால்)
                    selectedSizes.forEach(function(size) {
                        appendVariantRow(tbody, vIndex, null, size);
                        vIndex++;
                    });
                }
            });

            
            // டேபிளில் வரிசைகளை சேர்க்கும் பொதுவான ஃபங்க்ஷன்
            function appendVariantRow(tbody, index, color, size) {
                let colorId = color ? color.id : '';
                let colorName = color ? color.name : 'N/A';
                let sizeId = size ? size.id : '';
                let sizeName = size ? size.name : 'N/A';
                let sizeBadge = size ? 'bg-dark' : 'bg-light text-muted';

                let row = `
                    <tr class="variant-row">
                        <td>
                            <input type="hidden" name="variants[${index}][color_id]" value="${colorId}">
                            <span class="badge bg-secondary">${colorName}</span>
                        </td>
                        <td>
                            <input type="hidden" name="variants[${index}][size_id]" value="${sizeId}">
                            <span class="badge ${sizeBadge}">${sizeName}</span>
                        </td>
                        <td>
                            <input type="number" name="variants[${index}][price]" class="form-control v-price" step="0.01" required placeholder="Price">
                        </td>
                        <td>
                            <input type="number" name="variants[${index}][discount_percentage]" class="form-control v-discount" value="0" min="0" max="100" placeholder="%">
                        </td>
                        <td>
                            <input type="number" name="variants[${index}][discount_price]" class="form-control v-offer-price" step="0.01" readonly value="0.00">
                        </td>
                        <td>
                            <input type="number" name="variants[${index}][gst]" class="form-control" value="0" required placeholder="GST %">
                        </td>
                        <td>
                            <input type="number" name="variants[${index}][stock]" class="form-control" required placeholder="Qty">
                        </td>
                        <td>
                            <input type="file" name="variants[${index}][images][]" class="form-control" accept="image/*" multiple>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            }

            // Live Offer Price Calculation
            $(document).on('keyup change', '.v-price, .v-discount', function() {
                let row = $(this).closest('tr');
                let price = parseFloat(row.find('.v-price').val()) || 0;
                let discount = parseFloat(row.find('.v-discount').val()) || 0;

                let offerPrice = price - ((price * discount) / 100);
                row.find('.v-offer-price').val(offerPrice.toFixed(2));
            });

            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
            });
        });

        function openAddModal() {
            $("#addProductForm")[0].reset();
            $("#product_id").val('');
            $("#modalTitle").text("Add Product");
            $("#addProductForm button[type='submit']").text("Add Product");
            $(".color-checkbox, .size-checkbox").prop("checked", false);
            $('#variantTable tbody').empty();

            $("#mainThumbnailPreviewContainer").hide();
            $("#mainThumbnailPreview").attr('src', '');

            $("#productModal").modal('show');
        }
        function deleteProduct(productId) {

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to recover this product once it's deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete It!',
                cancelButtonText: 'Cancel'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ url('admin/products/delete') }}/" + productId,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },

                        success: function(response) {

                            if (response.success) {

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message ||
                                        'Product has been deleted successfully.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                $('#productTable').DataTable().ajax.reload(null, false);

                            } else {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
                                    text: response.message ||
                                        'Unable to delete the product.'
                                });

                            }
                        },

                        error: function(xhr) {

                            console.error(xhr.responseText);

                            let errorMessage =
                                'A server error occurred. Please try again later.';

                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage
                            });
                        }
                    });
                }
            });
        }

        // Form Submit Implementation
        $('#addProductForm').submit(function(e) {
            e.preventDefault();

            if ($('#variantTable tbody tr').length === 0) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please generate at least one variant matrix row before saving.',
                    icon: 'warning'
                });
                return false;
            }

            let id = $("#product_id").val();
            let formData = new FormData(this);
            let url = id ? "{{ url('admin/product/update') }}/" + id : "{{ route('admin.addProducts') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    Swal.showLoading();
                },
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $("#productModal").modal('hide');
                            $('#addProductForm')[0].reset();
                            $('#variantTable tbody').empty();
                            location.reload();
                        });
                    }
                }
            });
        });

        // Dynamic Subcategories Population Function
        function fetchSubcategories(category_id, selected_sub_id = null) {
            if (!category_id) {
                $('#subcategory').html('<option value="">Select Sub Category</option>');
                return;
            }

            return $.ajax({
                url: "{{ url('admin/get-subcategories') }}/" + category_id,
                type: 'GET',
                success: function(response) {
                    let html = '<option value="">Select Sub Category</option>';
                    $.each(response, function(index, item) {
                        let selected = (selected_sub_id && selected_sub_id == item.id) ? 'selected' :
                            '';
                        html +=
                            `<option value="${item.id}" ${selected}>${item.sub_category_name}</option>`;
                    });
                    $('#subcategory').html(html);
                }
            });
        }

        // Category மாறும் போது Subcategory-ஐ லோட் செய்ய
        $(document).on('change', '#category', function() {
            let category_id = $(this).val();
            fetchSubcategories(category_id);
        });

        // EDIT MODAL ஓபன் ஆகும் போது 
        function openEditModal(id) {
            $("#addProductForm")[0].reset();
            $(".color-checkbox, .size-checkbox").prop("checked", false);
            $('#variantTable tbody').empty();

            $("#mainThumbnailPreviewContainer").hide();
            $("#mainThumbnailPreview").attr('src', '');

            $("#modalTitle").text("Edit Product");
            $("#addProductForm button[type='submit']").text("Update Product");

            $.ajax({
                url: "{{ route('admin.product.edit', ':id') }}".replace(':id', id),
                type: "GET",
                success: function(response) {
                    if (response.success) {
                        let product = response.product;

                        $("#product_id").val(product.id);
                        $("input[name='name']").val(product.product_name);
                        $("select[name='material_id']").val(product.material_id);
                        $("select[name='tags']").val(product.tags);
                        $("textarea[name='short_description']").val(product.short_description);
                        $("textarea[name='description']").val(product.description);

                        $("input[name='status']").prop('checked', product.status == 1);
                        $("input[name='is_new_arrival']").prop('checked', product.is_new_arrival == 1);
                        $("input[name='is_best_selling']").prop('checked', product.is_best_selling == 1);
                        $("input[name='is_featured']").prop('checked', product.is_featured == 1);

                        if (product.thumbnail) {
                            let mainImgUrl = "{{ asset('public/uploads/products/') }}/" + product.thumbnail;
                            $("#mainThumbnailPreview").attr('src', mainImgUrl);
                            $("#mainThumbnailPreviewContainer").show();
                        }

                        $("select[name='category_id']").val(product.category_id);
                        if (product.category_id) {
                            fetchSubcategories(product.category_id, product.sub_category_id);
                        }

                        if (product.variants && product.variants.length > 0) {
                            let tbody = $('#variantTable tbody');

                            product.variants.forEach(function(variant, vIndex) {
                                if (variant.color_id) {
                                    $(`.color-checkbox[value='${variant.color_id}']`).prop('checked',
                                        true);
                                }
                                if (variant.size_id) {
                                    $(`.size-checkbox[value='${variant.size_id}']`).prop('checked',
                                        true);
                                }

                                let colorName = $(`.color-checkbox[value='${variant.color_id}']`).data(
                                    'name') || 'N/A';
                                let sizeName = $(`.size-checkbox[value='${variant.size_id}']`).data(
                                    'name') || 'N/A';
                                let sizeBadge = variant.size_id ? 'bg-dark' : 'bg-light text-muted';

                                // மல்டிபிள் இமேஜ் பிரிவியூ லாஜிக் 👈
                                let imgHtml = '';
                                if (variant
                                    .images
                                    ) { // டேபிளில் ஃபீல்டு பெயர் 'images' என்று இருப்பதாக எடுத்துக்கொள்ளப்பட்டுள்ளது
                                    let imageArray = [];
                                    try {
                                        // இமேஜஸ் JSON பார்மட்டில் இருந்தால்
                                        imageArray = typeof variant.images === 'string' && variant
                                            .images.startsWith('[') ?
                                            JSON.parse(variant.images) :
                                            variant.images.split(',');
                                    } catch (e) {
                                        imageArray = variant.images ? [variant.images] : [];
                                    }

                                    // அனைத்து பழைய படங்களையும் லூப் செய்து பிரிவியூ காட்டுகிறது
                                    imageArray.forEach(function(img) {
                                        if (img.trim() != "") {
                                            imgHtml +=
                                                `<img src="{{ asset('public/uploads/products') }}/${img.trim()}" width="40" height="40" class="me-1 mb-1 img-thumbnail" style="object-fit:cover; display:inline-block;">`;
                                        }
                                    });
                                    if (imgHtml != "") {
                                        imgHtml =
                                            `<div class="d-block mb-1 variant-images-preview">${imgHtml}</div>`;
                                    }
                                }

                                let row = `
                                        <tr class="variant-row">
                                            <td>
                                                <input type="hidden" name="variants[${vIndex}][color_id]" value="${variant.color_id || ''}">
                                                <span class="badge bg-secondary">${colorName}</span>
                                            </td>
                                            <td>
                                                <input type="hidden" name="variants[${vIndex}][size_id]" value="${variant.size_id || ''}">
                                                <span class="badge ${sizeBadge}">${sizeName}</span>
                                            </td>
                                            <td>
                                                <input type="number" name="variants[${vIndex}][price]" class="form-control v-price" step="0.01" required value="${variant.price}">
                                            </td>
                                            <td>
                                                <input type="number" name="variants[${vIndex}][discount_percentage]" class="form-control v-discount" min="0" max="100" value="${variant.discount_percentage || 0}">
                                            </td>
                                            <td>
                                                <input type="number" name="variants[${vIndex}][discount_price]" class="form-control v-offer-price" step="0.01" readonly value="${variant.discount_price || 0.00}">
                                            </td>
                                            <td>
                                                <input type="number" name="variants[${vIndex}][gst]" class="form-control" required value="${variant.gst || 0}">
                                            </td>
                                            <td>
                                                <input type="number" name="variants[${vIndex}][stock]" class="form-control" required value="${variant.stock}">
                                            </td>
                                            <td>
                                                ${imgHtml}
                                                <input type="file" name="variants[${vIndex}][images][]" class="form-control" accept="image/*" multiple>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
                                            </td>
                                        </tr>
                                    `;
                                tbody.append(row);
                            });
                        }

                        $("#productModal").modal('show');
                    } else {
                        Swal.fire('Error!', 'Failed to fetch product data.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'Something went wrong while fetching data.', 'error');
                }
            });
        }
    </script>
@endsection
